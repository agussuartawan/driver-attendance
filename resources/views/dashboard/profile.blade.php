@extends('layouts.dashboard')

@section('title', 'Profil')

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Profil</h1>
            <p class="text-gray-600 mt-1">Kelola informasi profil dan kata sandi Anda</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        <!-- Update Profile Information -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Profil</h2>
                <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil dan alamat email Anda</p>
            </div>

            @include('dashboard.profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Ubah Kata Sandi</h2>
                <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman</p>
            </div>

            @include('dashboard.profile.partials.update-password-form')
        </div>
    </div>
@endsection
