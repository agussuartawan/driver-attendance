@extends('layouts.dashboard')
@section('title', $employee ? 'Edit Karyawan' : 'Tambah Karyawan')

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $employee ? 'Edit Karyawan' : 'Tambah Karyawan' }}</h1>
            <p class="text-gray-600 mt-1">Tambahkan atau edit data karyawan</p>
        </div>
    </div>

    <div class="flex bg-white p-6 rounded-lg shadow-md max-w-2xl">
        <form action="{{ $employee ? route('employee.form.edit', ['employee' => $employee]) : route('employee.form.add') }}" class="w-full grid grid-cols-1 gap-6" method="post" enctype="multipart/form-data">
            @csrf
            @method($employee ? 'PATCH' : 'POST')
            <div class="col-span-1">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama*</label>
                <input value="{{ $employee->name ?? old('name') }}" type="text" name="name" id="name" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                @error('name')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-1">
                <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                <input value="{{ $employee->email ?? old('email') }}" type="email" name="email" id="email" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-1">
                <label for="phone" class="block text-sm font-medium text-gray-700">Telepon*</label>
                <input value="{{ $employee->phone ?? old('phone') }}" type="text" name="phone" id="phone" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-1">
                <label for="vehicle" class="block text-sm font-medium text-gray-700">Kendaraan</label>
                <input value="{{ $employee->vehicle ?? old('vehicle') }}" type="text" name="vehicle" id="vehicle" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm">
            </div>
            <div class="col-span-1">
                <label for="image" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm">
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-1 flex gap-4">
                <a href="{{ route('employee') }}" class="bg-red-500 text-white px-4 py-2 rounded-md">Batal</a>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection
