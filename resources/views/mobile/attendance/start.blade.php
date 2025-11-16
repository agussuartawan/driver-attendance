@extends('layouts.mobile')
@php($showNavbar = false)

@section('title', 'Absensi')

@section('content')
    <div class="p-6">
        <!-- Header with personalized message -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 text-white p-4 rounded-lg mb-6 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="text-sm">
                    <div class="font-medium text-xs">Selamat bekerja {{ auth()->user()->name }},</div>
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
        <div class="space-y-2 text-green-800 font-medium text-xs mb-6 p-4 bg-green-50 rounded-lg">
            <label class="text-green-800 font-semibold text-sm mb-2">Data Absensi</label>
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-4 flex flex-col items-start justify-start gap-1">
                    <span>Nama :</span>
                    <span>Tanggal :</span>
                    <span>Jam :</span>
                    <span>Status :</span>
                    <span>Lokasi :</span>
                </div>

                <div class="col-span-8 flex flex-col items-end justify-end text-right gap-1">
                    <span>{{ auth()->user()->name }}</span>
                    <span>{{ now()->format('d F Y') }}</span>
                    <span id="current-time">{{ now()->format('H.i') }}</span>
                    <span class="{{ $isLate ? 'text-orange-600' : 'text-green-600' }}">{{ $status }}</span>
                    <span id="current-address" class="text-green-700">Mendapatkan lokasi...</span>
                </div>
            </div>
        </div>

        <div class="space-y-2 text-green-800 font-medium text-xs mb-6 p-4 bg-green-50 rounded-lg">
            <label class="text-green-800 font-semibold text-sm mb-2">Data Penjemputan</label>
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-4 flex flex-col items-start justify-start gap-1">
                    <span>Nama Tamu :</span>
                    <span>Alamat :</span>
                </div>

                <div class="col-span-8 flex flex-col items-end justify-end text-right gap-1">
                    <span>{{ $schedule->customer_name }} ({{ $schedule->customer_phone }})</span>
                    <span>{{ $schedule->start_location }}</span>
                </div>
            </div>
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
            @error('image')
                <span class="text-red-600 font-medium text-xs">{{ $message }}</span>
            @enderror
            <div class="flex justify-center text-sm mb-2">
                <span id="distance-display" class="text-center text-green-700">Mengukur jarak...</span>
            </div>

            <div id="camera-box" class="relative bg-gray-100 border-2 border-green-300 rounded-lg p-8 mb-6">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <!-- Camera Icon -->
                    <div id="camera-icon" class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>

                    <!-- Camera Text -->
                    <div id="camera-label" class="text-gray-600 font-medium text-xs">Preview Foto</div>

                    <!-- Camera Preview Area (hidden by default) -->
                    <div id="camera-preview" class="hidden w-full h-64 bg-black rounded-lg overflow-hidden">
                        <video id="video" class="w-full h-full object-cover" autoplay></video>
                    </div>

                    <!-- Camera Controls -->
                    <div id="camera-controls" class="flex space-x-4">
                        <button id="start-camera" type="button" class="px-6 py-2 bg-green-600 text-white rounded-full font-medium hover:bg-green-700 transition-colors">
                            Lihat Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Delivery Button -->
        <form action="{{ route('mobile.attendance.create', ['type' => 'in', 'schedule' => $schedule]) }}" method="post" class="mb-6">
            @csrf
            <input type="hidden" name="location" id="location">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="image" id="image">
            <button id="start-delivery-btn" type="submit" disabled class="w-full py-4 px-2 text-md rounded-full border-2 border-green-600 text-green-600 bg-white font-medium text-center transition-all duration-200 hover:bg-green-600 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                Mulai Pengantaran
            </button>
            <p id="location-warning" class="mt-2 text-xs text-red-600 hidden">Izin lokasi belum diberikan. Aktifkan izin lokasi untuk melanjutkan.</p>
            <p id="distance-warning" class="mt-2 text-xs text-red-600 hidden">Anda terlalu jauh dari lokasi penjemputan. Jarak maksimal 100 meter. Silakan mendekati lokasi penjemputan.</p>
            <button type="button" id="request-location-permission" class="mt-1 text-xs text-green-700 underline hidden">Aktifkan izin lokasi</button>
        </form>
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
        // Schedule coordinates for distance validation
        const scheduleLat = "{{ $schedule->start_latitude }}" === "" ? null : parseFloat("{{ $schedule->start_latitude }}");
        const scheduleLng = "{{ $schedule->start_longitude }}" === "" ? null : parseFloat("{{ $schedule->start_longitude }}");
        const maxDistance = 100 * 1000; // 100 kilometers

        // Hidden inputs & controls
        const locationInput = document.getElementById('location');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const imageInput = document.getElementById('image');
        const startBtn = document.getElementById('start-delivery-btn');
        const warnEl = document.getElementById('location-warning');
        const distanceWarnEl = document.getElementById('distance-warning');
        const requestPermBtn = document.getElementById('request-location-permission');

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
        async function queryPermissionState() {
            if (!navigator.permissions) return null;
            try {
                const status = await navigator.permissions.query({ name: 'geolocation' });
                return status.state; // 'granted' | 'prompt' | 'denied'
            } catch (_) { return null; }
        }

        // Calculate distance between two points using Haversine formula
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // Earth's radius in meters
            const φ1 = lat1 * Math.PI/180;
            const φ2 = lat2 * Math.PI/180;
            const Δφ = (lat2-lat1) * Math.PI/180;
            const Δλ = (lon2-lon1) * Math.PI/180;

            const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                    Math.cos(φ1) * Math.cos(φ2) *
                    Math.sin(Δλ/2) * Math.sin(Δλ/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

            return R * c; // Distance in meters
        }

        function validateDistance(currentLat, currentLng) {
            if (scheduleLat === null || scheduleLng === null) {
                // No schedule coordinates, allow submission
                const distanceDisplay = document.getElementById('distance-display');
                if (distanceDisplay) {
                    distanceDisplay.textContent = 'Tidak tersedia';
                    distanceDisplay.className = 'text-gray-500';
                }
                return true;
            }

            const distance = calculateDistance(currentLat, currentLng, scheduleLat, scheduleLng);
            console.log(`Distance to schedule location: ${distance.toFixed(2)} meters`);

            // Update distance display
            const distanceDisplay = document.getElementById('distance-display');
            if (distanceDisplay) {
                distanceDisplay.textContent = `${distance.toFixed(0)} meter dari lokasi penjemputan`;
                if (distance <= maxDistance) {
                    distanceDisplay.className = 'text-green-700';
                } else {
                    distanceDisplay.className = 'text-red-600';
                }
            }

            return distance <= maxDistance;
        }

        function setLocationPermissionUI(hasPermission) {
            if (hasPermission) {
                warnEl.classList.add('hidden');
                requestPermBtn.classList.add('hidden');
            } else {
                warnEl.classList.remove('hidden');
                requestPermBtn.classList.remove('hidden');
            }
        }

        function setDistanceValidationUI(isValid) {
            if (isValid) {
                distanceWarnEl.classList.add('hidden');
            } else {
                distanceWarnEl.classList.remove('hidden');
            }
        }

        function updateButtonState() {
            // Button is enabled only when location permission is granted AND distance is valid
            const hasLocationPermission = warnEl.classList.contains('hidden');
            const isDistanceValid = distanceWarnEl.classList.contains('hidden');

            startBtn.disabled = !(hasLocationPermission && isDistanceValid);
        }

        function getCurrentLocation() {
            const addressElement = document.getElementById('current-address');

            if (navigator.geolocation) {
                addressElement.textContent = 'Mendapatkan lokasi...';

                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                        const { latitude, longitude } = position.coords;

                        // Isi hidden latitude/longitude terlebih dahulu
                        latitudeInput.value = latitude;
                        longitudeInput.value = longitude;

                        // Validate distance
                        const isDistanceValid = validateDistance(latitude, longitude);

                        try {
                            // Use reverse geocoding to get address
                            const response = await fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`
                            );

                            if (response.ok) {
                                const data = await response.json();
                                const address = data.display_name;
                                // Tampilkan alamat penuh secara ringkas (tetap semua elemen, tapi biarkan UI yang wrap)
                                addressElement.textContent = address;
                                // Isi hidden location dengan alamat penuh
                                locationInput.value = address;
                                setLocationPermissionUI(true);
                                setDistanceValidationUI(isDistanceValid);
                                updateButtonState();
                            } else {
                                addressElement.textContent = `${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
                                locationInput.value = `${latitude},${longitude}`;
                                setLocationPermissionUI(true);
                                setDistanceValidationUI(isDistanceValid);
                                updateButtonState();
                            }
                        } catch (error) {
                            console.error('Error getting address:', error);
                            addressElement.textContent = `${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
                            locationInput.value = `${latitude},${longitude}`;
                            setLocationPermissionUI(true);
                            setDistanceValidationUI(isDistanceValid);
                            updateButtonState();
                        }
                    },
                    (error) => {
                        console.error('Error getting location:', error);
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                addressElement.textContent = 'Izin lokasi ditolak';
                                locationInput.value = '';
                                setLocationPermissionUI(false);
                                setDistanceValidationUI(true); // Hide distance warning when location permission is denied
                                updateButtonState();
                                break;
                            case error.POSITION_UNAVAILABLE:
                                addressElement.textContent = 'Lokasi tidak tersedia';
                                locationInput.value = '';
                                setLocationPermissionUI(false);
                                setDistanceValidationUI(true); // Hide distance warning when location permission is denied
                                updateButtonState();
                                break;
                            case error.TIMEOUT:
                                addressElement.textContent = 'Timeout mendapatkan lokasi';
                                locationInput.value = '';
                                setLocationPermissionUI(false);
                                setDistanceValidationUI(true); // Hide distance warning when location permission is denied
                                updateButtonState();
                                break;
                            default:
                                addressElement.textContent = 'Tidak dapat mendapatkan lokasi';
                                locationInput.value = '';
                                setLocationPermissionUI(false);
                                setDistanceValidationUI(true); // Hide distance warning when location permission is denied
                                updateButtonState();
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
                locationInput.value = '';
                setLocationPermissionUI(false);
                setDistanceValidationUI(true); // Hide distance warning when geolocation is not supported
                updateButtonState();
            }
        }

        // Init
        (async () => {
            const state = await queryPermissionState();
            if (state === 'granted') {
                setLocationPermissionUI(true);
                setDistanceValidationUI(true); // Initially hide distance warning
                updateButtonState();
                getCurrentLocation();
            } else if (state === 'prompt' || state === null) {
                // Belum diketahui → tampilkan tombol minta izin
                setLocationPermissionUI(false);
                setDistanceValidationUI(true); // Hide distance warning when permission is not granted
                updateButtonState();
            } else {
                // denied
                setLocationPermissionUI(false);
                setDistanceValidationUI(true); // Hide distance warning when permission is denied
                updateButtonState();
            }
        })();

        // Meminta izin lokasi ulang
        requestPermBtn.addEventListener('click', () => {
            // Pemanggilan getCurrentPosition akan memicu prompt izin (jika state prompt)
            getCurrentLocation();
        });

        // Camera functionality
        let stream = null;
        const video = document.getElementById('video');
        const cameraPreview = document.getElementById('camera-preview');
        const cameraControls = document.getElementById('camera-controls');
        const startCameraBtn = document.getElementById('start-camera');
        const cameraIcon = document.getElementById('camera-icon');
        const cameraLabel = document.getElementById('camera-label');
        const cameraBox = document.getElementById('camera-box');

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
                // Hide icon/label and remove border/padding to let preview fill the box
                cameraIcon.classList.add('hidden');
                cameraLabel.classList.add('hidden');
                cameraBox.classList.remove('border-2','border-green-300','p-8','bg-gray-100');
                cameraBox.classList.add('p-0','bg-black');
            } catch (err) {
                console.error('Error accessing camera:', err);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera diaktifkan.');
            }
        });

        async function captureAndFillImage() {
            try {
                // Pastikan stream aktif. Jika belum, buka kamera cepat (tanpa menampilkan preview)
                let openedHere = false;
                if (!stream) {
                    try {
                        stream = await navigator.mediaDevices.getUserMedia({
                            video: { facingMode: 'environment', width: { ideal: 1280 }, height: { ideal: 720 } }
                        });
                        openedHere = true;
                        video.srcObject = stream;
                        // Tunggu metadata agar bisa mengambil frame
                        await new Promise((resolve) => {
                            if (video.readyState >= 1) return resolve();
                            video.onloadedmetadata = () => resolve();
                        });
                    } catch (err) {
                        console.error('Tidak bisa membuka kamera untuk capture:', err);
                        throw err;
                    }
                }

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth || 1280;
                canvas.height = video.videoHeight || 720;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
                imageInput.value = dataUrl;

                // Jika kita yang membuka stream, matikan kembali
                if (openedHere && stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                    video.srcObject = null;
                }

                // Sembunyikan preview jika ada
                cameraPreview.classList.add('hidden');
                startCameraBtn.classList.remove('hidden');
                cameraIcon.classList.remove('hidden');
                cameraLabel.classList.remove('hidden');
                cameraBox.classList.add('border-2','border-green-300','p-8','bg-gray-100');
                cameraBox.classList.remove('p-0','bg-black');
            } catch (err) {
                alert('Gagal mengambil foto. Pastikan izin kamera diaktifkan.');
                throw err;
            }
        }

        // Tangani submit: ambil foto otomatis lalu submit form
        const startForm = startBtn.closest('form');
        startForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            startBtn.disabled = true;
            try {
                await captureAndFillImage();
                startForm.submit();
            } catch (_) {
                startBtn.disabled = false;
            }
        });

        // Clean up camera when leaving page
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
@endsection
