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
</head>
<body class="bg-background min-h-screen flex text-on-surface antialiased" x-data="{ sidebarOpen: false }">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition.opacity 
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 md:hidden" style="display: none;"></div>

    <!-- SideNavBar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="w-[280px] h-screen fixed left-0 top-0 bg-primary border-r border-outline-variant/20 shadow-md flex flex-col py-6 px-4 gap-2 z-50 transition-transform duration-300 ease-in-out">
        <div class="px-4 mb-8">
            <a href="{{ url('/') }}" class="group block hover:opacity-90 transition-opacity">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-8 object-contain">
                    <h1 class="text-2xl font-sora font-bold text-on-primary">SIBENGKEL</h1>
                </div>
                <p class="text-sm text-on-primary/70 mt-1">Customer Portal</p>
            </a>
        </div>
        <nav class="flex-1 flex flex-col gap-2">
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
        
        <div class="mt-auto pt-6">
            <form method="POST" action="{{ route('public.logout') }}">
                @csrf
                <button type="submit" class="w-full h-11 bg-error text-on-error font-medium rounded-lg flex items-center justify-center gap-2 shadow-sm hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0 md:ml-[280px]">
        <!-- TopNavBar (Identical to Dashboard) -->
        <header class="flex justify-between items-center px-4 md:px-8 w-full h-16 sticky top-0 z-40 bg-primary md:bg-surface border-b border-outline-variant">
            <div class="flex items-center gap-2">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-full text-on-primary hover:bg-primary-container/20 transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <a href="{{ url('/') }}" class="md:hidden flex items-center gap-2 hover:opacity-90 transition-opacity">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 invert">
                    <h2 class="text-xl font-sora font-bold text-on-primary tracking-tight">SIBENGKEL</h2>
                </a>
            </div>
            
            <div class="flex items-center gap-3">
                @if(Auth::guard('customer')->check())
                    @php $customerBookingCount = Auth::guard('customer')->user()->bookings()->whereIn('status', ['menunggu_konfirmasi', 'disetujui'])->count(); @endphp
                    <a href="{{ route('public.orders.index') }}" class="w-10 h-10 rounded-full flex items-center justify-center text-on-primary md:text-on-surface-variant hover:bg-primary-container/20 md:hover:bg-surface-container-high transition-colors relative" title="Lihat Status Pesanan & Booking">
                        <span class="material-symbols-outlined">notifications</span>
                        @if($customerBookingCount > 0)
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-secondary animate-pulse"></span>
                        @endif
                    </a>
                    <a href="{{ route('public.profile') }}" class="font-medium text-sm text-on-primary md:text-on-surface-variant truncate max-w-[140px] sm:max-w-[200px] hover:opacity-80 transition-opacity flex items-center gap-2" title="Edit Profil Saya">
                        @if(Auth::guard('customer')->user()->profile_photo_url)
                            <img src="{{ Auth::guard('customer')->user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover border border-outline-variant/30">
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs border border-outline-variant/30">
                                {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span>Halo, <span class="font-bold underline decoration-secondary decoration-2 underline-offset-4">{{ Auth::guard('customer')->user()->name }}</span></span>
                    </a>
                @endif
                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('public.logout') }}" class="md:hidden flex items-center ml-1">
                    @csrf
                    <button type="submit" class="p-2 rounded-full text-error-container hover:bg-error/20 transition-colors" title="Logout">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-4 pb-24 md:p-8 flex flex-col gap-6">
            @if(session('success'))
                <div class="bg-[#dcfce7] text-[#166534] p-4 rounded-lg font-medium border border-[#bbf7d0]" role="alert">
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
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
    <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-between items-center bg-surface px-2 pb-safe h-16 rounded-t-xl border-t border-outline-variant shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <a class="flex flex-col items-center justify-center flex-1 min-w-[60px] text-center {{ request()->routeIs('public.dashboard') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1" href="{{ route('public.dashboard') }}">
            <span class="material-symbols-outlined mb-1" {{ request()->routeIs('public.dashboard') ? 'data-weight=fill style=font-variation-settings:\'FILL\'1;' : '' }}>dashboard</span>
            <span class="text-xs">Dashboard</span>
        </a>
        <a class="flex flex-col items-center justify-center flex-1 min-w-[60px] text-center {{ request()->routeIs('public.booking.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1" href="{{ route('public.booking.form') }}">
            <span class="material-symbols-outlined mb-1" {{ request()->routeIs('public.booking.*') ? 'data-weight=fill style=font-variation-settings:\'FILL\'1;' : '' }}>calendar_month</span>
            <span class="text-xs">Booking</span>
        </a>
        <a class="flex flex-col items-center justify-center flex-1 min-w-[60px] text-center {{ request()->routeIs('public.sparepart.*') || request()->routeIs('public.cart') || request()->routeIs('public.checkout') || request()->routeIs('public.orders.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1" href="{{ route('public.sparepart.index') }}">
            <span class="material-symbols-outlined mb-1" {{ request()->routeIs('public.sparepart.*') ? 'data-weight=fill style=font-variation-settings:\'FILL\'1;' : '' }}>settings_input_component</span>
            <span class="text-xs">Sparepart</span>
        </a>
    </nav>
</body>
</html>
