@extends('layouts.admin')
@section('title', 'Chi tiết gia sư — ' . $tutor->user->name)

@section('content')
    @php
        $backRoute  = request('from') === 'users' ? route('admin.users.index') : route('admin.tutors.index');
        $avgRating  = round($tutor->reviews->avg('rating'), 1);
        $totalRevs  = $tutor->reviews->count();
    @endphp

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ $backRoute }}" class="hover:text-violet-600 transition">Danh sách gia sư</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">{{ $tutor->user->name }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Cột trái: Profile card --}}
        <div class="space-y-5">

            {{-- Avatar + Status card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                <div class="relative inline-block mb-4">
                    @if($tutor->user->avatar)
                        <img src="{{ asset('storage/' . $tutor->user->avatar) }}"
                             class="w-28 h-28 rounded-2xl object-cover mx-auto shadow-md" alt="avatar">
                    @else
                        <div class="w-28 h-28 rounded-2xl bg-gradient-to-br from-violet-100 to-indigo-200
                                    flex items-center justify-center mx-auto shadow-md">
                            <i class="fas fa-user text-violet-400 text-4xl"></i>
                        </div>
                    @endif
                </div>

                <h2 class="text-lg font-bold text-gray-800">{{ $tutor->user->name }}</h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ $tutor->user->email }}</p>

                <div class="mt-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $tutor->status_color }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                        {{ $tutor->status_label }}
                    </span>
                </div>

                {{-- Rating --}}
                <div class="mt-4 pt-4 border-t border-gray-100">
                    @if($totalRevs > 0)
                        <div class="flex items-center justify-center gap-1 text-amber-500">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-sm {{ $i <= round($avgRating) ? '' : 'opacity-30' }}"></i>
                            @endfor
                        </div>
                        <p class="text-sm font-bold text-gray-700 mt-1">{{ $avgRating }}/5</p>
                        <p class="text-xs text-gray-400">{{ $totalRevs }} đánh giá</p>
                    @else
                        <p class="text-sm text-gray-400">Chưa có đánh giá</p>
                    @endif
                </div>

                {{-- Quick action --}}
                <button onclick="openStatusModal()"
                        class="mt-4 w-full flex items-center justify-center gap-2
                               bg-gradient-to-r from-violet-600 to-indigo-600 text-white
                               py-2.5 rounded-xl text-sm font-semibold hover:shadow-md transition">
                    <i class="fas fa-pen text-xs"></i> Đổi trạng thái
                </button>
            </div>

            {{-- Tài liệu hồ sơ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2 mb-4">
                    <i class="fas fa-file-lines text-violet-500"></i> Hồ sơ minh chứng
                </h3>
                @if($tutor->documents->count())
                    <ul class="space-y-2">
                        @foreach($tutor->documents as $doc)
                            <li>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                   class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 hover:underline transition">
                                    <i class="fas fa-file-pdf text-rose-400 flex-shrink-0"></i>
                                    {{ $doc->type_label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-xs text-gray-400 text-center py-4">Chưa có tài liệu</p>
                @endif
            </div>
        </div>

        {{-- Cột phải: Info chi tiết --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Thông tin chuyên môn --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm">
                    <i class="fas fa-graduation-cap text-violet-500"></i> Thông tin chuyên môn
                </h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-violet-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-certificate text-violet-500 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Học vấn / Bằng cấp</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $tutor->education ?? 'Chưa cập nhật' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-briefcase text-emerald-500 text-xs"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">
                                {{ $tutor->experience ? $tutor->experience . ' năm' : 'Chưa có kinh nghiệm' }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($tutor->bio)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 mb-1.5">Giới thiệu bản thân</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $tutor->bio }}</p>
                    </div>
                @endif
            </div>

            {{-- Môn dạy --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm">
                    <i class="fas fa-book text-blue-500"></i> Môn có thể dạy
                </h3>
                @if($tutor->subjects->count())
                    <div class="flex flex-wrap gap-2">
                        @foreach($tutor->subjects as $subject)
                            <span class="px-3 py-1.5 bg-blue-50 border border-blue-100 text-blue-700 rounded-xl text-xs font-semibold">
                                {{ $subject->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400">Chưa đăng ký môn học</p>
                @endif
            </div>

            {{-- Đánh giá --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm">
                    <i class="fas fa-star text-amber-400"></i> Đánh giá từ học viên
                </h3>
                @if($tutor->reviews->count())
                    <div class="space-y-3">
                        @foreach($tutor->reviews as $review)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-semibold text-gray-800 text-sm">{{ $review->student->user->name }}</p>
                                    <div class="flex items-center gap-0.5 text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-xs {{ $i <= $review->rating ? '' : 'opacity-30' }}"></i>
                                        @endfor
                                        <span class="text-xs text-gray-500 ml-1">{{ $review->rating }}/5</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600">{{ $review->comment ?? 'Không có nhận xét.' }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-star text-gray-200 text-3xl mb-2"></i>
                        <p class="text-sm text-gray-400">Chưa có đánh giá nào</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Status Modal --}}
    <div id="statusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-pen text-violet-600"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800">Cập nhật trạng thái</h3>
            </div>
            <form action="{{ route('admin.tutors.update', $tutor->id) }}" method="POST">
                @csrf @method('PUT')
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Trạng thái mới</label>
                <select name="status"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm mb-5
                               focus:ring-2 focus:ring-violet-400 focus:border-transparent focus:outline-none bg-white">
                    @foreach(\App\Models\Tutor::statusOptions() as $key => $label)
                        <option value="{{ $key }}" {{ $tutor->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeStatusModal()"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition">
                        Huỷ
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openStatusModal()  { document.getElementById('statusModal').classList.replace('hidden','flex'); }
    function closeStatusModal() { document.getElementById('statusModal').classList.replace('flex','hidden'); }
    document.getElementById('statusModal').addEventListener('click', function(e){ if(e.target===this) closeStatusModal(); });
</script>
@endpush
