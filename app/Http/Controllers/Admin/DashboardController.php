<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $countStudents = \App\Models\User::where('role', 'student')->count();
        $countStudents += \App\Models\User::where('role', 'both')->count();

        $countActiveClasses = \App\Models\ClassRequest::where('status', 'assigned')
            ->whereHas('tutorClass')
            ->count();


        $countTutors = \App\Models\User::where('role', 'tutor')->count();
        $countTutors += \App\Models\User::where('role', 'both')->count();
        
        $revenueVnd = 0;
        $revenueHistory = collect();

        if (Schema::hasTable('payment_transactions')) {
            $revenueVnd = PaymentTransaction::where('type', 'charge')
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount');

            $revenueHistory = PaymentTransaction::with('user')
                ->where('type', 'charge')
                ->where('status', 'completed')
                ->latest()
                ->take(10)
                ->get();
        }
        
        $pendingTutorsCount = \App\Models\Tutor::where('status', 'pending')->count();
        $newClassRequestsCount = \App\Models\ClassRequest::whereDate('created_at', now()->format('Y-m-d'))->count();
        $unreadContactsCount = \App\Models\Contact::where('status', 'pending')->count();

        return view('admin.home', compact('countStudents', 'countActiveClasses', 'countTutors', 'revenueVnd', 'revenueHistory', 'pendingTutorsCount', 'newClassRequestsCount', 'unreadContactsCount'));
    }
}