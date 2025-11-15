@extends('layouts.dashboard')

@section('title', 'Detail Karyawan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Karyawan</h1>
                <p class="text-gray-600 mt-1">Informasi lengkap karyawan</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('employee') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('employee.form.edit', $employee) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Employee Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Karyawan</h2>
                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full
                        @if($employee->status === 'active') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $employee->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>

                <div class="flex items-start gap-6 mb-6">
                    @if($employee->image)
                        <img src="{{ $employee->image }}" alt="{{ $employee->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-green-100">
                    @else
                        <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center border-4 border-green-200">
                            <span class="text-3xl font-semibold text-green-600">{{ strtoupper(substr($employee->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $employee->name }}</h3>
                        <p class="text-sm text-gray-600 mb-1">{{ $employee->email }}</p>
                        @if($employee->phone)
                            <p class="text-sm text-gray-600">
                                <a href="tel:{{ $employee->phone }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $employee->phone }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <p class="text-sm text-gray-900">
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                {{ $employee->getRoleNames()->first() ?? 'Driver' }}
                            </span>
                        </p>
                    </div>
                    @if($employee->vehicle)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                            <p class="text-sm text-gray-900">{{ $employee->vehicle }}</p>
                        </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bergabung</label>
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($employee->created_at)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($employee->updated_at)->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Jadwal</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalSchedules }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <x-icons.heroicon name="calendar" class="w-6 h-6 text-blue-600" />
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Nota Biaya</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalReceipts }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <x-icons.heroicon name="currency-dollar" class="w-6 h-6 text-yellow-600" />
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Absensi</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalAttendances }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <x-icons.heroicon name="calendar" class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Nota Biaya</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalReceiptAmount, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <x-icons.heroicon name="currency-dollar" class="w-6 h-6 text-purple-600" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Schedules -->
            @if($recentSchedules->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Jadwal Terbaru</h2>
                        <a href="{{ route('schedule') }}?driver={{ $employee->id }}" class="text-sm text-blue-600 hover:text-blue-800">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentSchedules as $schedule)
                            <a href="{{ route('schedule.detail', $schedule) }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $schedule->customer_name }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y H:i') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($schedule->status === 'completed') bg-green-100 text-green-800
                                        @elseif($schedule->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($schedule->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Receipts -->
            @if($recentReceipts->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Nota Biaya Terbaru</h2>
                        <a href="{{ route('receipt') }}?user={{ $employee->id }}" class="text-sm text-blue-600 hover:text-blue-800">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentReceipts as $receipt)
                            <a href="{{ route('receipt.show', $receipt) }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <h3 class="font-medium text-gray-900">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</h3>
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                                {{ $receipt->category }}
                                            </span>
                                        </div>
                                        @if($receipt->schedule)
                                            <p class="text-sm text-gray-600 mt-1">{{ $receipt->schedule->customer_name }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($receipt->date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="space-y-3">
                    @if($employee->phone)
                        <a href="tel:{{ $employee->phone }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Hubungi Karyawan
                        </a>
                    @endif

                    <a href="{{ route('employee.form.edit', $employee) }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Karyawan
                    </a>

                    <form action="{{ route('employee.status.toggle', $employee) }}" method="POST" class="inline-block w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white {{ $employee->status === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            {{ $employee->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
