<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\ClassRequest;

class TutorHomeController extends Controller
{
    public function index()
    {
        $studentId = auth()->user()->student?->id;

        $approvedClasses = ClassRequest::where('status', 'approved')
            ->when($studentId, function ($query, $studentId) {
                return $query->where('student_id', '!=', $studentId);
            })
            ->latest()
            ->take(6)
            ->get();

        return view('tutor.home', compact('approvedClasses'));
    }
}