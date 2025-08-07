@extends('layouts.dashboard')

@section('title', 'Data Karyawan')

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
            'type' => 'form',
            'label' => fn($row) => $row['status']['text'] == 'Aktif' ? 'Nonaktifkan' : 'Aktifkan',
            'action' => fn($row) => route('employee.status.toggle', ['employee' => $row]),
            'method' => 'PATCH',
            'class' => fn($row) => $row['status']['text'] == 'Aktif' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700',
            'confirm' => fn($row) => $row['status']['text'] == 'Aktif'
                ? 'Apakah Anda yakin ingin menonaktifkan karyawan ini?'
                : 'Apakah Anda yakin ingin mengaktifkan karyawan ini?',
        ]
    ];

    $data = $employees->through(function ($employee) {
        $employee->role = $employee->roles->first()->name . ' (' . ($employee->vehicle ?? 'Tidak ada info kendaraan') . ')';
        $employee->status = [
            'text' => $employee->status == 'active' ? 'Aktif' : 'Nonaktif',
            'class' => $employee->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        ];
        return $employee;
    });

    $button = [
        [
            'label' => 'Tambah Karyawan',
            'url' => route('employee.form.add'),
            'class' => 'bg-green-600 hover:bg-green-700'
        ]
    ];
@endphp

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Data Karyawan</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap data karyawan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <x-data-table
            :columns="$columns"
            :data="$employees"
            :actions="$actions"
            :button="$button"
            table-id="employeeTable"
            search-placeholder="Cari karyawan berdasarkan nama, nomor telepon atau email..."
        />
    </div>
@endsection
