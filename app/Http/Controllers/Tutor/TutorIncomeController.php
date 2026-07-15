<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\TutorClass;
use App\Models\PaymentTransaction;

class TutorIncomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tutor = $user->tutor;

        $tutorClasses = TutorClass::where('tutor_id', $tutor->id)
            ->where('status', '!=', 'cancelled')
            ->with(['classRequest.schedules', 'classRequest.subject', 'classRequest.grade'])
            ->get();

        $activeClasses = $tutorClasses->where('status', 'active');
        $completedClasses = $tutorClasses->where('status', 'completed');

        $classIncomes = [];
        $totalNetIncome = 0;
        $expectedNetIncome = 0;
        $totalPlatformFee = 0;

        foreach ($tutorClasses as $tc) {
            $cr = $tc->classRequest;
            if (!$cr) continue;

            $sessionsPerWeek = $cr->schedules->count() ?: 1;

            $totalValue = $cr->total_value;
            $platformFee = (int) round($totalValue * 0.25);
            $netIncome = $totalValue - $platformFee;

            $classIncomes[] = [
                'class_id' => $cr->id,
                'subject' => $cr->subject->name ?? 'N/A',
                'grade' => $cr->grade->name ?? '',
                'fee_per_hour' => $cr->fee,
                'sessions_per_week' => $sessionsPerWeek,
                'weeks' => $cr->weeks,
                'total_value' => $totalValue,
                'platform_fee' => $platformFee,
                'net_income' => $netIncome,
                'status' => $tc->status,
                'status_label' => $tc->status_label,
                'status_color' => $tc->status_color,
                'study_type' => $cr->study_type,
                'created_at' => $tc->created_at,
            ];

            $totalPlatformFee += $platformFee;

            if ($tc->status === 'completed') {
                $totalNetIncome += $netIncome;
            } elseif ($tc->status === 'active') {
                $expectedNetIncome += $netIncome;
            }
        }

        $transactions = PaymentTransaction::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        return view('tutor.income', compact(
            'classIncomes',
            'activeClasses',
            'completedClasses',
            'totalNetIncome',
            'expectedNetIncome',
            'totalPlatformFee',
            'transactions',
        ));
    }
}