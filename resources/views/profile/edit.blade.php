@extends($layout)

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="py-6 max-w-4xl mx-auto px-4" x-data="avatarPreview()">
    <!-- Breadcrumb / Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-id-card text-blue-600"></i> Thông tin cá nhân
        </h1>
        <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin của bạn để hoàn thiện hồ sơ trên hệ thống GiaSu247.</p>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
            @csrf
            @method('PUT')

            <!-- General Profile Information -->
            <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Left side: Avatar Management -->
                <div class="flex flex-col items-center border-b md:border-b-0 md:border-r border-gray-100 pb-8 md:pb-0 md:pr-8">
                    <div class="relative group">
                        <!-- Preview Image Container -->
                        <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-white shadow-lg ring-2 ring-gray-100 transition duration-300 group-hover:scale-105 relative">
                            <img :src="previewUrl || '{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff' }}'" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <label class="mt-4 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        Ảnh đại diện
                    </label>

                    <!-- Hidden input file, custom styled button -->
                    <div class="mt-4 w-full">
                        <label for="avatar-input" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-bold text-gray-600 bg-white hover:bg-gray-50 hover:border-gray-300 cursor-pointer transition shadow-sm">
                            <i class="fas fa-camera text-gray-400"></i> Chọn ảnh mới
                        </label>
                        <input id="avatar-input" type="file" name="avatar" class="hidden" @change="fileChosen" accept="image/*">
                    </div>

                    <!-- Dynamic Preview Notice Box -->
                    <div class="mt-4 w-full">
                        <div class="p-3 rounded-xl border text-xs leading-relaxed transition-all duration-300"
                             :class="previewUrl ? 'bg-blue-50 border-blue-100 text-blue-700' : 'bg-gray-50 border-gray-100 text-gray-400'">
                            
                            <!-- Static box notice when no change is made -->
                            <div x-show="!previewUrl" class="flex items-start gap-2">
                                <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                                <span>Chưa chọn ảnh mới. Chọn một tệp hình ảnh để xem trước trực tiếp tại đây.</span>
                            </div>

                            <!-- Animated preview notice when file is chosen -->
                            <div x-show="previewUrl" class="flex items-start gap-2" style="display: none;">
                                <i class="fas fa-eye text-blue-500 mt-0.5 animate-pulse"></i>
                                <span><strong>Xem trước ảnh mới!</strong> Nhấn nút "Lưu thay đổi" ở góc dưới bên phải để áp dụng ảnh này.</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right side: Profile Form Inputs -->
                <div class="md:col-span-2 space-y-6">
                    
                    <!-- Họ và tên -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Họ và tên <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 text-xs"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                class="pl-10 block w-full border border-gray-200 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm"
                                placeholder="Nhập họ và tên đầy đủ của bạn" required>
                        </div>
                    </div>

                    <!-- Email (Disabled) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Địa chỉ Email
                        </label>
                        <div class="mt-1 relative rounded-xl shadow-sm bg-gray-50">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 text-xs"></i>
                            </div>
                            <input type="email" value="{{ Auth::user()->email }}" disabled
                                class="pl-10 block w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50 text-gray-400 cursor-not-allowed text-sm">
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1.5"><i class="fas fa-info-circle mr-1"></i> Email không thể thay đổi để đảm bảo an toàn tài khoản.</p>
                    </div>

                    <!-- Số điện thoại -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Số điện thoại <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400 text-xs"></i>
                            </div>
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                class="pl-10 block w-full border {{ is_null(Auth::user()->phone) ? 'border-red-300 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200 focus:ring-blue-500/20 focus:border-blue-500' }} rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none transition text-sm"
                                placeholder="Nhập số điện thoại di động" required>
                        </div>
                        @if(is_null(Auth::user()->phone))
                            <span class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-2">
                                <i class="fas fa-exclamation-circle text-[10px]"></i> Bạn chưa cập nhật số điện thoại. Vui lòng bổ sung để kết nối gia sư/học viên.
                            </span>
                        @endif
                    </div>

                    <!-- Ngày sinh -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Ngày sinh <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                            </div>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}"
                                class="pl-10 block w-full border {{ is_null(Auth::user()->date_of_birth) ? 'border-red-300 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200 focus:ring-blue-500/20 focus:border-blue-500' }} rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none transition text-sm"
                                required>
                        </div>
                        @if(is_null(Auth::user()->date_of_birth))
                            <span class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-2">
                                <i class="fas fa-exclamation-circle text-[10px]"></i> Bạn chưa cập nhật ngày sinh. Vui lòng bổ sung thông tin này.
                            </span>
                        @endif
                    </div>

                </div>
            </div>

            <!-- Tutor Specific Information (Merged Section) -->
            @if ($tutor)
                <div class="p-6 md:p-8 space-y-6 bg-gray-50/50">
                    <div class="border-b border-gray-150 pb-3">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-user-graduate text-blue-600"></i> Thông tin Hồ sơ Gia sư
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Thông tin chuyên môn này sẽ được sử dụng để hiển thị cho Học viên khi duyệt lớp học.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Trình độ học vấn -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">
                                Trình độ học vấn / Bằng cấp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="education" value="{{ old('education', $tutor->education) }}"
                                class="mt-1 block w-full border border-gray-200 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm"
                                placeholder="Ví dụ: Cử nhân Sư phạm Toán, Sinh viên ĐH Ngoại Thương" required>
                        </div>

                        <!-- Số năm kinh nghiệm -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">
                                Số năm kinh nghiệm dạy kèm <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="experience" value="{{ old('experience', $tutor->experience) }}"
                                class="mt-1 block w-full border border-gray-200 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm"
                                min="0" placeholder="Nhập số năm kinh nghiệm" required>
                        </div>
                    </div>

                    <!-- Giới thiệu bản thân -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Giới thiệu bản thân / Phương pháp giảng dạy
                        </label>
                        <textarea name="bio" rows="4"
                            class="mt-1 block w-full border border-gray-200 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm resize-none"
                            placeholder="Mô tả chi tiết về phương pháp giảng dạy, điểm mạnh và những thành tích bạn đạt được để thu hút học viên...">{{ old('bio', $tutor->bio) }}</textarea>
                    </div>

                    <!-- Môn học đăng ký dạy (Checklist) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Môn học đăng ký dạy <span class="text-red-500">*</span>
                        </label>
                        <div class="p-4 bg-white rounded-xl border border-gray-150 grid grid-cols-2 md:grid-cols-4 gap-3 shadow-sm">
                            @foreach ($subjects as $subject)
                                <label class="flex items-center gap-2 px-3 py-2 border border-gray-100 rounded-lg hover:bg-gray-50 transition cursor-pointer text-sm font-medium text-gray-700">
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                        class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300"
                                        {{ in_array($subject->id, $tutor->subjects->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <span>{{ $subject->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hồ sơ / Tài liệu xác thực chứng minh năng lực -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700">
                            Tài liệu xác thực (Bằng cấp, bảng điểm, chứng chỉ)
                        </label>

                        <!-- Alpine list upload -->
                        <div x-data="{ docInputs: [0] }" class="space-y-3">
                            <template x-for="(inputIndex, idx) in docInputs" :key="inputIndex">
                                <div class="flex items-center gap-2">
                                    <input type="file" name="documents[]"
                                        class="block w-full text-xs text-gray-500 border border-gray-200 rounded-lg bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <button type="button" x-show="docInputs.length > 1" @click="docInputs = docInputs.filter(item => item !== inputIndex)"
                                        class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all duration-150">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            </template>

                            <button type="button" @click="docInputs.push(Date.now())"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-dashed border-blue-300 hover:border-blue-500 text-blue-600 hover:bg-blue-50 text-xs font-semibold transition">
                                <i class="fas fa-plus"></i> Thêm tài liệu khác
                            </button>
                        </div>

                        <!-- Table showing already uploaded documents with delete option -->
                        <div class="mt-4 border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white">
                            <table class="w-full text-sm border-collapse text-left">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="p-3 font-semibold text-gray-600 text-xs w-16 text-center border-r border-gray-200">STT</th>
                                        <th class="p-3 font-semibold text-gray-600 text-xs">Tên tài liệu</th>
                                        <th class="p-3 font-semibold text-gray-600 text-xs w-28 text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-150">
                                    @forelse($tutor->documents as $index => $doc)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="p-3 text-center border-r border-gray-150 text-gray-500 text-xs">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="p-3">
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 hover:underline font-medium text-sm">
                                                    <i class="fas fa-file-alt text-gray-400"></i>
                                                    {{ basename($doc->file_path) }}
                                                </a>
                                            </td>
                                            <td class="p-3 text-center">
                                                <button type="button" 
                                                        onclick="deleteDocument({{ $doc->id }}, '{{ basename($doc->file_path) }}')"
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-red-600 hover:text-white border border-red-200 hover:bg-red-600 rounded-lg transition-all duration-150 shadow-sm">
                                                    <i class="fas fa-trash-alt"></i> Xóa
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="p-4 text-center text-gray-400 text-xs">
                                                <i class="fas fa-folder-open text-gray-300 text-lg block mb-1"></i>
                                                Chưa có tài liệu minh chứng nào được lưu.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Actions -->
            <div class="p-5 bg-gray-50 flex flex-col sm:flex-row items-center justify-end gap-3">
                @php
                    $role = Auth::user()->role;
                    $homeRoute = ($role === 'tutor') ? route('tutor.home') : route('student.home');
                @endphp

                <a href="{{ $homeRoute }}"
                    class="w-full sm:w-auto text-center px-6 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-150 text-gray-700 bg-white text-sm font-semibold transition-all duration-150">
                    Quay về trang chủ
                </a>

                <button type="submit"
                    class="w-full sm:w-auto text-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-all duration-150 shadow-sm hover:shadow-md">
                    Lưu thay đổi
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Helper Delete Form for Documents -->
<form id="delete-document-form" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function avatarPreview() {
        return {
            previewUrl: null,
            fileChosen(event) {
                const file = event.target.files[0];
                if (file) {
                    this.previewUrl = URL.createObjectURL(file);
                } else {
                    this.previewUrl = null;
                }
            }
        }
    }

    function deleteDocument(id, filename) {
        if (confirm(`Bạn có chắc chắn muốn xóa tài liệu "${filename}"?`)) {
            const form = document.getElementById('delete-document-form');
            form.action = `/profile/documents/${id}`;
            form.submit();
        }
    }
</script>
@endsection
