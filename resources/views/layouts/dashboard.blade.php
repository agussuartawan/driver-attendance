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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-amber-50">
    <x-alert-container />

    <div class="min-h-screen flex flex-col">
        <!-- Top Header Bar -->
        <header class="bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-5 flex items-center justify-between shadow-lg relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 20px 20px;"></div>
            </div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="text-xl font-semibold">
                    Hallo, {{ auth()->user()->name }} !
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <div class="text-sm text-green-100">
                    Selamat datang kembali
                </div>
            </div>

            <div class="relative z-10 flex items-center gap-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-sm border border-white/20 px-4 py-2 hover:bg-white/10 rounded-xl transition-all duration-200 group">
                    <x-icons.heroicon name="logout" class="group-hover:scale-110 transition-transform text-white" />
                    Logout
                    </button>
                </form>

                <!-- <div class="flex items-center gap-0">
                    <button class="p-3 hover:bg-white/10 rounded-xl transition-all duration-200 group">
                        <x-icons.heroicon name="magnifying-glass" class="group-hover:scale-110 transition-transform" />
                    </button>
                    <button class="p-3 hover:bg-white/10 rounded-xl transition-all duration-200 group relative">
                        <x-icons.heroicon name="bell" class="group-hover:scale-110 transition-transform" />
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-400 rounded-full border-2 border-white"></span>
                    </button>
                </div> -->

                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ auth()->user()->name[0] }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-semibold text-sm">{{ auth()->user()->name }}</span>
                        <span class="text-xs text-green-100">{{ auth()->user()->getRoleNames()->first() }}</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Left Sidebar -->
            <aside class="w-80 bg-white shadow-xl relative">
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <x-icons.heroicon name="chart-bar" class="text-green-600" />
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900">Senyum Dashboard</h2>
                            <p class="text-xs text-gray-500">Management System</p>
                        </div>
                    </div>
                </div>

                <nav class="p-4">
                    <!-- Dashboard Section -->
                    <div class="mb-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-6 py-4 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ request()->routeIs('dashboard') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                            <x-icons.heroicon name="pie" />
                            <span class="font-medium">DASHBOARD</span>
                        </a>
                    </div>

                    <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mb-4"></div>

                    <!-- Features Section -->
                    <div class="mb-4">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-6">FEATURES</div>
                    </div>

                    <div class="space-y-2">
                        @role('admin')
                            <a href="{{ route('employee') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ str_contains(request()->route()->getName(), 'employee') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                                <x-icons.heroicon name="users" />
                                <span class="font-medium">DATA KARYAWAN</span>
                            </a>
                        @endrole

                        @role('admin')
                            <a href="{{ route('schedule') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ str_contains(request()->route()->getName(), 'schedule') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                                <x-icons.heroicon name="calendar" />
                                <span class="font-medium">JADWAL TAMU</span>
                            </a>
                        @endrole

                        @role('admin')
                            <a href="{{ route('receipt') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ str_contains(request()->route()->getName(), 'receipt') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                                <x-icons.heroicon name="document" />
                                <span class="font-medium">NOTA BIAYA</span>
                            </a>
                        @endrole

                        @role('admin|manager')
                            <a href="{{ route('report.attendance') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ str_contains(request()->route()->getName(), 'report.attendance') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                                <x-icons.heroicon name="folder" />
                                <span class="font-medium">LAPORAN ABSENSI</span>
                            </a>
                        @endrole
                    </div>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 p-8 bg-gradient-to-br from-amber-50 to-green-50">
                <div class="mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
