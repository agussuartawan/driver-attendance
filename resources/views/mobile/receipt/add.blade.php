@extends('layouts.mobile')
@php($showNavbar = false)

@section('title', 'Nota Biaya')

@section('content')
    <div class="p-6">
        <!-- Header with personalized message -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 text-white p-4 rounded-lg mb-6 relative overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="text-sm">
                    <div class="font-medium text-xs">Upload Nota Biaya</div>
                </div>
                <div class="text-right">
                    <a href="{{ route('mobile.receipt') }}" class="mt-2 px-4 py-2 bg-white text-green-600 border-2 border-green-600 rounded-full text-sm font-medium hover:bg-green-600 hover:text-white transition-colors">
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

        <form action="" class="space-y-4">
            <div class="flex flex-col gap-2">
                <label for="receipt" class="text-sm font-medium">Tanggal</label>
                <input type="date" id="date" class="w-full p-2 border border-gray-300 focus:outline-green-300 rounded-md">
            </div>
            <div class="flex flex-col gap-2">
                <label for="receipt" class="text-sm font-medium">Total</label>
                <input type="number" id="total" class="w-full p-2 border border-gray-300 focus:outline-green-300 rounded-md">
            </div>
            <div class="flex flex-col gap-2">
                <label for="receipt" class="text-sm font-medium">Nama Tamu</label>
                <input type="text" id="name" class="w-full p-2 border border-gray-300 focus:outline-green-300 rounded-md">
            </div>
            <div class="flex flex-col gap-2">
                <label for="receipt" class="text-sm font-medium">Foto Nota</label>
                <input
                    type="file"
                    id="receipt"
                    accept="image/*"
                    capture="environment"
                    class="w-full p-2 border border-gray-300 focus:outline-green-300 rounded-md"
                >
            </div>
            <div class="flex flex-col gap-2">
                <label for="receipt" class="text-sm font-medium">Keterangan</label>
                <textarea id="description" class="w-full p-2 border border-gray-300 focus:outline-green-300 rounded-md"></textarea>
            </div>
            <button type="submit" class="w-full px-6 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                Simpan
            </button>
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
@endsection
