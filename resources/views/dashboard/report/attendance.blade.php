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
                ['key' => 'employee', 'label' => 'Karyawan', 'class' => 'font-medium text-gray-900'],
                ['key' => 'customer', 'label' => 'Tamu', 'class' => 'font-medium text-gray-900'],
                ['key' => 'date', 'label' => 'Tanggal', 'type' => 'date', 'format' => 'd M Y'],
                ['key' => 'start', 'label' => 'Mulai', 'type' => 'date', 'format' => 'H:i'],
                ['key' => 'end', 'label' => 'Selesai', 'type' => 'date', 'format' => 'H:i'],
                ['key' => 'location', 'label' => 'Lokasi', 'type' => 'html'],
            ];

            $data = $attendances->through(function ($attendance) {
                $attendance->location = '<span class="text-gray-400">Tidak tersedia</span>';
                // Buka Google Maps dengan latitude dan longitude dari attendance
                if ($attendance->is_start_location_exists) {
                    $googleMapsUrl = 'https://www.google.com/maps?q=' . $attendance->start_latitude . ',' . $attendance->start_longitude;
                    $attendance->location = '<a href="' . $googleMapsUrl . '" target="_blank" class="text-blue-600">Lihat Lokasi Mulai</a>';
                }
                if ($attendance->is_end_location_exists) {
                    $googleMapsUrl = 'https://www.google.com/maps?q=' . $attendance->end_latitude . ',' . $attendance->end_longitude;
                    $attendance->location = '<a href="' . $googleMapsUrl . '" target="_blank" class="text-blue-600"> | Lihat Lokasi Selesai</a>';
                }
                $attendance->type = '<span class="inline-flex px-3 py-1 text-xs font-medium ' . ($attendance->type == 'in' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800') . ' rounded-full">' . ($attendance->type == 'in' ? 'Masuk' : 'Pulang') . '</span>';
                $attendance->status = '<span class="inline-flex px-3 py-1 text-xs font-medium ' . ($attendance->status == 'on_time' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') . ' rounded-full">' . ($attendance->status == 'late' ? 'Terlambat' : ($attendance->status == 'early' ? 'Terlalu Awal' : 'Tepat Waktu')) . '</span>';
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
