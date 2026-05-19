@extends('student.classes.create')
@section('title', 'Bước 3: Địa điểm học')
@section('step-content')
    <form action="{{ route('create-class.post.step3') }}" method="POST">
        @csrf

        <div class="space-y-6">

            {{-- Hình thức học --}}
            <div>
                <label class="font-semibold block mb-2">Hình thức học</label>
                <div class="flex gap-6">
                    <label>
                        <input type="radio" name="study_type" value="online"
                            {{ old('study_type', $data['study_type'] ?? '') == 'online' ? 'checked' : '' }}>
                        Online
                    </label>

                    <label>
                        <input type="radio" name="study_type" value="offline"
                            {{ old('study_type', $data['study_type'] ?? '') == 'offline' ? 'checked' : '' }}>
                        Offline
                    </label>
                </div>
            </div>

            {{-- FORM ĐỊA CHỈ (ẩn mặc định) --}}
            <div id="addressSection" class="hidden space-y-4">

                <div>
                    <label class="font-semibold block mb-2">Tỉnh / Thành phố</label>
                    <select id="province" name="province" class="w-full border rounded-lg px-4 py-2">
                    </select>
                </div>

                <div>
                    <label class="font-semibold block mb-2">Phường / Xã</label>
                    <select id="ward" name="ward" class="w-full border rounded-lg px-4 py-2"></select>
                </div>

                <div>
                    <label class="font-semibold block mb-2">Số nhà, tên đường</label>
                    <input type="text" name="detail_address"
                        value="{{ old('detail_address', $data['detail_address'] ?? '') }}"
                        class="w-full border rounded-lg px-4 py-2" placeholder="Số nhà, tên đường...">
                </div>

                <div>
                    <label class="font-semibold block mb-2">Địa chỉ hoàn chỉnh</label>
                    <input type="text" id="full_address" name="full_address"
                        value="{{ old('full_address', $data['full_address'] ?? '') }}"
                        class="w-full border rounded-lg px-4 py-2 bg-gray-100" readonly>
                </div>

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-between mt-10">
            <a href="{{ route('create-class.step2') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                ← Quay lại
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Tiếp theo →
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
