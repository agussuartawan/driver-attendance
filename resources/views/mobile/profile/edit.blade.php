@extends('layouts.mobile')
@php($showNavbar = false)

@section('title', 'Edit Profil')

@section('content')
    <div class="min-h-max">
        <!-- Header Section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 px-6 pt-8 pb-12">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('mobile.profile') }}" class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Edit Profil</h1>
                            <p class="text-green-100 text-sm mt-1">Perbarui informasi profil Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="px-6 -mt-6 relative z-20">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="from_mobile" value="1">

                    <!-- Profile Image Upload -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                        <div class="flex flex-col items-center">
                            <div class="relative mb-4">
                                <div id="image-preview" class="w-24 h-24 rounded-full overflow-hidden border-4 border-green-100 bg-gray-100 flex items-center justify-center">
                                    @if(auth()->user()->image)
                                        <img src="{{ auth()->user()->image }}" alt="Profile" class="w-full h-full object-cover" id="preview-img">
                                    @else
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="preview-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <input type="file"
                                   id="image"
                                   name="image"
                                   accept="image/*"
                                   class="hidden">
                            <label for="image"
                                   class="px-4 py-2 bg-green-50 border-2 border-green-300 text-green-700 rounded-xl cursor-pointer hover:bg-green-100 transition-all duration-200 text-sm font-medium">
                                Pilih Foto
                            </label>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2 text-center">JPG, PNG (Max. 2MB)</p>
                    </div>

                    <!-- Name Input -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                               placeholder="Masukkan nama lengkap"
                               required
                               autofocus
                               autocomplete="name">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                               placeholder="Masukkan email"
                               required
                               autocomplete="username">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Input -->
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text"
                               id="phone"
                               name="phone"
                               value="{{ old('phone', auth()->user()->phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                               placeholder="Masukkan nomor telepon"
                               autocomplete="tel">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vehicle Input -->
                    <div class="mb-6">
                        <label for="vehicle" class="block text-sm font-medium text-gray-700 mb-2">Kendaraan</label>
                        <input type="text"
                               id="vehicle"
                               name="vehicle"
                               value="{{ old('vehicle', auth()->user()->vehicle) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                               placeholder="Masukkan jenis kendaraan">
                        @error('vehicle')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Success Message -->
                    @if (session('status') === 'profile-updated')
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="text-sm font-medium text-green-800">Profil berhasil diperbarui</p>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl active:scale-95">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const preview = document.getElementById('image-preview');

            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const previewImg = document.getElementById('preview-img');
                    const previewIcon = document.getElementById('preview-icon');

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (previewIcon) {
                                previewIcon.style.display = 'none';
                            }
                            if (previewImg) {
                                previewImg.src = e.target.result;
                            } else {
                                const img = document.createElement('img');
                                img.id = 'preview-img';
                                img.src = e.target.result;
                                img.className = 'w-full h-full object-cover';
                                preview.appendChild(img);
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endsection
