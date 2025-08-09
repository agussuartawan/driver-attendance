@extends('layouts.mobile')

@section('title', 'Absensi')

@section('content')
    <div class="p-6">
        <!-- Header with personalized message -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 text-white p-4 rounded-lg mb-6 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="text-sm">
                    <div class="font-medium text-xs">Selamat datang {{ auth()->user()->name }},</div>
                    <div class="text-green-100 text-xs">Siap untuk bekerja hari ini?</div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-green-100">{{ now()->format('d M Y') }}</div>
                    <div class="text-sm font-medium" id="current-time">{{ now()->format('H:i') }}</div>
                </div>
            </div>

            <!-- Smiley decoration -->
            <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-green-500 rounded-full opacity-20"></div>
            <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-green-400 rounded-full opacity-30"></div>
        </div>

        @if(isset($recentSchedule) && $recentSchedule)
            <a href="{{ $recentSchedule->type ? route('mobile.attendance.form', ['type' => $recentSchedule->type, 'schedule' => $recentSchedule]) : '#' }}">
                <div class="mb-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-sm font-medium text-gray-900">Jadwal Terbaru</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($recentSchedule->start_date)->format('d M Y') }}</span>
                        </div>

                        <div class="space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Customer:</span>
                                <span class="font-medium text-gray-900">{{ $recentSchedule->customer_name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Telepon:</span>
                                <span class="font-medium text-gray-900">{{ $recentSchedule->customer_phone }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Lokasi:</span>
                                <span class="font-medium text-gray-900 text-right">{{ $recentSchedule->start_location }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Status:</span>
                                @if($recentSchedule->can_start)
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Belum Dimulai</span>
                                @elseif($recentSchedule->can_end)
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Sedang Berjalan</span>
                                @else
                                    <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full">Selesai</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endif

        <!-- Action Buttons -->
        <div class="space-y-4">
            <!-- Start Delivery Button -->
            <div class="relative group">
                <a href="{{ route('mobile.attendance.schedule', ['type' => 'in']) }}"
                   class="block w-full p-6 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl active:scale-95">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-bold">Absensi Masuk</div>
                                <div class="text-sm text-green-100">Klik untuk memulai absensi</div>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- End Delivery Button -->
            <div class="relative group">
                <a href="{{ route('mobile.attendance.schedule', ['type' => 'out']) }}"
                   class="block w-full p-6 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl active:scale-95">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-bold">Absensi Selesai</div>
                                <div class="text-sm text-orange-100">Klik untuk mengakhiri absensi</div>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- History Button -->
            <div class="relative group">
                <a href="{{ route('mobile.attendance.history') }}"
                   class="block w-full p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl active:scale-95">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-bold">Riwayat Absensi</div>
                                <div class="text-sm text-blue-100">Lihat data absensi</div>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="mt-8 grid grid-cols-2 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Jam Kerja</div>
                        <div class="text-sm font-bold text-gray-900">{{ $workingHoursFormatted ?? '0j' }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Pengantaran</div>
                        <div class="text-sm font-bold text-gray-900">{{ $totalDeliveries ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Smiley decoration at bottom right -->
    <!-- <div class="fixed bottom-20 right-4 w-24 h-24 bg-green-500 rounded-full opacity-80 flex items-center justify-center">
        <div class="flex flex-col items-center">
            <div class="flex space-x-1 mb-1">
                <div class="w-2 h-2 bg-white rounded-full"></div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
            <div class="w-8 h-4 border-2 border-white border-t-transparent border-l-transparent border-r-transparent rounded-full"></div>
        </div>
    </div> -->

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
