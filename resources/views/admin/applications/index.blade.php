@extends('layouts.admin')
@section('title', 'Quản lý đơn nhận lớp')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Đơn nhận lớp</h1>
            <p class="text-sm text-gray-500 mt-0.5">Lịch sử gia sư ứng tuyển nhận lớp</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Gia sư</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lớp</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Tin nhắn</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($applications as $app)
                        <tr class="hover:bg-gray-50/70 transition">

                            {{-- Tutor --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $app->tutor?->user?->avatar
                                        ? asset('storage/' . $app->tutor->user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($app->tutor?->user?->name ?? 'T') . '&background=7c3aed&color=fff' }}"
                                         class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="avatar">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $app->tutor?->user?->name ?? '—' }}</p>
                                        <p class="text-xs text-gray-400">ID: {{ $app->tutor_id }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Class --}}
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.class-requests.show', $app->class_request_id) }}"
                                   class="inline-flex items-center gap-1 font-mono text-xs bg-gray-100 text-gray-600
                                          px-2.5 py-1 rounded-lg hover:bg-violet-100 hover:text-violet-700 transition">
                                    #{{ $app->class_request_id }}
                                    <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $app->status_color }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                    {{ $app->status_label }}
                                </span>
                            </td>

                            {{-- Message --}}
                            <td class="px-5 py-3.5 text-center">
                                @if($app->message)
                                    <button onclick="document.getElementById('msg-{{ $app->id }}').classList.replace('hidden','flex')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition">
                                        <i class="fas fa-eye text-xs"></i> Xem
                                    </button>

                                    {{-- Message Modal --}}
                                    <div id="msg-{{ $app->id }}" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
                                        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-message text-blue-600"></i>
                                                </div>
                                                <h3 class="font-bold text-gray-800">Tin nhắn ứng tuyển</h3>
                                            </div>
                                            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-line leading-relaxed mb-4">{{ $app->message }}</div>
                                            <div class="flex justify-end">
                                                <button onclick="document.getElementById('msg-{{ $app->id }}').classList.replace('flex','hidden')"
                                                        class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition">
                                                    Đóng
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-handshake text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Chưa có đơn nhận lớp nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

@endsection
