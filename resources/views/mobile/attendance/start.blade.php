@extends('layouts.mobile')
@php($showNavbar = false)

@section('title', 'Absensi')

@section('content')
    <div class="p-6">
        <!-- Header with personalized message -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 text-white p-4 rounded-lg mb-6 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="text-sm">
                    <div class="font-medium text-xs">Selamat bekerja Budi,</div>
                    <div class="text-green-100 text-xs">Hati-hati dijalan!</div>
                </div>
                <div class="text-right">
                    <a href="{{ route('mobile.attendance') }}" class="mt-2 px-4 py-2 bg-white text-green-600 border-2 border-green-600 rounded-full text-sm font-medium hover:bg-green-600 hover:text-white transition-colors">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Smiley decoration -->
            <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-green-500 rounded-full opacity-20"></div>
            <div class="absolute -bottom-8 -right-8 w-20 h-20 bg-green-400 rounded-full opacity-30"></div>
        </div>

        <!-- Dotted line separator -->
        <div class="border-t-2 border-dotted border-gray-300 my-4"></div>

        <!-- Order Details Section -->
        <div class="space-y-2 text-green-800 font-medium text-xs mb-6">
            <div class="flex justify-between">
                <span>Tanggal :</span>
                <span>{{ now()->format('d F Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Jam :</span>
                <span id="current-time">{{ now()->format('H.i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status orderan :</span>
                <span class="text-orange-600">Mulai mengantar</span>
            </div>
            <div class="flex justify-between">
                <span>Alamat :</span>
                <span id="current-address" class="text-green-700">Mendapatkan lokasi...</span>
            </div>
        </div>

        <!-- Guest Name Input -->
        <div class="mb-6">
            <div class="text-green-800 font-medium text-xs mb-2">Nama Tamu :</div>
            <input type="text" placeholder="Masukkan nama tamu" class="w-full px-3 py-2 text-xs border border-green-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Dotted line separator -->
        <div class="border-t-2 border-dotted border-gray-300 my-4"></div>

        <!-- Camera Section -->
        <div class="mb-6">
            <div class="text-center mb-4">
                <span class="text-green-800 font-medium text-xs">Jangan Lupa </span>
                <span class="text-green-800 font-dancing-script text-md">Senyum!</span>
            </div>

            <!-- Camera Box -->
            <div class="relative bg-gray-100 border-2 border-green-300 rounded-lg p-8 mb-6">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <!-- Camera Icon -->
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>

                    <!-- Camera Text -->
                    <div class="text-gray-600 font-medium text-xs">Ambil gambar</div>

                    <!-- Camera Preview Area (hidden by default) -->
                    <div id="camera-preview" class="hidden w-full h-48 bg-black rounded-lg overflow-hidden">
                        <video id="video" class="w-full h-full object-cover" autoplay></video>
                    </div>

                    <!-- Camera Controls -->
                    <div id="camera-controls" class="flex space-x-4">
                        <button id="start-camera" class="px-6 py-2 bg-green-600 text-white rounded-full font-medium hover:bg-green-700 transition-colors">
                            Buka Kamera
                        </button>
                        <button id="capture-photo" class="hidden px-6 py-2 bg-red-600 text-white rounded-full font-medium hover:bg-red-700 transition-colors">
                            Ambil Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Delivery Button -->
        <div class="mb-6">
            <button class="w-full py-4 px-2 text-md rounded-full border-2 border-green-600 text-green-600 bg-white font-medium text-center transition-all duration-200 hover:bg-green-600 hover:text-white">
                Mulai Pengantaran
            </button>
        </div>

        <!-- Bottom dotted line -->
        <div class="border-t-2 border-dotted border-gray-300 mt-8"></div>
    </div>

    <!-- Smiley decoration at bottom right -->
    <div class="fixed bottom-20 right-4 w-24 h-24 bg-green-500 rounded-full opacity-80 flex items-center justify-center">
        <div class="flex flex-col items-center">
            <div class="flex space-x-1 mb-1">
                <div class="w-2 h-2 bg-white rounded-full"></div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
            <div class="w-8 h-4 border-2 border-white border-t-transparent border-l-transparent border-r-transparent rounded-full"></div>
        </div>
    </div>

    <script>
        // Update time every second
        function updateTime() {
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + '.' +
                             now.getMinutes().toString().padStart(2, '0');
            document.getElementById('current-time').textContent = timeString;
        }

        // Update time immediately and then every second
        updateTime();
        setInterval(updateTime, 1000);

        // Get current location and address
        function getCurrentLocation() {
            const addressElement = document.getElementById('current-address');

            if (navigator.geolocation) {
                addressElement.textContent = 'Mendapatkan lokasi...';

                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                        const { latitude, longitude } = position.coords;

                        try {
                            // Use reverse geocoding to get address
                            const response = await fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`
                            );

                            if (response.ok) {
                                const data = await response.json();
                                const address = data.display_name;

                                // Format address to show street and city
                                const addressParts = address.split(', ');
                                const streetAddress = addressParts.slice(0, 2).join(', ');
                                const cityAddress = addressParts.slice(-2).join(', ');

                                addressElement.textContent = `${streetAddress}, ${cityAddress}`;
                            } else {
                                addressElement.textContent = `${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
                            }
                        } catch (error) {
                            console.error('Error getting address:', error);
                            addressElement.textContent = `${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
                        }
                    },
                    (error) => {
                        console.error('Error getting location:', error);
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                addressElement.textContent = 'Izin lokasi ditolak';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                addressElement.textContent = 'Lokasi tidak tersedia';
                                break;
                            case error.TIMEOUT:
                                addressElement.textContent = 'Timeout mendapatkan lokasi';
                                break;
                            default:
                                addressElement.textContent = 'Tidak dapat mendapatkan lokasi';
                                break;
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000
                    }
                );
            } else {
                addressElement.textContent = 'Geolokasi tidak didukung';
            }
        }

        // Get location when page loads
        getCurrentLocation();

        // Camera functionality
        let stream = null;
        const video = document.getElementById('video');
        const cameraPreview = document.getElementById('camera-preview');
        const cameraControls = document.getElementById('camera-controls');
        const startCameraBtn = document.getElementById('start-camera');
        const capturePhotoBtn = document.getElementById('capture-photo');

        startCameraBtn.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment', // Use back camera on mobile
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                });
                video.srcObject = stream;
                cameraPreview.classList.remove('hidden');
                startCameraBtn.classList.add('hidden');
                capturePhotoBtn.classList.remove('hidden');
            } catch (err) {
                console.error('Error accessing camera:', err);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera diaktifkan.');
            }
        });

        capturePhotoBtn.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);

            // Convert to blob and create download link
            canvas.toBlob((blob) => {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'attendance-photo-' + new Date().toISOString().slice(0, 19).replace(/:/g, '-') + '.jpg';
                a.click();
                URL.revokeObjectURL(url);
            }, 'image/jpeg', 0.8);

            // Stop camera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            cameraPreview.classList.add('hidden');
            startCameraBtn.classList.remove('hidden');
            capturePhotoBtn.classList.add('hidden');
        });

        // Clean up camera when leaving page
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
@endsection
