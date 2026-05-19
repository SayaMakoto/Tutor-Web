<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang chủ')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <x-student.header />
    <div class="flex flex-1">
        <!-- Sidebar -->
        <x-student.sidebar />
        <!-- Main -->
        <main class="flex-1 p-6">
            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />
            <x-alert type="warning" :message="session('warning')" />
            <x-alert type="info" :message="session('info')" />

            @yield('content')
        </main>
    </div>
    <!-- Footer -->
    <x-partials.footer />
    @stack('scripts')
</body>

</html>
<script src="{{ asset('js/address.js') }}"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
