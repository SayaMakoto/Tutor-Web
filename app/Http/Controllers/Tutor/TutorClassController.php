<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ClassRequest;
use Illuminate\Http\Request;

class TutorClassController extends Controller
{
    public function index()
    {
        $approvedClasses = ClassRequest::where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();

        return view('tutor.classes.index', compact('approvedClasses'));
    }

    public function show(ClassRequest $class)
    {
        return view('tutor.classes.show', compact('class'));
    }

    public function invite(Request $request, ClassRequest $class)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $tutor = auth()->user()->tutor;

        if (!$tutor) {
            return back()->with('error', 'Bạn không phải gia sư!');
        }

        $count = Application::where('tutor_id', $tutor->id)
            ->where('class_request_id', $class->id)
            ->count();

        if ($count >= 5) {
            return back()->with('error', 'Bạn chỉ được gửi tối đa 5 lời mời cho lớp học này!');
        }

        Application::create([
            'tutor_id' => $tutor->id,
            'class_request_id' => $class->id,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Đã gửi lời mời!');
    }

    public function assigned()
    {
        $tutorId = auth()->user()->tutor->id;

        $assignedClasses = ClassRequest::where('tutor_id', $tutorId)
            ->where('status', 'assigned')
            ->latest()
            ->get();

        return view('tutor.classes.assigned', compact('assignedClasses'));
    }
}