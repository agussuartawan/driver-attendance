@extends('layouts.mobile')
@php $showNavbar = false; @endphp

@section('title', 'Jadwal')

@php
    $type = request()->type;
@endphp

@section('content')
    <div class="p-6">
        <!-- Header with personalized message -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 text-white p-4 rounded-lg mb-6 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="text-sm">
                    <div class="font-medium text-xs">Jadwal {{ $type == 'in' ? 'Penjemputan' : 'Pengantaran' }}</div>
                    <div class="text-green-100 text-xs">Silahkan pilih jadwal berikut</div>
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

        <!-- Schedule cards -->
        <div class="space-y-4">
            @forelse($schedules as $schedule)
                @php
                    $isStart   = $type == 'in';
                    $dateValue = $isStart ? ($schedule->start_date ?? null) : ($schedule->end_date ?? null);
                    $date      = $dateValue ? \Carbon\Carbon::parse($dateValue) : null;
                    $start     = $schedule->start_date ? \Carbon\Carbon::parse($schedule->start_date) : null;
                    $end       = $schedule->end_date ? \Carbon\Carbon::parse($schedule->end_date) : null;
                    $diffMin   = ($start && $end) ? $start->diffInMinutes($end) : null;

                    // Status styles
                    $dotClass = 'bg-gray-400';
                    $badgeClass = 'bg-gray-100 text-gray-700';
                    $statusLabel = ucfirst($schedule->status ?? '-');

                    if (($schedule->status ?? '') === 'pending') {
                        $dotClass = 'bg-yellow-500'; $badgeClass = 'bg-yellow-100 text-yellow-800'; $statusLabel = 'Belum Dimulai';
                    } elseif (($schedule->status ?? '') === 'in_progress') {
                        $dotClass = 'bg-blue-500'; $badgeClass = 'bg-blue-100 text-blue-800'; $statusLabel = 'Sedang Berjalan';
                    } elseif (($schedule->status ?? '') === 'completed') {
                        $dotClass = 'bg-green-500'; $badgeClass = 'bg-green-100 text-green-800'; $statusLabel = 'Selesai';
                    } elseif (($schedule->status ?? '') === 'canceled') {
                        $dotClass = 'bg-red-500'; $badgeClass = 'bg-red-100 text-red-800'; $statusLabel = 'Dibatalkan';
                    }

                    // Tampilkan alamat sesuai type dan siapkan data tujuan untuk Google Maps (origin = lokasi saat ini)
                    $displayAddress = $isStart ? ($schedule->start_location ?? '-') : ($schedule->end_location ?? '-');
                    $hasStartCoords = !empty($schedule->start_latitude) && !empty($schedule->start_longitude);
                    $hasEndCoords   = !empty($schedule->end_latitude) && !empty($schedule->end_longitude);

                    // Tujuan utama (berdasarkan type)
                    $destLat = $isStart ? ($schedule->start_latitude ?? null) : ($schedule->end_latitude ?? null);
                    $destLng = $isStart ? ($schedule->start_longitude ?? null) : ($schedule->end_longitude ?? null);
                    $destQuery = $isStart ? ($schedule->start_location ?? null) : ($schedule->end_location ?? null);

                    // Fallback href jika geolokasi gagal (tetap bawa user ke Maps)
                    $mapsUrl = null;
                    if (!empty($destLat) && !empty($destLng)) {
                        // Tanpa origin (biar fallback, nanti JS pakai origin=current)
                        $mapsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . $destLat . ',' . $destLng;
                    } elseif (!empty($destQuery)) {
                        $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($destQuery);
                    }
                @endphp
                <a href="{{ route('mobile.attendance.form', ['type' => $type, 'schedule' => $schedule]) }}">
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 rounded-full {{ $dotClass }}"></div>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $isStart ? 'Penjemputan' : 'Pengantaran' }}
                                </span>
                            </div>
                            <span class="text-xs text-gray-500">
                                {{ $date ? $date->translatedFormat('l, d M Y') : '-' }}
                            </span>
                        </div>

                        <div class="space-y-3 mb-3">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-xs text-gray-500">{{ $isStart ? 'Mulai' : 'Selesai' }}</div>
                                <div class="text-sm font-semibold text-green-600">
                                    {{ $date ? $date->format('H.i') : '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500 mb-1">Alamat {{ $isStart ? 'Penjemputan' : 'Pengantaran' }}</div>
                                <div class="text-sm font-medium text-gray-800 break-words leading-relaxed">
                                    {{ $displayAddress }}
                                </div>
                            </div>

                            <div>
                                <a href="{{ $mapsUrl ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md open-maps-btn"
                                data-dest-lat="{{ $destLat }}"
                                data-dest-lng="{{ $destLng }}"
                                data-dest-query="{{ $destQuery }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1118 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    Buka Google Maps
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs px-2 py-1 rounded-full {{ $badgeClass }}">{{ $statusLabel }}</span>
                            <div class="text-right">
                                <div class="text-xs text-gray-700 font-medium">
                                    {{ $schedule->customer_name }}
                                </div>
                                <a href="tel:{{ $schedule->customer_phone }}" class="text-[11px] text-green-600 underline">
                                    {{ $schedule->customer_phone }}
                                </a>
                            </div>
                        </div>

                        @if(!$isStart && $diffMin !== null)
                            <div class="mt-2 text-right">
                                <span class="text-[11px] text-gray-500">
                                    Durasi: {{ intdiv($diffMin, 60) }}j {{ $diffMin % 60 }}m
                                </span>
                            </div>
                        @endif
                    </div>
                </a>
            @empty
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <div class="text-center text-gray-500">Tidak ada jadwal {{ $type == 'in' ? 'Penjemputan' : 'Pengantaran' }}</div>
                </div>
            @endforelse
        </div>
    </div>

@push('scripts')
<script>
  function openMapsWithCurrentLocation(anchor) {
    const destLat = anchor.dataset.destLat;
    const destLng = anchor.dataset.destLng;
    const destQuery = anchor.dataset.destQuery;

    if (!navigator.geolocation) {
      // Fallback: biarkan href default bekerja (mapsUrl)
      return true;
    }

    anchor.addEventListener('click', function(e) {
      // Prevent default to build dynamic URL first
      e.preventDefault();

      navigator.geolocation.getCurrentPosition(function(pos) {
        const origin = pos.coords.latitude + ',' + pos.coords.longitude;
        let url = null;

        if (destLat && destLng) {
          url = 'https://www.google.com/maps/dir/?api=1&origin=' + encodeURIComponent(origin) + '&destination=' + destLat + ',' + destLng;
        } else if (destQuery) {
          url = 'https://www.google.com/maps/dir/?api=1&origin=' + encodeURIComponent(origin) + '&destination=' + encodeURIComponent(destQuery);
        }

        // Jika gagal membangun URL (data tidak lengkap), pakai href default
        window.open(url || anchor.href, '_blank');
      }, function() {
        // Jika user menolak geolokasi, pakai href default
        window.open(anchor.href, '_blank');
      }, { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 });
    }, { once: true });
  }

  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a.open-maps-btn').forEach(function(a) {
      openMapsWithCurrentLocation(a);
    });
  });
</script>
@endpush
@endsection
