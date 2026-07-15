<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subject\StoreSubjectRequest;
use App\Http\Requests\Admin\Subject\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('grades')->latest()->paginate(5);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(StoreSubjectRequest $request)
    {
        $existingSubject = Subject::where('name', $request->name)->first();

        if ($existingSubject) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Đã tồn tại môn học với tên này rồi');
        }

        Subject::create([
            'name' => $request->name,
            'status' => 1
        ]);

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Thêm môn học thành công');
    }

    public function edit(Subject $subject)
    {
        $grades = \App\Models\Grade::orderBy('sort_order')->get();

        return view('admin.subjects.edit', compact('subject', 'grades'));
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $existingSubject = Subject::withTrashed()
            ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
            ->where('id', '!=', $subject->id)
            ->first();

        if ($existingSubject) {
            return back()
                ->withInput()
                ->with('error', 'Đã tồn tại môn học với tên này rồi');
        }

        $subject->update([
            'name' => $request->name
        ]);

        $subject->grades()->sync($request->grades ?? []);

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);

        if ($subject->classRequests()->exists()) {
            return redirect()
                ->route('admin.subjects.index')
                ->with('error', 'Không thể xóa môn học này(đã tồn tại trong đơn đăng lớp)!');
        }

        $subject->delete();

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Đã chuyển môn học vào thùng rác.');
    }

    public function trash()
    {
        $subjects = Subject::with('grades')
            ->onlyTrashed()
            ->paginate(5);

        return view('admin.subjects.trash', compact('subjects'));
    }

    public function restore($id)
    {
        $subject = Subject::onlyTrashed()->findOrFail($id);
        $subject->restore();

        return redirect()
            ->route('admin.subjects.trash')
            ->with('success', 'Khôi phục môn học thành công!');
    }

    public function forceDelete($id)
    {
        $subject = Subject::onlyTrashed()->findOrFail($id);

        $subject->grades()->detach();

        $subject->forceDelete();

        return redirect()
            ->route('admin.subjects.trash')
            ->with('success', 'Đã xóa vĩnh viễn môn học!');
    }

    public function approve(Subject $subject)
    {
        $subject->update(['is_approved' => true]);
        return back()->with('success', 'Đã duyệt môn học thành công.');
    }

    public function toggleStatus(Subject $subject)
    {
        $subject->status = $subject->status == 1 ? 0 : 1;
        $subject->save();

        return response()->json([
            'success' => true,
            'status' => $subject->status
        ]);
    }
}