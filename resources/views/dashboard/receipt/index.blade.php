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
                ['key' => 'image', 'label' => 'Bukti', 'type' => 'html'],
            ];

            $data = $receipts->through(function ($receipt) {
                $receipt->image = '<a href="' . asset('storage/' . $receipt->image) . '" target="_blank"><img src="' . asset('storage/' . $receipt->image) . '" alt="Bukti" class="w-16 h-16"></a>';
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
