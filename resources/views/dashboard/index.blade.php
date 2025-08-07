@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap dashboard</p>
        </div>
    </div>

    <!-- Top Row - Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <x-dashboard.metric-card :value="$totalDriver" label="Jumlah Supir Aktif" icon-name="users" size="8" />
        <x-dashboard.metric-card :value="$totalSchedule" label="Jumlah Jadwal" icon-name="calendar" size="8" />
        <x-dashboard.metric-card :value="'Rp ' . number_format($totalReceipt, 0, ',', '.')" label="Total Pengeluaran" icon-name="currency-dollar" size="8" />
    </div>

    <!-- Bottom Row - Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Rekap Absensi Tahun {{ $currentYear }} -->
        <x-dashboard.chart-card title="REKAP ABSENSI TAHUN {{ $currentYear }}">
            <div class="flex items-end justify-between h-48 mt-8">
                @php
                    $maxAttendance = max(array_column($attendanceData, 'total'));
                    $maxHeight = 160; // 10rem dalam pixel
                @endphp

                @foreach($attendanceData as $data)
                    @php
                        $height = $maxAttendance > 0 ? ($data['total'] / $maxAttendance) * $maxHeight : 0;
                        $height = max($height, 8); // Minimum height
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="bg-blue-400 hover:bg-blue-500 rounded-t w-8 transition-all duration-300"
                             style='height: {{ $height }}px'
                             title="{{ $data['monthName'] }}: {{ $data['total'] }} absensi (In: {{ $data['in'] }}, Out: {{ $data['out'] }})">
                        </div>
                        <div class="text-xs text-gray-600 mt-2">{{ $data['month'] }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Chart Info -->
            <div class="mt-4 text-center">
                <div class="text-sm text-gray-600">
                    Total Absensi: {{ array_sum(array_column($attendanceData, 'total')) }}
                </div>
                <div class="flex justify-center gap-4 mt-2 text-xs">
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 bg-blue-400 rounded"></div>
                        <span>In: {{ array_sum(array_column($attendanceData, 'in')) }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 bg-blue-600 rounded"></div>
                        <span>Out: {{ array_sum(array_column($attendanceData, 'out')) }}</span>
                    </div>
                </div>
            </div>
        </x-dashboard.chart-card>

        <!-- Pengeluaran Berdasarkan Kategori -->
        <x-dashboard.chart-card title="PENGELUARAN BERDASARKAN KATEGORI">
            @if(count($receiptCategories) > 0)
                <div class="relative w-48 h-48 mx-auto">
                    @php
                        $colors = ['bg-blue-300', 'bg-blue-500', 'bg-blue-700', 'bg-green-300', 'bg-green-500', 'bg-green-700', 'bg-yellow-300', 'bg-yellow-500', 'bg-yellow-700', 'bg-red-300', 'bg-red-500', 'bg-red-700'];
                        $totalPercentage = 0;
                    @endphp

                    @foreach($receiptCategories as $index => $category)
                        @php
                            $color = $colors[$index % count($colors)];
                            $startAngle = $totalPercentage * 3.6; // 360 degrees / 100%
                            $endAngle = ($totalPercentage + $category['percentage']) * 3.6;
                            $totalPercentage += $category['percentage'];

                            // Calculate coordinates for pie segment
                            $startX = 50 + 50 * cos(deg2rad($startAngle));
                            $startY = 50 + 50 * sin(deg2rad($startAngle));
                            $endX = 50 + 50 * cos(deg2rad($endAngle));
                            $endY = 50 + 50 * sin(deg2rad($endAngle));
                        @endphp

                        <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                            <path
                                d="M50,50 L{{ $startX }},{{ $startY }} A50,50 0 {{ ($endAngle - $startAngle) > 180 ? 1 : 0 }},1 {{ $endX }},{{ $endY }} Z"
                                class="{{ $color }}"
                            />
                        </svg>
                    @endforeach

                    <!-- Center circle -->
                    <div class="absolute inset-4 bg-white rounded-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-sm font-medium text-gray-600">Total</div>
                            <div class="text-lg font-bold text-gray-800">Rp {{ number_format($totalReceipt, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="mt-6 space-y-2">
                    @foreach($receiptCategories as $index => $category)
                        @php
                            $color = $colors[$index % count($colors)];
                        @endphp
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded {{ $color }}"></div>
                            <span class="text-sm text-gray-600">
                                {{ $category['category'] }} ({{ $category['percentage'] }}%) - Rp {{ number_format($category['total'], 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex items-center justify-center h-48">
                    <div class="text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-sm">Belum ada data pengeluaran</p>
                    </div>
                </div>
            @endif
        </x-dashboard.chart-card>
    </div>
@endsection
