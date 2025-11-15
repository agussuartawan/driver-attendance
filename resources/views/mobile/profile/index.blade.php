@extends('layouts.mobile')

@section('title', 'Profil')

@section('content')
    <div class="p-6">
        <!-- Profile Header -->
        <div class="text-center mb-8">
            @if(auth()->user()->image)
                <img src="{{ auth()->user()->image }}" alt="Profile" class="w-24 h-24 rounded-full object-cover mx-auto mb-4">
            @else
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
            <h2 class="text-xl font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</h2>
            <p class="text-gray-600 text-sm">{{ auth()->user()->email ?? 'user@example.com' }}</p>
        </div>

        <!-- Profile Information -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Informasi Profil</h3>

            <div class="space-y-4 text-sm">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Nama Lengkap</span>
                    <span class="text-gray-800 font-medium">{{ auth()->user()->name ?? 'User' }}</span>
                </div>

                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Email</span>
                    <span class="text-gray-800 font-medium">{{ auth()->user()->email ?? 'user@example.com' }}</span>
                </div>

                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Nomor Telepon</span>
                    <span class="text-gray-800 font-medium">{{ auth()->user()->phone ?? '081234567890' }}</span>
                </div>

                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Kendaraan</span>
                    <span class="text-gray-800 font-medium">{{ auth()->user()->vehicle ?? 'Kendaraan tidak diisi' }}</span>
                </div>

                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Bergabung Sejak</span>
                    <span class="text-gray-800 font-medium">{{ auth()->user()->created_at->format('d M Y') }}</span>
                </div>

                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Status</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Aktif</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <a href="{{ route('mobile.profile.edit') }}" class="block w-full py-2 px-6 rounded-lg border-2 border-green-600 text-green-600 bg-white font-medium text-center transition-all duration-200 hover:bg-green-600 hover:text-white">
                Edit Profil
            </a>

            <a href="{{ route('mobile.profile.edit-password') }}" class="block w-full py-2 px-6 rounded-lg border-2 border-green-600 text-green-600 bg-white font-medium text-center transition-all duration-200 hover:bg-green-600 hover:text-white">
                Ubah Password
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="w-full py-2 px-6 rounded-lg border-2 border-red-600 bg-red-600 text-white font-medium text-center transition-all duration-200 hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>
    </div>
@endsection
