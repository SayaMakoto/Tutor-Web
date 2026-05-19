<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassRequest;

class StudentHomeController extends Controller
{
    public function index()
    {
        $classes = ClassRequest::with(['grade', 'subject'])
            ->where('student_id', auth()->id())
            ->latest()
            ->take(3)
            ->get();

        return view('student.home', compact('classes'));
    }
}