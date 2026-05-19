@extends('layouts.admin')
@section('title', 'Quản lý người dùng')
@section('content')
    <x-alert type="success" :message="session('success')" />
    <x-alert type="error" :message="$errors->first()" />

    <div class="bg-white p-6 rounded-2xl shadow-md">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Quản lý người dùng
            </h2>

            <x-admin.role-filter />
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="p-3">Mã người dùng</th>
                        <th class="p-3">Tên người dùng</th>
                        <th class="p-3">Xem chi tiết</th>
                        <th class="p-3">Vai trò</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">

                            {{-- ID --}}
                            <td class="p-3 font-semibold text-gray-700">
                                #{{ $user->id }}
                            </td>

                            {{-- Name --}}
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar
                                        ? asset('storage/' . $user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                        class="w-8 h-8 rounded-full object-cover border">

                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>

                            {{-- Detail --}}
                            <td class="p-3">
                                @if ($user->role === 'student')
                                    <a href="{{ route('admin.students.show', $user->student->id) }}?from=users"
                                        class="text-blue-500 hover:text-blue-700">
                                        Xem chi tiết
                                    </a>
                                @elseif ($user->role === 'tutor')
                                    <a href="{{ route('admin.tutors.show', $user->tutor->id) }}?from=users"
                                        class="text-blue-500 hover:text-blue-700">
                                        Xem chi tiết
                                    </a>
                                @endif
                            </td>

                            {{-- Role --}}
                            <td class="p-3">
                                @php
                                    $roleColor = match ($user->role) {
                                        'admin' => 'bg-red-100 text-red-600',
                                        'tutor' => 'bg-green-100 text-green-600',
                                        'student' => 'bg-blue-100 text-blue-600',
                                        default => 'bg-gray-100 text-gray-600',
                                    };

                                    $roleLabel = match ($user->role) {
                                        'admin' => 'Quản trị viên',
                                        'tutor' => 'Gia sư',
                                        'student' => 'Học viên',
                                        default => 'Không xác định',
                                    };
                                @endphp

                                <span class="px-2 py-1 rounded-full text-xs {{ $roleColor }}">
                                    {{ $roleLabel }}
                                </span>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
