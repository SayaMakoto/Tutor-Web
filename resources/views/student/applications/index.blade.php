@extends('layouts.student')
@section('title', 'Lời mời từ gia sư')
@section('content')
    <div class="max-w-5xl mx-auto mt-6">

        <h2 class="text-2xl font-bold mb-6">
            📩 Lời mời từ gia sư
        </h2>

        @if ($applications->isEmpty())
            <div class="bg-gray-50 p-6 rounded-lg text-center text-gray-500">
                Chưa có gia sư nào gửi lời mời
            </div>
        @else
            <div class="space-y-4">

                @foreach ($applications as $app)
                    <x-application-card :app="$app" />
                @endforeach

            </div>
        @endif

    </div>
@endsection
