@extends('layouts.dashboard')

@section('title', 'Detail Jadwal')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Jadwal</h1>
                <p class="text-gray-600 mt-1">Informasi lengkap jadwal perjalanan</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('schedule') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('schedule.form.edit', $schedule) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Schedule Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Jadwal</h2>
                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full
                        @if($schedule->status === 'completed') bg-green-100 text-green-800
                        @elseif($schedule->status === 'in_progress') bg-blue-100 text-blue-800
                        @elseif($schedule->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        @switch($schedule->status)
                            @case('pending')
                                Menunggu
                                @break
                            @case('in_progress')
                                Sedang Berlangsung
                                @break
                            @case('completed')
                                Selesai
                                @break
                            @case('cancelled')
                                Dibatalkan
                                @break
                            @default
                                {{ ucfirst($schedule->status) }}
                        @endswitch
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <p class="text-sm text-gray-900">
                            @if($schedule->end_date)
                                {{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y H:i') }}
                            @else
                                <span class="text-gray-500">Belum selesai</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Customer</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
                        <p class="text-sm text-gray-900">{{ $schedule->customer_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <p class="text-sm text-gray-900">
                            <a href="tel:{{ $schedule->customer_phone }}" class="text-blue-600 hover:text-blue-800">
                                {{ $schedule->customer_phone }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Lokasi</h2>
                <div class="space-y-4">
                    <!-- Start Location -->
                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Lokasi Awal</h3>
                        <p class="text-sm text-gray-700 mb-2">{{ $schedule->start_location }}</p>
                        @if($schedule->start_latitude && $schedule->start_longitude)
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">Koordinat:</span>
                                <span class="text-xs text-gray-700">{{ $schedule->start_latitude }}, {{ $schedule->start_longitude }}</span>
                                <a href="https://maps.google.com/?q={{ $schedule->start_latitude }},{{ $schedule->start_longitude }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800">
                                    Lihat di Maps
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- End Location -->
                    @if($schedule->end_location)
                        <div class="border-l-4 border-red-500 pl-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Lokasi Tujuan</h3>
                            <p class="text-sm text-gray-700 mb-2">{{ $schedule->end_location }}</p>
                            @if($schedule->end_latitude && $schedule->end_longitude)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Koordinat:</span>
                                    <span class="text-xs text-gray-700">{{ $schedule->end_latitude }}, {{ $schedule->end_longitude }}</span>
                                    <a href="https://maps.google.com/?q={{ $schedule->end_latitude }},{{ $schedule->end_longitude }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800">
                                        Lihat di Maps
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Driver Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Driver</h2>
                @if($schedule->driver)
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ $schedule->driver->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $schedule->driver->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Status:</span>
                            <span class="font-medium text-gray-900">{{ ucfirst($schedule->driver->status) }}</span>
                        </div>
                        @if($schedule->driver->phone)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Telepon:</span>
                                <a href="tel:{{ $schedule->driver->phone }}" class="font-medium text-blue-600 hover:text-blue-800">
                                    {{ $schedule->driver->phone }}
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-gray-500">Driver tidak ditemukan</p>
                @endif
            </div>

            <!-- Schedule Timeline -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h2>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Jadwal Dibuat</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($schedule->created_at)->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if($schedule->status !== 'pending')
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Perjalanan Dimulai</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($schedule->status === 'completed' && $schedule->end_date)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Perjalanan Selesai</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($schedule->status === 'cancelled')
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Jadwal Dibatalkan</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($schedule->updated_at)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="space-y-3">
                    <a href="tel:{{ $schedule->customer_phone }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Hubungi Customer
                    </a>

                    @if($schedule->driver)
                        <a href="tel:{{ $schedule->driver->phone }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Hubungi Driver
                        </a>
                    @endif

                    <form action="{{ route('schedule.destroy', $schedule) }}" method="POST" class="inline-block w-full" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
