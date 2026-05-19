<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - GiaSu247')</title>
    @yield('scripts')
    @vite(['resources/css/app.css', 'resources/js/admin.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <x-admin.header-admin />
    <div class="flex flex-1">
        <!-- Sidebar -->
        <x-admin.sidebar-ad />
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
    <x-admin.footer-admin />
</body>

</html>
<script>
    function toggleAdminMenu() {
        document.getElementById('adminMenu').classList.toggle('hidden');
    }

    function toggleClassMenu() {
        document.getElementById('classMenu').classList.toggle('hidden');
    }

    function toggleCategoryMenu() {
        document.getElementById('categoryMenu').classList.toggle('hidden');
    }
</script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
