<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang chủ')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col"
      style="font-family: 'Inter', sans-serif;">
    <!-- Header -->
    <x-tutor.header />
    <div class="flex flex-1">
        <!-- Sidebar -->
        <x-tutor.sidebar-gs />
        <!-- Main -->
        <main class="flex-1 p-4">
            <x-alert type="success" :message="session('success')" />
            <x-alert type="error" :message="session('error')" />
            <x-alert type="warning" :message="session('warning')" />
            <x-alert type="info" :message="session('info')" />
            @yield('content')
        </main>
    </div>
    <!-- Footer -->
    <x-partials.footer />
</body>

</html>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
