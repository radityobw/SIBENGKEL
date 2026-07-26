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
        html.theme-transitioning::view-transition-old(root),
        html.theme-transitioning::view-transition-new(root) {
            animation: none;
            mix-blend-mode: normal;
        }
        html.theme-transitioning::view-transition-old(root) { z-index: 1; }
        html.theme-transitioning::view-transition-new(root) { z-index: 2; }
    </style>
    <script>
        // Customer Portal defaults to Light Mode
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
<body class="bg-background dark:bg-[#0a0a0a] min-h-screen flex text-on-surface dark:text-[#EDEDEC] antialiased transition-colors duration-300" x-data="{ sidebarOpen: window.innerWidth >= 768 }">
    <!-- SideNavBar (Desktop Only) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '!-translate-x-full'" class="hidden md:flex w-[280px] h-screen fixed left-0 top-0 bg-surface dark:bg-[#111111] border-r border-outline-variant/20 dark:border-[#3E3E3A]/50 shadow-md flex-col py-6 px-4 gap-2 z-50 transition-all duration-300 ease-in-out">
        <div class="px-4 mb-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="group block hover:opacity-90 transition-opacity">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-8 object-contain brightness-0 dark:invert">
                    <h1 class="text-2xl font-sora font-bold text-primary dark:text-[#EDEDEC]">SIBENGKEL</h1>
                </div>
                <p class="text-sm text-on-surface-variant dark:text-gray-400 mt-1">Customer Portal</p>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-1 flex flex-col gap-1.5 overflow-y-auto pr-2 custom-scrollbar">
            <!-- PORTAL PELANGGAN -->
            <div class="text-[10px] font-bold tracking-wider text-secondary uppercase px-4 mt-2 mb-1">Portal Pelanggan</div>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('public.dashboard') ? 'bg-secondary text-white font-semibold' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10 font-medium' }} rounded-lg transition-all duration-200 ease-in-out h-11" href="{{ route('public.dashboard') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('public.dashboard') ? 'icon-filled' : '' }}">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('public.booking.*') ? 'bg-secondary text-white font-semibold' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10 font-medium' }} rounded-lg transition-all duration-200 ease-in-out h-11" href="{{ route('public.booking.form') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('public.booking.*') ? 'icon-filled' : '' }}">calendar_month</span>
                <span>Booking Servis</span>
            </a>

            <!-- KATALOG & BELANJA -->
            <div class="text-[10px] font-bold tracking-wider text-secondary uppercase px-4 mt-4 mb-1">Katalog & Belanja</div>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('public.sparepart.*') || request()->routeIs('public.cart') || request()->routeIs('public.checkout') || request()->routeIs('public.orders.*') ? 'bg-secondary text-white font-semibold' : 'text-on-surface-variant dark:text-gray-400 hover:text-on-surface dark:hover:text-white hover:bg-surface-container dark:hover:bg-white/10 font-medium' }} rounded-lg transition-all duration-200 ease-in-out h-11" href="{{ route('public.sparepart.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('public.sparepart.*') || request()->routeIs('public.cart') || request()->routeIs('public.checkout') || request()->routeIs('public.orders.*') ? 'icon-filled' : '' }}">settings_input_component</span>
                <span>Katalog Sparepart</span>
            </a>
        </nav>
        

    </aside>

    <!-- Main Content Area -->
    <main :class="sidebarOpen ? 'md:ml-[280px]' : 'md:!ml-0'" class="flex-1 flex flex-col min-w-0 md:ml-[280px] transition-all duration-300 ease-in-out">
        <!-- TopNavBar (Identical to Dashboard) -->
        <header class="flex justify-between items-center px-4 md:px-8 w-full h-16 sticky top-0 z-40 bg-surface dark:bg-[#161615] border-b border-outline-variant dark:border-[#3E3E3A]">
            <div class="flex items-center gap-2">
                <button @click="sidebarOpen = !sidebarOpen" class="hidden md:flex w-10 h-10 rounded-full items-center justify-center text-on-surface-variant dark:text-white hover:bg-surface-container-high dark:hover:bg-white/10 transition-colors mr-1" title="Toggle Sidebar">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <a href="{{ url('/') }}" class="md:hidden flex items-center gap-2 hover:opacity-90 transition-opacity">
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
                @if(Auth::guard('customer')->check())
                <!-- Notification Dropdown -->
                <div x-data="{ notifOpen: false, profileOpen: false }" class="relative">
                    @php 
                        $unreadCount = Auth::guard('customer')->user()->unreadNotifications->count(); 
                        $notifications = Auth::guard('customer')->user()->notifications()->take(5)->get();
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
                                <form action="{{ route('public.notifications.readAll') }}" method="POST">
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
                                            <form action="{{ route('public.notifications.read', $notif->id) }}" method="POST" class="shrink-0">
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
                        @if(Auth::guard('customer')->user()->profile_photo_url)
                            <img src="{{ Auth::guard('customer')->user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover border border-outline-variant/30">
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs border border-outline-variant/30">
                                {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="hidden md:inline font-medium text-sm text-on-surface dark:text-[#EDEDEC] truncate max-w-[120px]">{{ Auth::guard('customer')->user()->name }}</span>
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
                            <p class="text-sm font-bold text-on-surface dark:text-[#EDEDEC] truncate">{{ Auth::guard('customer')->user()->name }}</p>
                            <p class="text-xs text-on-surface-variant dark:text-gray-400 truncate">{{ Auth::guard('customer')->user()->email ?? Auth::guard('customer')->user()->phone }}</p>
                        </div>
                        
                        <div class="py-1.5 px-1.5">
                            <a href="{{ route('public.profile') }}" class="flex items-center gap-3 px-3 py-2 text-sm rounded-xl text-on-surface dark:text-[#EDEDEC] hover:bg-surface-container dark:hover:bg-white/10 hover:text-primary dark:hover:text-amber-400 transition-all">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                Pengaturan Profil
                            </a>
                        </div>
                        
                        <div class="py-1.5 px-1.5 border-t border-outline-variant dark:border-[#3E3E3A]">
                            <form method="POST" action="{{ route('public.logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-3 py-2 text-sm rounded-xl text-error w-full text-left hover:bg-error/10 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
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
    <div class="fixed bottom-20 md:bottom-8 right-4 md:right-8 z-40">
        <a href="{{ route('public.booking.form') }}" class="bg-secondary text-on-secondary rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-xs px-sm md:px-md min-h-[56px] min-w-[56px] group active:scale-95">
            <span class="material-symbols-outlined text-[24px]">add</span>
            <span class="text-label-md font-label-md font-semibold whitespace-nowrap hidden sm:inline">Booking Servis Baru</span>
        </a>
    </div>
    @endif

    <!-- BottomNavBar (Visible only on Mobile - Sleek Flat Dock) -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 grid grid-cols-4 items-center bg-surface/95 dark:bg-[#161615]/95 backdrop-blur-md px-2 pb-safe h-16 border-t border-outline-variant dark:border-[#3E3E3A] shadow-[0_-4px_12px_rgba(0,0,0,0.1)]">
        <a class="flex flex-col items-center justify-center py-1 transition-all {{ request()->routeIs('public.dashboard') ? 'text-secondary font-bold scale-105' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('public.dashboard') }}">
            <span class="material-symbols-outlined text-2xl mb-0.5" {{ request()->routeIs('public.dashboard') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>dashboard</span>
            <span class="text-[10px] tracking-tight font-medium">Dashboard</span>
        </a>
        <a class="flex flex-col items-center justify-center py-1 transition-all {{ request()->routeIs('public.booking.*') ? 'text-secondary font-bold scale-105' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('public.booking.form') }}">
            <span class="material-symbols-outlined text-2xl mb-0.5" {{ request()->routeIs('public.booking.*') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>calendar_month</span>
            <span class="text-[10px] tracking-tight font-medium">Booking</span>
        </a>
        <a class="flex flex-col items-center justify-center py-1 transition-all {{ request()->routeIs('public.sparepart.*') || request()->routeIs('public.cart') || request()->routeIs('public.checkout') || request()->routeIs('public.orders.*') ? 'text-secondary font-bold scale-105' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('public.sparepart.index') }}">
            <span class="material-symbols-outlined text-2xl mb-0.5" {{ request()->routeIs('public.sparepart.*') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>settings_input_component</span>
            <span class="text-[10px] tracking-tight font-medium">Sparepart</span>
        </a>
        <a class="flex flex-col items-center justify-center py-1 transition-all {{ request()->routeIs('public.profile') ? 'text-secondary font-bold scale-105' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('public.profile') }}">
            <span class="material-symbols-outlined text-2xl mb-0.5" {{ request()->routeIs('public.profile') ? "data-weight=fill style=font-variation-settings:'FILL' 1;" : '' }}>account_circle</span>
            <span class="text-[10px] tracking-tight font-medium">Profil</span>
        </a>
    </nav>

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
    @if(session('confetti'))
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
