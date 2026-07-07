@extends($layout)
@section('title', 'Lớp đang tuyển gia sư')
@section('content')
    <div class="max-w-5xl mx-auto mt-6">

        <h2 class="text-2xl font-bold mb-4">
            Lớp đang tuyển gia sư
        </h2>

        @if ($approvedClasses->isEmpty())
            <div class="bg-gray-50 p-4 rounded-lg text-gray-500 text-center">
                Hiện chưa có lớp nào đang tuyển
            </div>
        @else
            <div class="grid md:grid-cols-2 gap-6">
                @foreach ($approvedClasses as $class)
                    <x-partials.class-card :class-request="$class" detail-route="tutor.classes.show" :show-cancel="false" />
                @endforeach
            </div>
        @endif

    </div>
@endsection
