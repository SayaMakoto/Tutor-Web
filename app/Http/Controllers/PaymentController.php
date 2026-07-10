<?php

namespace App\Http\Controllers;

use App\Models\PaymentOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // ─── Helper: kiểm tra bảng đã tồn tại chưa ───────────────
    private function tablesExist(): bool
    {
        return Schema::hasTable('payment_transactions') && Schema::hasTable('payment_orders');
    }

    // ─── Lịch sử thanh toán ───────────────────────────────────
    public function wallet()
    {
        $transactions = collect();
        $escrowBalance = 0;

        if ($this->tablesExist()) {
            $transactions = \App\Models\PaymentTransaction::where('user_id', Auth::id())
                ->latest()
                ->limit(30)
                ->get();

            // Tính số tiền đóng băng (escrow) hiện tại
            $escrowBalance = \App\Models\PaymentTransaction::where('user_id', Auth::id())
                ->where('type', 'hold')
                ->whereHas('classRequest.tutorClass', function ($q) {
                    $q->where('status', 'active');
                })
                ->sum('amount');
        }

        return view('payment.wallet', compact('transactions', 'escrowBalance'));
    }

    // ─── Nạp tiền vào ví (ngừng hỗ trợ) ───────────────────────
    public function topup()
    {
        return redirect()->route('payment.wallet')->with('error', 'Không hỗ trợ nạp tiền vào ví. Phí nhận lớp được thanh toán trực tiếp bằng VNĐ.');
    }

    // ─── Tạo đơn & Redirect QR ────────────────────────────────
    public function create(Request $request)
    {
        return redirect()->route('payment.wallet')->with('error', 'Không thể tự tạo đơn nạp tiền. Đơn thanh toán chỉ được tạo khi gia sư nhận lớp.');
    }

    // ─── Trang QR ─────────────────────────────────────────────
    public function qr(string $orderRef)
    {
        if (!$this->tablesExist()) {
            // Demo mode: dùng session
            $demo = session('demo_order', []);
            $order = (object) array_merge([
                'order_ref' => $orderRef,
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
                'amount_vnd' => 200000,
            ], $demo);
            return view('payment.success', compact('order'));
        }

        $order = PaymentOrder::where('order_ref', $request->order_ref)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $order->update(['status' => 'success', 'vnpay_txn_no' => 'SBX-' . strtoupper(Str::random(8))]);

        if ($order->class_request_id) {
            $paymentService = new \App\Services\PaymentService();
            $paymentService->holdEscrow(Auth::user(), $order->amount_vnd, $order->class_request_id, $order->order_ref);

            $class = \App\Models\ClassRequest::find($order->class_request_id);
            if ($class && $class->tutorClass) {
                $class->tutorClass->update(['status' => 'active']);
            }
        }

        return view('payment.success', compact('order'));
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
        return view('payment.success', compact('order'));
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
