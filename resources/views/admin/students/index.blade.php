@extends('layouts.admin')
@section('title', 'Quản lý học viên')
@section('content')
    <x-alert type="success" :message="session('success')" />
    <x-alert type="error" :message="$errors->first()" />

    <div class="bg-white p-6 rounded-2xl shadow-md">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Quản lý học viên
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="p-3">Mã học viên</th>
                        <th class="p-3">Mã người dùng</th>
                        <th class="p-3">Tên học viên</th>
                        <th class="p-3">Xem chi tiết</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($students as $student)
                        <tr class="hover:bg-gray-50">

                            {{-- Student ID --}}
                            <td class="p-3 font-semibold text-gray-700">
                                #{{ $student->id }}
                            </td>

                            {{-- User ID --}}
                            <td class="p-3 text-gray-600">
                                #{{ $student->user_id }}
                            </td>

                            {{-- Name --}}
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $student->user->avatar
                                        ? asset('storage/' . $student->user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($student->user->name) }}"
                                        class="w-8 h-8 rounded-full object-cover border">

                                    <span class="font-medium text-gray-800">
                                        {{ $student->user->name }}
                                    </span>
                                </div>
                            </td>

                            {{-- Detail --}}
                            <td class="p-3">
                                <a href="{{ route('admin.students.show', $student->id) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    Xem chi tiết
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="mt-6">
                {{ $students->links() }}
            </div>
        </div>
    </div>
@endsection
