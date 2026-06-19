<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class StudentApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['tutor.user', 'classRequest'])
            ->whereHas('classRequest.student', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('student.applications.index', compact('applications'));
    }

    public function accept(Application $application)
    {
        // Kiểm tra IDOR: đảm bảo ứng dụng thuộc về lớp của sinh viên đang đăng nhập
        if ($application->classRequest->student_id !== auth()->user()->student->id) {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }
        // chỉ xử lý pending
        if ($application->status !== 'pending') {
            return back()->with('error', 'Lời mời đã được xử lý');
        }

        $application->update([
            'status' => 'accepted'
        ]);

        // gán gia sư cho lớp
        $application->classRequest()->update([
            'status' => 'assigned',
            'tutor_id' => $application->tutor_id
        ]);

        // (OPTIONAL) reject các application khác của cùng class
        Application::where('class_request_id', $application->class_request_id)
            ->where('id', '!=', $application->id)
            ->update([
                'status' => 'rejected'
            ]);

        return back()->with('success', 'Đã chọn gia sư thành công!');
    }

    public function reject(Application $application)
    {
        $application->update(['status' => 'rejected']);
        return back();
    }
}