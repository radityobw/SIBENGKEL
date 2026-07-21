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
<body class="bg-background min-h-screen flex text-on-surface antialiased">
    <!-- SideNavBar (Hidden on Mobile) -->
    <aside class="w-[280px] h-screen fixed left-0 top-0 bg-primary dark:bg-tertiary border-r border-outline-variant/20 shadow-md hidden lg:flex flex-col py-6 px-4 gap-2 z-50">
        <div class="px-4 mb-8">
            <h1 class="text-2xl font-sora font-bold text-on-primary">SIBENGKEL</h1>
            <p class="text-sm text-on-primary/70">Workshop Management</p>
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
            <a class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('mechanics.*') ? 'bg-secondary-container text-on-secondary-container' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/50' }} rounded-lg font-semibold transition-all duration-200 ease-in-out h-11" href="{{ route('mechanics.index') }}">
                <span class="material-symbols-outlined">build</span>
                <span>Mekanik</span>
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
        <header class="flex justify-between items-center px-4 lg:px-8 w-full h-16 sticky top-0 z-40 bg-surface border-b border-outline-variant">
            <div class="flex items-center gap-6">
                <!-- Mobile Menu Button -->
                <button class="lg:hidden p-2 rounded-full text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h2 class="lg:hidden text-xl font-sora font-bold text-primary tracking-tight">SIBENGKEL</h2>
            </div>
            <div class="flex items-center gap-2">
                <div class="ml-2 font-medium text-sm">
                    Halo, {{ Auth::user()->name ?? 'Admin' }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-4 lg:p-8 flex flex-col gap-6">
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
        <a href="{{ route('mechanics.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('mechanics.*') ? 'text-secondary' : 'text-on-surface-variant' }} font-bold h-full w-full max-w-[80px] touch-none active:scale-90 active:bg-surface-container rounded-lg">
            <span class="material-symbols-outlined mb-1">build</span>
            <span class="text-xs">Mech</span>
        </a>
    </nav>
</body>
</html>
