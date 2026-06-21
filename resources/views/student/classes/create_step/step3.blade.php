@extends('student.classes.create')
@section('title', 'Bước 3: Địa điểm học')
@section('step-content')
    <form action="{{ route('create-class.post.step3') }}" method="POST" class="space-y-8">
        @csrf

        <div class="space-y-6">

            {{-- Hình thức học --}}
            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                    Chọn hình thức học tập
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Online --}}
                    <label class="flex items-center justify-between p-5 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none">
                        <input type="radio" name="study_type" value="online" class="sr-only peer"
                            {{ old('study_type', $data['study_type'] ?? 'online') == 'online' ? 'checked' : '' }}>
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-base font-semibold peer-checked:bg-blue-100">
                                <i class="fas fa-laptop-house"></i>
                            </span>
                            <div>
                                <span class="block text-sm font-bold text-gray-800 peer-checked:text-blue-600 transition">Trực tuyến (Online)</span>
                                <span class="block text-[11px] text-gray-400 mt-0.5">Học tập từ xa qua các nền tảng video call</span>
                            </div>
                        </div>
                        <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                        </div>
                    </label>

                    {{-- Offline --}}
                    <label class="flex items-center justify-between p-5 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none">
                        <input type="radio" name="study_type" value="offline" class="sr-only peer"
                            {{ old('study_type', $data['study_type'] ?? 'online') == 'offline' ? 'checked' : '' }}>
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-base font-semibold peer-checked:bg-indigo-100">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <div>
                                <span class="block text-sm font-bold text-gray-800 peer-checked:text-blue-600 transition">Trực tiếp (Offline)</span>
                                <span class="block text-[11px] text-gray-400 mt-0.5">Gia sư tới tận nơi giảng dạy trực tiếp</span>
                            </div>
                        </div>
                        <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                        </div>
                    </label>
                </div>
                @error('study_type')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- FORM ĐỊA CHỈ (luôn hiển thị dưới dạng card nhưng sẽ mờ/khóa khi chọn online) --}}
            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                    Địa điểm học tập (chỉ áp dụng đối với học trực tiếp)
                </h3>

                <div id="addressSection" class="bg-gray-50/50 border border-gray-200/60 rounded-2xl p-6 space-y-5 transition-all duration-300">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Tỉnh / Thành phố --}}
                        <div>
                            <label class="font-bold text-xs text-gray-600 block mb-2 uppercase tracking-wide">Tỉnh / Thành phố</label>
                            <div class="relative">
                                <select id="province" name="province" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%2522%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236b7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[size:1.25rem_1.25rem] bg-[position:right_1rem_center] bg-no-repeat pr-10">
                                </select>
                            </div>
                            @error('province')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phường / Xã --}}
                        <div>
                            <label class="font-bold text-xs text-gray-600 block mb-2 uppercase tracking-wide">Phường / Xã</label>
                            <div class="relative">
                                <select id="ward" name="ward" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%2522%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236b7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[size:1.25rem_1.25rem] bg-[position:right_1rem_center] bg-no-repeat pr-10"></select>
                            </div>
                            @error('ward')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Số nhà, tên đường --}}
                    <div>
                        <label class="font-bold text-xs text-gray-600 block mb-2 uppercase tracking-wide">Số nhà, tên đường</label>
                        <input type="text" name="detail_address"
                            value="{{ old('detail_address', $data['detail_address'] ?? '') }}"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all placeholder:text-gray-400" 
                            placeholder="Ví dụ: Số 123, đường Nguyễn Trãi...">
                        @error('detail_address')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Địa chỉ hoàn chỉnh --}}
                    <div>
                        <label class="font-bold text-xs text-gray-600 block mb-2 uppercase tracking-wide">Địa chỉ hoàn chỉnh hiển thị</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>
                            <input type="text" id="full_address" name="full_address"
                                value="{{ old('full_address', $data['full_address'] ?? '') }}"
                                class="w-full bg-gray-100 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm font-medium text-gray-600 cursor-not-allowed focus:outline-none" 
                                readonly>
                        </div>
                        @error('full_address')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        {{-- NÚT CHUYỂN BƯỚC --}}
        <div class="flex justify-between pt-6 border-t border-gray-100">
            <a href="{{ route('create-class.step2') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-xl font-semibold text-sm text-gray-600 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold text-sm transition shadow-sm hover:shadow-md flex items-center gap-2">
                Tiếp theo <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        AddressAPI({
            provinceSelector: "#province",
            wardSelector: "#ward",
            detailSelector: "input[name='detail_address']",
            fullAddressSelector: "#full_address"
        });
    });
</script>
