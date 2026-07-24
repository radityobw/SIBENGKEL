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
        <nav class="flex-1 flex flex-col gap-2 overflow-y-auto pr-2 custom-scrollbar">
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
            <a class="flex items-center justify-between px-4 py-2 {{ request()->routeIs('admin.orders.*') ? 'bg-secondary text-white' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admin.orders.index') }}">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.orders.*') ? 'icon-filled' : '' }}">shopping_bag</span>
                    <span>Pesanan Online</span>
                </div>
                @php $pendingOrderCount = \App\Models\Order::where('status', 'menunggu_pembayaran')->count(); @endphp
                @if($pendingOrderCount > 0)
                    <span class="bg-white text-secondary text-xs px-2 py-0.5 rounded-full font-bold">{{ $pendingOrderCount }}</span>
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
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="flex items-center ml-2 border-l border-outline-variant/30 pl-4">
                    @csrf
                    <button type="submit" class="p-2 rounded-full text-error lg:text-error hover:bg-error/10 transition-colors" title="Logout">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </form>
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
        <a href="{{ route('admin.settings.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('admin.settings.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl">settings</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Pengaturan</span>
        </a>

        <!-- 6. Mekanik -->
        <a href="{{ route('mechanics.index') }}" class="flex flex-col items-center justify-center flex-1 min-w-[64px] shrink-0 text-center {{ request()->routeIs('mechanics.*') ? 'text-secondary font-bold' : 'text-on-surface-variant font-medium' }} h-full active:scale-90 rounded-lg px-1">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('mechanics.*') ? 'icon-filled' : '' }}">build</span>
            <span class="text-[11px] mt-1 whitespace-nowrap">Mekanik</span>
        </a>
        @endif

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
            <span class="text-[11px] mt-1 whitespace-nowrap">Transaksi</span>
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
// Global Password Toggle — injects show/hide button on all password fields
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="password"]').forEach((input, idx) => {
        // Wrap in relative container
        const parent = input.parentElement;
        const wrapper = document.createElement('div');
        wrapper.className = 'relative';
        parent.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        // Create toggle button
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.id = 'pw-toggle-' + idx;
        btn.setAttribute('aria-label', 'Toggle visibility');
        btn.className = 'absolute inset-y-0 right-0 flex items-center px-3 text-on-surface-variant hover:text-secondary transition-colors';
        btn.innerHTML = '<span class="material-symbols-outlined text-[20px] select-none" style="font-variation-settings:\'FILL\' 0;">visibility</span>';
        wrapper.appendChild(btn);

        // Pad input right so text doesn't go under button
        input.style.paddingRight = '2.5rem';

        btn.addEventListener('click', () => {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.querySelector('span').textContent = isHidden ? 'visibility_off' : 'visibility';
        });
    });
});
</script>
</body>
</html>
