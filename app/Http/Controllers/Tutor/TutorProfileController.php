<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Tutor\UpdateTutorProfileRequest;
use App\Models\Subject;
use App\Models\TutorDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TutorProfileController extends Controller
{
    public function edit()
    {
        $tutor = auth()->user()->tutor;

        if (!$tutor) {
            return redirect()
                ->route('tutor.home')
                ->with('error', 'Không tìm thấy hồ sơ gia sư.');
        }

        if ($tutor->status === 'draft') {
            return redirect()
                ->route('tutor.home')
                ->with('warning', 'Phải chờ quản trị chấp nhận yêu cầu đăng ký.');
        }

        if ($tutor->status !== 'pending') {
            return redirect()
                ->route('tutor.home')
                ->with('error', 'Bạn không có quyền cập nhật hồ sơ lúc này.');
        }

        $subjects = Subject::where('status', 1)->get();

        return view('tutor.profile.edit', compact('tutor', 'subjects'));
    }

    public function update(UpdateTutorProfileRequest $request)
    {
        $tutor = auth()->user()->tutor;

        if (!$tutor || $tutor->status !== 'pending') {
            return redirect()
                ->route('tutor.home')
                ->with('error', 'Bạn không thể cập nhật hồ sơ ở trạng thái hiện tại.');
        }

        try {
            DB::transaction(function () use ($request, $tutor) {

                $tutor->update([
                    'bio' => $request->bio,
                    'education' => $request->education,
                    'experience' => $request->experience,
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
            });

            return redirect()
                ->route('tutor.profile.edit')
                ->with('success', 'Cập nhật hồ sơ thành công!');
        } catch (\Exception $e) {

            Log::error('Update Tutor Profile Error: ' . $e->getMessage());

            return redirect()
                ->route('tutor.home')
                ->with('error', 'Có lỗi xảy ra khi cập nhật hồ sơ. Vui lòng thử lại.');
        }
    }
}