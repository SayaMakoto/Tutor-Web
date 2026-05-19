@extends('layouts.admin')
@section('title', 'Quản lý Đơn nhận lớp')
@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-md">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Quản lý Đơn nhận lớp
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="p-3">Mã đơn</th>
                        <th class="p-3">Mã gia sư</th>
                        <th class="p-3">Mã lớp</th>
                        <th class="p-3">Tin nhắn</th>
                        <th class="p-3">Trạng thái</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($applications as $app)
                        <tr class="hover:bg-gray-50">

                            {{-- ID --}}
                            <td class="p-3 font-semibold text-gray-700">
                                #{{ $app->id }}
                            </td>

                            {{-- Tutor ID --}}
                            <td class="p-3">
                                {{ $app->tutor_id }}
                            </td>

                            {{-- Class ID --}}
                            <td class="p-3">
                                {{ $app->class_request_id }}
                            </td>

                            {{-- Message --}}
                            <td class="p-3">
                                <button onclick="openMessage({{ $app->id }})"
                                    class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg text-xs hover:bg-blue-200">
                                    Xem tin nhắn
                                </button>

                                {{-- Popup --}}
                                <div id="modal-{{ $app->id }}"
                                    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

                                    <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-lg relative">

                                        <h3 class="text-lg font-semibold mb-3">
                                            Nội dung tin nhắn
                                        </h3>

                                        <p class="text-sm text-gray-700 whitespace-pre-line">
                                            {{ $app->message ?? 'Không có nội dung.' }}
                                        </p>

                                        <button onclick="closeMessage({{ $app->id }})"
                                            class="mt-4 px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">
                                            Đóng
                                        </button>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="p-3">
                                <span class="px-2 py-1 text-xs rounded-full {{ $app->status_color }}">
                                    {{ $app->status_label }}
                                </span>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="mt-6">
                {{ $applications->links() }}
            </div>

        </div>
    </div>

    {{-- Script mở / đóng modal --}}
    <script>
        function openMessage(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
            document.getElementById('modal-' + id).classList.add('flex');
        }

        function closeMessage(id) {
            document.getElementById('modal-' + id).classList.remove('flex');
            document.getElementById('modal-' + id).classList.add('hidden');
        }
    </script>
@endsection
