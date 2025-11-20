<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')
    <input type="hidden" name="from_dashboard" value="1">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">Kata Sandi Saat Ini <span class="text-red-500">*</span></label>
            <input type="password" name="current_password" id="update_password_current_password"
                   class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm"
                   autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru <span class="text-red-500">*</span></label>
            <input type="password" name="password" id="update_password_password"
                   class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm"
                   autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span></label>
            <input type="password" name="password_confirmation" id="update_password_password_confirmation"
                   class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm"
                   autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md transition-colors">
            Simpan Kata Sandi
        </button>

        @if (session('status') === 'password-updated')
            <p class="text-sm text-green-600">
                Tersimpan.
            </p>
        @endif
    </div>
</form>
