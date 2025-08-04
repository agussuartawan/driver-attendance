@props(['value', 'label', 'icon' => null])

<div class="bg-white rounded-lg shadow-sm p-6">
    @if($icon)
        <div class="flex items-center justify-between mb-2">
            <div class="text-3xl font-bold text-green-600">{{ $value }}</div>
            <div class="text-green-500">
                {!! $icon !!}
            </div>
        </div>
    @else
        <div class="text-3xl font-bold text-green-600">{{ $value }}</div>
    @endif
    <div class="text-gray-600 font-medium">{{ $label }}</div>
</div>
