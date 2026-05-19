@extends('layouts.admin')
@section('title', 'Thêm ngành học')
@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">
            Thêm ngành học
        </h2>
        <form action="{{ route('admin.grades.store') }}" method="POST" class="space-y-6">

            @csrf

            <!-- Tên ngành học -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tên ngành học
                </label>
                <input type="text" name="name"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <!-- Trạng thái sắp xếp -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Thứ tự hiển thị
                </label>
                <input type="number" name="sort_order"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <!-- Nút -->
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('admin.grades.index') }}"
                    class="px-6 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                    Hủy
                </a>
                <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    Lưu ngành học
                </button>
            </div>
        </form>
    </div>
@endsection
