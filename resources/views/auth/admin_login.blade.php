<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — GiaSu247</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @vite(['resources/css/app.css'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-linear-to-br from-gray-900 via-violet-950 to-indigo-950 flex items-center justify-center p-4">

    {{-- Decorative circles --}}
    <div class="absolute top-0 left-0 w-72 h-72 bg-violet-500/10 rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

    <div class="w-full max-w-sm relative z-10">

        {{-- Logo --}}
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-linear-to-br from-violet-600 to-indigo-700 rounded-2xl
                        flex items-center justify-center mx-auto mb-3 shadow-lg shadow-violet-900/50">
                <i class="fas fa-shield-halved text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">GiaSu247 Admin</h1>
            <p class="text-gray-400 text-sm mt-1">Đăng nhập khu vực quản trị</p>
        </div>

        {{-- Card --}}
        <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-2xl p-7 shadow-2xl">

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/30 rounded-xl px-4 py-3 mb-5 flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation text-red-400 text-sm shrink-0"></i>
                    <p class="text-red-300 text-sm">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('admin.login.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-300 mb-1.5">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-sm pointer-events-none"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="admin@giasu247.vn"
                               class="w-full pl-10 pr-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-sm text-white
                                      placeholder-gray-500 focus:ring-2 focus:ring-violet-500 focus:border-transparent focus:outline-none">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-300 mb-1.5">Mật khẩu</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-sm pointer-events-none"></i>
                        <input :type="show ? 'text' : 'password'" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-10 pr-11 py-2.5 bg-white/10 border border-white/20 rounded-xl text-sm text-white
                                      placeholder-gray-500 focus:ring-2 focus:ring-violet-500 focus:border-transparent focus:outline-none">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                            <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-linear-to-r from-violet-600 to-indigo-600 text-white py-3 rounded-xl
                               font-semibold hover:from-violet-700 hover:to-indigo-700 hover:shadow-lg
                               hover:shadow-violet-900/50 transition-all mt-2">
                    <i class="fas fa-right-to-bracket mr-2 text-sm"></i> Đăng nhập
                </button>
            </form>
        </div>

        {{-- Back to site --}}
        <div class="text-center mt-5">
            <a href="{{ route('student.home') }}"
               class="text-xs text-gray-500 hover:text-gray-300 transition flex items-center justify-center gap-1.5">
                <i class="fas fa-arrow-left text-xs"></i> Quay lại trang người dùng
            </a>
        </div>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
