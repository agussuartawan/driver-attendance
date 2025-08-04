@extends('layouts.mobile')

@section('title', 'Absensi')

@section('content')
    <div class="p-6">
        <!-- Information Section -->
        <div class="mb-6">
            <div class="border-t-2 border-dotted border-gray-300 my-4"></div>

            <div class="space-y-2 text-green-800 font-medium text-xs">
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
                    <span class="text-orange-600">Belum dimulai</span>
                </div>
            </div>

            <div class="border-t-2 border-dotted border-gray-300 my-4"></div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4 flex flex-col gap-2">
            <a href="{{ route('mobile.attendance-start') }}" class="block w-full py-4 px-6 mb-4 rounded-full border-2 border-green-600 text-green-600 bg-white font-medium text-center transition-all duration-200 hover:bg-green-600 hover:text-white">
                Mulai Pengantaran
            </a>

            <a href="{{ route('mobile.attendance-end') }}" class="w-full py-4 px-6 mb-4 rounded-full border-2 border-green-600 text-green-600 bg-white font-medium text-center transition-all duration-200 hover:bg-green-600 hover:text-white">
                Selesai Pengantaran
            </a>

            <a href="#" class="w-full py-4 px-6 mb-4 rounded-full border-2 border-green-600 text-green-600 bg-white font-medium text-center transition-all duration-200 hover:bg-green-600 hover:text-white">
                Riwayat
            </a>
        </div>

        <!-- Bottom dotted line -->
        <div class="border-t-2 border-dotted border-gray-300 mt-8"></div>
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
    </script>
@endsection
