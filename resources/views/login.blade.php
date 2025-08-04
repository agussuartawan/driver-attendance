<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Senyum</title>

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Custom styles for mobile design */
            .mobile-dotted-line {
                height: 2px;
                background: repeating-linear-gradient(
                    to right,
                    #166534 0,
                    #166534 4px,
                    transparent 4px,
                    transparent 8px
                );
            }

            .green-blob {
                position: absolute;
                bottom: -100px;
                right: -100px;
                width: 300px;
                height: 300px;
                background: #22c55e;
                border-radius: 50%;
            }

            .smiley-eyes {
                display: flex;
                justify-content: space-between;
                margin-bottom: 15px;
            }

            .eye {
                width: 12px;
                height: 12px;
                background: white;
                border-radius: 50%;
            }

            .smiley-mouth {
                width: 40px;
                height: 20px;
                border: 3px solid white;
                border-top: none;
                border-radius: 0 0 40px 40px;
                margin: 0 auto;
            }
        </style>
    @endif
</head>
<body>
    <!-- Mobile Version (hidden on desktop) -->
    <div class="md:hidden min-h-screen flex flex-col">
        <!-- Green Header Section -->
        <div class="bg-green-500 px-8 py-10">
            <div class="text-white">
                <div class="text-lg font-normal font-serif mb-2">Selamat datang di</div>
                <div class="text-3xl font-semibold font-cursive">Senyum !</div>
            </div>
        </div>

        <!-- Main White Section -->
        <div class="flex-1 bg-white px-8 relative">
            <div class="mobile-dotted-line my-5"></div>

            <h1 class="text-2xl font-semibold text-green-800 text-center my-8 font-serif">Ayo masuk!</h1>

            <div class="max-w-xs mx-auto py-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-6">
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="w-full px-5 py-4 border-2 border-green-800 rounded-xl text-base transition-all duration-300 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100"
                            placeholder="Username"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-5 py-4 border-2 border-green-800 rounded-xl text-base transition-all duration-300 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100"
                            placeholder="Password"
                            required
                        >
                    </div>

                    <button type="submit" class="w-full px-5 py-4 bg-green-500 text-white border-none rounded-xl text-lg font-semibold cursor-pointer transition-all duration-300 hover:bg-green-600 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-green-300">
                        Masuk
                    </button>
                </form>
            </div>

            <div class="mobile-dotted-line my-5"></div>

            <!-- Bottom Decorative Section -->
            <div class="relative h-48 mt-10">
                <div class="green-blob flex items-center justify-center">
                    <div class="w-20 h-20 relative -mt-12 -ml-12">
                        <div class="smiley-eyes">
                            <div class="eye"></div>
                            <div class="eye"></div>
                        </div>
                        <div class="smiley-mouth"></div>
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
                        <label for="username-desktop" class="block text-green-500 font-medium mb-2 text-sm uppercase tracking-wide">
                            USERNAME
                        </label>
                        <input
                            type="text"
                            id="username-desktop"
                            name="username"
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-lg text-base transition-all duration-300 bg-white focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100"
                            value="admin"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label for="password-desktop" class="block text-green-500 font-medium mb-2 text-sm uppercase tracking-wide">
                            PASSWORD
                        </label>
                        <input
                            type="password"
                            id="password-desktop"
                            name="password"
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-lg text-base transition-all duration-300 bg-white focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100"
                            value="******"
                            required
                        >
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
