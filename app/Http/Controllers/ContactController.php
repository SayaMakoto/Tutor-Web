<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // Hiển thị trang liên hệ
    public function index()
    {
        $layout = auth()->user()->role === 'tutor'
            ? 'layouts.tutor'
            : 'layouts.student';

        return view('contact.index', compact('layout'));
    }

    // Xử lý gửi liên hệ
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Gửi liên hệ thành công!');
    }
}