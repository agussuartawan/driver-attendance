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
    <div class="grid grid-cols-2 items-center">
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
            <form action="{{ route('employee') }}" method="get" class="p-6 border-b border-gray-200 flex justify-end">
                <input
                    value="{{ request()->get('search') }}"
                    name="search"
                    type="text"
                    id="searchInput-{{ $tableId }}"
                    class="w-full max-w-md px-4 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="{{ $searchPlaceholder }}"
                >
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
                @foreach($data as $row)
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
                                    <a href="{{ $action['url']($row) }}"
                                       class="inline-flex items-center px-3 py-1 text-xs font-medium text-white {{ $action['class'] }} rounded-md hover:opacity-80 transition-colors {{ $loop->last ? '' : 'mr-2' }}">
                                        {{ $action['label'] }}
                                    </a>
                                @endforeach
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- No Results Message -->
        <div id="noResults-{{ $tableId }}" class="text-center py-8 text-gray-500" style="display: none;">
            <p>{{ $noResultsMessage }}</p>
        </div>
    </div>
</div>

@if($searchable)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput-{{ $tableId }}');
        const tableBody = document.getElementById('tableBody-{{ $tableId }}');
        const rows = tableBody.getElementsByTagName('tr');
        const noResults = document.getElementById('noResults-{{ $tableId }}');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let hasResults = false;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let rowVisible = false;

                // Search in all columns except the last one (actions column)
                const searchableCells = !empty($actions) ? cells.length - 1 : cells.length;
                for (let j = 0; j < searchableCells; j++) {
                    const cellText = cells[j].textContent.toLowerCase();
                    if (cellText.includes(searchTerm)) {
                        rowVisible = true;
                        break;
                    }
                }

                if (rowVisible) {
                    row.style.display = '';
                    hasResults = true;
                } else {
                    row.style.display = 'none';
                }
            }

            // Show/hide no results message
            if (hasResults) {
                noResults.style.display = 'none';
            } else {
                noResults.style.display = 'block';
            }
        });
    });
</script>
@endif
