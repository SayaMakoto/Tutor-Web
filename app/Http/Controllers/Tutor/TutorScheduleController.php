<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\TutorClass;

class TutorScheduleController extends Controller
{
    public function index()
    {
        $tutor = auth()->user()->tutor;

        // Lấy các lớp đang dạy hoặc chờ thanh toán (không lấy lớp đã hoàn thành/hủy)
        $tutorClasses = TutorClass::where('tutor_id', $tutor->id)
            ->whereIn('status', ['active', 'payment_pending'])
            ->with(['classRequest.schedules', 'classRequest.subject', 'classRequest.grade', 'classRequest.student.user'])
            ->get();

        // Tạo danh sách events cho lịch tuần
        $dayMap = [
            'T2' => 'monday', 'Thứ 2' => 'monday',
            'T3' => 'tuesday', 'Thứ 3' => 'tuesday',
            'T4' => 'wednesday', 'Thứ 4' => 'wednesday',
            'T5' => 'thursday', 'Thứ 5' => 'thursday',
            'T6' => 'friday', 'Thứ 6' => 'friday',
            'T7' => 'saturday', 'Thứ 7' => 'saturday',
            'CN' => 'sunday', 'Chủ nhật' => 'sunday',
        ];

        // Màu sắc cho mỗi lớp
        $colors = [
            ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
            ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
            ['bg' => 'bg-teal-50', 'border' => 'border-teal-200', 'text' => 'text-teal-700', 'dot' => 'bg-teal-500'],
            ['bg' => 'bg-cyan-50', 'border' => 'border-cyan-200', 'text' => 'text-cyan-700', 'dot' => 'bg-cyan-500'],
            ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'],
            ['bg' => 'bg-violet-50', 'border' => 'border-violet-200', 'text' => 'text-violet-700', 'dot' => 'bg-violet-500'],
            ['bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
            ['bg' => 'bg-rose-50', 'border' => 'border-rose-200', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500'],
        ];

        $scheduleByDay = [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
        ];

        $totalSessionsPerWeek = 0;
        $totalHoursPerWeek = 0;
        $activeClasses = $tutorClasses->where('status', 'active');

        foreach ($tutorClasses as $index => $tc) {
            $cr = $tc->classRequest;
            if (!$cr) continue;

            $color = $colors[$index % count($colors)];

            foreach ($cr->schedules as $schedule) {
                $dayKey = $dayMap[$schedule->day_of_week] ?? null;
                if (!$dayKey) continue;

                $start = \Carbon\Carbon::parse($schedule->start_time);
                $end = \Carbon\Carbon::parse($schedule->end_time);
                $hours = $start->diffInMinutes($end) / 60.0;

                if ($tc->status === 'active') {
                    $totalSessionsPerWeek++;
                    $totalHoursPerWeek += $hours;
                }

                $scheduleByDay[$dayKey][] = [
                    'class_id' => $cr->id,
                    'subject' => $cr->subject->name ?? 'N/A',
                    'grade' => $cr->grade->name ?? '',
                    'start_time' => $start->format('H:i'),
                    'end_time' => $end->format('H:i'),
                    'hours' => round($hours, 1),
                    'study_type' => $cr->study_type,
                    'status' => $tc->status,
                    'status_label' => $tc->status_label,
                    'fee' => $cr->fee,
                    'color' => $color,
                ];
            }
        }

        // Sắp xếp mỗi ngày theo thời gian bắt đầu
        foreach ($scheduleByDay as &$daySchedules) {
            usort($daySchedules, fn($a, $b) => strcmp($a['start_time'], $b['start_time']));
        }

        return view('tutor.schedule', compact(
            'tutorClasses',
            'scheduleByDay',
            'activeClasses',
            'totalSessionsPerWeek',
            'totalHoursPerWeek',
        ));
    }
}
