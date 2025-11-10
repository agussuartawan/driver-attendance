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
                            <h1 class="text-2xl font-bold text-white">Riwayat Nota</h1>
                            <p class="text-green-100 text-sm mt-1">Semua dokumen biaya pengantaran</p>
                        </div>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-4 shadow-lg">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-xs text-gray-500 mb-1">Total</div>
                            <div class="text-sm font-semibold text-gray-900">{{ $receipts->total() }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 mb-1">Bulan Ini</div>
                            <div class="text-sm font-semibold text-gray-900">{{ $monthlyCount ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 mb-1">Total Biaya</div>
                            <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($totalAmount ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-6 -mt-6 relative z-20">
            @if($receipts->count() > 0)
                <div class="space-y-4">
                    @foreach($receipts as $receipt)
                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                            <div class="flex items-start space-x-4">
                                <!-- File Icon -->
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    @if(str_contains($receipt->image ?? '', '.pdf'))
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $receipt->category }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">{{ $receipt->schedule->customer_name ?? 'Tanpa jadwal' }}</p>
                                        </div>
                                        <div class="text-right ml-2">
                                            <div class="text-sm font-bold text-gray-900">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</div>
                                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($receipt->created_at)->format('d M Y') }}</div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center space-x-2 mt-3">
                                        @if($receipt->image)
                                            <a href="{{ $receipt->image }}"
                                               target="_blank"
                                               class="flex-1 bg-green-50 text-green-700 text-xs px-3 py-1.5 rounded-lg font-medium text-center hover:bg-green-100 transition-colors">
                                                Lihat File
                                            </a>
                                        @endif
                                        <form action="{{ route('mobile.receipt.destroy', $receipt->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus nota biaya ini?')"
                                                    class="bg-red-50 text-red-700 text-xs px-3 py-1.5 rounded-lg font-medium hover:bg-red-100 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($receipts->hasPages())
                    <div class="mt-6">
                        {{ $receipts->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada nota biaya</h3>
                        <p class="text-gray-500 text-sm mb-6">Mulai dengan upload dokumen biaya pengantaran pertama Anda</p>
                        <a href="{{ route('mobile.receipt.add') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Upload Nota Biaya
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
