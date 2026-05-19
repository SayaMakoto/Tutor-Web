@php
    $tutor = $app->tutor;
    $class = $app->classRequest;

    $statusClass = match ($app->status) {
        'pending' => 'bg-yellow-100 text-yellow-700',
        'accepted' => 'bg-green-100 text-green-700',
        'rejected' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<div class="bg-white shadow rounded-xl p-5 border hover:shadow-md transition">

    {{-- HEADER --}}
    <div class="flex justify-between items-start">

        <div>
            <h3 class="text-lg font-semibold text-blue-600">
                {{ $tutor->user->name }}
            </h3>

            <p class="text-sm text-gray-500">
                {{ $class->subject?->name ?? 'N/A' }}
                -
                {{ $class->grade?->name ?? '' }}
            </p>
        </div>

        {{-- STATUS --}}
        <span class="px-3 py-1 text-xs rounded-full {{ $statusClass }}">
            {{ ucfirst($app->status) }}
        </span>

    </div>

    {{-- MESSAGE --}}
    <div class="mt-4 bg-gray-50 p-3 rounded-lg text-sm text-gray-700">
        {{ $app->message ?? 'Không có lời nhắn' }}
    </div>

    {{-- ACTIONS --}}
    <div class="flex flex-wrap gap-2 mt-4">

        {{-- Xem lớp --}}
        <a href="{{ route('classes.show', $class->id) }}"
            class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 text-sm">
            Lớp học
        </a>

        {{-- Xem gia sư --}}
        <a href="{{ route('student.tutor.show', $tutor->id) }}"
            class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 text-sm">
            Gia sư
        </a>

        @if ($app->status === 'pending')
            {{-- Accept --}}
            <form method="POST" action="{{ route('student.applications.accept', $app->id) }}">
                @csrf
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                    Chấp nhận lời mời
                </button>
            </form>

            {{-- Reject --}}
            <form method="POST" action="{{ route('student.applications.reject', $app->id) }}">
                @csrf
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                    Từ chối lời mời
                </button>
            </form>
        @else
            <span class="text-xs text-gray-400 self-center">
                Đã xử lý
            </span>
        @endif

    </div>

</div>
