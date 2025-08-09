@if(session('success'))
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-sm px-4">
        <x-alert type="success" message="{{ session('success') }}" :timeout="session()->get('timeout', 3000)" />
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-sm px-4">
        <x-alert type="error" message="{{ session('error') }}" :timeout="session()->get('timeout', 3000)" />
    </div>
@endif
