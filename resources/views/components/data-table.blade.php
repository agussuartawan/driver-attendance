@props([
    'columns' => [],
    'data' => [],
    'searchable' => true,
    'searchPlaceholder' => 'Cari...',
    'tableId' => 'dataTable',
    'noResultsMessage' => 'Tidak ada hasil yang ditemukan.',
    'actions' => [],
    'button' => [],
    'dateRange' => false,
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
            <form action="{{ request()->url() }}" method="get" class="w-full p-6 border-b border-gray-200">
                <div class="flex gap-3">
                    @if($searchable)
                        <div class="relative flex-1">
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
                    @endif

                    @if($dateRange)
                        <div class="relative">
                            <button
                                type="button"
                                id="dateRangeBtn-{{ $tableId }}"
                                class="inline-flex items-center px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                            >
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                <span id="dateRangeText-{{ $tableId }}">
                                    @if(request()->get('start_date') && request()->get('end_date'))
                                        {{ \Carbon\Carbon::parse(request()->get('start_date'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request()->get('end_date'))->format('d M Y') }}
                                    @else
                                        Pilih Tanggal
                                    @endif
                                </span>
                            </button>

                            <!-- Date Range Picker Modal -->
                            <div id="dateRangeModal-{{ $tableId }}" class="hidden w-80 bg-white border border-gray-200 rounded-lg shadow-lg">
                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-sm font-medium text-gray-900">Pilih Rentang Tanggal</h3>
                                        <button type="button" id="closeDateRange-{{ $tableId }}" class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label for="startDate-{{ $tableId }}" class="block text-xs font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                            <input
                                                type="date"
                                                id="startDate-{{ $tableId }}"
                                                name="start_date"
                                                value="{{ request()->get('start_date') }}"
                                                class="w-full px-3 py-2 text-xs border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                            >
                                        </div>

                                        <div>
                                            <label for="endDate-{{ $tableId }}" class="block text-xs font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                                            <input
                                                type="date"
                                                id="endDate-{{ $tableId }}"
                                                name="end_date"
                                                value="{{ request()->get('end_date') }}"
                                                class="w-full px-3 py-2 text-xs border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                            >
                                        </div>

                                        <div class="flex gap-2 pt-2">
                                            <button
                                                type="button"
                                                id="applyDateRange-{{ $tableId }}"
                                                class="flex-1 px-3 py-2 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-md transition-colors"
                                            >
                                                Terapkan
                                            </button>
                                            <button
                                                type="button"
                                                id="clearDateRange-{{ $tableId }}"
                                                class="flex-1 px-3 py-2 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors"
                                            >
                                                Bersihkan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
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
                                @elseif(isset($column['type']) && $column['type'] === 'html')
                                    {!! $row[$column['key']] !!}
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

@if($dateRange)
<style>
.date-range-modal {
    position: fixed !important;
    z-index: 9999 !important;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableId = '{{ $tableId }}';
    const dateRangeBtn = document.getElementById(`dateRangeBtn-${tableId}`);
    const dateRangeModal = document.getElementById(`dateRangeModal-${tableId}`);
    const closeDateRange = document.getElementById(`closeDateRange-${tableId}`);
    const applyDateRange = document.getElementById(`applyDateRange-${tableId}`);
    const clearDateRange = document.getElementById(`clearDateRange-${tableId}`);
    const startDateInput = document.getElementById(`startDate-${tableId}`);
    const endDateInput = document.getElementById(`endDate-${tableId}`);
    const dateRangeText = document.getElementById(`dateRangeText-${tableId}`);
    const searchForm = dateRangeBtn.closest('form');

    // Toggle date range modal
    dateRangeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const isHidden = dateRangeModal.classList.contains('hidden');

        if (isHidden) {
            // Show modal
            dateRangeModal.classList.remove('hidden');
            dateRangeModal.classList.add('date-range-modal');

            // Position the modal relative to the button
            const buttonRect = dateRangeBtn.getBoundingClientRect();
            const modalWidth = 320; // w-80 = 320px

            // Calculate position
            let left = buttonRect.right - modalWidth;
            let top = buttonRect.bottom + 8;

            // Ensure modal doesn't go off-screen to the left
            if (left < 8) {
                left = 8;
            }

            // Check if modal would be cut off at the bottom
            const viewportHeight = window.innerHeight;
            const modalHeight = 280; // Approximate height
            const spaceBelow = viewportHeight - top;

            if (spaceBelow < modalHeight + 20) {
                // Position modal above the button instead
                top = buttonRect.top - modalHeight - 8;
            }

            // Apply positioning
            dateRangeModal.style.position = 'fixed';
            dateRangeModal.style.left = left + 'px';
            dateRangeModal.style.top = top + 'px';
            dateRangeModal.style.right = 'auto';
            dateRangeModal.style.bottom = 'auto';
            dateRangeModal.style.margin = '0';
        } else {
            // Hide modal
            dateRangeModal.classList.add('hidden');
        }
    });

    // Close modal when clicking close button
    closeDateRange.addEventListener('click', function() {
        dateRangeModal.classList.add('hidden');
        dateRangeModal.classList.remove('date-range-modal');
        dateRangeModal.style.position = '';
        dateRangeModal.style.left = '';
        dateRangeModal.style.top = '';
        dateRangeModal.style.right = '';
        dateRangeModal.style.bottom = '';
        dateRangeModal.style.margin = '';
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (!dateRangeModal.contains(e.target) && !dateRangeBtn.contains(e.target)) {
            dateRangeModal.classList.add('hidden');
            dateRangeModal.classList.remove('date-range-modal');
            dateRangeModal.style.position = '';
            dateRangeModal.style.left = '';
            dateRangeModal.style.top = '';
            dateRangeModal.style.right = '';
            dateRangeModal.style.bottom = '';
            dateRangeModal.style.margin = '';
        }
    });

    // Apply date range filter
    applyDateRange.addEventListener('click', function() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        if (startDate && endDate) {
            // Update the form with date parameters
            const startDateHidden = document.createElement('input');
            startDateHidden.type = 'hidden';
            startDateHidden.name = 'start_date';
            startDateHidden.value = startDate;

            const endDateHidden = document.createElement('input');
            endDateHidden.type = 'hidden';
            endDateHidden.name = 'end_date';
            endDateHidden.value = endDate;

            // Remove existing date inputs if any
            const existingStartDate = searchForm.querySelector('input[name="start_date"]');
            const existingEndDate = searchForm.querySelector('input[name="end_date"]');
            if (existingStartDate) existingStartDate.remove();
            if (existingEndDate) existingEndDate.remove();

            // Add new date inputs
            searchForm.appendChild(startDateHidden);
            searchForm.appendChild(endDateHidden);

            // Update button text
            const startDateFormatted = new Date(startDate).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            const endDateFormatted = new Date(endDate).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            dateRangeText.textContent = `${startDateFormatted} - ${endDateFormatted}`;

            // Submit the form
            searchForm.submit();
        } else {
            alert('Silakan pilih tanggal mulai dan tanggal akhir');
        }

        // Reset modal positioning
        dateRangeModal.classList.add('hidden');
        dateRangeModal.classList.remove('date-range-modal');
        dateRangeModal.style.position = '';
        dateRangeModal.style.left = '';
        dateRangeModal.style.top = '';
        dateRangeModal.style.right = '';
        dateRangeModal.style.bottom = '';
        dateRangeModal.style.margin = '';
    });

    // Clear date range filter
    clearDateRange.addEventListener('click', function() {
        startDateInput.value = '';
        endDateInput.value = '';
        dateRangeText.textContent = 'Pilih Tanggal';

        // Remove date parameters from URL and reload
        const url = new URL(window.location);
        url.searchParams.delete('start_date');
        url.searchParams.delete('end_date');
        window.location.href = url.toString();

        // Reset modal positioning
        dateRangeModal.classList.add('hidden');
        dateRangeModal.classList.remove('date-range-modal');
        dateRangeModal.style.position = '';
        dateRangeModal.style.left = '';
        dateRangeModal.style.top = '';
        dateRangeModal.style.right = '';
        dateRangeModal.style.bottom = '';
        dateRangeModal.style.margin = '';
    });
});
</script>
@endif
