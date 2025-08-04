<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Senyum</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Custom styles for dashboard */
            body {
                font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            }

            .sidebar-item {
                @apply flex items-center gap-4 px-6 py-4 text-green-600 hover:bg-green-50 transition-colors duration-200;
            }

            .sidebar-item.active {
                @apply bg-green-100 text-green-700 font-medium;
            }

            .sidebar-section {
                @apply text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-3;
            }
        </style>
    @endif

    @stack('styles')
</head>
<body class="bg-amber-50">
    <div class="min-h-screen flex flex-col">
        <!-- Top Header Bar -->
        <header class="bg-green-600 text-white px-6 py-4 flex items-center justify-between">
            <div class="text-lg font-medium">
                Hallo, Admin !
            </div>
            <div class="flex items-center gap-4">
                <!-- Search Icon -->
                <button class="p-2 hover:bg-green-700 rounded-lg transition-colors">
                    <x-icons.heroicon name="magnifying-glass" class="w-5 h-5" />
                </button>
                <!-- Notification Icon -->
                <button class="p-2 hover:bg-green-700 rounded-lg transition-colors">
                    <x-icons.heroicon name="bell" class="w-5 h-5" />
                </button>
                <!-- User Name -->
                <span class="font-medium">Erni Primayanti</span>
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Left Sidebar -->
            <aside class="w-72 bg-white border-r border-gray-200">
                <nav class="p-6">
                    <!-- Dashboard Section -->
                    <div class="mb-8">
                        <x-dashboard.sidebar-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            <x-icons.heroicon name="chart-bar" class="w-5 h-5" />
                            <span>DASHBOARD</span>
                        </x-dashboard.sidebar-item>
                    </div>

                    <hr class="border-gray-200 mb-8">

                    <!-- Features Section -->
                    <div class="mb-6">
                        <div class="sidebar-section">FEATURES</div>
                    </div>

                    <div class="space-y-6">
                        <x-dashboard.sidebar-item href="{{ route('employee') }}">
                            <x-icons.heroicon name="users" class="w-5 h-5" />
                            <span>DATA KARYAWAN</span>
                        </x-dashboard.sidebar-item>

                        <x-dashboard.sidebar-item href="#">
                            <x-icons.heroicon name="calendar" class="w-5 h-5" />
                            <span>JADWAL TAMU</span>
                        </x-dashboard.sidebar-item>

                        <x-dashboard.sidebar-item href="#">
                            <x-icons.heroicon name="document-text" class="w-5 h-5" />
                            <span>NOTA BIAYA</span>
                        </x-dashboard.sidebar-item>

                        <x-dashboard.sidebar-item href="#">
                            <x-icons.heroicon name="clipboard-list" class="w-5 h-5" />
                            <span>LAPORAN ABSENSI</span>
                        </x-dashboard.sidebar-item>
                    </div>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
