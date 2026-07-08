<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        //Đếm số lượng học viên đang hoạt động (user có role là student và both)
        $countStudents = \App\Models\User::where('role', 'student')->count();
        $countStudents += \App\Models\User::where('role', 'both')->count();

        //Đếm số lượng lớp đang hoạt động
        $countActiveClasses = \App\Models\ClassRequest::where('status', 'assigned')
            ->whereHas('tutorClass')
            ->count();


        //Đếm số lượng gia sư đang hoạt động (user có role là tutor và both)
        $countTutors = \App\Models\User::where('role', 'tutor')->count();
        $countTutors += \App\Models\User::where('role', 'both')->count();
        
        //Tính doanh thu tháng này từ các giao dịch khấu trừ phí nhận lớp (type = charge)
        $revenueCoins = \App\Models\WalletTransaction::where('type', 'charge')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        
        $revenueVnd = $revenueCoins * 1000;
        
        // Lịch sử nhận doanh thu (10 giao dịch gần nhất loại charge)
        $revenueHistory = \App\Models\WalletTransaction::with('wallet.user')
            ->where('type', 'charge')
            ->latest()
            ->take(10)
            ->get();
            
        // Quick Actions counts
        $pendingTutorsCount = \App\Models\Tutor::where('status', 'pending')->count();
        $newClassRequestsCount = \App\Models\ClassRequest::whereDate('created_at', now()->format('Y-m-d'))->count();
        $unreadContactsCount = \App\Models\Contact::where('status', 'pending')->count();

        return view('admin.home', compact('countStudents', 'countActiveClasses', 'countTutors', 'revenueVnd', 'revenueHistory', 'pendingTutorsCount', 'newClassRequestsCount', 'unreadContactsCount'));
    }
}