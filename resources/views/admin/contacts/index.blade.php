@extends('layouts.admin')
@section('title', 'Quản lý liên hệ')
@section('content')

    <div class="bg-white p-6 rounded-2xl shadow-md">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Quản lý liên hệ
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="p-3">Mã liên hệ</th>
                        <th class="p-3">Tên</th>
                        <th class="p-3">Nội dung</th>
                        <th class="p-3">Trạng thái</th>
                        <th class="p-3">Hành động</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($contacts as $contact)
                        <tr class="hover:bg-gray-50">

                            {{-- ID --}}
                            <td class="p-3 font-semibold text-gray-700">
                                #{{ $contact->id }}
                            </td>

                            {{-- Name --}}
                            <td class="p-3">
                                {{ $contact->name }}
                            </td>

                            {{-- Content --}}
                            <td class="p-3">
                                <button onclick="openMessage({{ $contact->id }})"
                                    class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg text-xs hover:bg-blue-200">
                                    Xem chi tiết
                                </button>

                                {{-- Modal --}}
                                <div id="modal-{{ $contact->id }}"
                                    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

                                    <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-lg relative">

                                        <h3 class="text-lg font-semibold mb-3">
                                            Nội dung tin nhắn
                                        </h3>

                                        <p class="text-sm text-gray-700 whitespace-pre-line">
                                            {{ $contact->message }}
                                        </p>

                                        <button onclick="closeMessage({{ $contact->id }})"
                                            class="mt-4 px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="p-3">
                                @if ($contact->status === 'pending')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">
                                        Đang chờ phản hồi
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                        Đã phản hồi
                                    </span>
                                @endif
                            </td>

                            {{-- Action --}}
                            {{-- Action --}}
                            <td class="p-3">
                                @if ($contact->status === 'pending')
                                    <button onclick="openReply({{ $contact->id }})"
                                        class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-lg text-xs hover:bg-indigo-200">
                                        Phản hồi
                                    </button>

                                    {{-- Modal reply --}}
                                    <div id="reply-modal-{{ $contact->id }}"
                                        class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

                                        <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-lg relative">

                                            <h3 class="text-lg font-semibold mb-4 text-gray-800">
                                                Phản hồi cho {{ $contact->name }}
                                            </h3>

                                            <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                                                @csrf

                                                <textarea name="admin_reply" rows="4"
                                                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                                    placeholder="Nhập nội dung phản hồi..." required></textarea>

                                                <div class="flex justify-end gap-2 mt-4">
                                                    <button type="button" onclick="closeReply({{ $contact->id }})"
                                                        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">
                                                        Hủy
                                                    </button>

                                                    <button type="submit"
                                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                                                        Gửi phản hồi
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">
                                        Đã phản hồi
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="mt-6">
                {{ $contacts->links() }}
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

        function openReply(id) {
            document.getElementById('reply-modal-' + id).classList.remove('hidden');
            document.getElementById('reply-modal-' + id).classList.add('flex');
        }

        function closeReply(id) {
            document.getElementById('reply-modal-' + id).classList.remove('flex');
            document.getElementById('reply-modal-' + id).classList.add('hidden');
        }
    </script>

@endsection
