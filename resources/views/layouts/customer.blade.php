<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Customer Portal - SIBENGKEL')</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: theme('colors.background'); color: theme('colors.on-surface'); }
        h1, h2, h3, h4, h5, h6, .font-sora { font-family: 'Sora', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .icon-filled { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
    <script>
        // Dark mode setup
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</head>
<body class="bg-background dark:bg-[#0a0a0a] min-h-screen flex text-on-surface dark:text-[#EDEDEC] antialiased transition-colors duration-300" x-data="{ sidebarOpen: false }">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition.opacity 
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 md:hidden" style="display: none;"></div>

    <!-- SideNavBar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="hidden md:flex w-[280px] h-screen fixed left-0 top-0 bg-primary dark:bg-[#111111] border-r border-outline-variant/20 dark:border-[#3E3E3A]/50 shadow-md flex-col py-6 px-4 gap-2 z-50 transition-transform duration-300 ease-in-out">
        <div class="px-4 mb-8">
            <a href="{{ url('/') }}" class="group block hover:opacity-90 transition-opacity">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-8 object-contain brightness-0 invert">
                    <h1 class="text-2xl font-sora font-bold text-on-primary">SIBENGKEL</h1>
                </div>
                <p class="text-sm text-on-primary/70 mt-1">Customer Portal</p>
            </a>
        </div>
        <nav class="flex-1 flex flex-col gap-2 overflow-y-auto pr-2 custom-scrollbar">
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('public.dashboard') ? 'bg-secondary text-white font-semibold' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50 font-medium' }} rounded-lg transition-all duration-200 ease-in-out h-11" href="{{ route('public.dashboard') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('public.dashboard') ? 'icon-filled' : '' }}">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('public.booking.*') ? 'bg-secondary text-white font-semibold' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50 font-medium' }} rounded-lg transition-all duration-200 ease-in-out h-11" href="{{ route('public.booking.form') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('public.booking.*') ? 'icon-filled' : '' }}">calendar_month</span>
                <span>Booking</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('public.sparepart.*') || request()->routeIs('public.cart') || request()->routeIs('public.checkout') || request()->routeIs('public.orders.*') ? 'bg-secondary text-white font-semibold' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50 font-medium' }} rounded-lg transition-all duration-200 ease-in-out h-11" href="{{ route('public.sparepart.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('public.sparepart.*') || request()->routeIs('public.cart') || request()->routeIs('public.checkout') || request()->routeIs('public.orders.*') ? 'icon-filled' : '' }}">settings_input_component</span>
                <span>Katalog Sparepart</span>
            </a>
        </nav>
        

    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0 md:ml-[280px]">
        <!-- TopNavBar (Identical to Dashboard) -->
        <header class="flex justify-between items-center px-4 md:px-8 w-full h-16 sticky top-0 z-40 bg-primary md:bg-surface dark:bg-[#161615] border-b border-outline-variant dark:border-[#3E3E3A]">
            <div class="flex items-center gap-2">
                <a href="{{ url('/') }}" class="md:hidden flex items-center gap-2 hover:opacity-90 transition-opacity">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 invert">
                    <h2 class="text-xl font-sora font-bold text-on-primary tracking-tight">SIBENGKEL</h2>
                </a>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" class="w-10 h-10 rounded-full flex items-center justify-center text-on-primary md:text-on-surface-variant hover:bg-primary-container/20 md:hover:bg-surface-container-high transition-colors" title="Toggle Dark Mode">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block text-amber-400">light_mode</span>
                </button>
                @if(Auth::guard('customer')->check())
                <!-- Notification Dropdown -->
                <div x-data="{ notifOpen: false }" class="relative">
                    @php 
                        $unreadCount = Auth::guard('customer')->user()->unreadNotifications->count(); 
                        $notifications = Auth::guard('customer')->user()->notifications()->take(5)->get();
                    @endphp
                    <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="w-10 h-10 rounded-full flex items-center justify-center text-on-primary md:text-on-surface-variant hover:bg-primary-container/20 md:hover:bg-surface-container-high transition-colors relative" title="Notifikasi">
                        <span class="material-symbols-outlined">notifications</span>
                        @if($unreadCount > 0)
                            <span class="absolute top-2 right-2 w-4 h-4 rounded-full bg-error text-white text-[9px] font-bold flex items-center justify-center border-2 border-surface">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="notifOpen" x-transition class="fixed left-4 right-4 top-16 md:absolute md:left-auto md:right-0 md:top-auto md:mt-2 md:w-80 bg-surface rounded-xl shadow-lg border border-outline-variant/30 overflow-hidden z-50 hidden" :class="{'hidden': !notifOpen}">
                        <div class="p-3 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-lowest">
                            <h3 class="font-bold text-on-surface text-sm">Notifikasi</h3>
                            @if($unreadCount > 0)
                                <form action="{{ route('public.notifications.readAll') }}" method="POST">
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
                                            <form action="{{ route('public.notifications.read', $notif->id) }}" method="POST">
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
                    <a href="{{ route('public.profile') }}" class="font-medium text-sm text-on-primary md:text-on-surface-variant dark:text-[#EDEDEC] truncate max-w-[140px] sm:max-w-[200px] hover:opacity-80 transition-opacity flex items-center gap-2" title="Edit Profil Saya">
                        @if(Auth::guard('customer')->user()->profile_photo_url)
                            <img src="{{ Auth::guard('customer')->user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover border border-outline-variant/30">
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs border border-outline-variant/30">
                                {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="hidden md:inline">Halo, <span class="font-bold underline decoration-secondary decoration-2 underline-offset-4">{{ Auth::guard('customer')->user()->name }}</span></span>
                    </a>
                @endif
                <!-- Logout -->
                <form method="POST" action="{{ route('public.logout') }}" class="flex items-center ml-2 border-l border-outline-variant/30 pl-4">
                    @csrf
                    <button type="submit" class="p-2 rounded-full text-error md:text-error hover:bg-error/10 transition-colors" title="Logout">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-4 pb-24 md:p-8 flex flex-col gap-6">
            @if ($errors->any())
                <div class="bg-error-container text-on-error-container p-4 rounded-lg text-sm border border-outline-variant">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
        <x-toast />
    </main>

    <!-- Prominent FAB (Visible only on Customer Dashboard) -->
    @if(request()->routeIs('public.dashboard'))
    <div class="fixed bottom-24 md:bottom-8 right-4 md:right-8 z-40">
        <a href="{{ route('public.booking.form') }}" class="bg-secondary text-on-secondary rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-xs px-sm md:px-md min-h-[56px] min-w-[56px] group active:scale-95">
            <span class="material-symbols-outlined text-[24px]">add</span>
            <span class="text-label-md font-label-md font-semibold whitespace-nowrap hidden sm:inline">Booking Servis Baru</span>
        </a>
    </div>
    @endif

    <!-- BottomNavBar (Visible only on Mobile - Flex-1 Auto-Stretch to Fill Space) -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-between items-center bg-surface dark:bg-[#161615] px-2 pb-safe h-20 rounded-t-2xl border-t border-outline-variant dark:border-[#3E3E3A] shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <a class="flex flex-col items-center justify-center flex-1 min-w-[72px] text-center {{ request()->routeIs('public.dashboard') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1" href="{{ route('public.dashboard') }}">
            <span class="material-symbols-outlined text-2xl mb-1" {{ request()->routeIs('public.dashboard') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>dashboard</span>
            <span class="text-xs">Dashboard</span>
        </a>
        <a class="flex flex-col items-center justify-center flex-1 min-w-[72px] text-center {{ request()->routeIs('public.booking.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1" href="{{ route('public.booking.form') }}">
            <span class="material-symbols-outlined text-2xl mb-1" {{ request()->routeIs('public.booking.*') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>calendar_month</span>
            <span class="text-xs">Booking</span>
        </a>
        <a class="flex flex-col items-center justify-center flex-1 min-w-[72px] text-center {{ request()->routeIs('public.sparepart.*') || request()->routeIs('public.cart') || request()->routeIs('public.checkout') || request()->routeIs('public.orders.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1" href="{{ route('public.sparepart.index') }}">
            <span class="material-symbols-outlined text-2xl mb-1" {{ request()->routeIs('public.sparepart.*') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>settings_input_component</span>
            <span class="text-xs">Sparepart</span>
        </a>
        <a class="flex flex-col items-center justify-center flex-1 min-w-[72px] text-center {{ request()->routeIs('public.profile') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1" href="{{ route('public.profile') }}">
            <span class="material-symbols-outlined text-2xl mb-1" {{ request()->routeIs('public.profile') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>account_circle</span>
            <span class="text-xs">Profil</span>
        </a>
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
</body>
</html>
