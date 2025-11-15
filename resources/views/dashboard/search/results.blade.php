@extends('layouts.dashboard')

@section('title', 'Hasil Pencarian')

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hasil Pencarian</h1>
            <p class="text-gray-600 mt-1">
                @if($query)
                    Menampilkan hasil untuk: <span class="font-semibold text-green-600">"{{ $query }}"</span>
                @else
                    Masukkan kata kunci untuk mencari
                @endif
            </p>
        </div>
        <button onclick="openSearchModal()" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all flex items-center gap-2">
            <x-icons.heroicon name="magnifying-glass" class="w-5 h-5" />
            Cari Lagi
        </button>
    </div>

    @if(empty($query))
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <x-icons.heroicon name="magnifying-glass" class="w-16 h-16 text-gray-400 mx-auto mb-4" />
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Mulai Pencarian</h3>
            <p class="text-gray-500 mb-6">Gunakan form pencarian di header untuk mencari data</p>
            <button onclick="openSearchModal()" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all">
                Buka Form Pencarian
            </button>
        </div>
    @else
        @php
            $totalResults = $results['users']->count() +
                           $results['schedules']->count() +
                           $results['receipts']->count() +
                           $results['attendances']->count();
        @endphp

        @if($totalResults === 0)
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <x-icons.heroicon name="magnifying-glass" class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-gray-500 mb-6">Tidak ada data yang cocok dengan kata kunci "{{ $query }}"</p>
                <button onclick="openSearchModal()" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all">
                    Cari Lagi
                </button>
            </div>
        @else
            <div class="space-y-6">
                <!-- Users Results -->
                @if($results['users']->count() > 0 && ($type === 'all' || $type === 'users'))
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <x-icons.heroicon name="users" class="w-6 h-6 text-green-600" />
                                    <h2 class="text-lg font-semibold text-gray-900">Karyawan ({{ $results['users']->count() }})</h2>
                                </div>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($results['users'] as $user)
                                <a href="{{ route('employee.detail', $user) }}" class="block p-6 hover:bg-green-50 transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-green-600 font-semibold">{{ $user->name[0] }}</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                                @if($user->phone)
                                                    <p class="text-xs text-gray-500 mt-1">{{ $user->phone }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                {{ $user->getRoleNames()->first() ?? 'User' }}
                                            </span>
                                            @if($user->vehicle)
                                                <p class="text-xs text-gray-500 mt-1">{{ $user->vehicle }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Schedules Results -->
                @if($results['schedules']->count() > 0 && ($type === 'all' || $type === 'schedules'))
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <x-icons.heroicon name="calendar" class="w-6 h-6 text-blue-600" />
                                    <h2 class="text-lg font-semibold text-gray-900">Jadwal ({{ $results['schedules']->count() }})</h2>
                                </div>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($results['schedules'] as $schedule)
                                <a href="{{ route('schedule.detail', $schedule) }}" class="block p-6 hover:bg-blue-50 transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">{{ $schedule->customer_name }}</h3>
                                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                                <p><span class="font-medium">Dari:</span> {{ $schedule->start_location }}</p>
                                                <p><span class="font-medium">Ke:</span> {{ $schedule->end_location }}</p>
                                                <p><span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right ml-4">
                                            @if($schedule->driver)
                                                <p class="text-sm text-gray-600">{{ $schedule->driver->name }}</p>
                                            @endif
                                            @if($schedule->category)
                                                <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                    {{ $schedule->category }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Receipts Results -->
                @if($results['receipts']->count() > 0 && ($type === 'all' || $type === 'receipts'))
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 px-6 py-4 border-b border-yellow-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <x-icons.heroicon name="document" class="w-6 h-6 text-yellow-600" />
                                    <h2 class="text-lg font-semibold text-gray-900">Nota Biaya ({{ $results['receipts']->count() }})</h2>
                                </div>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($results['receipts'] as $receipt)
                                <a href="{{ route('receipt.show', $receipt->id) }}" class="block p-6 hover:bg-yellow-50 transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                <h3 class="font-semibold text-gray-900">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</h3>
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                                    {{ $receipt->category }}
                                                </span>
                                            </div>
                                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                                @if($receipt->user)
                                                    <p><span class="font-medium">Karyawan:</span> {{ $receipt->user->name }}</p>
                                                @endif
                                                @if($receipt->schedule)
                                                    <p><span class="font-medium">Jadwal:</span> {{ $receipt->schedule->customer_name }}</p>
                                                @endif
                                                <p><span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($receipt->date)->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Attendances Results -->
                @if($results['attendances']->count() > 0 && ($type === 'all' || $type === 'attendances'))
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <x-icons.heroicon name="calendar" class="w-6 h-6 text-purple-600" />
                                    <h2 class="text-lg font-semibold text-gray-900">Absensi ({{ $results['attendances']->count() }})</h2>
                                </div>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($results['attendances'] as $attendance)
                                <div class="p-6 hover:bg-purple-50 transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                @if($attendance->employee)
                                                    <h3 class="font-semibold text-gray-900">{{ $attendance->employee->name }}</h3>
                                                @endif
                                                <span class="px-3 py-1 {{ $attendance->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs font-medium rounded-full">
                                                    {{ $attendance->type === 'in' ? 'Masuk' : 'Keluar' }}
                                                </span>
                                            </div>
                                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                                @if($attendance->schedule)
                                                    <p><span class="font-medium">Jadwal:</span> {{ $attendance->schedule->customer_name }}</p>
                                                @endif
                                                @if($attendance->location)
                                                    <p><span class="font-medium">Lokasi:</span> {{ $attendance->location }}</p>
                                                @endif
                                                <p><span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @endif
@endsection
