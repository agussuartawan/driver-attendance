@extends('layouts.mobile')

@section('title', 'Dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Mobile Dashboard</h1>

        <div class="space-y-4">
            <div class="bg-green-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-green-800 mb-2">Selamat Datang!</h2>
                <p class="text-green-700">Ini adalah tampilan mobile yang responsif dengan layout yang mirip dengan gambar yang Anda berikan.</p>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-blue-800 mb-2">Fitur Mobile</h2>
                <ul class="text-blue-700 space-y-1">
                    <li>• Header dengan gradient hijau</li>
                    <li>• Bottom navigation</li>
                    <li>• Ukuran layar terkunci mobile (375px)</li>
                    <li>• Responsif dengan Tailwind CSS</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
