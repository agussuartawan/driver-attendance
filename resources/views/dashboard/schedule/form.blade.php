@extends('layouts.dashboard')

@php
    $id = request()->route('id');
@endphp

@section('title', $id ? 'Edit Jadwal Tamu' : 'Tambah Jadwal Tamu')

@section('content')
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-700 mb-8">{{ $id ? 'Edit Jadwal Tamu' : 'Tambah Jadwal Tamu' }}</h1>

    <div class="flex bg-white p-6 rounded-lg shadow-md max-w-2xl">
        <form action="{{ $id ? route('employee.form.edit', ['id' => $id]) : route('employee.form.add') }}" class="w-full grid grid-cols-1 gap-6" method="post">
            @csrf
            <div class="col-span-1">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Tamu</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm">
            </div>
            <div class="col-span-1">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Tamu</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm">
            </div>

            <div class="col-span-1 flex gap-4">
                <a href="{{ route('schedule') }}" class="bg-red-500 text-white px-4 py-2 rounded-md">Batal</a>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection
