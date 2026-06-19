<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ClassRequest\FilterRequest;
use App\Http\Requests\Frontend\ClassRequest\UpdateRequest;
use App\Models\ClassRequest;

class ClassRequestController extends Controller
{
    public function index(FilterRequest $request)
    {
        $query = ClassRequest::where('student_id', auth()->user()->student->id);

        $query->when($request->filled('id'), function ($q) use ($request) {
            $q->where('id', $request->id);
        });

        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $query->when($request->filled('study_type'), function ($q) use ($request) {
            $q->where('study_type', $request->study_type);
        });

        $classes = $query->latest()
            ->paginate(6)
            ->withQueryString();

        $statuses = ClassRequest::statusOptions(); // lấy từ model

        return view('student.classes.index', compact('classes', 'statuses'));
    }


    public function show(ClassRequest $class_request)
    {
        $class_request->load([
            'subject',
            'grade',
            'tutor.user'
        ]);

        return view('student.classes.show', [
            'class' => $class_request
        ]);
    }

    public function edit(ClassRequest $class_request)
    {
        if ($class_request->student_id != auth()->user()->student->id) {
            abort(403);
        }

        return view('frontend.classes.edit', compact('class_request'));
    }

    public function update(UpdateRequest $request, ClassRequest $class_request)
    {
        $class_request->update($request->validated());

        return redirect()->route('classes.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy(ClassRequest $class_request)
    {
        // Kiểm tra quyền sở hữu
        if ($class_request->student_id != auth()->user()->student->id) {
            abort(403);
        }

        // Không cho hủy nếu đang payment_pending hoặc completed
        if (in_array($class_request->status, ['payment_pending', 'completed'])) {
            return back()->with('error', 'Không thể hủy lớp ở trạng thái này.');
        }

        $class_request->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Lớp đã được hủy thành công.');
    }
}