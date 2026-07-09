<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ClassRequest\FilterRequest;
use App\Http\Requests\Frontend\ClassRequest\UpdateRequest;
use App\Models\ClassRequest;
use App\Models\Grade;
use App\Models\Subject;

class ClassRequestController extends Controller
{
    public function index(FilterRequest $request)
    {
        // Lấy thông tin học viên từ user role student hoặc both
        $student = auth()->user()?->student;
        $both = auth()->user()?->both;

        if (!$student && !$both) {
            return redirect()->route('login')->with('info', 'Bạn cần đăng nhập để truy cập vào trang này.');
        }

        $query = ClassRequest::where('student_id', $student->id);

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
            'tutor.user',
            'schedules'
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

        if ($class_request->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể chỉnh sửa yêu cầu đang chờ duyệt.');
        }

        $grades = Grade::all();
        $subjects = Subject::all();

        return view('student.classes.edit', compact('class_request', 'grades', 'subjects'));
    }

    public function update(UpdateRequest $request, ClassRequest $class_request)
    {
        $class_request->update($request->validated());

        return redirect()->route('classes.show', $class_request->id)
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy(ClassRequest $class_request)
    {
        // Kiểm tra quyền sở hữu
        if ($class_request->student_id != auth()->user()->student->id) {
            abort(403);
        }

        $tutorClass = $class_request->tutorClass;
        
        if ($tutorClass) {
            if ($tutorClass->status === 'completed') {
                return back()->with('error', 'Lớp học đã hoàn thành, không thể hủy.');
            }
            
            if ($tutorClass->status === 'cancelled') {
                return back()->with('error', 'Lớp học đã được hủy trước đó.');
            }
            
            if ($tutorClass->status === 'active') {
                // Hủy lớp học đang học thử (hoàn tiền 20% xu cho gia sư)
                $tutorClass->update(['status' => 'cancelled']);
                
                $totalValueCoins = (int) round($class_request->total_value / 1000);
                $walletService = new \App\Services\WalletService();
                $walletService->cancelClassAndRefund($tutorClass->tutor->user, $totalValueCoins, $class_request->id);
            } elseif ($tutorClass->status === 'payment_pending') {
                // Hủy lớp khi gia sư chưa đóng phí
                $tutorClass->update(['status' => 'cancelled']);
            }
        }

        $class_request->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Lớp học và phân công gia sư đã được hủy thành công.');
    }

    public function restore(ClassRequest $class_request)
    {
        if ($class_request->student_id != auth()->user()->student->id) {
            abort(403);
        }

        if ($class_request->status !== 'cancelled') {
            return back()->with('error', 'Chỉ có thể khôi phục lớp đã hủy.');
        }

        $class_request->update([
            'status' => 'pending'
        ]);

        return back()->with('success', 'Đã khôi phục lớp thành công.');
    }
}