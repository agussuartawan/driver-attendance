@props([
    'columns' => [],
    'data' => [],
    'searchable' => true,
    'searchPlaceholder' => 'Cari...',
    'tableId' => 'dataTable',
    'noResultsMessage' => 'Tidak ada hasil yang ditemukan.',
    'actions' => [],
    'button' => [],
])

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <!-- Search Bar -->
    <div class="grid grid-cols-2 items-center justify-between items-center">
        @if(!empty($button))
            <div class="p-6 border-b border-gray-200">
                @foreach($button as $btn)
                    <a href="{{ $btn['url'] }}" class="inline-flex items-center px-4 py-2 text-xs font-medium text-white {{ $btn['class'] ?? 'bg-blue-600 hover:bg-blue-700' }} rounded-md transition-colors">
                        {{ $btn['label'] }}
                    </a>
                @endforeach
            </div>
        @endif
        @if($searchable)
            <form action="{{ route('employee') }}" method="get" class="w-full p-6 border-b border-gray-200">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input
                        value="{{ request()->get('search') }}"
                        name="search"
                        type="text"
                        id="searchInput-{{ $tableId }}"
                        class="w-full pl-10 px-4 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        placeholder="{{ $searchPlaceholder }}"
                    >
                </div>
            </form>
        @endif
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full" id="{{ $tableId }}">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    @foreach($columns as $column)
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">
                            {{ $column['label'] }}
                        </th>
                    @endforeach
                    @if(!empty($actions))
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody id="tableBody-{{ $tableId }}" class="divide-y divide-gray-100">
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50 transition-colors">
                        @foreach($columns as $column)
                            <td class="px-6 py-4 text-xs {{ $column['class'] ?? 'text-gray-600' }}">
                                @if(isset($column['type']) && $column['type'] === 'status')
                                    <span class="inline-flex px-3 py-1 text-xs font-medium {{ $row[$column['key']]['class'] ?? 'bg-gray-100 text-gray-800' }} rounded-full">
                                        {{ $row[$column['key']]['text'] ?? $row[$column['key']] }}
                                    </span>
                                @elseif(isset($column['type']) && $column['type'] === 'date')
                                    {{ \Carbon\Carbon::parse($row[$column['key']])->format($column['format'] ?? 'd M Y') }}
                                @else
                                    {{ $row[$column['key']] }}
                                @endif
                            </td>
                        @endforeach
                        @if(!empty($actions))
                            <td class="px-6 py-4">
                                @foreach($actions as $action)
                                    @php
                                        // Handle closure functions for label, class, and confirm
                                        $label = is_callable($action['label']) ? $action['label']($row) : $action['label'];
                                        $class = is_callable($action['class'] ?? null) ? $action['class']($row) : ($action['class'] ?? 'bg-blue-600 hover:bg-blue-700');
                                        $confirm = is_callable($action['confirm'] ?? null) ? $action['confirm']($row) : ($action['confirm'] ?? null);
                                    @endphp

                                    @if(isset($action['type']) && $action['type'] === 'link')
                                        {{-- Link Action --}}
                                        <a href="{{ $action['url']($row) }}"
                                           class="inline-flex items-center px-3 py-1 text-xs font-medium text-white {{ $class }} rounded-md hover:opacity-80 transition-colors {{ $loop->last ? '' : 'mr-2' }}">
                                            {{ $label }}
                                        </a>
                                    @elseif(isset($action['type']) && $action['type'] === 'button')
                                        {{-- Button Click Action --}}
                                        <button
                                            type="button"
                                            onclick="{{ $action['onclick']($row) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-white {{ $class }} rounded-md hover:opacity-80 transition-colors {{ $loop->last ? '' : 'mr-2' }}">
                                            {{ $label }}
                                        </button>
                                    @elseif(isset($action['type']) && $action['type'] === 'form')
                                        {{-- Form Submit Action --}}
                                        <form action="{{ $action['action']($row) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method($action['method'] ?? 'POST')
                                            @if(isset($action['fields']))
                                                @foreach($action['fields']($row) as $name => $value)
                                                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                                @endforeach
                                            @endif
                                            <button
                                                type="submit"
                                                @if($confirm) onclick="return confirm('{{ $confirm }}')" @endif
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-white {{ $class }} rounded-md hover:opacity-80 transition-colors {{ $loop->last ? '' : 'mr-2' }}">
                                                {{ $label }}
                                            </button>
                                        </form>
                                    @else
                                        {{-- Default Link Action (Backward Compatibility) --}}
                                        <a href="{{ $action['url']($row) }}"
                                           class="inline-flex items-center px-3 py-1 text-xs font-medium text-white {{ $class }} rounded-md hover:opacity-80 transition-colors {{ $loop->last ? '' : 'mr-2' }}">
                                            {{ $label }}
                                        </a>
                                    @endif
                                @endforeach
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}" class="px-6 py-4 text-center text-gray-500">
                            {{ $noResultsMessage }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination with Tailwind CSS --}}
    @if(method_exists($data, 'links'))
        <div class="px-6 py-4">
            {{ $data->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
