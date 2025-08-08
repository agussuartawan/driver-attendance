@extends('layouts.mobile')

@section('title', 'Biaya')

@section('content')
    <div class="min-h-max">
        <!-- Header Section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 px-6 pt-8 pb-12">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Nota Biaya</h1>
                        <p class="text-green-100 text-sm mt-1">Kelola dokumen biaya pengantaran</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-6 -mt-6 relative z-20">
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Total Upload</div>
                            <div class="text-lg font-bold text-gray-900">{{ $totalUploads ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Bulan Ini</div>
                            <div class="text-lg font-bold text-gray-900">{{ $monthlyUploads ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4 mb-6">
                <!-- Upload Button -->
                <div class="relative group">
                    <a href="{{ route('mobile.receipt.add') }}"
                        class="block w-full p-6 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl active:scale-95">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold">Upload Nota Biaya</div>
                                    <div class="text-green-100 text-sm">Tambah dokumen biaya baru</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                    <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-green-400 rounded-full opacity-30"></div>
                </div>

                <!-- History Button -->
                <div class="relative group">
                    <a href="{{ route('mobile.receipt.history') }}"
                        class="block w-full p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl active:scale-95">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold">Riwayat Nota</div>
                                    <div class="text-blue-100 text-sm">Lihat semua dokumen</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                    <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-blue-400 rounded-full opacity-30"></div>
                </div>
            </div>

            <!-- Recent Uploads Section -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Upload Terbaru</h3>
                    <a href="{{ route('mobile.receipt.history') }}" class="text-sm text-green-600 font-medium">Lihat Semua</a>
                </div>

                @if(isset($recentReceipts) && $recentReceipts->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentReceipts->take(3) as $receipt)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $receipt->title ?? 'Nota Biaya' }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($receipt->created_at)->format('d M Y H:i') }}</div>
                                </div>
                                <div class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Uploaded</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="text-gray-500 text-sm">Belum ada upload nota biaya</div>
                        <div class="text-gray-400 text-xs mt-1">Mulai dengan upload dokumen pertama</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Update time every second
        function updateTime() {
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' +
                             now.getMinutes().toString().padStart(2, '0');
            document.getElementById('current-time').textContent = timeString;
        }

        // Update time immediately and then every second
        updateTime();
        setInterval(updateTime, 1000);
    </script>
@endsection
