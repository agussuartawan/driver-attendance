@extends('layouts.mobile')
@php($showNavbar = false)

@section('title', 'Biaya')

@section('content')
    <div class="min-h-max">
        <!-- Header Section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 px-6 pt-8 pb-12">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('mobile.receipt') }}" class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Upload Nota Biaya</h1>
                            <p class="text-green-100 text-sm mt-1">Tambah dokumen biaya pengantaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="px-6 -mt-6 relative z-20">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <form action="{{ route('mobile.receipt.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Amount Input -->
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Biaya</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number"
                                   id="amount"
                                   name="amount"
                                   value="{{ old('amount') }}"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                   placeholder="0"
                                   min="0"
                                   step="100"
                                   required>
                        </div>
                        @error('amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Schedule Input -->
                    <div class="mb-6">
                        <label for="schedule_id" class="block text-sm font-medium text-gray-700 mb-2">Jadwal</label>
                        <select id="schedule_id"
                                name="schedule_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                required>
                            <option value="">Pilih jadwal</option>
                            @foreach ($schedules as $schedule)
                                <option value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>{{ $schedule->name }}</option>
                            @endforeach
                        </select>
                        @error('schedule_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Input -->
                    <div class="mb-6">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select id="category"
                                name="category"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                required>
                            <option value="">Pilih kategori</option>
                            <option value="Bensin" {{ old('category') == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                            <option value="Parkir" {{ old('category') == 'Parkir' ? 'selected' : '' }}>Parkir</option>
                            <option value="Tol" {{ old('category') == 'Tol' ? 'selected' : '' }}>Tol</option>
                            <option value="Makan" {{ old('category') == 'Makan' ? 'selected' : '' }}>Makan</option>
                            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload -->
                    <div class="mb-8">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                        <div class="relative">
                            <input type="file"
                                   id="image"
                                   name="image"
                                   accept="image/*"
                                   class="hidden">
                            <label for="image"
                                   class="block w-full p-6 border-2 border-dashed border-gray-300 rounded-xl text-center cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all duration-200">
                                <div class="space-y-2">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <div>
                                        <span class="text-sm font-medium text-green-600">Klik untuk upload</span>
                                        <p class="text-xs text-gray-500 mt-1">JPG, PNG (Max. 10MB)</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl active:scale-95">
                        Upload Nota Biaya
                    </button>
                </form>
            </div>

            <!-- Tips Section -->
            <div class="mt-6 bg-blue-50 rounded-2xl p-4 border border-blue-200">
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900 mb-1">Tips Upload</h4>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li>• Pastikan foto nota jelas dan tidak blur</li>
                            <li>• Format yang didukung: JPG, PNG</li>
                            <li>• Ukuran maksimal file: 10MB</li>
                            <li>• Isi semua field yang wajib diisi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File upload preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const label = e.target.nextElementSibling;

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    label.innerHTML = `
                        <div class="space-y-2">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-green-600">File dipilih</span>
                                <p class="text-xs text-gray-500 mt-1">${file.name}</p>
                            </div>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
