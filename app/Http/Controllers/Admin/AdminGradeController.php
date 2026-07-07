<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Grade\StoreGradeRequest;
use App\Http\Requests\Admin\Grade\UpdateGradeRequest;
use App\Models\Grade;

class AdminGradeController extends Controller
{
    public function index()
    {
        $grades = Grade::latest()->paginate(5);
        return view('admin.grades.index', compact('grades'));
    }

    public function create()
    {
        return view('admin.grades.create');
    }

    public function store(StoreGradeRequest $request)
    {
        // Tìm cả bản ghi đã xóa mềm
        $existingGrade = Grade::withTrashed()
            ->where('sort_order', $request->sort_order)
            ->first();

        if ($existingGrade) {

            $statusText = $existingGrade->deleted_at
                ? 'đang nằm trong thùng rác'
                : 'đang hoạt động';

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'sort_order' => "Thứ tự sắp xếp này đã thuộc về ngành học '{$existingGrade->name}' ({$statusText})."
                ]);
        }

        Grade::create([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'status' => 1
        ]);

        return redirect()->route('admin.grades.index')
            ->with('success', 'Thêm ngành học thành công');
    }

    public function edit(Grade $grade)
    {
        return view('admin.grades.edit', compact('grade'));
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade->update($request->validated());

        return redirect()->route('admin.grades.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);

        $grade->delete(); // soft delete

        return redirect()->route('admin.grades.index')
            ->with('success', 'Xóa ngành học thành công');
    }

    public function trash()
    {
        $grades = Grade::onlyTrashed()->paginate(5);

        return view('admin.grades.trash', compact('grades'));
    }

    public function restore($id)
    {
        $grade = Grade::onlyTrashed()->findOrFail($id);
        $grade->restore();

        return back()->with('success', 'Khôi phục thành công');
    }

    public function forceDelete($id)
    {
        $grade = Grade::onlyTrashed()->findOrFail($id);
        $grade->forceDelete();

        return back()->with('delete_success', 'Đã xóa vĩnh viễn');
    }

    public function approve(Grade $grade)
    {
        $grade->update(['is_approved' => true]);
        return back()->with('success', 'Đã duyệt ngành học thành công.');
    }

    public function toggleStatus(Grade $grade)
    {
        $grade->status = $grade->status == 1 ? 0 : 1;
        $grade->save();

        return response()->json([
            'success' => true,
            'status' => $grade->status
        ]);
    }
}