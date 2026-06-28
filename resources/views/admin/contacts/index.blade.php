@extends('layouts.admin')
@section('title', 'Quản lý liên hệ')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Quản lý liên hệ</h1>
            <p class="text-sm text-gray-500 mt-0.5">Phản hồi tin nhắn từ người dùng</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Người gửi</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($contacts as $contact)
                        <tr class="hover:bg-gray-50/70 transition">

                            {{-- Sender --}}
                            <td class="px-5 py-3.5">
                                <p class="font-semibold text-gray-800">{{ $contact->name }}</p>
                                <p class="text-xs text-gray-400">{{ $contact->email }}</p>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-3.5">
                                @if ($contact->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Chờ phản hồi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Đã phản hồi
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openMessage({{ $contact->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition">
                                        <i class="fas fa-eye text-xs"></i> Xem
                                    </button>
                                    @if ($contact->status === 'pending')
                                        <button onclick="openReply({{ $contact->id }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-violet-50 hover:bg-violet-100 text-violet-600 rounded-lg text-xs font-semibold transition">
                                            <i class="fas fa-reply text-xs"></i> Phản hồi
                                        </button>
                                    @endif
                                </div>

                                {{-- Message Modal --}}
                                <div id="modal-{{ $contact->id }}"
                                     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
                                    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-envelope text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800 text-sm">{{ $contact->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $contact->email }}</p>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-line leading-relaxed mb-4">{{ $contact->message }}</div>
                                        <div class="flex justify-end">
                                            <button onclick="closeMessage({{ $contact->id }})"
                                                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition">
                                                Đóng
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Reply Modal --}}
                                @if ($contact->status === 'pending')
                                <div id="reply-modal-{{ $contact->id }}"
                                     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
                                    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-reply text-violet-600"></i>
                                            </div>
                                            <h3 class="font-bold text-gray-800 text-sm">Phản hồi cho {{ $contact->name }}</h3>
                                        </div>
                                        <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                                            @csrf
                                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nội dung phản hồi</label>
                                            <textarea name="admin_reply" rows="4" required
                                                      class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm mb-4 resize-none
                                                             focus:ring-2 focus:ring-violet-400 focus:border-transparent focus:outline-none"
                                                      placeholder="Nhập nội dung phản hồi..."></textarea>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" onclick="closeReply({{ $contact->id }})"
                                                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition">
                                                    Hủy
                                                </button>
                                                <button type="submit"
                                                        class="px-5 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">
                                                    Gửi phản hồi
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-envelope-open text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Chưa có liên hệ nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contacts->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
    function openMessage(id)  { toggleModal('modal-' + id, true); }
    function closeMessage(id) { toggleModal('modal-' + id, false); }
    function openReply(id)    { toggleModal('reply-modal-' + id, true); }
    function closeReply(id)   { toggleModal('reply-modal-' + id, false); }

    function toggleModal(id, show) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.toggle('hidden', !show);
        el.classList.toggle('flex', show);
    }
</script>
@endpush
