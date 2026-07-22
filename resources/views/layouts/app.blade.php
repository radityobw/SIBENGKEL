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
            <div class="flex items-center gap-2">
                <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-8 object-contain">
                <h1 class="text-2xl font-sora font-bold text-on-primary">SIBENGKEL</h1>
            </div>
            <p class="text-sm text-on-primary/70 mt-1">Workshop Management</p>
        </div>
        <nav class="flex-1 flex flex-col gap-2">
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined" data-weight="fill" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('customers.*') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('customers.index') }}">
                <span class="material-symbols-outlined">person_book</span>
                <span>Pelanggan</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('vehicles.*') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('vehicles.index') }}">
                <span class="material-symbols-outlined">directions_car</span>
                <span>Kendaraan</span>
            </a>
            @if(Auth::user()->role === 'admin')
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admins.*') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('admins.index') }}">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span>Manajemen Admin</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('mechanics.*') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('mechanics.index') }}">
                <span class="material-symbols-outlined">build</span>
                <span>Mekanik</span>
            </a>
            @endif
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('transactions.*') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('transactions.index') }}">
                <span class="material-symbols-outlined">receipt_long</span>
                <span>Transaksi</span>
            </a>
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
            <div class="flex items-center gap-6">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-full text-on-primary hover:bg-primary-container/20 transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="lg:hidden flex items-center gap-2">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 invert">
                    <h2 class="text-xl font-sora font-bold text-on-primary tracking-tight">SIBENGKEL</h2>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="font-medium text-sm text-on-primary lg:text-on-surface-variant truncate max-w-[100px] sm:max-w-[200px]">
                    Halo, {{ Auth::user()->name ?? 'Admin' }}
                </div>
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

    <!-- BottomNavBar (Visible only on Mobile) -->
    <nav class="lg:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center bg-surface px-4 pb-safe h-16 rounded-t-xl border-t border-outline-variant shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('dashboard') ? 'text-secondary' : 'text-on-surface-variant' }} font-bold h-full w-full max-w-[80px] touch-none active:scale-90 active:bg-surface-container rounded-lg">
            <span class="material-symbols-outlined mb-1" {{ request()->routeIs('dashboard') ? 'data-weight=fill style=font-variation-settings:\'FILL\'1;' : '' }}>home</span>
            <span class="text-xs">Home</span>
        </a>
        <a href="{{ route('customers.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('customers.*') ? 'text-secondary' : 'text-on-surface-variant' }} font-bold h-full w-full max-w-[80px] touch-none active:scale-90 active:bg-surface-container rounded-lg">
            <span class="material-symbols-outlined mb-1">person_book</span>
            <span class="text-xs">Cust</span>
        </a>
        <a href="{{ route('vehicles.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('vehicles.*') ? 'text-secondary' : 'text-on-surface-variant' }} font-bold h-full w-full max-w-[80px] touch-none active:scale-90 active:bg-surface-container rounded-lg">
            <span class="material-symbols-outlined mb-1">directions_car</span>
            <span class="text-xs">Veh</span>
        </a>
        @if(Auth::user()->role === 'admin')
        <a href="{{ route('admins.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('admins.*') ? 'text-secondary' : 'text-on-surface-variant' }} font-bold h-full w-full max-w-[80px] touch-none active:scale-90 active:bg-surface-container rounded-lg">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('admins.*') ? 'icon-filled' : '' }}">admin_panel_settings</span>
            <span class="text-[10px] mt-1">Admin</span>
        </a>
        <a href="{{ route('mechanics.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('mechanics.*') ? 'text-secondary' : 'text-on-surface-variant' }} font-bold h-full w-full max-w-[80px] touch-none active:scale-90 active:bg-surface-container rounded-lg">
            <span class="material-symbols-outlined text-2xl {{ request()->routeIs('mechanics.*') ? 'icon-filled' : '' }}">build</span>
            <span class="text-[10px] mt-1">Mekanik</span>
        </a>
        @endif
        <a href="{{ route('transactions.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('transactions.*') ? 'text-secondary' : 'text-on-surface-variant' }} font-bold h-full w-full max-w-[80px] touch-none active:scale-90 active:bg-surface-container rounded-lg">
            <span class="material-symbols-outlined mb-1">receipt_long</span>
            <span class="text-xs">Tx</span>
        </a>
    </nav>
</body>
</html>
