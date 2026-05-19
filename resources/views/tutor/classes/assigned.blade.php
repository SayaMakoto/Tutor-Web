@extends('layouts.tutor')
@section('title', 'Lớp đã được giao dạy')

@section('content')
    <div class="max-w-5xl mx-auto mt-6">

        <h2 class="text-2xl font-bold mb-4">
            Lớp đã được giao dạy
        </h2>

        @if ($assignedClasses->isEmpty())
            <div class="bg-gray-50 p-4 rounded-lg text-gray-500 text-center">
                Bạn chưa được giao lớp nào
            </div>
        @else
            <div class="grid md:grid-cols-2 gap-6">
                @foreach ($assignedClasses as $class)
                    <x-partials.class-card :class-request="$class" detail-route="tutor.classes.show" :show-cancel="true" />
                @endforeach
            </div>
        @endif

    </div>
@endsection
