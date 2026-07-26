<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIBENGKEL') }} - Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: theme('colors.background'); color: theme('colors.on-surface'); }
        h1, h2, h3, h4, h5, h6, .font-sora { font-family: 'Sora', sans-serif; }
        html.theme-transitioning::view-transition-old(root),
        html.theme-transitioning::view-transition-new(root) {
            animation: none;
            mix-blend-mode: normal;
        }
        html.theme-transitioning::view-transition-old(root) { z-index: 1; }
        html.theme-transitioning::view-transition-new(root) { z-index: 2; }
    </style>
    <script>
        // Staff Dashboard defaults to Light Mode
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        function toggleTheme(event) {
            const doToggle = () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            };

            if (!document.startViewTransition || !event) {
                doToggle();
                return;
            }

            let x = window.innerWidth / 2;
            let y = window.innerHeight / 2;
            if (event) {
                if (event.clientX !== undefined && event.clientY !== undefined && (event.clientX !== 0 || event.clientY !== 0)) {
                    x = event.clientX;
                    y = event.clientY;
                } else if (event.touches && event.touches.length > 0) {
                    x = event.touches[0].clientX;
                    y = event.touches[0].clientY;
                } else {
                    const btn = event.currentTarget || (event.target && event.target.closest ? event.target.closest('button') : event.target);
                    if (btn) {
                        const rect = btn.getBoundingClientRect();
                        x = rect.left + rect.width / 2;
                        y = rect.top + rect.height / 2;
                    }
                }
            }
            const w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
            const h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
            const endRadius = Math.hypot(Math.max(x, w - x), Math.max(y, h - y));

            document.documentElement.classList.add('theme-transitioning');
            const transition = document.startViewTransition(doToggle);
            transition.ready.then(() => {
                document.documentElement.animate(
                    {
                        clipPath: [
                            `circle(0px at ${x}px ${y}px)`,
                            `circle(${endRadius}px at ${x}px ${y}px)`
                        ],
                    },
                    {
                        duration: 500,
                        easing: 'ease-in-out',
                        pseudoElement: '::view-transition-new(root)',
                    }
                );
            });
            transition.finished.finally(() => {
                document.documentElement.classList.remove('theme-transitioning');
            });
        }
    </script>
</head>
<body class="bg-background dark:bg-[#0a0a0a] min-h-screen flex text-on-surface dark:text-[#EDEDEC] antialiased transition-colors duration-300" x-data="{ sidebarOpen: window.innerWidth >= 1024, mobileMenuOpen: false }">
    <!-- SideNavBar (Desktop Only) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '!-translate-x-full'" class="hidden lg:flex w-[280px] h-screen fixed left-0 top-0 bg-surface dark:bg-[#111111] border-r border-outline-variant/20 shadow-md flex-col py-6 px-4 gap-2 z-50 transition-all duration-300 ease-in-out">
        <div class="px-4 mb-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="group block hover:opacity-90 transition-opacity">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-8 object-contain brightness-0 dark:invert">
                    <h1 class="text-2xl font-sora font-bold text-primary dark:text-[#EDEDEC]">SIBENGKEL</h1>
                </div>
                <p class="text-sm text-on-surface-variant dark:text-gray-400 mt-1">Workshop Management</p>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-1 flex flex-col gap-1.5 overflow-y-auto pr-2 custom-scrollbar">
            <!-- 1. OPERASI UTAMA -->
            <div class="text-[10px] font-bold tracking-wider text-secondary uppercase px-4 mt-2 mb-1">Utama</div>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined" data-weight="fill" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center justify-between px-4 py-2 {{ request()->routeIs('admin.bookings.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.bookings.index') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.bookings.*') ? 'icon-filled' : '' }}">calendar_month</span>
                    <span>Booking Servis</span>
                </div>
                @php $pendingBookingCount = \App\Models\Booking::where('status', 'menunggu_konfirmasi')->count(); @endphp
                @if($pendingBookingCount > 0)
                    <span class="{{ request()->routeIs('admin.bookings.*') ? 'bg-white text-secondary' : 'bg-secondary text-white' }} text-xs px-2 py-0.5 rounded-full font-bold">{{ $pendingBookingCount }}</span>
                @endif
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('transactions.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('transactions.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('transactions.*') ? 'icon-filled' : '' }}">receipt_long</span>
                <span>Transaksi Servis</span>
            </a>

            <!-- 2. SUKU CADANG & TOKO -->
            <div class="text-[10px] font-bold tracking-wider text-secondary uppercase px-4 mt-4 mb-1">Suku Cadang & Toko</div>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.spareparts.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.spareparts.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.spareparts.*') ? 'icon-filled' : '' }}">inventory_2</span>
                <span>Sparepart</span>
            </a>
            @if(Auth::user()->role === 'admin')
            <a class="flex items-center justify-between px-4 py-2 {{ request()->routeIs('admin.orders.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.orders.index') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.orders.*') ? 'icon-filled' : '' }}">shopping_bag</span>
                    <span>Pesanan Online</span>
                </div>
                @php $pendingOrderCount = \App\Models\Order::where('status', 'menunggu_pembayaran')->count(); @endphp
                @if($pendingOrderCount > 0)
                    <span class="{{ request()->routeIs('admin.orders.*') ? 'bg-white text-secondary' : 'bg-secondary text-white' }} text-xs px-2 py-0.5 rounded-full font-bold">{{ $pendingOrderCount }}</span>
                @endif
            </a>
            @endif

            <!-- 3. RELASI PELANGGAN -->
            <div class="text-[10px] font-bold tracking-wider text-secondary uppercase px-4 mt-4 mb-1">Relasi Pelanggan</div>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('customers.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('customers.index') }}">
                <span class="material-symbols-outlined">person_book</span>
                <span>Pelanggan</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('vehicles.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('vehicles.index') }}">
                <span class="material-symbols-outlined">directions_car</span>
                <span>Kendaraan</span>
            </a>
            @if(Auth::user()->role === 'admin')
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.testimonials.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.testimonials.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.testimonials.*') ? 'icon-filled' : '' }}">reviews</span>
                <span>Ulasan Pelanggan</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.messages.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11 relative" href="{{ route('admin.messages.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.messages.*') ? 'icon-filled' : '' }}">mail</span>
                <span>Pesan Masuk</span>
                @php $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                @if($unreadMessages > 0)
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 {{ request()->routeIs('admin.messages.*') ? 'bg-white text-secondary' : 'bg-secondary text-white' }} text-[10px] px-1.5 py-0.5 rounded-full font-bold">{{ $unreadMessages > 9 ? '9+' : $unreadMessages }}</span>
                @endif
            </a>
            @endif

            @if(Auth::user()->role === 'admin')
            <!-- 4. MANAJEMEN & SISTEM -->
            <div class="text-[10px] font-bold tracking-wider text-secondary uppercase px-4 mt-4 mb-1">Manajemen & Sistem</div>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admins.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admins.index') }}">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span>Admin</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('mechanics.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('mechanics.index') }}">
                <span class="material-symbols-outlined">build</span>
                <span>Mekanik</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('pages.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('pages.index') }}">
                <span class="material-symbols-outlined">description</span>
                <span>Halaman Web</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.settings.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.settings.index') }}">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan</span>
            </a>
            @endif
        </nav>

    </aside>

    <!-- Main Content Area -->
    <main :class="sidebarOpen ? 'lg:ml-[280px]' : 'lg:!ml-0'" class="flex-1 flex flex-col min-w-0 lg:ml-[280px] transition-all duration-300 ease-in-out">
        <!-- TopNavBar (Visible on Mobile & Desktop) -->
        <header class="flex justify-between items-center px-4 lg:px-8 w-full h-16 sticky top-0 z-40 bg-surface dark:bg-[#161615] border-b border-outline-variant dark:border-[#3E3E3A]">
            <div class="flex items-center gap-2">
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex w-10 h-10 rounded-full items-center justify-center text-on-surface-variant dark:text-white hover:bg-surface-container-high dark:hover:bg-white/10 transition-colors mr-1" title="Toggle Sidebar">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <a href="{{ url('/') }}" class="lg:hidden flex items-center gap-2 hover:opacity-90 transition-opacity">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 dark:invert">
                    <h2 class="text-xl font-sora font-bold text-primary dark:text-[#EDEDEC] tracking-tight">SIBENGKEL</h2>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <!-- Theme Toggle -->
                <button onclick="toggleTheme(event)" class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant dark:text-white hover:bg-surface-container-high dark:hover:bg-white/10 transition-colors" title="Toggle Dark Mode">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block text-amber-400">light_mode</span>
                </button>
                <!-- Notification Dropdown -->
                <div x-data="{ notifOpen: false }" class="relative">
                    @php 
                        $unreadCount = Auth::user()->unreadNotifications->count(); 
                        $notifications = Auth::user()->notifications()->take(5)->get();
                    @endphp
                    <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant dark:text-white hover:bg-surface-container-high dark:hover:bg-white/10 transition-colors relative" title="Notifikasi">
                        <span class="material-symbols-outlined">notifications</span>
                        @if($unreadCount > 0)
                            <span class="absolute top-2 right-2 w-4 h-4 rounded-full bg-error text-white text-[9px] font-bold flex items-center justify-center border-2 border-surface">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="notifOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                         class="absolute right-0 mt-2 w-80 sm:w-96 rounded-2xl bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] shadow-2xl overflow-hidden z-50 origin-top-right"
                         style="display: none;">
                        <div class="px-4 py-3 border-b border-outline-variant dark:border-[#3E3E3A] flex justify-between items-center bg-surface-container/30 dark:bg-[#1f1f1d]">
                            <h3 class="font-bold text-on-surface dark:text-[#EDEDEC] text-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary dark:text-amber-400 text-[18px]">notifications</span>
                                Notifikasi
                            </h3>
                            @if($unreadCount > 0)
                                <form action="{{ route('admin.notifications.readAll') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-primary dark:text-amber-400 font-semibold hover:underline">Tandai semua dibaca</button>
                                </form>
                            @endif
                        </div>
                        <div class="max-h-[340px] overflow-y-auto custom-scrollbar divide-y divide-outline-variant/30 dark:divide-[#3E3E3A]">
                            @forelse($notifications as $notif)
                                <div class="p-3.5 hover:bg-surface-container dark:hover:bg-white/5 transition-colors {{ is_null($notif->read_at) ? 'bg-primary/5 dark:bg-primary/10' : '' }}">
                                    <div class="flex justify-between items-start gap-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-on-surface dark:text-[#EDEDEC] leading-tight">{{ $notif->data['title'] ?? 'Pemberitahuan' }}</p>
                                            <p class="text-xs text-on-surface-variant dark:text-gray-400 mt-1 line-clamp-2">{{ $notif->data['message'] ?? '' }}</p>
                                            <p class="text-[10px] text-outline dark:text-gray-500 mt-1.5 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[12px]">schedule</span>
                                                {{ $notif->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if(is_null($notif->read_at))
                                            <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST" class="shrink-0">
                                                @csrf
                                                <button type="submit" class="w-7 h-7 rounded-full hover:bg-primary/20 dark:hover:bg-white/10 flex items-center justify-center text-primary dark:text-amber-400 transition-colors" title="Tandai dibaca">
                                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    @if(isset($notif->data['action_url']))
                                        <a href="{{ $notif->data['action_url'] }}" class="inline-flex items-center gap-1 mt-2.5 text-xs text-primary dark:text-amber-400 font-semibold hover:underline">
                                            <span>Lihat Detail</span>
                                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                        </a>
                                    @endif
                                </div>
                            @empty
                                <div class="p-8 text-center text-sm text-on-surface-variant dark:text-gray-400 flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-outline/50 dark:text-gray-600">notifications_off</span>
                                    <span>Belum ada notifikasi baru.</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div x-data="{ open: false }" class="relative ml-2 border-l border-outline-variant/30 pl-4">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 p-1 rounded-full hover:bg-surface-container dark:hover:bg-[#161615] transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        @if(Auth::user()->profile_photo_url)
                            <img src="{{ Auth::user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover border border-outline-variant/30">
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs border border-outline-variant/30">
                                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                            </div>
                        @endif
                        <span class="hidden md:inline font-medium text-sm text-on-surface dark:text-[#EDEDEC] truncate max-w-[120px]">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <span class="material-symbols-outlined text-[18px] text-on-surface-variant dark:text-gray-400" :class="{'rotate-180': open}">expand_more</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                         class="absolute right-0 mt-2 w-60 rounded-2xl bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] shadow-2xl py-2 z-50 origin-top-right"
                         style="display: none;">
                        
                        <div class="px-4 py-3 border-b border-outline-variant dark:border-[#3E3E3A]">
                            <p class="text-sm font-bold text-on-surface dark:text-[#EDEDEC] truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-on-surface-variant dark:text-gray-400 truncate">{{ Auth::user()->email ?? 'admin@sibengkel.web.id' }}</p>
                        </div>
                        
                        <div class="py-1.5 px-1.5">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-sm rounded-xl text-on-surface dark:text-[#EDEDEC] hover:bg-surface-container dark:hover:bg-white/10 hover:text-primary dark:hover:text-amber-400 transition-all">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                Pengaturan Profil
                            </a>
                        </div>
                        
                        <div class="py-1.5 px-1.5 border-t border-outline-variant dark:border-[#3E3E3A]">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-3 py-2 text-sm rounded-xl text-error w-full text-left hover:bg-error/10 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-4 pb-24 lg:p-8 flex flex-col gap-6">
            {{ $slot }}
        </div>
        <x-toast />
    </main>

    @php
        $pendingCount = \App\Models\Booking::where('status', 'menunggu_konfirmasi')->count();
        $pendingMobileOrders = (Auth::user()->role === 'admin') ? \App\Models\Order::where('status', 'menunggu_pembayaran')->count() : 0;
        $unreadMessages = (Auth::user()->role === 'admin') ? \App\Models\ContactMessage::where('is_read', false)->count() : 0;
        $totalAlerts = $pendingMobileOrders + $unreadMessages;
    @endphp

    <!-- BottomNavBar (Visible only on Mobile - Sleek 4-Tab Core Dock) -->
    <nav class="lg:hidden fixed bottom-0 left-0 w-full z-50 grid grid-cols-4 items-center bg-surface/95 dark:bg-[#161615]/95 backdrop-blur-md px-1 pb-safe h-16 border-t border-outline-variant dark:border-[#3E3E3A] shadow-[0_-4px_12px_rgba(0,0,0,0.1)]">
        <!-- 1. Home -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center py-1 transition-all {{ request()->routeIs('dashboard') ? 'text-secondary font-bold scale-105' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-2xl mb-0.5" {{ request()->routeIs('dashboard') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>home</span>
            <span class="text-[10px] tracking-tight font-medium">Home</span>
        </a>

        <!-- 2. Booking -->
        <a href="{{ route('admin.bookings.index') }}" class="flex flex-col items-center justify-center py-1 transition-all {{ request()->routeIs('admin.bookings.*') ? 'text-secondary font-bold scale-105' : 'text-on-surface-variant hover:text-on-surface' }} relative">
            <span class="material-symbols-outlined text-2xl mb-0.5" {{ request()->routeIs('admin.bookings.*') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>calendar_month</span>
            <span class="text-[10px] tracking-tight font-medium">Booking</span>
            @if($pendingCount > 0)
                <span class="absolute top-0 right-4 bg-secondary text-white text-[9px] font-bold px-1 rounded-full animate-pulse">{{ $pendingCount }}</span>
            @endif
        </a>

        <!-- 3. Transaksi -->
        <a href="{{ route('transactions.index') }}" class="flex flex-col items-center justify-center py-1 transition-all {{ request()->routeIs('transactions.*') ? 'text-secondary font-bold scale-105' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-2xl mb-0.5" {{ request()->routeIs('transactions.*') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>receipt_long</span>
            <span class="text-[10px] tracking-tight font-medium">Transaksi</span>
        </a>

        <!-- 4. Menu / Lainnya -->
        <button @click="mobileMenuOpen = true" type="button" class="flex flex-col items-center justify-center py-1 transition-all text-on-surface-variant hover:text-on-surface active:scale-95 relative">
            <span class="material-symbols-outlined text-2xl mb-0.5">grid_view</span>
            <span class="text-[10px] tracking-tight font-medium">Menu</span>
            @if($totalAlerts > 0)
                <span class="absolute top-0 right-5 w-2 h-2 rounded-full bg-secondary"></span>
            @endif
        </button>
    </nav>

    <!-- Mobile Menu Drawer (Slide-up Sheet for all items) -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="lg:hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-end justify-center" style="display: none;" @click.self="mobileMenuOpen = false" @keydown.escape.window="mobileMenuOpen = false">
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="bg-surface dark:bg-[#161615] w-full max-h-[85vh] rounded-t-3xl border-t border-outline-variant dark:border-[#3E3E3A] shadow-2xl overflow-y-auto flex flex-col pb-safe">
            <!-- Drawer Handle & Header -->
            <div class="sticky top-0 bg-surface dark:bg-[#161615] z-10 px-6 pt-3 pb-4 border-b border-outline-variant/30 flex items-center justify-between">
                <div>
                    <div class="w-10 h-1 bg-outline-variant/40 rounded-full mx-auto mb-3"></div>
                    <h3 class="text-label-lg font-bold font-sora text-on-surface dark:text-white">Semua Menu SIBENGKEL</h3>
                    <p class="text-[11px] text-on-surface-variant">Akses cepat seluruh modul sistem</p>
                </div>
                <button @click="mobileMenuOpen = false" type="button" class="w-8 h-8 rounded-full bg-surface-container-low dark:bg-white/5 flex items-center justify-center text-on-surface-variant hover:text-on-surface">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>

            <!-- Drawer Content Grid -->
            <div class="p-6 space-y-6 pb-20">
                <!-- 1. UTAMA -->
                <div>
                    <span class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-3">Utama</span>
                    <div class="grid grid-cols-3 gap-3">
                        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">home</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Home</span>
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group relative">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">calendar_month</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Booking</span>
                            @if($pendingCount > 0)
                                <span class="absolute top-1 right-1 bg-secondary text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('transactions.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">receipt_long</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Transaksi</span>
                        </a>
                    </div>
                </div>

                <!-- 2. SUKU CADANG & TOKO -->
                <div>
                    <span class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-3">Suku Cadang & Toko</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <a href="{{ route('admin.spareparts.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">inventory_2</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Sparepart</span>
                        </a>
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group relative">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">shopping_bag</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Pesanan</span>
                            @if($pendingMobileOrders > 0)
                                <span class="absolute top-1 right-1 bg-secondary text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">{{ $pendingMobileOrders }}</span>
                            @endif
                        </a>
                        @endif
                    </div>
                </div>

                <!-- 3. RELASI PELANGGAN -->
                <div>
                    <span class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-3">Relasi Pelanggan</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <a href="{{ route('customers.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">person_book</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Pelanggan</span>
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">directions_car</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Kendaraan</span>
                        </a>
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.testimonials.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">reviews</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Ulasan</span>
                        </a>
                        <a href="{{ route('admin.messages.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group relative">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">mail</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Pesan</span>
                            @if($unreadMessages > 0)
                                <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-error"></span>
                            @endif
                        </a>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->role === 'admin')
                <!-- 4. MANAJEMEN & SISTEM -->
                <div>
                    <span class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-3">Manajemen & Sistem</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <a href="{{ route('admins.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">admin_panel_settings</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Admin</span>
                        </a>
                        <a href="{{ route('mechanics.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">build</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Mekanik</span>
                        </a>
                        <a href="{{ route('pages.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">description</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Halaman Web</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-surface-container-low dark:bg-[#1f1f1d] border border-outline-variant/20 hover:border-secondary transition-all text-center group">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant group-hover:text-secondary mb-1">settings</span>
                            <span class="text-[11px] font-medium text-on-surface dark:text-gray-300">Pengaturan</span>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('input[type="password"]').forEach((input, idx) => {
        if (input.dataset.pwToggled || (input.parentElement && input.parentElement.querySelector('button[aria-label="Toggle visibility"], button[onclick*="visibility"], span.material-symbols-outlined[style*="FILL"]'))) {
            return;
        }
        input.dataset.pwToggled = "true";
        
        let wrapper = input.parentNode;
        if (!wrapper || !wrapper.classList.contains("relative")) {
            wrapper = document.createElement("div");
            wrapper.className = "relative w-full flex items-center";
            Array.from(input.classList).forEach(cls => {
                if (cls.startsWith("mt-") || cls.startsWith("mb-") || cls.startsWith("my-")) {
                    wrapper.classList.add(cls);
                    input.classList.remove(cls);
                }
            });
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
        }

        const leftIcon = wrapper.querySelector("span.material-symbols-outlined, i");
        if (leftIcon) leftIcon.style.zIndex = "10";

        const btn = document.createElement("button");
        btn.type = "button";
        btn.id = "pw-toggle-" + idx;
        btn.setAttribute("aria-label", "Toggle visibility");
        btn.className = "absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center justify-center w-8 h-8 rounded-full text-on-surface-variant dark:text-gray-400 hover:text-primary dark:hover:text-white hover:bg-on-surface/5 dark:hover:bg-white/10 transition-all z-10";
        btn.innerHTML = '<span class="material-symbols-outlined text-[20px] select-none" style="font-variation-settings:\'FILL\' 0;">visibility</span>';
        wrapper.appendChild(btn);
        
        input.style.paddingRight = "2.75rem";
        
        btn.addEventListener("click", () => {
            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";
            btn.querySelector("span").textContent = isHidden ? "visibility_off" : "visibility";
        });
    });
});
</script>

</body>
</html>
