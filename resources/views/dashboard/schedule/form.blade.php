@extends('layouts.dashboard')

@section('title', $schedule ? 'Edit Jadwal Tamu' : 'Tambah Jadwal Tamu')

@section('content')
    <!-- Page Title -->
    <div class="flex justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $schedule ? 'Edit Jadwal Tamu' : 'Tambah Jadwal Tamu' }}</h1>
            <p class="text-gray-600 mt-1">Tambahkan atau edit jadwal perjalanan tamu</p>
        </div>
        <a href="{{ route('schedule') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors" title="Kembali">
            <x-icons.heroicon name="arrow-left" class="w-4 h-4 mr-2" /> Kembali
        </a>
     </div>

    <div class="flex bg-white p-6 rounded-lg shadow-md">
        <form action="{{ $schedule ? route('schedule.update', ['schedule' => $schedule]) : route('schedule.store') }}" class="w-full grid grid-cols-1 gap-6" method="post">
            @csrf
            @method($schedule ? 'PATCH' : 'POST')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama Tamu <span class="text-red-500">*</span></label>
                    <input type="text" value="{{ $schedule ? $schedule->customer_name : old('customer_name') }}" name="customer_name" id="customer_name" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                    <span class="text-red-500">{{ $errors->first('customer_name') }}</span>
                </div>
                <div class="col-span-1">
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700">No Telepon Tamu <span class="text-red-500">*</span></label>
                    <input type="text" value="{{ $schedule ? $schedule->customer_phone : old('customer_phone') }}" name="customer_phone" id="customer_phone" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                    <span class="text-red-500">{{ $errors->first('customer_phone') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="datetime-local" value="{{ $schedule ? $schedule->start_date : old('start_date') }}" name="start_date" id="start_date" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                </div>
                <div class="col-span-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="datetime-local" value="{{ $schedule ? $schedule->end_date : old('end_date') }}" name="end_date" id="end_date" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                </div>
            </div>

            <div class="col-span-1">
                <label for="driver_id" class="block text-sm font-medium text-gray-700">Driver <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select name="driver_id" id="driver_id" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                        <option value="">Pilih Driver</option>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id ?? old('driver_id') }}" {{ $schedule && $schedule->driver_id == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Location Picker Section -->
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-gray-100 rounded-md grid grid-cols-1 gap-4">
                    <label for="start_location" class="block text-sm font-medium text-gray-700">Lokasi Penjemputan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" value="{{ $schedule ? $schedule->start_location : old('start_location') }}" name="start_location" id="start_location" placeholder="Masukkan alamat atau klik pada peta" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                        <div id="start-search-results" class="absolute z-[9999] w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
                    </div>

                    <div class="col-span-1">
                        <div id="start_map" class="w-full h-64 rounded-md border border-gray-300"></div>
                    </div>

                    <div class="col-span-1 hidden">
                        <input type="text" value="{{ $schedule ? $schedule->start_latitude : old('start_latitude') }}" name="start_latitude" id="start_latitude" readonly class="mt-1 block w-full p-2 rounded-md border border-gray-300 bg-gray-50 shadow-sm sm:text-sm">
                        <input type="text" value="{{ $schedule ? $schedule->start_longitude : old('start_longitude') }}" name="start_longitude" id="start_longitude" readonly class="mt-1 block w-full p-2 rounded-md border border-gray-300 bg-gray-50 shadow-sm sm:text-sm">
                    </div>
                </div>

                <div class="p-4 bg-gray-100 rounded-md grid grid-cols-1 gap-4">
                    <label for="end_location" class="block text-sm font-medium text-gray-700">Lokasi Pengantaran <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" value="{{ $schedule ? $schedule->end_location : old('end_location') }}" name="end_location" id="end_location" placeholder="Masukkan alamat atau klik pada peta" class="mt-1 block w-full p-2 rounded-md border border-gray-300 shadow-sm focus:outline-green-500 sm:text-sm" required>
                        <div id="end-search-results" class="absolute z-[9999] w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
                    </div>

                    <div class="col-span-1">
                        <div id="end_map" class="w-full h-64 rounded-md border border-gray-300"></div>
                    </div>

                    <div class="col-span-1 hidden">
                        <input type="text" value="{{ $schedule ? $schedule->end_latitude : old('end_latitude') }}" name="end_latitude" id="end_latitude" readonly class="mt-1 block w-full p-2 rounded-md border border-gray-300 bg-gray-50 shadow-sm sm:text-sm">
                        <input type="text" value="{{ $schedule ? $schedule->end_longitude : old('end_longitude') }}" name="end_longitude" id="end_longitude" readonly class="mt-1 block w-full p-2 rounded-md border border-gray-300 bg-gray-50 shadow-sm sm:text-sm">
                    </div>
                </div>
            </div>


            <div class="col-span-1 flex gap-4">
                <a href="{{ route('schedule') }}" class="bg-red-500 text-white px-4 py-2 rounded-md">Batal</a>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Configuration object for map settings
        const MAP_CONFIG = {
            defaultLocation: [-6.2088, 106.8456], // Jakarta, Indonesia
            zoom: 13,
            searchZoom: 15,
            tileLayer: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            attribution: '© OpenStreetMap contributors',
            searchDebounce: 500,
            minSearchLength: 3,
            searchLimit: 8,
            countryCodes: 'id'
        };

        // Map state management
        const MapManager = {
            maps: {},
            markers: {},
            currentActive: 'start',
            searchTimeout: null,

            // Initialize all maps
            init() {
                this.initializeMaps();
                this.setupEventListeners();
                this.setInitialCoordinates();
            },

            // Initialize individual maps
            initializeMaps() {
                const mapConfigs = {
                    start: {
                        elementId: 'start_map',
                        defaultLocation: ['{{ $schedule ? $schedule->start_latitude : -6.2088 }}', '{{ $schedule ? $schedule->start_longitude : 106.8456 }}'],
                        markerId: 'startMarker'
                    },
                    end: {
                        elementId: 'end_map',
                        defaultLocation: ['{{ $schedule ? $schedule->end_latitude : -6.2088 }}', '{{ $schedule ? $schedule->end_longitude : 106.8456 }}'],
                        markerId: 'endMarker'
                    }
                };

                Object.entries(mapConfigs).forEach(([type, config]) => {
                    this.createMap(type, config);
                });
            },

            // Create a single map with marker
            createMap(type, config) {
                const map = L.map(config.elementId).setView(config.defaultLocation, MAP_CONFIG.zoom);

                // Add tile layer
                L.tileLayer(MAP_CONFIG.tileLayer, {
                    attribution: MAP_CONFIG.attribution
                }).addTo(map);

                // Create marker
                const marker = L.marker(config.defaultLocation, {
                    draggable: true,
                    title: "Drag to set location"
                }).addTo(map);

                // Store references
                this.maps[type] = map;
                this.markers[type] = marker;

                // Setup map events
                this.setupMapEvents(type, map, marker);
            },

            // Setup map click and marker drag events
            setupMapEvents(type, map, marker) {
                map.on('click', (e) => {
                    this.currentActive = type;
                    this.placeMarker(e.latlng);
                    this.updateLocationInfo(e.latlng);
                });

                marker.on('dragend', (e) => {
                    this.currentActive = type;
                    const position = e.target.getLatLng();
                    this.updateLocationInfo(position);
                });
            },

            // Setup input event listeners
            setupEventListeners() {
                const inputConfigs = {
                    start: { inputId: 'start_location', resultsId: 'start-search-results' },
                    end: { inputId: 'end_location', resultsId: 'end-search-results' }
                };

                Object.entries(inputConfigs).forEach(([type, config]) => {
                    this.setupInputListener(type, config);
                });

                // Setup global click listener to hide search results
                document.addEventListener('click', (e) => {
                    const isStartInput = e.target.closest('#start_location') || e.target.closest('#start-search-results');
                    const isEndInput = e.target.closest('#end_location') || e.target.closest('#end-search-results');

                    if (!isStartInput && !isEndInput) {
                        this.hideSearchResults();
                    }
                });
            },

            // Setup input listener for search functionality
            setupInputListener(type, config) {
                const input = document.getElementById(config.inputId);
                if (!input) return;

                input.addEventListener('input', (e) => {
                    this.currentActive = type;
                    clearTimeout(this.searchTimeout);
                    const query = e.target.value.trim();

                    if (query.length >= MAP_CONFIG.minSearchLength) {
                        this.searchTimeout = setTimeout(() => {
                            this.searchLocation(query);
                        }, MAP_CONFIG.searchDebounce);
                    } else {
                        this.hideSearchResults();
                    }
                });
            },

            // Set initial coordinate values
            setInitialCoordinates() {
                const coordinateConfigs = {
                    start: {
                        latId: 'start_latitude',
                        lngId: 'start_longitude',
                        defaultLocation: ['{{ $schedule ? $schedule->start_latitude : -6.2088 }}', '{{ $schedule ? $schedule->start_longitude : 106.8456 }}']
                    },
                    end: {
                        latId: 'end_latitude',
                        lngId: 'end_longitude',
                        defaultLocation: ['{{ $schedule ? $schedule->end_latitude : -6.2088 }}', '{{ $schedule ? $schedule->end_longitude : 106.8456 }}']
                    }
                };

                Object.entries(coordinateConfigs).forEach(([type, config]) => {
                    const latElement = document.getElementById(config.latId);
                    const lngElement = document.getElementById(config.lngId);
                    if (latElement && lngElement) {
                        latElement.value = config.defaultLocation[0];
                        lngElement.value = config.defaultLocation[1];
                    }
                });
            },

            // Place marker on current active map
            placeMarker(latLng) {
                const marker = this.markers[this.currentActive];
                const map = this.maps[this.currentActive];

                if (marker && map) {
                    marker.setLatLng(latLng);
                    map.setView(latLng, MAP_CONFIG.searchZoom);
                }
            },

            // Update location information (coordinates and address)
            updateLocationInfo(latLng) {
                const fieldConfigs = {
                    start: {
                        latId: 'start_latitude',
                        lngId: 'start_longitude',
                        locationId: 'start_location'
                    },
                    end: {
                        latId: 'end_latitude',
                        lngId: 'end_longitude',
                        locationId: 'end_location'
                    }
                };

                const config = fieldConfigs[this.currentActive];
                if (!config) return;

                // Update coordinates
                const latElement = document.getElementById(config.latId);
                const lngElement = document.getElementById(config.lngId);
                if (latElement && lngElement) {
                    latElement.value = latLng.lat.toFixed(6);
                    lngElement.value = latLng.lng.toFixed(6);
                }

                // Reverse geocoding
                this.reverseGeocode(latLng, config.locationId);
            },

            // Reverse geocoding using Nominatim
            reverseGeocode(latLng, locationFieldId) {
                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latLng.lat}&lon=${latLng.lng}&zoom=18&addressdetails=1`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            const locationElement = document.getElementById(locationFieldId);
                            if (locationElement) {
                                locationElement.value = data.display_name;
                            }
                        }
                    })
                    .catch(error => {
                        console.log('Geocoding error:', error);
                    });
            },

            // Search for locations
            searchLocation(query) {
                const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=${MAP_CONFIG.searchLimit}&countrycodes=${MAP_CONFIG.countryCodes}&addressdetails=1`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        this.displaySearchResults(data);
                    })
                    .catch(error => {
                        console.log('Search error:', error);
                        this.hideSearchResults();
                    });
            },

            // Display search results
            displaySearchResults(results) {
                const resultsContainer = document.getElementById(`${this.currentActive}-search-results`);
                if (!resultsContainer) return;

                if (results.length === 0) {
                    resultsContainer.innerHTML = '<div class="p-3 text-gray-500 text-sm">Tidak ada hasil ditemukan</div>';
                    resultsContainer.classList.remove('hidden');
                    return;
                }

                const html = results.map(result => {
                    const displayName = result.display_name;
                    const lat = parseFloat(result.lat);
                    const lon = parseFloat(result.lon);

                    return `
                        <div class="search-result-item p-3 hover:bg-gray-100 cursor-pointer border-b border-gray-200 last:border-b-0"
                             data-lat="${lat}" data-lon="${lon}" data-name="${displayName}">
                            <div class="font-medium text-sm">${displayName}</div>
                            <div class="text-xs text-gray-500">Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}</div>
                        </div>
                    `;
                }).join('');

                resultsContainer.innerHTML = html;
                resultsContainer.classList.remove('hidden');

                // Add click handlers
                this.setupSearchResultHandlers(resultsContainer);
            },

            // Setup click handlers for search results
            setupSearchResultHandlers(container) {
                container.querySelectorAll('.search-result-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const lat = parseFloat(item.dataset.lat);
                        const lon = parseFloat(item.dataset.lon);
                        const name = item.dataset.name;

                        const latLng = [lat, lon];
                        this.placeMarker(latLng);
                        this.updateLocationInfo(latLng);

                        const locationFieldId = `${this.currentActive}_location`;
                        const locationElement = document.getElementById(locationFieldId);
                        if (locationElement) {
                            locationElement.value = name;
                        }

                        this.hideSearchResults();
                    });
                });
            },

            // Hide all search results
            hideSearchResults() {
                const containers = ['start-search-results', 'end-search-results'];
                containers.forEach(containerId => {
                    const container = document.getElementById(containerId);
                    if (container) {
                        container.classList.add('hidden');
                    }
                });
            }
        };

        // Initialize when page loads
        window.addEventListener('load', () => MapManager.init());
    </script>
@endsection
