@props(['value', 'label', 'icon' => null, 'iconName' => null, 'iconClass' => ''])

<div class="bg-white rounded-lg shadow-sm p-6">
    @if($icon || $iconName)
        <div class="flex items-center justify-between mb-2">
            <div class="text-3xl font-bold text-green-600">{{ $value }}</div>
            <div class="text-green-500">
                @if($iconName)
                    <x-icons.heroicon :name="$iconName" />
                @elseif($icon)
                    @if(str_contains($icon, 'x-icons.heroicon'))
                        @php
                            preg_match('/name="([^"]+)"/', $icon, $matches);
                            $iconName = $matches[1] ?? 'question-mark-circle';
                            preg_match('/class="([^"]+)"/', $icon, $matches);
                            $iconClass = $matches[1] ?? '';
                        @endphp
                        <x-icons.heroicon :name="$iconName" />
                    @else
                        {!! $icon !!}
                    @endif
                @endif
            </div>
        </div>
    @else
        <div class="text-3xl font-bold text-green-600">{{ $value }}</div>
    @endif
    <div class="text-gray-600 font-medium">{{ $label }}</div>
</div>
