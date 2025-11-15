@extends('layouts.dashboard')

@section('title', 'Jadwal Tamu')

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Jadwal Tamu</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap jadwal perjalanan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @php
            $columns = [
                ['key' => 'customer', 'label' => 'Tamu', 'class' => 'font-medium text-gray-900'],
                ['key' => 'category', 'label' => 'Kategori'],
                ['key' => 'driver', 'label' => 'Driver'],
                ['key' => 'start_date', 'label' => 'Tanggal Mulai', 'type' => 'date', 'format' => 'd M Y'],
                ['key' => 'end_date', 'label' => 'Tanggal Selesai', 'type' => 'date', 'format' => 'd M Y'],
                ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
            ];

            $data = $schedules->through(function ($schedule) {
                $schedule->customer = $schedule->customer_name . ' - ' . $schedule->customer_phone;
                $schedule->driver = $schedule->driver->name;
                $schedule->category = $schedule->category ? ucfirst(str_replace('_', ' ', $schedule->category)) : '-';
                return $schedule;
            });

            $actions = [
                [
                    'label' => 'Edit',
                    'url' => fn($row) => route('schedule.form.edit', ['schedule' => $row]),
                    'class' => 'bg-blue-600 hover:bg-blue-700',
                    'icon' => '<x-icons.heroicon name="pencil-micro" class="mr-1" />'
                ],
                [
                    'type' => 'form',
                    'label' => 'Hapus',
                    'action' => fn($row) => route('schedule.destroy', ['schedule' => $row]),
                    'class' => 'bg-red-600 hover:bg-red-700',
                    'method' => 'DELETE',
                    'confirm' => 'Apakah Anda yakin ingin menghapus jadwal tamu ini?',
                    'icon' => '<x-icons.heroicon name="trash-micro" class="mr-1" />'
                ],
                [
                    'label' => 'Detail',
                    'url' => fn($row) => route('schedule.detail', ['schedule' => $row]),
                    'class' => 'bg-green-600 hover:bg-green-700',
                    'icon' => '<x-icons.heroicon name="eye-micro" class="mr-1" />'
                ],
            ];

            $button = [
                [
                    'label' => 'Tambah Jadwal Tamu',
                    'url' => route('schedule.form.add'),
                    'class' => 'bg-green-600 hover:bg-green-700',
                    'icon' => '<x-icons.heroicon name="plus-mini" />'
                ],
            ];
        @endphp

        <x-data-table
            :columns="$columns"
            :data="$data"
            :actions="$actions"
            :button="$button"
            :date-range="true"
            table-id="employeeTable"
            search-placeholder="Cari jadwal tamu"
        />
    </div>
@endsection
