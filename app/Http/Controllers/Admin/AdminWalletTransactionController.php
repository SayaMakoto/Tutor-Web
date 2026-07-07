<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class AdminWalletTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = WalletTransaction::with(['wallet.user', 'classRequest']);

        // Tìm kiếm theo tên, email, ID hoặc mô tả
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('payment_order_ref', 'like', "%{$search}%")
                  ->orWhereHas('wallet.user', function ($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Lọc theo loại giao dịch
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();

        return view('admin.wallet_transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = WalletTransaction::with(['wallet.user', 'classRequest', 'paymentOrder'])
            ->findOrFail($id);

        return view('admin.wallet_transactions.show', compact('transaction'));
    }
}
