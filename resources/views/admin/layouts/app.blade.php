<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админка - @yield('title')</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar { transition: all 0.3s; }
        .content-area { transition: all 0.3s; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">
<div class="min-h-screen flex">
    <!-- Сайдбар -->
    <div class="sidebar bg-indigo-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 transform -translate-x-64 md:translate-x-0 transition duration-200 ease-in-out z-50">
        <div class="text-white flex items-center space-x-2 px-4">
            <i class="fas fa-cube fa-lg"></i>
            <span class="text-xl font-bold">Админ-панель</span>
        </div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                <i class="fas fa-tachometer-alt mr-2"></i> Дашборд
            </a>
            <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 bg-indigo-700">
                <i class="fas fa-box-open mr-2"></i> Товары
            </a>
            <a href="{{ route('categories.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                <i class="fas fa-tags mr-2"></i> Категории
            </a>
        </nav>
    </div>

    <!-- Основной контент -->
    <div class="content-area flex-1 md:ml-64">
        <!-- Навбар -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-lg font-semibold text-gray-800">@yield('header')</h1>
                <div class="flex items-center space-x-4">
                    <button class="md:hidden" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-gray-500"></i>
                    </button>
                    <div class="relative">
                        <i class="fas fa-bell text-gray-500"></i>
                        <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                    </div>
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=indigo&color=white" alt="Admin" class="h-8 w-8 rounded-full">
                        <span class="ml-2 text-sm font-medium text-gray-700 hidden md:inline">Администратор</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Контент -->
        <main class="bg-white rounded-lg shadow-sm m-4 p-6">
            @yield('content')
        </main>
    </div>
</div>

<!-- Alpine JS для мобильного меню -->

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('-translate-x-64');
        document.querySelector('.content-area').classList.toggle('md:ml-64');
    }
</script>
@stack('scripts')
</body>
</html>
