@extends('layouts.admin')
@section('title', 'Quản lý người dùng')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Tất cả người dùng</h1>
            <p class="text-sm text-gray-500 mt-0.5">Danh sách toàn bộ tài khoản trong hệ thống</p>
        </div>
        <x-admin.role-filter />
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Người dùng</th>
                        <th
                            class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                            Email</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Vai
                            trò</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Chi
                            tiết</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($users as $user)
                        @php
                            $roleConfig = match ($user->role) {
                                'admin' => [
                                    'label' => 'Admin',
                                    'bg' => 'bg-rose-100',
                                    'text' => 'text-rose-700',
                                    'icon' => 'fas fa-shield-halved',
                                ],
                                'tutor' => [
                                    'label' => 'Gia sư',
                                    'bg' => 'bg-emerald-100',
                                    'text' => 'text-emerald-700',
                                    'icon' => 'fas fa-chalkboard-teacher',
                                ],
                                'student' => [
                                    'label' => 'Học viên',
                                    'bg' => 'bg-blue-100',
                                    'text' => 'text-blue-700',
                                    'icon' => 'fas fa-user-graduate',
                                ],
                                'both' => [
                                    'label' => 'GS & HV',
                                    'bg' => 'bg-purple-100',
                                    'text' => 'text-purple-700',
                                    'icon' => 'fas fa-user-tie',
                                ],
                                default => [
                                    'label' => 'Khác',
                                    'bg' => 'bg-gray-100',
                                    'text' => 'text-gray-700',
                                    'icon' => 'fas fa-user',
                                ],
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar
                                        ? asset('storage/' . $user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=7c3aed&color=fff' }}"
                                        class="w-9 h-9 rounded-full object-cover shrink-0" alt="avatar">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400 sm:hidden">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-gray-500 text-sm hidden sm:table-cell">
                                {{ $user->email }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleConfig['bg'] }} {{ $roleConfig['text'] }}">
                                    <i class="{{ $roleConfig['icon'] }} text-[10px]"></i>
                                    {{ $roleConfig['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($user->role === 'both')
                                    <div class="inline-flex items-center gap-1.5">
                                        @if ($user->student)
                                            <a href="{{ route('admin.students.show', $user->student->id) }}?from=users"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition"
                                                title="Hồ sơ học viên">
                                                <i class="fas fa-user-graduate text-xs"></i> Học viên
                                            </a>
                                        @endif
                                        @if ($user->tutor)
                                            <a href="{{ route('admin.tutors.show', $user->tutor->id) }}?from=users"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg text-xs font-semibold transition"
                                                title="Hồ sơ gia sư">
                                                <i class="fas fa-chalkboard-teacher text-xs"></i> Gia sư
                                            </a>
                                        @endif
                                        @if (!$user->student && !$user->tutor)
                                            <span class="text-xs text-gray-300">—</span>
                                        @endif
                                    </div>
                                @elseif($user->role === 'student' && $user->student)
                                    <a href="{{ route('admin.students.show', $user->student->id) }}?from=users"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition">
                                        <i class="fas fa-eye text-xs"></i> Xem
                                    </a>
                                @elseif($user->role === 'tutor' && $user->tutor)
                                    <a href="{{ route('admin.tutors.show', $user->tutor->id) }}?from=users"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg text-xs font-semibold transition">
                                        <i class="fas fa-eye text-xs"></i> Xem
                                    </a>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

@endsection
