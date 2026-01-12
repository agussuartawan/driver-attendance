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
                ['key' => 'user', 'label' => 'Nama', 'class' => 'font-medium text-gray-900', 'sortable' => true, 'sort_key' => 'user_name'],
                ['key' => 'customer', 'label' => 'Tamu', 'class' => 'font-medium text-gray-900', 'sortable' => true, 'sort_key' => 'customer_name'],
                ['key' => 'date', 'label' => 'Tanggal', 'type' => 'date', 'format' => 'd M Y', 'sortable' => true, 'sort_key' => 'date'],
                ['key' => 'amount', 'label' => 'Jumlah', 'type' => 'currency', 'format' => 'Rp', 'sortable' => true, 'sort_key' => 'amount'],
                ['key' => 'category', 'label' => 'Kategori', 'type' => 'text', 'sortable' => true, 'sort_key' => 'category'],
                ['key' => 'image', 'label' => 'Bukti', 'type' => 'html'],
            ];

            $data = $receipts->through(function ($receipt) {
                $receipt->image = '<a href="' . $receipt->image . '" target="_blank" class="text-blue-500">Lihat Bukti</a>';
                $receipt->user = $receipt->user->name;
                $receipt->customer = $receipt->schedule?->customer_name ?? "-";
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
