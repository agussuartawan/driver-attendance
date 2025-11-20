<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('patch')
    <input type="hidden" name="from_dashboard" value="1">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm"
                   required autofocus autocomplete="name">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm"
                   required autocomplete="username">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        Alamat email Anda belum diverifikasi.
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="inline">
                            @csrf
                            <button type="submit" class="underline text-sm text-green-600 hover:text-green-800">
                                Klik di sini untuk mengirim ulang email verifikasi.
                            </button>
                        </form>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Tautan verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                   class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm"
                   autocomplete="tel">
            @error('phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2">
            <label for="image" class="block text-sm font-medium text-gray-700">Foto Profil</label>
            <div class="mt-2 flex items-center gap-4">
                @if($user->image)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Foto Profil"
                             class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                    </div>
                @else
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-300">
                            <span class="text-gray-500 text-2xl font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    </div>
                @endif
                <div class="flex-1">
                    <input type="file" name="image" id="image" accept="image/jpeg,image/jpg,image/png"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                </div>
            </div>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md transition-colors">
            Simpan Perubahan
        </button>

        @if (session('status') === 'profile-updated')
            <p class="text-sm text-green-600">
                Tersimpan.
            </p>
        @endif
    </div>
</form>
