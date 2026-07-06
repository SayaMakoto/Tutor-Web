<?php

namespace App\Http\Controllers;

use App\Models\PaymentOrder;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // ─── Helper: kiểm tra bảng đã tồn tại chưa ───────────────
    private function tablesExist(): bool
    {
        return Schema::hasTable('wallets') && Schema::hasTable('payment_orders');
    }

    // ─── Lấy ví hoặc trả về object rỗng nếu chưa migrate ─────
    private function getWallet()
    {
        if (!$this->tablesExist()) {
            return (object) ['balance' => 0, 'frozen_balance' => 0, 'total_topped_up' => 0];
        }
        return Auth::user()->getOrCreateWallet();
    }

    // ─── Trang Ví ─────────────────────────────────────────────
    public function wallet()
    {
        $wallet = $this->getWallet();
        $transactions = collect(); // Rỗng nếu chưa migrate

        if ($this->tablesExist() && method_exists($wallet, 'transactions')) {
            $transactions = $wallet->transactions()->latest()->limit(30)->get();
        }

        return view('payment.wallet', compact('wallet', 'transactions'));
    }

    // ─── Trang Nạp Xu ─────────────────────────────────────────
    public function topup()
    {
        $wallet = $this->getWallet();
        return view('payment.topup', compact('wallet'));
    }

    // ─── Tạo đơn & Redirect QR ────────────────────────────────
    public function create(Request $request)
    {
        $request->validate([
            'coin_amount' => 'required|integer|min:50|max:10000',
            'payment_method' => 'required|in:qr,atm,intl',
        ]);

        $routeMap = ['qr' => 'payment.qr', 'atm' => 'payment.atm', 'intl' => 'payment.intl'];
        $routeName = $routeMap[$request->payment_method] ?? 'payment.qr';

        if (!$this->tablesExist()) {
            // Chưa migrate: dùng session để preview
            $orderRef = 'GS247-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
            session([
                'demo_order' => [
                    'order_ref' => $orderRef,
                    'coin_amount' => (int) $request->coin_amount,
                    'amount_vnd' => (int) $request->coin_amount * 1000,
                    'payment_method' => $request->payment_method,
                    'expires_at' => now()->addMinutes(15)->toISOString(),
                ]
            ]);
            return redirect()->route($routeName, $orderRef);
        }

        $coinAmount = (int) $request->coin_amount;
        $order = PaymentOrder::create([
            'user_id' => Auth::id(),
            'order_ref' => 'GS247-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'amount_vnd' => $coinAmount * 1000,
            'coin_amount' => $coinAmount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(15),
        ]);

        return redirect()->route($routeName, $order->order_ref);
    }

    // ─── Trang QR ─────────────────────────────────────────────
    public function qr(string $orderRef)
    {
        if (!$this->tablesExist()) {
            // Demo mode: dùng session
            $demo = session('demo_order', []);
            $order = (object) array_merge([
                'order_ref' => $orderRef,
                'coin_amount' => 200,
                'amount_vnd' => 200000,
                'status' => 'pending',
                'expires_at' => now()->addMinutes(15),
            ], $demo);
            $order->expires_at = \Carbon\Carbon::parse($order->expires_at);
            return view('payment.qr', compact('order'));
        }

        $order = PaymentOrder::where('order_ref', $orderRef)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'success') {
            return redirect()->route('payment.success')->with('order_ref', $orderRef);
        }

        return view('payment.qr', compact('order'));
    }

    // ─── Trang ATM ────────────────────────────────────────────
    public function atm(string $orderRef)
    {
        if (!$this->tablesExist()) {
            $demo = session('demo_order', []);
            $order = (object) array_merge([
                'order_ref' => $orderRef,
                'coin_amount' => 200,
                'amount_vnd' => 200000,
                'status' => 'pending',
                'expires_at' => now()->addMinutes(15),
            ], $demo);
            $order->expires_at = \Carbon\Carbon::parse($order->expires_at);
            return view('payment.atm', compact('order'));
        }

        $order = PaymentOrder::where('order_ref', $orderRef)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'success') {
            return redirect()->route('payment.success')->with('order_ref', $orderRef);
        }

        return view('payment.atm', compact('order'));
    }

    // ─── Trang Thẻ quốc tế ────────────────────────────────────
    public function intl(string $orderRef)
    {
        if (!$this->tablesExist()) {
            $demo = session('demo_order', []);
            $order = (object) array_merge([
                'order_ref' => $orderRef,
                'coin_amount' => 200,
                'amount_vnd' => 200000,
                'status' => 'pending',
                'expires_at' => now()->addMinutes(15),
            ], $demo);
            $order->expires_at = \Carbon\Carbon::parse($order->expires_at);
            return view('payment.intl', compact('order'));
        }

        $order = PaymentOrder::where('order_ref', $orderRef)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'success') {
            return redirect()->route('payment.success')->with('order_ref', $orderRef);
        }

        return view('payment.intl', compact('order'));
    }

    // ─── Mô phỏng Sandbox ─────────────────────────────────────
    public function simulate(Request $request)
    {
        if (!$this->tablesExist()) {
            // Demo mode: trực tiếp vào success
            $demo = session('demo_order', []);
            $order = (object) array_merge([
                'order_ref' => $request->order_ref,
                'coin_amount' => 200,
                'amount_vnd' => 200000,
            ], $demo);
            $wallet = $this->getWallet();
            return view('payment.success', compact('order', 'wallet'));
        }

        $order = PaymentOrder::where('order_ref', $request->order_ref)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $order->update(['status' => 'success', 'vnpay_txn_no' => 'SBX-' . strtoupper(Str::random(8))]);

        $walletService = new WalletService();
        $walletService->topUp(Auth::user(), $order->coin_amount, $order->order_ref);

        $wallet = Auth::user()->fresh()->getOrCreateWallet();
        return view('payment.success', compact('order', 'wallet'));
    }

    // ─── Mô phỏng thất bại Sandbox ───────────────────────────
    public function simulateFail(Request $request)
    {
        if (!$this->tablesExist()) {
            return redirect()->route('payment.failed')
                ->with('reason', 'Giao dịch thất bại (mô phỏng). Ngân hàng từ chối giao dịch.');
        }

        $order = PaymentOrder::where('order_ref', $request->order_ref)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $order->update(['status' => 'failed']);
    }

    // ─── AJAX Status check ────────────────────────────────────
    public function status(string $orderRef)
    {
        if (!$this->tablesExist()) {
            return response()->json(['status' => 'pending']);
        }
        $order = PaymentOrder::where('order_ref', $orderRef)->where('user_id', Auth::id())->first();
        return response()->json(['status' => $order?->status ?? 'not_found']);
    }

    // ─── Hủy đơn ──────────────────────────────────────────────
    public function cancel(Request $request)
    {
        if ($this->tablesExist()) {
            PaymentOrder::where('order_ref', $request->order_ref)
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->update(['status' => 'failed']);
        }
        return redirect()->route('payment.wallet')->with('info', 'Đã hủy đơn hàng.');
    }

    // ─── Success / Failed ─────────────────────────────────────
    public function success()
    {
        $order = null;
        $wallet = $this->getWallet();
        return view('payment.success', compact('order', 'wallet'));
    }

    public function failed()
    {
        $reason = session('reason', 'Giao dịch không thể hoàn tất.');
        return view('payment.failed', compact('reason'));
    }

    // ─── Lịch sử (alias wallet) ───────────────────────────────
    public function history()
    {
        return $this->wallet();
    }
}
