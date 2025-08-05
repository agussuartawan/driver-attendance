@extends('layouts.mobile')
@php($showNavbar = false)

@section('title', 'Nota Biaya')

@section('content')
    <div class="p-6">
        <!-- Header with personalized message -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 text-white p-4 rounded-lg mb-6 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="text-sm">
                    <div class="font-medium text-xs">Riwayat Nota Biaya</div>
                </div>
                <div class="text-right">
                    <a href="{{ route('mobile.receipt') }}" class="mt-2 px-4 py-2 bg-white text-green-600 border-2 border-green-600 rounded-full text-sm font-medium hover:bg-green-600 hover:text-white transition-colors">
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
        <form action="" method="get" class="flex items-center space-x-2 mb-6">
            <!-- Search Input -->
            <div class="flex-1">
                <input
                    type="text"
                    placeholder="Search"
                    class="w-full px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:border-green-400 text-sm"
                >
            </div>

            <!-- Search Button -->
            <button type="button" class="px-4 py-3 bg-green-200 hover:bg-green-300 transition-colors">
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

        <!-- Sample receipt history cards -->
        <div class="space-y-4">
            <!-- Card 1: Approved receipt -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-900">NB-2024-001</span>
                    </div>
                    <span class="text-xs text-gray-500">Senin, 15 Jan 2024</span>
                </div>

                <div class="mb-3">
                    <div class="text-sm text-gray-700 mb-2">Biaya Transportasi Meeting Client</div>
                    <div class="text-xs text-gray-500">Jakarta - Bandung PP</div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div class="text-center">
                        <div class="text-xs text-gray-500 mb-1">Jumlah</div>
                        <div class="text-sm font-semibold text-green-600">Rp 250.000</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-500 mb-1">Status</div>
                        <div class="text-sm font-semibold text-green-600">Disetujui</div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Disetujui</span>
                    <span class="text-xs text-gray-500">Dibayar: 17 Jan 2024</span>
                </div>
            </div>

            <!-- Card 2: Pending receipt -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-900">NB-2024-002</span>
                    </div>
                    <span class="text-xs text-gray-500">Minggu, 14 Jan 2024</span>
                </div>

                <div class="mb-3">
                    <div class="text-sm text-gray-700 mb-2">Biaya Makan Siang Tim</div>
                    <div class="text-xs text-gray-500">Restoran Padang Sederhana</div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div class="text-center">
                        <div class="text-xs text-gray-500 mb-1">Jumlah</div>
                        <div class="text-sm font-semibold text-yellow-600">Rp 180.000</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-500 mb-1">Status</div>
                        <div class="text-sm font-semibold text-yellow-600">Menunggu</div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Menunggu Approval</span>
                    <span class="text-xs text-gray-500">Dikirim: 14 Jan 2024</span>
                </div>
            </div>

            <!-- Card 3: Rejected receipt -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-900">NB-2024-003</span>
                    </div>
                    <span class="text-xs text-gray-500">Sabtu, 13 Jan 2024</span>
                </div>

                <div class="mb-3">
                    <div class="text-sm text-gray-700 mb-2">Biaya Hotel Meeting</div>
                    <div class="text-xs text-gray-500">Hotel Grand Palace Jakarta</div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div class="text-center">
                        <div class="text-xs text-gray-500 mb-1">Jumlah</div>
                        <div class="text-sm font-semibold text-red-600">Rp 850.000</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-500 mb-1">Status</div>
                        <div class="text-sm font-semibold text-red-600">Ditolak</div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Ditolak</span>
                    <span class="text-xs text-gray-500">Alasan: Budget melebihi limit</span>
                </div>
            </div>

            <!-- Card 4: Draft receipt -->
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm opacity-80">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-900">Draft</span>
                    </div>
                    <span class="text-xs text-gray-500">Jumat, 12 Jan 2024</span>
                </div>

                <div class="mb-3">
                    <div class="text-sm text-gray-700 mb-2">Biaya Parkir Mall</div>
                    <div class="text-xs text-gray-500">Mall Taman Anggrek</div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div class="text-center">
                        <div class="text-xs text-gray-500 mb-1">Jumlah</div>
                        <div class="text-sm font-semibold text-gray-600">Rp 15.000</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-500 mb-1">Status</div>
                        <div class="text-sm font-semibold text-gray-600">Draft</div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">Draft</span>
                    <span class="text-xs text-gray-500">Belum dikirim</span>
                </div>
            </div>
        </div>

        <!-- Load more button -->
        <div class="mt-6 text-center">
            <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                Lihat Lebih Banyak
            </button>
        </div>
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
