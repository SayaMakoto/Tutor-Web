@extends('layouts.tutor')

@section('content')
    <div class="max-w-3xl mx-auto mt-6 bg-white shadow-md rounded-lg p-5">

        <h2 class="text-2xl font-bold mb-4">Cập nhật hồ sơ gia sư</h2>

        {{-- Thông tin cơ bản --}}
        <div class="mb-4 bg-gray-50 p-3 rounded-md text-sm">
            <p><strong>Họ tên:</strong> {{ $tutor->user->name }}</p>
            <p><strong>Email:</strong> {{ $tutor->user->email }}</p>
            <p><strong>Giới tính:</strong> {{ $tutor->user->gender }}</p>
        </div>

        <form action="{{ route('tutor.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">
                    Học vấn
                </label>
                <input type="text" name="education" value="{{ old('education', $tutor->education) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">
                    Kinh nghiệm
                </label>
                <input type="text" name="experience" value="{{ old('experience', $tutor->experience) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">
                    Giới thiệu
                </label>
                <textarea name="bio" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm leading-relaxed focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none">{{ old('bio', $tutor->bio) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-3">
                    Môn có thể dạy
                </label>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-y-2 gap-x-3">
                    @foreach ($subjects as $subject)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                                {{ in_array($subject->id, $tutor->subjects->pluck('id')->toArray()) ? 'checked' : '' }}>
                            {{ $subject->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-3">
                    Tải thêm tài liệu
                </label>

                <div x-data="{ files: [1] }" class="mb-4">
                    <template x-for="(file, index) in files" :key="index">
                        <div class="mb-2">
                            <input type="file" name="documents[]"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </template>

                    <button type="button" @click="files.push(files.length + 1)"
                        class="text-sm text-blue-600 hover:underline mt-2">
                        + Thêm tài liệu
                    </button>
                </div>

                {{-- Bảng checklist nằm dưới --}}
                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                <th class="p-2 text-left w-16 border-r border-gray-300">STT</th>
                                <th class="p-2 text-left">Tên file</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tutor->documents as $index => $doc)
                                <tr class="border-b border-gray-200">
                                    <td class="p-2 border-r border-gray-200">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="p-2">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            {{ basename($doc->file_path) }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="p-3 text-center text-gray-500">
                                        Chưa có tài liệu nào
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('tutor.home') }}"
                    class="border-2 border-gray-300 text-gray-700 px-6 py-2 rounded-lg
              hover:bg-gray-100 hover:border-gray-400 transition">
                    ← Quay lại
                </a>

                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
@endsection
