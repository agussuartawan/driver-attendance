@extends('layouts.dashboard')

@section('title', 'Nota Biaya')

@section('content')
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-700 mb-8">NOTA BIAYA</h1>

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
        @endphp

        <x-data-table
            :columns="$columns"
            :data="$data"
            table-id="employeeTable"
            search-placeholder="Cari nota biaya"
        />
    </div>
@endsection
