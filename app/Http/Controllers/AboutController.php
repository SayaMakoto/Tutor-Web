<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $layout = 'layouts.student';

        if (auth()->check()) {
            $layout = auth()->user()->role === 'tutor'
                ? 'layouts.tutor'
                : 'layouts.student';
        }

        return view('about', compact('layout'));
    }
}