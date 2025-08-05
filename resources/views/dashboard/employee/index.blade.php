@extends('layouts.dashboard')

@section('title', 'Data Karyawan')

@section('content')
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-700 mb-8">DATA KARYAWAN</h1>

    <div class="grid grid-cols-1 gap-6">
        @php
            $columns = [
                ['key' => 'name', 'label' => 'Nama', 'class' => 'font-medium text-gray-900'],
                ['key' => 'role', 'label' => 'Jabatan'],
                ['key' => 'email', 'label' => 'Email'],
                ['key' => 'phone', 'label' => 'Telepon'],
                ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                ['key' => 'created_at', 'label' => 'Tanggal Bergabung', 'type' => 'date', 'format' => 'd M Y']
            ];

            $actions = [
                [
                    'label' => 'Edit',
                    'url' => fn($row) => route('employee.form.edit', ['employee' => $row]),
                    'class' => 'bg-blue-600 hover:bg-blue-700'
                ],
                [
                    'label' => 'Nonaktifkan',
                    'url' => fn($row) => '#',
                    'class' => 'bg-red-600 hover:bg-red-700'
                ]
            ];

            $button = [
                [
                    'label' => 'Tambah Karyawan',
                    'url' => route('employee.form.add'),
                    'class' => 'bg-green-600 hover:bg-green-700'
                ],
                [
                    'label' => 'Import Karyawan',
                    'url' => route('employee.form.add'),
                    'class' => 'bg-yellow-600 hover:bg-yellow-700'
                ]
            ];
        @endphp

        <x-data-table
            :columns="$columns"
            :data="$employees"
            :actions="$actions"
            :button="$button"
            table-id="employeeTable"
            search-placeholder="Cari karyawan berdasarkan nama, jabatan, atau email..."
        />
    </div>
@endsection
