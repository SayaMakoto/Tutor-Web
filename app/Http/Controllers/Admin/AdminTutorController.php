<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tutor\UpdateStatusRequest;
use App\Models\Tutor;

class AdminTutorController extends Controller
{
    public function index()
    {
        $tutors = Tutor::with('user')
            ->latest()
            ->paginate(6);

        return view('admin.tutors.index', compact('tutors'));
    }

    public function show($id)
    {
        $tutor = Tutor::with([
            'user',
            'subjects',
            'documents'
        ])->findOrFail($id);

        return view('admin.tutors.show', compact('tutor'));
    }

    public function update(UpdateStatusRequest $request, Tutor $tutor)
    {
        if ($tutor->status === 'approved' && $request->status === 'pending') {
            return back()->withErrors('Gia sư đã được duyệt, không thể quay lại pending.');
        }

        $tutor->update([
            'status' => $request->status
        ]);

        if ($request->status === 'rejected') {
            return back()->with('error', 'Đã từ chối hồ sơ gia sư.')->with('rejected_alert', true);
        }

        if ($request->status === 'approved') {
            return back()->with('success', 'Đã chấp nhận hồ sơ gia sư.');
        }

        return back()->with('success', 'Đã cập nhật trạng thái gia sư.');
    }
}