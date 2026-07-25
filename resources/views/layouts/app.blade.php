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
        ::view-transition-old(root),
        ::view-transition-new(root) {
            animation: none;
            mix-blend-mode: normal;
        }
        ::view-transition-old(root) { z-index: 1; }
        ::view-transition-new(root) { z-index: 2; }
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

            const x = event.clientX ?? innerWidth / 2;
            const y = event.clientY ?? innerHeight / 2;
            const endRadius = Math.hypot(Math.max(x, innerWidth - x), Math.max(y, innerHeight - y));

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
        }
    </script>
</head>
<body class="bg-background dark:bg-[#0a0a0a] min-h-screen flex text-on-surface dark:text-[#EDEDEC] antialiased transition-colors duration-300" x-data="{ sidebarOpen: false }">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition.opacity 
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden" style="display: none;"></div>
    <!-- SideNavBar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="hidden lg:flex w-[280px] h-screen fixed left-0 top-0 bg-surface dark:bg-[#111111] border-r border-outline-variant/20 shadow-md flex-col py-6 px-4 gap-2 z-50 transition-transform duration-300 ease-in-out">
        <div class="px-4 mb-8">
            <a href="{{ url('/') }}" class="group block hover:opacity-90 transition-opacity">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-8 object-contain brightness-0 dark:invert">
                    <h1 class="text-2xl font-sora font-bold text-primary dark:text-[#EDEDEC]">SIBENGKEL</h1>
                </div>
                <p class="text-sm text-on-surface-variant dark:text-gray-400 mt-1">Workshop Management</p>
            </a>
        </div>
        <nav class="flex-1 flex flex-col gap-2 overflow-y-auto pr-2 custom-scrollbar">
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined" data-weight="fill" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('customers.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('customers.index') }}">
                <span class="material-symbols-outlined">person_book</span>
                <span>Pelanggan</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('vehicles.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('vehicles.index') }}">
                <span class="material-symbols-outlined">directions_car</span>
                <span>Kendaraan</span>
            </a>
            @if(Auth::user()->role === 'admin')
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admins.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admins.index') }}">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span>Manajemen Admin</span>
            </a>

            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.testimonials.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.testimonials.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.testimonials.*') ? 'icon-filled' : '' }}">reviews</span>
                <span>Ulasan Pelanggan</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('mechanics.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('mechanics.index') }}">
                <span class="material-symbols-outlined">build</span>
                <span>Mekanik</span>
            </a>
            @endif
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.spareparts.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.spareparts.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.spareparts.*') ? 'icon-filled' : '' }}">inventory_2</span>
                <span>Sparepart</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('transactions.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('transactions.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('transactions.*') ? 'icon-filled' : '' }}">receipt_long</span>
                <span>Transaksi Servis</span>
            </a>
            <a class="flex items-center justify-between px-4 py-2 {{ request()->routeIs('admin.bookings.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.bookings.index') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.bookings.*') ? 'icon-filled' : '' }}">calendar_month</span>
                    <span>Booking Servis</span>
                </div>
                @php $pendingBookingCount = \App\Models\Booking::where('status', 'menunggu_konfirmasi')->count(); @endphp
                @if($pendingBookingCount > 0)
                    <span class="bg-secondary text-on-secondary text-xs px-2 py-0.5 rounded-full font-bold">{{ $pendingBookingCount }}</span>
                @endif
            </a>
            <a class="flex items-center justify-between px-4 py-2 {{ request()->routeIs('admin.orders.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.orders.index') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.orders.*') ? 'icon-filled' : '' }}">shopping_bag</span>
                    <span>Pesanan Online</span>
                </div>
                @php $pendingOrderCount = \App\Models\Order::where('status', 'menunggu_pembayaran')->count(); @endphp
                @if($pendingOrderCount > 0)
                    <span class="bg-white text-secondary text-xs px-2 py-0.5 rounded-full font-bold">{{ $pendingOrderCount }}</span>
                @endif
            </a>

            @if(Auth::user()->role === 'admin')
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('pages.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('pages.index') }}">
                <span class="material-symbols-outlined">description</span>
                <span>Halaman Statis</span>
            </a>
            
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.messages.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11 relative" href="{{ route('admin.messages.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.messages.*') ? 'icon-filled' : '' }}">mail</span>
                <span>Pesan Masuk</span>
                @php $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                @if($unreadMessages > 0)
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 bg-error text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold">{{ $unreadMessages > 9 ? '9+' : $unreadMessages }}</span>
                @endif
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.settings.*') ? 'bg-secondary text-white' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.settings.index') }}">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan Sistem</span>
            </a>
            @endif
        </nav>

    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0 lg:ml-[280px]">
        <!-- TopNavBar (Visible on Mobile & Desktop) -->
        <header class="flex justify-between items-center px-4 lg:px-8 w-full h-16 sticky top-0 z-40 bg-surface dark:bg-[#161615] border-b border-outline-variant dark:border-[#3E3E3A]">
            <div class="flex items-center gap-2">
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
                    <div x-show="notifOpen" x-transition class="fixed left-4 right-4 top-16 sm:absolute sm:left-auto sm:right-0 sm:top-auto sm:mt-2 sm:w-80 bg-surface rounded-xl shadow-lg border border-outline-variant/30 overflow-hidden z-50 hidden" :class="{'hidden': !notifOpen}">
                        <div class="p-3 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-lowest">
                            <h3 class="font-bold text-on-surface text-sm">Notifikasi</h3>
                            @if($unreadCount > 0)
                                <form action="{{ route('admin.notifications.readAll') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-on-surface hover:underline">Tandai semua dibaca</button>
                                </form>
                            @endif
                        </div>
                        <div class="max-h-[300px] overflow-y-auto custom-scrollbar">
                            @forelse($notifications as $notif)
                                <div class="p-3 border-b border-outline-variant/10 hover:bg-surface-container-lowest transition-colors {{ is_null($notif->read_at) ? 'bg-primary/5' : '' }}">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-on-surface leading-tight">{{ $notif->data['title'] ?? 'Pemberitahuan' }}</p>
                                            <p class="text-xs text-on-surface-variant mt-1">{{ $notif->data['message'] ?? '' }}</p>
                                            <p class="text-[10px] text-outline mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if(is_null($notif->read_at))
                                            <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-6 h-6 rounded-full hover:bg-surface-container flex items-center justify-center text-on-surface" title="Tandai dibaca">
                                                    <span class="material-symbols-outlined text-[14px]">check</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    @if(isset($notif->data['action_url']))
                                        <a href="{{ $notif->data['action_url'] }}" class="inline-block mt-2 text-xs text-on-surface font-semibold hover:underline">Lihat Detail</a>
                                    @endif
                                </div>
                            @empty
                                <div class="p-4 text-center text-sm text-on-surface-variant">
                                    Belum ada notifikasi.
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
                         class="absolute right-0 mt-2 w-56 rounded-xl bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] shadow-lg py-2 z-50 origin-top-right"
                         style="display: none;">
                        
                        <div class="px-4 py-3 border-b border-outline-variant dark:border-[#3E3E3A]">
                            <p class="text-sm font-bold text-on-surface dark:text-[#EDEDEC] truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-on-surface-variant dark:text-gray-400 truncate">{{ Auth::user()->email ?? 'admin@sibengkel.web.id' }}</p>
                        </div>
                        
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-on-surface dark:text-[#EDEDEC] hover:bg-surface-container dark:hover:bg-[#111111] transition-colors">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                Pengaturan Profil
                            </a>
                        </div>
                        
                        <div class="py-1 border-t border-outline-variant dark:border-[#3E3E3A]">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-2 text-sm text-error w-full text-left hover:bg-error/10 transition-colors">
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

    <!-- BottomNavBar (Visible only on Mobile - Flex-1 Auto-Stretch to Fill Space) -->
    <nav class="lg:hidden fixed bottom-0 left-0 w-full z-50 flex items-center justify-between bg-surface px-1 pb-safe h-20 rounded-t-2xl border-t border-outline-variant shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] overflow-x-auto gap-0.5 scroll-smooth shrink-0 no-scrollbar">
        <!-- 1. Home -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('dashboard') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('dashboard') ? 'icon-filled' : '' }}">home</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Home</span>
        </a>

        <!-- 2. Pelanggan -->
        <a href="{{ route('customers.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('customers.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('customers.*') ? 'icon-filled' : '' }}">person_book</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Pelanggan</span>
        </a>

        <!-- 3. Kendaraan -->
        <a href="{{ route('vehicles.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('vehicles.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('vehicles.*') ? 'icon-filled' : '' }}">directions_car</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Kendaraan</span>
        </a>

        @if(Auth::user()->role === 'admin')
        <!-- 4. Manajemen Admin -->
        <a href="{{ route('admins.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('admins.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('admins.*') ? 'icon-filled' : '' }}">admin_panel_settings</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Admin</span>
        </a>

        <!-- 5. Ulasan Pelanggan -->
        <a href="{{ route('pages.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('pages.*') || request()->routeIs('admin.testimonials.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl">web</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Halaman</span>
        </a>
        <a href="{{ route('pages.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('pages.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl">description</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Pages</span>
        </a>
        
        <a href="{{ route('admin.messages.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('admin.messages.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1 relative">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('admin.messages.*') ? 'icon-filled' : '' }}">mail</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Pesan</span>
            @php $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
            @if($unreadMessages > 0)
                <span class="absolute top-1 right-2 w-2 h-2 rounded-full bg-error"></span>
            @endif
        </a>
        @endif

        <!-- 6. Mekanik -->
        <a href="{{ route('mechanics.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('mechanics.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('mechanics.*') ? 'icon-filled' : '' }}">build</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Mekanik</span>
        </a>

        <!-- 7. Sparepart -->
        <a href="{{ route('admin.spareparts.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('admin.spareparts.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('admin.spareparts.*') ? 'icon-filled' : '' }}">inventory_2</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Sparepart</span>
        </a>

        <!-- 8. Pesanan Online -->
        <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('admin.orders.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1 relative">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('admin.orders.*') ? 'icon-filled' : '' }}">shopping_bag</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Pesanan</span>
            @php $pendingMobileOrders = \App\Models\Order::where('status', 'menunggu_pembayaran')->count(); @endphp
            @if($pendingMobileOrders > 0)
                <span class="absolute top-1 right-1 bg-secondary text-white text-[9px] font-bold px-1 rounded-full">{{ $pendingMobileOrders }}</span>
            @endif
        </a>

        <!-- 8b. Booking Servis -->
        <a href="{{ route('admin.bookings.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('admin.bookings.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1 relative">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('admin.bookings.*') ? 'icon-filled' : '' }}">calendar_month</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Booking</span>
            @php $pendingCount = \App\Models\Booking::where('status', 'menunggu_konfirmasi')->count(); @endphp
            @if($pendingCount > 0)
                <span class="absolute top-1 right-2 bg-secondary text-on-secondary text-[9px] font-bold px-1 rounded-full animate-pulse">{{ $pendingCount }}</span>
            @endif
        </a>

        <!-- 9. Transaksi -->
        <a href="{{ route('transactions.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('transactions.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('transactions.*') ? 'icon-filled' : '' }}">receipt_long</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Transaksi Servis</span>
        </a>

        @if(Auth::user()->role === 'admin')
        <!-- 10. Pengaturan Halaman -->
        <a href="{{ route('pages.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('pages.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('pages.*') ? 'icon-filled' : '' }}">description</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Halaman</span>
        </a>
        @endif
    </nav>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('input[type="password"]').forEach((input, idx) => {
        const parent = input.parentElement;
        if (window.getComputedStyle(parent).position === "static") {
            parent.style.position = "relative";
        }
        const btn = document.createElement("button");
        btn.type = "button";
        btn.id = "pw-toggle-" + idx;
        btn.setAttribute("aria-label", "Toggle visibility");
        btn.className = "absolute inset-y-0 right-0 flex items-center px-3 text-on-surface-variant hover:text-secondary transition-colors";
        btn.innerHTML = '<span class="material-symbols-outlined text-[20px] select-none" style="font-variation-settings:\'FILL\' 0;">visibility</span>';
        parent.appendChild(btn);
        input.style.paddingRight = "2.5rem";
        btn.addEventListener("click", () => {
            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";
            btn.querySelector("span").textContent = isHidden ? "visibility_off" : "visibility";
        });
    });
});
</script>
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var end = Date.now() + (2 * 1000);
                var colors = ['#f26b21', '#f97316', '#ffffff'];
                (function frame() {
                    confetti({ particleCount: 3, angle: 60, spread: 55, origin: { x: 0 }, colors: colors, zIndex: 100000 });
                    confetti({ particleCount: 3, angle: 120, spread: 55, origin: { x: 1 }, colors: colors, zIndex: 100000 });
                    if (Date.now() < end) requestAnimationFrame(frame);
                }());
            });
        </script>
    @endif
</body>
</html>
