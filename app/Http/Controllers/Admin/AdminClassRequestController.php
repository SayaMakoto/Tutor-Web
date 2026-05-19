<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ClassRequest\StoreGradeFromRequest;
use App\Http\Requests\Admin\ClassRequest\StoreSubjectFromRequest;
use App\Http\Requests\Admin\ClassRequest\UpdateClassRequestStatusRequest;
use App\Models\ClassRequest;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminClassRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRequest::query()
            ->with(['grade', 'subject']);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {

                // 🔎 Tìm theo mã yêu cầu (ID)
                if (is_numeric($keyword)) {
                    $q->orWhere('id', $keyword);
                }

                // 🔎 Tìm theo tên grade
                $q->orWhereHas('grade', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%$keyword%");
                });

                // 🔎 Tìm theo tên subject
                $q->orWhereHas('subject', function ($q3) use ($keyword) {
                    $q3->where('name', 'like', "%$keyword%");
                });

            });
        }

        // 🎯 Filter theo status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $classRequests = $query->latest()->paginate(6)->withQueryString();

        return view('admin.class_requests.index', compact('classRequests'));
    }



    public function show(string $id)
    {
        $classRequest = ClassRequest::withTrashed()
            ->with([
                'student.user',
                'grade',
                'subject'
            ])
            ->findOrFail($id);

        return view('admin.class_requests.show', compact('classRequest'));
    }

    public function update(UpdateClassRequestStatusRequest $request, string $id)
    {
        $classRequest = ClassRequest::findOrFail($id);

        if ($classRequest->status === 'completed') {
            return back()->withErrors('Lớp đã hoàn thành, không thể thay đổi trạng thái.');
        }

        $classRequest->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái.');
    }

    public function destroy(string $id)
    {
        $classRequest = ClassRequest::findOrFail($id);

        if ($classRequest->status !== 'cancelled') {
            return back()->with('error', 'Chỉ được xoá lớp đã hủy.');
        }

        $classRequest->delete();

        return back()->with('success', 'Đã chuyển lớp vào thùng rác.');
    }

    public function trash()
    {
        $classRequests = ClassRequest::onlyTrashed()
            ->with('student.user')
            ->latest()
            ->paginate(6);

        return view('admin.class_requests.trash', compact('classRequests'));
    }

    public function forceDelete($id)
    {
        $classRequests = ClassRequest::onlyTrashed()->findOrFail($id);
        $classRequests->forceDelete();

        return back()->with('delete_success', 'Đã xóa vĩnh viễn');
    }

    public function createSubject(StoreSubjectFromRequest $request, $id)
    {
        $classRequest = ClassRequest::findOrFail($id);

        $name = ucwords(trim($request->name));

        $subject = Subject::firstOrCreate([
            'name' => $name
        ]);

        // 🔥 nếu classRequest có grade_id thì gán luôn
        if ($classRequest->grade_id) {
            $subject->grades()->syncWithoutDetaching([
                $classRequest->grade_id
            ]);
        }

        $classRequest->update([
            'subject_id' => $subject->id,
            'subject_request' => null
        ]);

        return back()->with('success', 'Đã thêm môn học vào hệ thống.');
    }

    public function createGrade(StoreGradeFromRequest $request, $id)
    {
        $classRequest = ClassRequest::findOrFail($id);

        $name = ucwords(trim($request->name));

        $grade = Grade::firstOrCreate([
            'name' => $name
        ]);

        // 🔥 nếu đã có subject thì gán ngược lại
        if ($classRequest->subject_id) {
            $grade->subjects()->syncWithoutDetaching([
                $classRequest->subject_id
            ]);
        }

        $classRequest->update([
            'grade_id' => $grade->id,
            'grade_request' => null
        ]);

        return back()->with('success', 'Đã thêm ngành học vào hệ thống.');
    }
}