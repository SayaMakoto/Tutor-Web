<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminApplicationController extends Controller
{
    public function index()
    {
        $applications = \App\Models\Application::latest()->paginate(10);

        return view('admin.applications.index', compact('applications'));
    }
}