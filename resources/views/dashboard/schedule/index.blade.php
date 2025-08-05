@extends('layouts.dashboard')

@section('title', 'Jadwal Tamu')

@section('content')
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-700 mb-8">JADWAL TAMU</h1>

    <div class="grid grid-cols-1 gap-6">
        @php
            $columns = [
                ['key' => 'name', 'label' => 'Nama', 'class' => 'font-medium text-gray-900'],
                ['key' => 'position', 'label' => 'Jabatan'],
                ['key' => 'email', 'label' => 'Email'],
                ['key' => 'phone', 'label' => 'Telepon'],
                ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                ['key' => 'join_date', 'label' => 'Tanggal Bergabung', 'type' => 'date', 'format' => 'd M Y']
            ];

            $data = [
                [
                    'id' => 1,
                    'name' => 'Ahmad Rizki',
                    'position' => 'Software Engineer',
                    'email' => 'ahmad.rizki@company.com',
                    'phone' => '0812-3456-7890',
                    'status' => ['text' => 'Aktif', 'class' => 'bg-green-100 text-green-800'],
                    'join_date' => '2023-01-15'
                ]
            ];

            $actions = [
                [
                    'label' => 'Edit',
                    'url' => fn($row) => route('schedule.form.edit', ['id' => $row['id']]),
                    'class' => 'bg-blue-600 hover:bg-blue-700'
                ],
                [
                    'label' => 'Hapus',
                    'url' => fn($row) => '#',
                    'class' => 'bg-red-600 hover:bg-red-700'
                ]
            ];

            $button = [
                [
                    'label' => 'Tambah Jadwal Tamu',
                    'url' => route('schedule.form.add'),
                    'class' => 'bg-green-600 hover:bg-green-700'
                ],
            ];
        @endphp

        <x-data-table
            :columns="$columns"
            :data="$data"
            :actions="$actions"
            :button="$button"
            table-id="employeeTable"
            search-placeholder="Cari jadwal tamu"
        />
    </div>
@endsection
