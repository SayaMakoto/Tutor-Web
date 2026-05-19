<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Đăng nhập')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <x-alert type="success" :message="session('success')" />
    <x-alert type="error" :message="session('error')" />
    <x-alert type="warning" :message="session('warning')" />
    <x-alert type="info" :message="session('info')" />

    @yield('content')

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
