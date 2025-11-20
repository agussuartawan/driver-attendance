<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Senyum</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-amber-50">
    <x-alert-container />

    <!-- Notification Toast Container -->
    <div id="notificationToastContainer" class="fixed top-4 right-4 z-50 space-y-2 max-w-sm w-full"></div>

    <div class="min-h-screen flex flex-col">
        <!-- Top Header Bar -->
        <header class="bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-5 flex items-center justify-between shadow-lg relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 20px 20px;"></div>
            </div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="text-xl font-semibold">
                    Hallo, {{ auth()->user()->name }} !
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <div class="text-sm text-green-100">
                    Selamat datang kembali
                </div>
            </div>

            <div class="relative z-10 flex items-center gap-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-sm border border-white/20 px-4 py-2 hover:bg-white/10 rounded-xl transition-all duration-200 group">
                    <x-icons.heroicon name="logout" class="group-hover:scale-110 transition-transform text-white" />
                    Logout
                    </button>
                </form>

                <div class="flex items-center gap-0">
                    <button onclick="openSearchModal()" class="p-3 hover:bg-white/10 rounded-xl transition-all duration-200 group">
                        <x-icons.heroicon name="magnifying-glass" class="group-hover:scale-110 transition-transform" />
                    </button>
                    <div class="relative" id="notificationDropdown">
                        <button onclick="toggleNotificationDropdown()" class="p-3 hover:bg-white/10 rounded-xl transition-all duration-200 group relative">
                            <x-icons.heroicon name="bell" class="group-hover:scale-110 transition-transform" />
                            <span id="notificationBadge" class="absolute -top-1 -right-1 w-3 h-3 bg-red-400 rounded-full border-2 border-white hidden"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notificationDropdownMenu"
                             class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 z-50 max-h-[600px] overflow-hidden flex flex-col hidden">
                            <!-- Dropdown Header -->
                            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg">Notifikasi</h3>
                                    <p class="text-green-100 text-xs">Pemberitahuan terbaru</p>
                                </div>
                                <button onclick="markAllAsRead()" class="text-xs text-green-100 hover:text-white underline">
                                    Tandai semua dibaca
                                </button>
                            </div>

                            <!-- Notifications List -->
                            <div id="notificationsList" class="overflow-y-auto flex-1">
                                <div class="p-4 text-center text-gray-500">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600 mx-auto"></div>
                                    <p class="mt-2 text-sm">Memuat notifikasi...</p>
                                </div>
                            </div>

                            <!-- Dropdown Footer -->
                            <div class="border-t border-gray-200 p-3 bg-gray-50 text-center">
                                <a href="{{ route('dashboard') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ auth()->user()->name[0] }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-semibold text-sm">{{ auth()->user()->name }}</span>
                        <span class="text-xs text-green-100">{{ auth()->user()->getRoleNames()->first() }}</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Left Sidebar -->
            <aside class="w-80 bg-white shadow-xl relative">
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <x-icons.heroicon name="chart-bar" class="text-green-600" />
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900">Senyum Dashboard</h2>
                            <p class="text-xs text-gray-500">Management System</p>
                        </div>
                    </div>
                </div>

                <nav class="p-4">
                    <!-- Dashboard Section -->
                    <div class="mb-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-6 py-4 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ request()->routeIs('dashboard') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                            <x-icons.heroicon name="pie" />
                            <span class="font-medium">DASHBOARD</span>
                        </a>
                    </div>

                    <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mb-4"></div>

                    <!-- Features Section -->
                    <div class="mb-4">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-6">FEATURES</div>
                    </div>

                    <div class="space-y-2">
                        @role('admin')
                            <a href="{{ route('employee') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ str_contains(request()->route()->getName(), 'employee') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                                <x-icons.heroicon name="users" />
                                <span class="font-medium">DATA KARYAWAN</span>
                            </a>
                        @endrole

                        @role('admin')
                            <a href="{{ route('schedule') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ str_contains(request()->route()->getName(), 'schedule') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                                <x-icons.heroicon name="calendar" />
                                <span class="font-medium">JADWAL TAMU</span>
                            </a>
                        @endrole

                        @role('admin')
                            <a href="{{ route('receipt') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ str_contains(request()->route()->getName(), 'receipt') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                                <x-icons.heroicon name="document" />
                                <span class="font-medium">NOTA BIAYA</span>
                            </a>
                        @endrole

                        @role('admin|manager')
                            <a href="{{ route('report.attendance') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ str_contains(request()->route()->getName(), 'report.attendance') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                                <x-icons.heroicon name="folder" />
                                <span class="font-medium">LAPORAN ABSENSI</span>
                            </a>
                        @endrole
                    </div>

                    <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent my-4"></div>

                    <!-- Account Section -->
                    <div class="mb-4">
                        <div class="text-xs font-semibold text-gray-500 tracking-wider px-6">Akun</div>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('dashboard.profile') }}" class="flex items-center gap-4 px-6 py-2 text-green-600 hover:bg-green-50 hover:text-green-700 hover:shadow-lg hover:scale-105 hover:translate-x-1 transition-all duration-300 ease-in-out rounded-xl mx-2 {{ request()->routeIs('dashboard.profile') ? 'bg-green-100 text-green-700 font-medium shadow-sm' : '' }}">
                            <x-icons.heroicon name="user" />
                            <span class="font-medium">Profil</span>
                        </a>
                    </div>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 p-8 bg-gradient-to-br from-amber-50 to-green-50">
                <div class="mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Search Modal -->
    <div id="searchModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">Pencarian</h2>
                    <p class="text-green-100 text-sm mt-1">Cari data di seluruh sistem</p>
                </div>
                <button onclick="closeSearchModal()" class="p-2 hover:bg-white/10 rounded-lg transition-all">
                    <x-icons.heroicon name="x-mark" class="w-6 h-6" />
                </button>
            </div>

            <!-- Search Form -->
            <div class="p-6 border-b border-gray-200">
                <form action="{{ route('search') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text"
                               name="q"
                               id="searchQuery"
                               value="{{ request('q') }}"
                               placeholder="Masukkan kata kunci pencarian..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                               autofocus>
                    </div>
                    <div class="w-48">
                        <select name="type"
                                id="searchType"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="users" {{ request('type') === 'users' ? 'selected' : '' }}>Karyawan</option>
                            <option value="schedules" {{ request('type') === 'schedules' ? 'selected' : '' }}>Jadwal</option>
                            <option value="receipts" {{ request('type') === 'receipts' ? 'selected' : '' }}>Nota Biaya</option>
                            <option value="attendances" {{ request('type') === 'attendances' ? 'selected' : '' }}>Absensi</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-lg">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Quick Search Tips -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-start gap-2 text-sm text-gray-600">
                    <x-icons.heroicon name="information-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                    <div>
                        <p class="font-medium text-gray-700 mb-1">Tips Pencarian:</p>
                        <ul class="text-xs space-y-1 text-gray-600">
                            <li>• Cari berdasarkan nama, email, nomor telepon, atau kendaraan untuk Karyawan</li>
                            <li>• Cari berdasarkan nama customer, lokasi, atau kategori untuk Jadwal</li>
                            <li>• Cari berdasarkan kategori atau nama karyawan untuk Nota Biaya</li>
                            <li>• Cari berdasarkan lokasi, tipe, atau nama karyawan untuk Absensi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openSearchModal() {
            document.getElementById('searchModal').classList.remove('hidden');
            document.getElementById('searchModal').classList.add('flex');
            document.getElementById('searchQuery').focus();
            document.body.style.overflow = 'hidden';
        }

        function closeSearchModal() {
            document.getElementById('searchModal').classList.add('hidden');
            document.getElementById('searchModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearchModal();
            }
        });

        // Close modal on backdrop click
        document.getElementById('searchModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSearchModal();
            }
        });

        // Notification functions
        let notifications = [];
        let unreadCount = 0;
        let lastNotificationIds = new Set();

        function loadNotifications(showNewToasts = false) {
            fetch('{{ route("notifications.index") }}')
                .then(response => response.json())
                .then(data => {
                    const newNotifications = data.notifications;
                    const newUnreadCount = data.unread_count;

                    // Check for new notifications if showNewToasts is true
                    if (showNewToasts && notifications.length > 0) {
                        newNotifications.forEach(notif => {
                            if (!lastNotificationIds.has(notif.id) && !notif.read) {
                                showNotificationToast(notif);
                            }
                        });
                    }

                    // Update last known notification IDs
                    lastNotificationIds = new Set(newNotifications.map(n => n.id));

                    notifications = newNotifications;
                    unreadCount = newUnreadCount;
                    updateNotificationBadge();
                    renderNotifications();
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }

        function updateNotificationBadge() {
            const badge = document.getElementById('notificationBadge');
            if (unreadCount > 0) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        function renderNotifications() {
            const container = document.getElementById('notificationsList');

            if (notifications.length === 0) {
                container.innerHTML = `
                    <div class="p-8 text-center text-gray-500">
                        <x-icons.heroicon name="bell" class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                        <p class="text-sm">Tidak ada notifikasi</p>
                    </div>
                `;
                return;
            }

            const colorClasses = {
                blue: 'bg-blue-100 text-blue-800',
                yellow: 'bg-yellow-100 text-yellow-800',
                orange: 'bg-orange-100 text-orange-800',
                red: 'bg-red-100 text-red-800',
                green: 'bg-green-100 text-green-800',
            };

            container.innerHTML = notifications.map(notif => `
                <a href="${notif.url}"
                   onclick="markAsRead(${notif.id}); return true;"
                   class="block p-4 border-b border-gray-100 hover:bg-gray-50 transition-all ${notif.read ? 'opacity-60' : 'bg-green-50/30'}"
                   data-type="${notif.type}"
                   data-id="${notif.id}">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 ${colorClasses[notif.color] || colorClasses.blue} rounded-lg flex items-center justify-center">
                                <x-icons.heroicon name="${notif.icon}" class="w-5 h-5" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">${notif.title}</p>
                                    <p class="text-sm text-gray-600 mt-1">${notif.message}</p>
                                    <p class="text-xs text-gray-500 mt-1">${notif.time}</p>
                                </div>
                                ${!notif.read ? '<div class="w-2 h-2 bg-green-600 rounded-full flex-shrink-0 mt-2"></div>' : ''}
                            </div>
                        </div>
                    </div>
                </a>
            `).join('');
        }

        function getIconSVG(iconName, className = 'w-6 h-6') {
            const icons = {
                'calendar': `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="${className}"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3a.75.75 0 011.5 0v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" /></svg>`,
                'currency-dollar': `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="${className}"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" /><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" /></svg>`,
                'bell': `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="${className}"><path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" /></svg>`,
            };
            return icons[iconName] || icons['bell'];
        }

        function showNotificationToast(notification) {
            const container = document.getElementById('notificationToastContainer');
            const toastId = 'toast-' + Date.now();

            const colorClasses = {
                blue: 'bg-blue-50 border-blue-200 text-blue-800',
                yellow: 'bg-yellow-50 border-yellow-200 text-yellow-800',
                orange: 'bg-orange-50 border-orange-200 text-orange-800',
                red: 'bg-red-50 border-red-200 text-red-800',
                green: 'bg-green-50 border-green-200 text-green-800',
            };

            const iconColors = {
                blue: 'text-blue-400',
                yellow: 'text-yellow-400',
                orange: 'text-orange-400',
                red: 'text-red-400',
                green: 'text-green-400',
            };

            const toast = document.createElement('div');
            toast.id = toastId;
            const clickableClass = notification.url ? 'cursor-pointer hover:shadow-xl' : '';
            toast.className = `bg-white rounded-xl shadow-2xl border-2 ${colorClasses[notification.color] || colorClasses.blue} p-4 transform transition-all duration-300 translate-x-full ${clickableClass}`;

            if (notification.url) {
                toast.addEventListener('click', function(e) {
                    if (!e.target.closest('button')) {
                        window.location.href = notification.url;
                        closeNotificationToast(toastId);
                    }
                });
            }

            toast.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 ${iconColors[notification.color] || iconColors.blue}">
                        ${getIconSVG(notification.icon, 'w-6 h-6')}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900">${notification.title}</p>
                        <p class="text-sm text-gray-700 mt-1">${notification.message}</p>
                    </div>
                    <button onclick="event.stopPropagation(); closeNotificationToast('${toastId}')" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;

            container.appendChild(toast);

            // Trigger animation
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 10);

            // Auto close after 5 seconds
            setTimeout(() => {
                closeNotificationToast(toastId);
            }, 5000);
        }

        function closeNotificationToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        function markAsRead(id) {
            fetch('{{ route("notifications.mark-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notification = notifications.find(n => n.id === id);
                    if (notification) {
                        notification.read = true;
                        unreadCount = Math.max(0, unreadCount - 1);
                        updateNotificationBadge();
                        renderNotifications();
                    }
                }
            });
        }

        function markAllAsRead() {
            fetch('{{ route("notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notifications.forEach(notif => notif.read = true);
                    unreadCount = 0;
                    updateNotificationBadge();
                    renderNotifications();
                }
            });
        }

        // Notification dropdown functions
        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notificationDropdownMenu');
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                loadNotifications();
            } else {
                dropdown.classList.add('hidden');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notificationDropdown');
            const button = dropdown.querySelector('button');
            const menu = document.getElementById('notificationDropdownMenu');

            if (!dropdown.contains(event.target) && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });

        // Load notifications on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initial load without showing toasts
            loadNotifications(false);

            // Wait a bit then start polling with toast notifications
            setTimeout(() => {
                // Fallback: Polling untuk update notifikasi
                // Refresh notifications setiap 10 detik
                setInterval(function() {
                    loadNotifications(true); // Show toasts for new notifications
                }, 10000); // Poll every 10 seconds
            }, 2000); // Wait 2 seconds after initial load

            let websocketConnected = false;

            // Listen for real-time notifications via WebSocket
            if (window.Echo) {
                try {
                    const channel = window.Echo.channel('notifications');

                    channel.listen('.notification.created', (e) => {
                        console.log('Notification received via WebSocket:', e);
                        websocketConnected = true;

                        // Show custom toast notification
                        if (e.notification) {
                            showNotificationToast(e.notification);
                        }

                        // Reload notifications from server to get all notifications for current user
                        loadNotifications(false);
                    });

                    // Log connection status
                    if (window.Echo.connector && window.Echo.connector.pusher) {
                        window.Echo.connector.pusher.connection.bind('connected', function() {
                            console.log('Pusher connected');
                            websocketConnected = true;
                        });

                        window.Echo.connector.pusher.connection.bind('disconnected', function() {
                            console.log('Pusher disconnected');
                            websocketConnected = false;
                        });

                        window.Echo.connector.pusher.connection.bind('error', function(err) {
                            console.error('Pusher error:', err);
                            websocketConnected = false;
                        });
                    }

                    console.log('Listening to notifications channel');
                } catch (error) {
                    console.error('Error setting up Echo listener:', error);
                    websocketConnected = false;
                }
            } else {
                console.warn('Echo not available. Using polling fallback.');
                websocketConnected = false;
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
