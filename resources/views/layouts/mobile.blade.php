<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=375, initial-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Senyum') - Mobile</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-gray-100 overflow-x-hidden">
    <x-alert-container />

    <div class="w-[375px] max-w-[375px] mx-auto min-h-screen bg-white shadow-2xl relative overflow-hidden">
        <!-- Mobile Header -->
        <header class="bg-gradient-to-br from-green-600 to-green-500 text-green-50 p-4 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="text-xl font-medium">@yield('title')</div>
                <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">{{ auth()->user()->name[0] }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-sm">{{ auth()->user()->name }}</span>
                </div>
            </div>
            </div>

            <!-- Smiley decoration -->
            <!-- <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-green-500 rounded-full opacity-20"></div>
            <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-green-400 rounded-full opacity-30"></div> -->
        </header>

        <!-- Main Content Area -->
        <main class="bg-white pb-16">
            @yield('content')
        </main>

        <!-- Bottom Navigation -->
        @if(!isset($showNavbar) || $showNavbar)
            <nav class="fixed bottom-0 left-1/2 transform -translate-x-1/2 w-[375px] max-w-[375px] bg-white border-t border-gray-200 py-1 z-50">
                <div class="flex justify-around">
                    <a href="{{ route('mobile.attendance') }}" class="flex flex-col items-center justify-center py-1 px-2 text-xs font-medium transition-colors duration-200 {{ request()->routeIs('mobile.attendance') ? 'text-green-600' : 'text-gray-500' }}">
                        <svg class="w-4 h-4 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        <span>Absensi</span>
                    </a>

                    <a href="{{ route('mobile.receipt') }}" class="flex flex-col items-center justify-center py-1 px-2 text-xs font-medium transition-colors duration-200 {{ request()->routeIs('mobile.receipt') ? 'text-green-600' : 'text-gray-500' }}">
                        <svg class="w-4 h-4 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <span>Nota Biaya</span>
                    </a>

                    <!-- <a href="#" class="flex flex-col items-center justify-center py-1 px-2 text-xs font-medium transition-colors duration-200 text-gray-500">
                        <svg class="w-4 h-4 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Jadwal</span>
                    </a> -->

                    <!-- <a href="#" class="flex flex-col items-center justify-center py-1 px-2 text-xs font-medium transition-colors duration-200 text-gray-500 {{ request()->routeIs('mobile.report') ? 'text-green-600' : 'text-gray-500' }}">
                        <svg class="w-4 h-4 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Laporan</span>
                    </a> -->

                    <a href="{{ route('mobile.profile') }}" class="flex flex-col items-center justify-center py-1 px-2 text-xs font-medium transition-colors duration-200 {{ request()->routeIs('mobile.profile') ? 'text-green-600' : 'text-gray-500' }}">
                        <svg class="w-4 h-4 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil</span>
                    </a>
                </div>
            </nav>
        @endif
    </div>

    @stack('scripts')
</body>
</html>
