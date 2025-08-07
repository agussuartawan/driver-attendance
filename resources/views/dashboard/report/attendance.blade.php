@extends('layouts.dashboard')

@section('title', 'Laporan Absensi')

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Absensi</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap laporan absensi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @php
            $columns = [
                ['key' => 'image', 'label' => 'Bukti', 'type' => 'html'],
                ['key' => 'employee', 'label' => 'Karyawan', 'class' => 'font-medium text-gray-900'],
                ['key' => 'customer', 'label' => 'Tamu', 'class' => 'font-medium text-gray-900'],
                ['key' => 'date', 'label' => 'Tanggal', 'type' => 'date', 'format' => 'd M Y H:i'],
                ['key' => 'type', 'label' => 'Jenis', 'type' => 'status'],
                ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                ['key' => 'location', 'label' => 'Lokasi', 'type' => 'html', 'class' => 'text-center'],
            ];

            $data = $attendances->through(function ($attendance) {
                $attendance->image = '<a href="' . asset('storage/' . $attendance->image) . '" target="_blank"><img src="' . asset('storage/' . $attendance->image) . '" alt="Bukti" class="w-16 h-16"></a>';
                $attendance->location = '<a href="' . asset('storage/' . $attendance->location) . '" target="_blank">' . $attendance->location . '</a>';
                $attendance->type = '<span class="inline-flex px-3 py-1 text-xs font-medium ' . ($attendance->type == 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') . ' rounded-full">' . ($attendance->type == 'in' ? 'Masuk' : 'Pulang') . '</span>';
                return $attendance;
            });

            $button = [
                [
                    'label' => 'Unduh Laporan',
                    'url' => route('report.attendance.export'),
                    'class' => 'bg-green-600 hover:bg-green-700',
                    'icon' => '<x-icons.heroicon name="download-mini" />'
                ]
            ];
        @endphp

        <x-data-table
            :columns="$columns"
            :data="$data"
            :button="$button"
            table-id="attendanceTable"
            search-placeholder="Cari laporan absensi"
            :date-range="true"
        />
    </div>
@endsection
