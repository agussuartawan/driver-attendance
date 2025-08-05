<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Senyum</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Mobile Version (hidden on desktop) -->
    <div class="md:hidden min-h-screen flex flex-col bg-gray-50">
        <!-- Green Header Section -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 px-6 py-8 relative overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute top-4 right-4 w-16 h-16 bg-white bg-opacity-20 rounded-full"></div>
            <div class="absolute bottom-4 left-4 w-12 h-12 bg-white bg-opacity-15 rounded-full"></div>

            <div class="text-white relative z-10">
                <div class="text-base font-normal mb-1 opacity-90">Selamat datang di</div>
                <div class="text-2xl font-bold">Senyum !</div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="flex-1 px-6 py-8">
            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h1 class="text-xl font-semibold text-gray-800 text-center mb-6">Ayo masuk!</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            class="w-full px-4 py-3 border rounded-lg text-base transition-all duration-300 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-100 {{ $errors->has('email') ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-green-500' }}"
                            placeholder="Masukkan email"
                            required
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Kata Sandi
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-3 border rounded-lg text-base transition-all duration-300 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-100 {{ $errors->has('password') ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-green-500' }}"
                            placeholder="Masukkan password"
                            required
                            value="{{ old('password') }}"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white border-none rounded-xl text-base font-semibold cursor-pointer transition-all duration-300 hover:from-green-600 hover:to-green-700 active:scale-95 shadow-md">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- Decorative Bottom Section -->
            <div class="relative">
                <!-- Decorative line -->
                <div class="flex items-center justify-center mb-6">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                    <div class="mx-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <div class="w-4 h-4 bg-white rounded-full"></div>
                        </div>
                    </div>
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                </div>

                <!-- Smile face decoration -->
                <div class="flex justify-center">
                    <div class="relative">
                        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                            <div class="w-12 h-12 relative">
                                <!-- Eyes -->
                                <div class="flex justify-between mb-2">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <!-- Smile -->
                                <div class="w-8 h-4 border-2 border-white border-t-0 rounded-b-full mx-auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Version (hidden on mobile) -->
    <div class="hidden md:flex items-center justify-center min-h-screen p-6 lg:p-8">
        <div class="flex max-w-4xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl">
            <!-- Login Form Section -->
            <div class="flex-1 p-12 lg:p-20 flex flex-col justify-center">
                <h1 class="text-4xl font-semibold text-green-500 mb-10 font-serif">Ayo Masuk!</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-green-500 font-medium mb-2 text-sm tracking-wide">
                            Email
                        </label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            class="w-full px-4 py-3 border-2 rounded-lg text-base transition-all duration-300 bg-white focus:outline-none focus:ring-4 focus:ring-green-100 {{ $errors->has('email') ? 'border-red-500 focus:border-red-500' : 'border-gray-200 focus:border-green-500' }}"
                            placeholder="Masukkan email"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-green-500 font-medium mb-2 text-sm tracking-wide">
                            Kata Sandi
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-3 border-2 rounded-lg text-base transition-all duration-300 bg-white focus:outline-none focus:ring-4 focus:ring-green-100 {{ $errors->has('password') ? 'border-red-500 focus:border-red-500' : 'border-gray-200 focus:border-green-500' }}"
                            placeholder="Masukkan password"
                            value="{{ old('password') }}"
                            required
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-5 py-4 bg-green-500 text-white border-none rounded-lg text-lg font-semibold cursor-pointer transition-all duration-300 hover:bg-green-600 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-green-300 mt-5">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- Welcome Section -->
            <div class="flex-1 bg-gradient-to-br from-green-500 to-green-600 flex flex-col justify-center items-center p-12 lg:p-20 relative">
                <div class="text-center text-white mb-10">
                    <div class="text-xl mb-3 font-normal">Selamat datang di</div>
                    <div class="text-4xl font-semibold font-cursive">Senyum !</div>
                </div>

                <div class="w-32 h-32 relative">
                    <div class="flex justify-between mb-5">
                        <div class="w-5 h-5 bg-white rounded-full"></div>
                        <div class="w-5 h-5 bg-white rounded-full"></div>
                    </div>
                    <div class="w-16 h-8 border-4 border-white border-t-0 rounded-b-full mx-auto"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
