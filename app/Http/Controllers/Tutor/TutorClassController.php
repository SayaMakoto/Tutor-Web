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
        $studentId = auth()->user()->student?->id;

        $approvedClasses = ClassRequest::where('status', 'approved')
            ->when($studentId, function ($query, $studentId) {
                return $query->where('student_id', '!=', $studentId);
            })
            ->latest()
            ->take(6)
            ->get();

        return view('tutor.classes.index', compact('approvedClasses'));
    }

    public function show(ClassRequest $class)
    {
        $class->load(['subject', 'grade', 'student.user', 'schedules']);
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

        $assignedClasses = ClassRequest::whereHas('tutorClass', function ($query) use ($tutorId) {
            $query->where('tutor_id', $tutorId);
        })
        ->where('status', 'assigned')
        ->latest()
        ->get();


        return view('tutor.classes.assigned', compact('assignedClasses'));
    }

    /**
     * Gia sư thanh toán phí nhận lớp (Tạm giữ 25%)
     */
    public function pay(ClassRequest $class)
    {
        $tutor = auth()->user()->tutor;
        if (!$tutor) {
            return back()->with('error', 'Bạn không phải gia sư.');
        }

        $tutorClass = $class->tutorClass;
        if (!$tutorClass || $tutorClass->tutor_id !== $tutor->id) {
            return back()->with('error', 'Lớp học này không được giao cho bạn.');
        }

        if ($tutorClass->status !== 'payment_pending') {
            return back()->with('error', 'Lớp học không ở trạng thái chờ thanh toán.');
        }

        // Tính 25% tổng giá trị lớp học (VND)
        $feeVnd = (int) round($class->total_value * 0.25);

        // Tạo đơn hàng thanh toán trực tiếp cho lớp học này
        $order = \App\Models\PaymentOrder::create([
            'user_id'          => auth()->id(),
            'class_request_id' => $class->id,
            'order_ref'        => 'GS247-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5)),
            'amount_vnd'       => $feeVnd,
            'payment_method'   => 'pending',
            'status'           => 'pending',
            'expires_at'       => now()->addMinutes(15),
        ]);

        return redirect()->route('payment.checkout', $order->order_ref);
    }

    /**
     * Gia sư hủy lớp học thử (hoàn 20% phí, giữ lại 5% phí dịch vụ)
     */
    public function cancel(ClassRequest $class)
    {
        $tutor = auth()->user()->tutor;
        if (!$tutor) {
            return back()->with('error', 'Bạn không phải gia sư.');
        }

        $tutorClass = $class->tutorClass;
        if (!$tutorClass || $tutorClass->tutor_id !== $tutor->id) {
            return back()->with('error', 'Lớp học này không được giao cho bạn.');
        }

        if ($tutorClass->status !== 'active') {
            return back()->with('error', 'Chỉ có thể hủy lớp học đang học thử.');
        }

        // Hủy lớp học
        $tutorClass->update(['status' => 'cancelled']);
        $class->update(['status' => 'cancelled']);

        $paymentService = new \App\Services\PaymentService();
        $paymentService->cancelClassAndRefund(auth()->user(), $class->total_value, $class->id);

        $refundAmount = (int) round($class->total_value * 0.20);
        return redirect()->route('tutor.classes.show', $class->id)
            ->with('success', 'Đã hủy lớp học thử thành công. Hệ thống đã hoàn lại 20% phí (' . number_format($refundAmount) . 'đ) cho bạn.');
    }

    /**
     * Gia sư mô phỏng hoàn thành lớp học (Hệ thống khấu trừ 25% vào doanh thu)
     */
    public function complete(ClassRequest $class)
    {
        $tutor = auth()->user()->tutor;
        if (!$tutor) {
            return back()->with('error', 'Bạn không phải gia sư.');
        }

        $tutorClass = $class->tutorClass;
        if (!$tutorClass || $tutorClass->tutor_id !== $tutor->id) {
            return back()->with('error', 'Lớp học này không được giao cho bạn.');
        }

        if ($tutorClass->status !== 'active') {
            return back()->with('error', 'Chỉ có thể hoàn thành lớp học đang dạy (active).');
        }

        $feeVnd = (int) round($class->total_value * 0.25);

        // Khấu trừ 25% phí đang bị đóng băng thành doanh thu hệ thống
        $paymentService = new \App\Services\PaymentService();
        $paymentService->chargeEscrow(auth()->user(), $feeVnd, $class->id);

        // Chỉ cập nhật trạng thái trong bảng classes (tutorClass), class_request vẫn là assigned
        $tutorClass->update(['status' => 'completed']);

        return redirect()->route('tutor.classes.show', $class->id)
            ->with('success', 'Hoàn thành lớp học thành công. Cảm ơn bạn đã đồng hành!');
    }
}
