<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\ClassRequest;

class TutorHomeController extends Controller
{
    public function index()
    {
        $approvedClasses = ClassRequest::where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();

        return view('tutor.home', compact('approvedClasses'));
    }
}