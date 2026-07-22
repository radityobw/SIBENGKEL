<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - SIBENGKEL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background min-h-screen flex text-on-surface antialiased">
    <!-- Split Screen Layout -->
    <div class="flex w-full min-h-screen">
        <!-- Left Side: Image/Branding (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-[55%] relative bg-primary flex-col justify-between overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <div class="bg-cover bg-center w-full h-full opacity-40 mix-blend-overlay" data-alt="A pristine, high-tech automotive workshop interior." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCp8N7Qg_QuXbYy6Syl2edvPnrnJuUm1VnM4OZs36sP_-PHJNbPXaGkkpfjuH4bdBMNggcsAm1YlC91XHlvhvm8TU6iapaN5Y-MsPaPv2tqzYaBbQZ4g-GEYq1Z6aOcgVkkAs24dF6ytKVxiWCSQviV8FLYL4PmR8bdM0kVl0F1Kq-dv1N_aYngSz8YHmDHcNhRSUTHLKYj5yJ1Z9o5n5tVXi8vIas1XQUGcN-z1ArtctdgwS_UDKueSA')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 to-primary/30"></div>
            </div>
            <!-- Content overlay -->
            <div class="relative z-10 p-xl flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-2 text-on-primary">
                        <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-10 md:h-12 object-contain brightness-0 invert">
                        <h1 class="font-headline-xl text-headline-xl text-on-primary tracking-tight">SIBENGKEL</h1>
                    </div>
                    <p class="font-headline-md text-headline-md text-primary-fixed mt-4 max-w-md">Digitalisasi Bengkel Masa Kini. Efisiensi Tanpa Batas.</p>
                </div>
                <div class="text-on-primary/60 font-label-md text-label-md">
                    © {{ date('Y') }} SIBENGKEL. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-[45%] flex items-center justify-center p-sm md:p-lg bg-surface relative z-10">
            <!-- Mobile Logo (visible only on small screens) -->
            <div class="absolute top-sm left-sm lg:hidden flex items-center gap-2 text-primary">
                <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-8 object-contain">
                <span class="font-headline-md text-headline-md font-bold">SIBENGKEL</span>
            </div>

            <div class="w-full max-w-md bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-lg md:p-xl mt-12 lg:mt-0">
                <div class="mb-lg">
                    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Selamat Datang</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Silakan masuk ke akun manajemen bengkel Anda.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-md">
                    @csrf
                    
                    <!-- Email Field -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="login">Email atau Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined @error('login') text-error @else text-on-surface-variant @enderror">person</span>
                            </div>
                            <input class="block w-full pl-10 pr-3 py-3 min-h-[44px] border @error('login') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors placeholder-on-surface-variant/50" 
                                id="login" 
                                name="login" 
                                placeholder="Masukkan email atau username Anda" 
                                required 
                                type="text" 
                                value="{{ old('login') }}" 
                                autofocus 
                                autocomplete="username" />
                        </div>
                        @error('login')
                            <p class="mt-1 font-label-sm text-label-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="password">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined @error('password') text-error @else text-on-surface-variant @enderror">lock</span>
                            </div>
                            <input class="block w-full pl-10 pr-10 py-3 min-h-[44px] border @error('password') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors" 
                                id="password" 
                                name="password" 
                                placeholder="••••••••" 
                                required 
                                type="password" 
                                autocomplete="current-password" />
                            <button type="button" onclick="const p=document.getElementById('password'); p.type=p.type==='password'?'text':'password'; this.querySelector('span').innerText=p.type==='password'?'visibility_off':'visibility';" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-on-surface">
                                <span class="material-symbols-outlined">visibility_off</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 font-label-sm text-label-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary bg-surface-container-lowest" 
                                id="remember_me" 
                                name="remember" 
                                type="checkbox" />
                            <label class="ml-2 block font-body-md text-body-md text-on-surface-variant" for="remember_me">
                                Ingat saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm font-label-md text-label-md text-on-primary bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary min-h-[44px] items-center transition-colors" type="submit">
                        Masuk Sistem
                    </button>
                    
                    @if (Route::has('register'))
                    <div class="text-center mt-4">
                        <a class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors" href="{{ route('register') }}">
                            Belum punya akun? Daftar sekarang
                        </a>
                    </div>
                    @endif
                </form>

                <!-- System Status Indicator -->
                <div class="mt-lg pt-sm border-t border-outline-variant flex items-center justify-center gap-2">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-secondary"></span>
                    </span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Sistem Operasional Normal</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
