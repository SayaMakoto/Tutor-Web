@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    <div class="grid md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-500">Tổng Gia sư</h3>
            <p class="text-2xl font-bold mt-2"> {{ $countTutors }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-500">Tổng Học Viên</h3>
            <p class="text-2xl font-bold mt-2">{{ $countStudents }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-500">Lớp đang hoạt động</h3>
            <p class="text-2xl font-bold mt-2">{{ $countActiveClasses }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-500">Doanh thu tháng</h3>
            <p class="text-2xl font-bold mt-2">50.000.000đ</p>
        </div>
    </div>
@endsection
