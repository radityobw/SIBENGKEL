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
    </style>
</head>
<body class="bg-background min-h-screen flex text-on-surface antialiased" x-data="{ sidebarOpen: false }">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition.opacity 
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden" style="display: none;"></div>
    <!-- SideNavBar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="w-[280px] h-screen fixed left-0 top-0 bg-primary dark:bg-tertiary border-r border-outline-variant/20 shadow-md flex flex-col py-6 px-4 gap-2 z-50 transition-transform duration-300 ease-in-out">
        <div class="px-4 mb-8">
            <a href="{{ url('/') }}" class="group block hover:opacity-90 transition-opacity">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-8 object-contain">
                    <h1 class="text-2xl font-sora font-bold text-on-primary">SIBENGKEL</h1>
                </div>
                <p class="text-sm text-on-primary/70 mt-1">Workshop Management</p>
            </a>
        </div>
        <nav class="flex-1 flex flex-col gap-2">
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined" data-weight="fill" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('customers.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('customers.index') }}">
                <span class="material-symbols-outlined">person_book</span>
                <span>Pelanggan</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('vehicles.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('vehicles.index') }}">
                <span class="material-symbols-outlined">directions_car</span>
                <span>Kendaraan</span>
            </a>
            @if(Auth::user()->role === 'admin')
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admins.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admins.index') }}">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span>Manajemen Admin</span>
            </a>

            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.testimonials.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.testimonials.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.testimonials.*') ? 'icon-filled' : '' }}">reviews</span>
                <span>Ulasan Pelanggan</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('mechanics.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('mechanics.index') }}">
                <span class="material-symbols-outlined">build</span>
                <span>Mekanik</span>
            </a>
            @endif
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.spareparts.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.spareparts.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.spareparts.*') ? 'icon-filled' : '' }}">inventory_2</span>
                <span>Sparepart</span>
            </a>
            <a class="flex items-center justify-between px-4 py-2 {{ request()->routeIs('admin.bookings.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.bookings.index') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.bookings.*') ? 'icon-filled' : '' }}">calendar_month</span>
                    <span>Booking Servis</span>
                </div>
                @php $pendingBookingCount = \App\Models\Booking::where('status', 'menunggu_konfirmasi')->count(); @endphp
                @if($pendingBookingCount > 0)
                    <span class="bg-secondary text-on-secondary text-xs px-2 py-0.5 rounded-full font-bold">{{ $pendingBookingCount }}</span>
                @endif
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('transactions.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('transactions.index') }}">
                <span class="material-symbols-outlined">receipt_long</span>
                <span>Transaksi</span>
            </a>
            @if(Auth::user()->role === 'admin')
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('pages.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('pages.index') }}">
                <span class="material-symbols-outlined">description</span>
                <span>Pengaturan Halaman</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.settings.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.settings.index') }}">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan Sistem</span>
            </a>
            @endif
        </nav>
        <div class="mt-auto pt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full h-11 bg-error text-on-error font-medium rounded-lg flex items-center justify-center gap-2 shadow-sm hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0 lg:ml-[280px]">
        <!-- TopNavBar (Visible on Mobile & Desktop) -->
        <header class="flex justify-between items-center px-4 lg:px-8 w-full h-16 sticky top-0 z-40 bg-primary lg:bg-surface border-b border-outline-variant">
            <div class="flex items-center gap-2">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-full text-on-primary hover:bg-primary-container/20 transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <a href="{{ url('/') }}" class="lg:hidden flex items-center gap-2 hover:opacity-90 transition-opacity">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 invert">
                    <h2 class="text-xl font-sora font-bold text-on-primary tracking-tight">SIBENGKEL</h2>
                </a>
            </div>
            <div class="flex items-center gap-3">
                @php $pendingBookingCount = \App\Models\Booking::where('status', 'menunggu_konfirmasi')->count(); @endphp
                <a href="{{ route('admin.bookings.index') }}" class="w-10 h-10 rounded-full flex items-center justify-center text-on-primary lg:text-on-surface-variant hover:bg-primary-container/20 lg:hover:bg-surface-container-high transition-colors relative" title="Cek {{ $pendingBookingCount }} Booking Masuk">
                    <span class="material-symbols-outlined">notifications</span>
                    @if($pendingBookingCount > 0)
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-secondary animate-pulse"></span>
                    @endif
                </a>
                <a href="{{ route('profile.edit') }}" class="font-medium text-sm text-on-primary lg:text-on-surface-variant truncate max-w-[140px] sm:max-w-[200px] hover:opacity-80 transition-opacity flex items-center gap-2" title="Edit Profil Admin">
                    @if(Auth::user()->profile_photo_url)
                        <img src="{{ Auth::user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover border border-outline-variant/30">
                    @else
                        <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs border border-outline-variant/30">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                    <span>Halo, <span class="font-bold underline decoration-secondary decoration-2 underline-offset-4">{{ Auth::user()->name ?? 'Admin' }}</span></span>
                </a>
                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}" class="lg:hidden flex items-center ml-2">
                    @csrf
                    <button type="submit" class="p-2 rounded-full text-error-container hover:bg-error/20 transition-colors" title="Logout">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-4 pb-24 lg:p-8 flex flex-col gap-6">
            @if(session('success'))
                <div class="bg-[#dcfce7] text-[#166534] p-4 rounded-lg font-medium border border-[#bbf7d0]">
                    {{ session('success') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <!-- BottomNavBar (Visible only on Mobile - Flex-1 Auto-Stretch to Fill Space) -->
    <nav class="lg:hidden fixed bottom-0 left-0 w-full z-50 flex items-center justify-between bg-surface px-2 pb-safe h-16 rounded-t-xl border-t border-outline-variant shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] overflow-x-auto gap-1 scroll-smooth shrink-0 no-scrollbar">
        <!-- 1. Home -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('dashboard') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('dashboard') ? 'icon-filled' : '' }}">home</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Home</span>
        </a>

        <!-- 2. Pelanggan -->
        <a href="{{ route('customers.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('customers.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('customers.*') ? 'icon-filled' : '' }}">person_book</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Pelanggan</span>
        </a>

        <!-- 3. Kendaraan -->
        <a href="{{ route('vehicles.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('vehicles.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('vehicles.*') ? 'icon-filled' : '' }}">directions_car</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Kendaraan</span>
        </a>

        @if(Auth::user()->role === 'admin')
        <!-- 4. Manajemen Admin -->
        <a href="{{ route('admins.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('admins.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('admins.*') ? 'icon-filled' : '' }}">admin_panel_settings</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Admin</span>
        </a>

        <!-- 5. Ulasan Pelanggan -->
        <a href="{{ route('pages.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('pages.*') || request()->routeIs('admin.testimonials.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl">web</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Halaman</span>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('admin.settings.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl">settings</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Pengaturan</span>
        </a>

        <!-- 6. Mekanik -->
        <a href="{{ route('mechanics.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('mechanics.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('mechanics.*') ? 'icon-filled' : '' }}">build</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Mekanik</span>
        </a>
        @endif

        <!-- 7. Sparepart -->
        <a href="{{ route('admin.spareparts.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('admin.spareparts.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('admin.spareparts.*') ? 'icon-filled' : '' }}">inventory_2</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Sparepart</span>
        </a>

        <!-- 8. Booking Servis -->
        <a href="{{ route('admin.bookings.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('admin.bookings.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1 relative">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('admin.bookings.*') ? 'icon-filled' : '' }}">calendar_month</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Booking</span>
            @php $pendingCount = \App\Models\Booking::where('status', 'menunggu_konfirmasi')->count(); @endphp
            @if($pendingCount > 0)
                <span class="absolute top-1 right-2 bg-secondary text-on-secondary text-[9px] font-bold px-1 rounded-full animate-pulse">{{ $pendingCount }}</span>
            @endif
        </a>

        <!-- 9. Transaksi -->
        <a href="{{ route('transactions.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('transactions.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('transactions.*') ? 'icon-filled' : '' }}">receipt_long</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Transaksi</span>
        </a>

        @if(Auth::user()->role === 'admin')
        <!-- 10. Pengaturan Halaman -->
        <a href="{{ route('pages.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[60px] shrink-0 text-center {{ request()->routeIs('pages.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-xl {{ request()->routeIs('pages.*') ? 'icon-filled' : '' }}">description</span>
            <span class="text-[10px] mt-0.5 whitespace-nowrap">Halaman</span>
        </a>
        @endif
    </nav>
</body>
</html>
