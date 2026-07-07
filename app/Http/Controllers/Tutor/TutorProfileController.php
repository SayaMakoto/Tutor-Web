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
        return redirect()->route('profile.edit');
    }

    public function update(UpdateTutorProfileRequest $request)
    {
        $tutor = auth()->user()->tutor;

        if (!$tutor) {
            return redirect()
                ->route('tutor.home')
                ->with('error', 'Không tìm thấy hồ sơ gia sư.');
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
                ->route('profile.edit')
                ->with('success', 'Cập nhật hồ sơ gia sư thành công!');
        } catch (\Exception $e) {

            Log::error('Update Tutor Profile Error: ' . $e->getMessage());

            return redirect()
                ->route('tutor.home')
                ->with('error', 'Có lỗi xảy ra khi cập nhật hồ sơ. Vui lòng thử lại.');
        }
    }
}