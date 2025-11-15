@extends('layouts.dashboard')

@section('title', 'Detail Nota Biaya')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Nota Biaya</h1>
                <p class="text-gray-600 mt-1">Informasi lengkap nota biaya</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('receipt') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Receipt Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Nota Biaya</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <p class="text-sm text-gray-900">
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full">
                                {{ $receipt->category }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Upload</label>
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->created_at)->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <!-- Receipt Image -->
                @if($receipt->image)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Nota Biaya</label>
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <a href="{{ $receipt->image }}" target="_blank" class="block">
                                <img src="{{ $receipt->image }}" alt="Bukti Nota Biaya" class="w-full h-auto rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer">
                            </a>
                            <p class="text-xs text-gray-500 mt-2 text-center">Klik gambar untuk melihat ukuran penuh</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Employee Information -->
            @if($receipt->user)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Karyawan</h2>
                    <div class="flex items-center space-x-3 mb-4">
                        @if($receipt->user->image)
                            <img src="{{ $receipt->user->image }}" alt="{{ $receipt->user->name }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 font-semibold">{{ strtoupper(substr($receipt->user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="{{ route('employee.detail', $receipt->user) }}" class="hover:text-blue-600">
                                    {{ $receipt->user->name }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-500">{{ $receipt->user->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        @if($receipt->user->phone)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Telepon:</span>
                                <a href="tel:{{ $receipt->user->phone }}" class="font-medium text-blue-600 hover:text-blue-800">
                                    {{ $receipt->user->phone }}
                                </a>
                            </div>
                        @endif
                        @if($receipt->user->vehicle)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Kendaraan:</span>
                                <span class="font-medium text-gray-900">{{ $receipt->user->vehicle }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Status:</span>
                            <span class="font-medium {{ $receipt->user->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $receipt->user->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Schedule Information -->
            @if($receipt->schedule)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Jadwal</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                            <p class="text-sm text-gray-900">
                                <a href="{{ route('schedule.detail', $receipt->schedule) }}" class="hover:text-blue-600">
                                    {{ $receipt->schedule->customer_name }}
                                </a>
                            </p>
                        </div>
                        @if($receipt->schedule->customer_phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                                <p class="text-sm text-gray-900">
                                    <a href="tel:{{ $receipt->schedule->customer_phone }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $receipt->schedule->customer_phone }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->schedule->start_date)->format('d M Y H:i') }}</p>
                        </div>
                        @if($receipt->schedule->end_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($receipt->schedule->end_date)->format('d M Y H:i') }}</p>
                            </div>
                        @endif
                        @if($receipt->schedule->start_location)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Awal</label>
                                <p class="text-sm text-gray-900">{{ $receipt->schedule->start_location }}</p>
                            </div>
                        @endif
                        @if($receipt->schedule->end_location)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Tujuan</label>
                                <p class="text-sm text-gray-900">{{ $receipt->schedule->end_location }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="space-y-3">
                    @if($receipt->user && $receipt->user->phone)
                        <a href="tel:{{ $receipt->user->phone }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Hubungi Karyawan
                        </a>
                    @endif

                    @if($receipt->user)
                        <a href="{{ route('employee.detail', $receipt->user) }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil Karyawan
                        </a>
                    @endif

                    @if($receipt->schedule)
                        <a href="{{ route('schedule.detail', $receipt->schedule) }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Lihat Jadwal
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
