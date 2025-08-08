@extends('layouts.mobile')
@php($showNavbar = false)

@section('title', 'Absensi')

@section('content')
    <div class="p-6">
        <!-- Header with personalized message -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 text-white p-4 rounded-lg mb-6 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="text-sm">
                    <div class="font-medium text-xs">Riwayat Absensi</div>
                    <!-- <div class="text-green-100 text-xs">Selamat istirahat!</div> -->
                </div>
                <div class="text-right">
                    <a href="{{ route('mobile.attendance') }}" class="mt-2 px-4 py-2 bg-white text-green-600 border-2 border-green-600 rounded-full text-sm font-medium hover:bg-green-600 hover:text-white transition-colors">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Smiley decoration -->
            <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-green-500 rounded-full opacity-20"></div>
            <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-green-400 rounded-full opacity-30"></div>
        </div>

        <!-- Dotted line separator -->
        <div class="border-t-2 border-dotted border-gray-300 my-4"></div>

        <!-- Search and Filter Bar -->
        <form action="{{ route('mobile.attendance.history') }}" method="get" class="flex items-center space-x-2 mb-6">
            <!-- Search Input -->
            <div class="flex-1">
                <input
                    value="{{ request('search') }}"
                    type="text"
                    name="search"
                    placeholder="Search"
                    class="w-full px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:border-green-400 text-sm"
                >
            </div>

            <!-- Search Button -->
            <button type="submit" class="px-4 py-3 bg-green-200 hover:bg-green-300 transition-colors">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>

            <!-- Filter Button -->
            <button type="button" class="px-4 py-3 bg-green-600 hover:bg-green-700 transition-colors rounded-r-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                </svg>
            </button>
        </form>

        <!-- Sample attendance history cards -->
        <div class="space-y-4">
            <!-- Attendance Cards -->
            @forelse ($attendances as $attendance)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <!-- Header: Day and Date -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-900">{{ $attendance->day }}</span>
                        </div>
                        <span class="text-xs text-gray-500">{{ $attendance->date->translatedFormat('d M Y') }}</span>
                    </div>

                    <!-- Customer Info -->
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                        <div class="text-xs text-gray-500 mb-1">Customer</div>
                        <div class="text-sm font-medium text-gray-900">{{ $attendance->customer }}</div>
                    </div>

                    <!-- Attendance In Section -->
                    <div class="mb-4 p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs text-gray-500">Absen Masuk</div>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">{{ $attendance->start_status }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-green-600">{{ $attendance->start_time }}</div>
                            @if($attendance->start_image)
                                <img src="{{ asset('storage/' . $attendance->start_image) }}" alt="Foto Masuk" class="w-8 h-8 rounded object-cover">
                            @else
                                <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Attendance Out Section -->
                    <div class="mb-4 p-3 bg-red-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs text-gray-500">Absen Keluar</div>
                            <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">{{ $attendance->end_status }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-red-600">{{ $attendance->end_time }}</div>
                            @if($attendance->end_image)
                                <img src="{{ asset('storage/' . $attendance->end_image) }}" alt="Foto Keluar" class="w-8 h-8 rounded object-cover">
                            @else
                                <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Duration -->
                    <div class="flex items-center justify-center p-2 bg-blue-50 rounded-lg">
                        <span class="text-xs text-blue-700 font-medium">Durasi: {{ $attendance->duration }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="text-sm">Tidak ada data absensi</div>
                </div>
            @endforelse
        </div>

        <!-- Load more button -->
        <!-- <div class="mt-6 text-center">
            <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                Lihat Lebih Banyak
            </button>
        </div> -->
    </div>

    <!-- Smiley decoration at bottom right -->
    <div class="fixed bottom-20 right-4 w-24 h-24 bg-green-500 rounded-full opacity-80 flex items-center justify-center">
        <div class="flex flex-col items-center">
            <div class="flex space-x-1 mb-1">
                <div class="w-2 h-2 bg-white rounded-full"></div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
            <div class="w-8 h-4 border-2 border-white border-t-transparent border-l-transparent border-r-transparent rounded-full"></div>
        </div>
    </div>
@endsection
