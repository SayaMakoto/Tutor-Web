@extends($layout)

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="py-6 max-w-2xl mx-auto px-4">
    <!-- Breadcrumb / Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-lock text-blue-600"></i> Đổi mật khẩu
        </h1>
        <p class="text-sm text-gray-500 mt-1">Cập nhật mật khẩu để bảo vệ tài khoản của bạn.</p>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-6 md:p-8">
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('change-password.store') }}" method="POST" class="space-y-6" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
            @csrf

            <!-- Mật khẩu hiện tại -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Mật khẩu hiện tại <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-key text-gray-400 text-xs"></i>
                    </div>
                    <input :type="showCurrent ? 'text' : 'password'" name="current_password" required
                        class="pl-10 block w-full border border-gray-200 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm"
                        placeholder="••••••••">
                    <button type="button" @click="showCurrent = !showCurrent"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-blue-500 transition">
                        <i :class="showCurrent ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Mật khẩu mới -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Mật khẩu mới <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400 text-xs"></i>
                    </div>
                    <input :type="showNew ? 'text' : 'password'" name="password" required
                        class="pl-10 block w-full border border-gray-200 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm"
                        placeholder="Ít nhất 6 ký tự">
                    <button type="button" @click="showNew = !showNew"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-blue-500 transition">
                        <i :class="showNew ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Xác nhận mật khẩu mới -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Xác nhận mật khẩu mới <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-check text-gray-400 text-xs"></i>
                    </div>
                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                        class="pl-10 block w-full border border-gray-200 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition text-sm"
                        placeholder="Nhập lại mật khẩu mới">
                    <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-blue-500 transition">
                        <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ url()->previous() }}" class="px-6 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold transition-all">
                    Hủy
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-all shadow-sm">
                    Cập nhật mật khẩu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
