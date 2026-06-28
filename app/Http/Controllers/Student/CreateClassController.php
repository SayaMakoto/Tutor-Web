<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreateClass\Step1Request;
use App\Http\Requests\Frontend\CreateClass\Step2Request;
use App\Http\Requests\Frontend\CreateClass\Step3Request;
use App\Http\Requests\Frontend\CreateClass\Step4Request;
use App\Models\ClassRequest;
use App\Models\Grade;
use App\Models\Subject;

class CreateClassController extends Controller
{
    public function step1()
    {
        $grades = Grade::with(['subjects' => function($q) {
                $q->where('is_approved', true);
            }])
            ->where('is_approved', true)
            ->orderBy('sort_order')
            ->get();
        $subjects = Subject::with(['grades:id'])
            ->where('is_approved', true)
            ->get()
            ->unique('id');

        return view('student.classes.create_step.step1', [
            'step' => 1,
            'grades' => $grades,
            'subjects' => $subjects
        ]);
    }

    public function step2()
    {
        $data = session('create_class');

        if (!$data) {
            return redirect()->route('create-class.step1');
        }

        if (!empty($data['grade_id'])) {
            $data['grade_name'] = Grade::find($data['grade_id'])?->name;
        }

        if (!empty($data['subject_id'])) {
            $data['subject_name'] = Subject::find($data['subject_id'])?->name;
        }

        return view('student.classes.create_step.step2', [
            'step' => 2,
            'data' => $data,
        ]);
    }

    public function step3()
    {
        if (!session('create_class')) {
            return redirect()->route('create-class.step1');
        }

        return view('student.classes.create_step.step3', [
            'step' => 3,
        ]);
    }

    public function step4()
    {
        if (!session('create_class')) {
            return redirect()->route('create-class.step1');
        }

        return view('student.classes.create_step.step4', [
            'step' => 4
        ]);
    }

    public function postStep1(Step1Request $request)
    {
        $data = $request->validated();

        session([
            'create_class' => [
                'grade_id' => $data['grade_id'] !== 'other' ? $data['grade_id'] : null,
                'grade_request' => $data['grade_id'] === 'other' ? $data['grade_request'] : null,
                'subject_id' => $data['subject_id'] !== 'other' ? $data['subject_id'] : null,
                'subject_request' => $data['subject_id'] === 'other' ? $data['subject_request'] : null,
            ]
        ]);

        return redirect()->route('create-class.step2');
    }

    public function postStep2(Step2Request $request)
    {
        $step1 = session('create_class', []);

        session([
            'create_class' => array_merge($step1, $request->validated())
        ]);

        return redirect()->route('create-class.step3');
    }

    public function postStep3(Step3Request $request)
    {
        $stepData = session('create_class', []);

        $location = null;

        if ($request->study_type === 'online') {
            $location = 'Online';
        } else {
            if (!empty($request->full_address)) {
                $location = $request->full_address;
            } else {
                $parts = array_filter([
                    $request->detail_address,
                    $request->ward,
                    $request->province
                ]);
                $location = implode(', ', $parts);
            }
        }

        session([
            'create_class' => array_merge($stepData, [
                ...$request->validated(),
                'location' => $location,
            ])
        ]);

        return redirect()->route('create-class.step4');
    }

    public function postStep4(Step4Request $request)
    {
        $stepData = session('create_class', []);

        $timeRange = $request->time_start . ' - ' . $request->time_end;

        session([
            'create_class' => array_merge($stepData, [
                'weeks' => $request->weeks,
                'schedule' => implode(', ', $request->schedule),
                'schedule_days' => $request->schedule,
                'time' => $timeRange,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
            ])
        ]);

        return redirect()->route('create-class.confirm');
    }

    public function confirm()
    {
        $data = session('create_class');

        if (!$data) {
            return redirect()->route('create-class.step1');
        }

        // Lấy grade name nếu có grade_id
        if (!empty($data['grade_id'])) {
            $data['grade_display'] =
                \App\Models\Grade::find($data['grade_id'])?->name
                ?? 'Không xác định';
        } else {
            $data['grade_display'] =
                $data['grade_request']
                ?? 'Không xác định';
        }

        // Lấy subject name nếu có subject_id
        if (!empty($data['subject_id'])) {
            $data['subject_display'] =
                \App\Models\Subject::find($data['subject_id'])?->name
                ?? 'Không xác định';
        } else {
            $data['subject_display'] =
                $data['subject_request']
                ?? 'Không xác định';
        }

        $data['gender_display'] = match ($data['gender'] ?? null) {
            'male' => 'Nam',
            'female' => 'Nữ',
            'no_need' => 'Không yêu cầu',
            default => 'Không xác định',
        };

        return view('student.classes.create_step.confirm', [
            'step' => 5,
            'data' => $data
        ]);
    }

    public function store()
    {
        $data = session('create_class');

        if (!$data) {
            return redirect()->route('create-class.step1');
        }

        // 1. Tạo ngành học tự nhập (chờ duyệt) nếu có
        $gradeId = null;
        if (!empty($data['grade_request'])) {
            $grade = Grade::create([
                'name' => $data['grade_request'],
                'status' => true,
                'is_approved' => false,
            ]);
            $gradeId = $grade->id;
        } else {
            $gradeId = $data['grade_id'] ?? null;
        }

        // 2. Tạo môn học tự nhập (chờ duyệt) nếu có
        $subjectId = null;
        if (!empty($data['subject_request'])) {
            $subject = Subject::create([
                'name' => $data['subject_request'],
                'status' => true,
                'is_approved' => false,
            ]);
            $subjectId = $subject->id;
        } else {
            $subjectId = $data['subject_id'] ?? null;
        }

        // 3. Tạo ClassRequest
        $classRequest = ClassRequest::create([
            'student_id' => auth()->user()->student->id,
            'grade_id' => $gradeId,
            'subject_id' => $subjectId,
            'degree' => $data['degree'] ?? null,
            'experience' => $data['experience'] ?? null,
            'gender' => $data['gender'] ?? null,
            'age_range' => $data['age_range'] ?? null,
            'fee' => $data['fee'] ?? null,
            'description' => $data['description'] ?? null,
            'study_type' => $data['study_type'] ?? null,
            'location' => $data['location'] ?? null,
            'weeks' => $data['weeks'] ?? null,
            'status' => 'pending'
        ]);

        // 4. Lưu lịch học chi tiết vào bảng class_schedules
        if (!empty($data['schedule_days'])) {
            foreach ($data['schedule_days'] as $day) {
                $classRequest->schedules()->create([
                    'day_of_week' => $day,
                    'start_time' => $data['time_start'] ?? '00:00',
                    'end_time' => $data['time_end'] ?? '00:00',
                ]);
            }
        }

        session()->forget('create_class');

        return redirect()->route('classes.index')
            ->with('success', 'Tạo lớp thành công! Lớp đang chờ quản trị viên duyệt.');
    }
}