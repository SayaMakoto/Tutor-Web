<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\TutorDocument;
use App\Models\Subject;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $layout = $user->role === 'tutor' ? 'layouts.tutor' : 'layouts.student';
        
        $tutor = $user->tutor;
        $subjects = [];
        if ($tutor) {
            $tutor->load(['subjects', 'documents']);
            $subjects = Subject::where('status', 1)->get();
        }

        return view('profile.edit', compact('layout', 'tutor', 'subjects'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $isTutor = in_array($user->role, ['tutor', 'both']);

        $rules = [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^0[0-9]{9,10}$/'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today'
            ],
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($isTutor) {
            $rules['education'] = 'required|string|max:255';
            $rules['experience'] = 'required|integer|min:0';
            $rules['bio'] = 'nullable|string';
            $rules['subjects'] = 'required|array';
            $rules['subjects.*'] = 'exists:subjects,id';
            $rules['documents'] = 'nullable|array';
            $rules['documents.*'] = 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120';
        }

        $request->validate($rules, [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng 0 và gồm 10 hoặc 11 chữ số.',
            'date_of_birth.required' => 'Vui lòng nhập ngày sinh.',
            'date_of_birth.date' => 'Ngày sinh không hợp lệ.',
            'date_of_birth.before' => 'Ngày sinh phải trước ngày hôm nay.',
            
            'education.required' => 'Vui lòng nhập trình độ học vấn.',
            'experience.required' => 'Vui lòng nhập số năm kinh nghiệm.',
            'experience.integer' => 'Kinh nghiệm phải là số nguyên.',
            'subjects.required' => 'Vui lòng chọn ít nhất một môn dạy.',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        if ($isTutor && $user->tutor) {
            $tutor = $user->tutor;
            
            $tutor->update([
                'education' => $request->education,
                'experience' => $request->experience,
                'bio' => $request->bio,
            ]);

            $tutor->subjects()->sync($request->subjects);

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('tutor_documents', 'public');
                    TutorDocument::create([
                        'tutor_id' => $tutor->id,
                        'file_path' => $path,
                        'type' => 'additional',
                    ]);
                }
            }
        }

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function deleteDocument($id)
    {
        $document = TutorDocument::findOrFail($id);
        
        if ($document->tutor_id !== Auth::user()->tutor?->id) {
            abort(403, 'Bạn không có quyền xóa tài liệu này.');
        }

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Xóa tài liệu thành công!');
    }
}