@extends('layouts.dashboard')

@section('title', 'Dashboard')

@push('styles')
<style>
    .bar-chart {
        @apply flex items-end justify-between h-48 mt-8;
    }

    .bar {
        @apply bg-blue-400 rounded-t;
    }

    .pie-chart {
        @apply relative w-48 h-48 mx-auto;
    }

    .pie-segment {
        @apply absolute inset-0 rounded-full;
    }

    .pie-center {
        @apply absolute inset-4 bg-white rounded-full flex items-center justify-center;
    }
</style>
@endpush

@section('content')
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">DASHBOARD</h1>

    <!-- Top Row - Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-dashboard.metric-card value="18" label="JUMLAH SUPIR AKTIF" />
        <x-dashboard.metric-card value="10" label="JUMLAH TAMU" />
    </div>

    <!-- Bottom Row - Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Rekap Absensi Bulanan -->
        <x-dashboard.chart-card title="REKAP ABSENSI BULANAN">
            <div class="bar-chart">
                <div class="bar w-8" style="height: 2rem;"></div>
                <div class="bar w-8" style="height: 3rem;"></div>
                <div class="bar w-8" style="height: 5rem;"></div>
                <div class="bar w-8" style="height: 6rem;"></div>
                <div class="bar w-8" style="height: 4rem;"></div>
                <div class="bar w-8" style="height: 3rem;"></div>
                <div class="bar w-8" style="height: 2rem;"></div>
                <div class="bar w-8" style="height: 2rem;"></div>
            </div>
            <!-- Y-axis labels -->
            <div class="flex justify-between text-xs text-gray-500 mt-2">
                <span>1</span>
                <span>2</span>
                <span>3</span>
                <span>4</span>
                <span>5</span>
                <span>6</span>
            </div>
        </x-dashboard.chart-card>

        <!-- Pengeluaran Bulanan -->
        <x-dashboard.chart-card title="PENGELUARAN BULANAN">
            <div class="pie-chart">
                <!-- Pie chart segments -->
                <div class="pie-segment bg-blue-300" style="clip-path: polygon(50% 50%, 50% 0%, 100% 0%, 100% 50%)"></div>
                <div class="pie-segment bg-blue-500" style="clip-path: polygon(50% 50%, 100% 50%, 100% 100%, 50% 100%)"></div>
                <div class="pie-segment bg-blue-700" style="clip-path: polygon(50% 50%, 50% 100%, 0% 100%, 0% 50%)"></div>

                <!-- Center circle -->
                <div class="pie-center">
                    <div class="text-center">
                        <div class="text-sm font-medium text-gray-600">Total</div>
                        <div class="text-lg font-bold text-gray-800">100%</div>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="mt-6 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-blue-300 rounded"></div>
                    <span class="text-sm text-gray-600">Item 1 (62.5%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-blue-500 rounded"></div>
                    <span class="text-sm text-gray-600">Item 2 (25%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-blue-700 rounded"></div>
                    <span class="text-sm text-gray-600">Item 3 (12.5%)</span>
                </div>
            </div>
        </x-dashboard.chart-card>
    </div>
@endsection
