<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class AdminContactController extends Controller
{
    // Danh sách liên hệ
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);

        return view('admin.contacts.index', compact('contacts'));
    }

    // Đánh dấu đã phản hồi
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string'
        ]);

        $contact = Contact::findOrFail($id);

        $contact->admin_reply = $request->admin_reply;
        $contact->status = 'replied';
        $contact->save();

        return redirect()->back()->with('success', 'Phản hồi đã được gửi.');
    }
}