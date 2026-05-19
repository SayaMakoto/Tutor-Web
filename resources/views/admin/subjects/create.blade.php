@extends('layouts.admin')
@section('title', 'Thêm môn học')
@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">
            Thêm môn học
        </h2>
        <form action="{{ route('admin.subjects.store') }}" method="POST" class="space-y-6">

            @csrf

            <!-- Tên môn học -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tên môn học
                </label>
                <input type="text" name="name"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <!-- Nút -->
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('admin.subjects.index') }}"
                    class="px-6 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                    Hủy
                </a>
                <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    Lưu môn học
                </button>
            </div>
        </form>
    </div>
@endsection
