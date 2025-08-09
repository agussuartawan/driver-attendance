@extends('layouts.dashboard')

@section('title', 'Nota Biaya')

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Nota Biaya</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap nota biaya</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @php
            $columns = [
                ['key' => 'user', 'label' => 'Nama', 'class' => 'font-medium text-gray-900'],
                ['key' => 'date', 'label' => 'Tanggal', 'type' => 'date', 'format' => 'd M Y'],
                ['key' => 'amount', 'label' => 'Jumlah', 'type' => 'currency', 'format' => 'Rp'],
                ['key' => 'category', 'label' => 'Kategori', 'type' => 'text'],
                ['key' => 'image', 'label' => 'Bukti', 'type' => 'html'],
            ];

            $data = $receipts->through(function ($receipt) {
                $receipt->image = '<a href="' . $receipt->image . '" target="_blank" class="text-blue-500">Lihat Bukti</a>';
                $receipt->user = $receipt->user->name;
                return $receipt;
            })
        @endphp

        <x-data-table
            :columns="$columns"
            :data="$data"
            table-id="receiptTable"
            :date-range="true"
            search-placeholder="Cari nota biaya"
        />
    </div>
@endsection
