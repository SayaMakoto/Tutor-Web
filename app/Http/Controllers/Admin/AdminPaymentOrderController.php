<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;

class AdminPaymentOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentOrder::with('user');

        // Tìm kiếm theo tên người dùng, email, mã tham chiếu đơn hàng hoặc ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('order_ref', 'like', "%{$search}%")
                  ->orWhere('vnpay_txn_no', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payment_orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = PaymentOrder::with('user')->findOrFail($id);

        return view('admin.payment_orders.show', compact('order'));
    }
}
