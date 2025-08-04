@props(['href' => '#', 'active' => false])

<a href="{{ $href }}" class="sidebar-item {{ $active ? 'active' : '' }}">
    <div class="flex items-center gap-3">
        {{ $slot }}
    </div>
</a>
