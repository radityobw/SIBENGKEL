<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - SIBENGKEL</title>
    
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

        <!-- Right Side: Register Form -->
        <div class="w-full lg:w-[45%] flex flex-col bg-surface relative z-10 min-h-screen">
            <!-- Mobile Navbar (visible only on small screens) -->
            <header class="lg:hidden flex items-center gap-2 px-4 h-16 w-full bg-primary shrink-0 shadow-sm">
                <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 invert">
                <h2 class="text-xl font-sora font-bold text-on-primary tracking-tight">SIBENGKEL</h2>
            </header>

            <div class="flex-1 flex items-center justify-center p-4 md:p-lg">
                <div class="w-full max-w-md bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6 md:p-12">
                    <div class="mb-lg">
                    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Buat Akun Baru</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Silakan lengkapi data untuk mendaftar ke sistem.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-md">
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="name">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined @error('name') text-error @else text-on-surface-variant @enderror">badge</span>
                            </div>
                            <input class="block w-full pl-10 pr-3 py-2 min-h-[44px] border @error('name') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors placeholder-on-surface-variant/50" 
                                id="name" 
                                name="name" 
                                placeholder="Masukkan nama Anda" 
                                required 
                                type="text" 
                                value="{{ old('name') }}" 
                                autofocus 
                                autocomplete="name" />
                        </div>
                        @error('name')
                            <p class="mt-1 font-label-sm text-label-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username Field -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="username">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined @error('username') text-error @else text-on-surface-variant @enderror">alternate_email</span>
                            </div>
                            <input class="block w-full pl-10 pr-3 py-2 min-h-[44px] border @error('username') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors placeholder-on-surface-variant/50" 
                                id="username" 
                                name="username" 
                                placeholder="Masukkan username Anda" 
                                required 
                                type="text" 
                                value="{{ old('username') }}" 
                                autocomplete="username" />
                        </div>
                        @error('username')
                            <p class="mt-1 font-label-sm text-label-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="email">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined @error('email') text-error @else text-on-surface-variant @enderror">mail</span>
                            </div>
                            <input class="block w-full pl-10 pr-3 py-2 min-h-[44px] border @error('email') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors placeholder-on-surface-variant/50" 
                                id="email" 
                                name="email" 
                                placeholder="Masukkan email Anda" 
                                required 
                                type="email" 
                                value="{{ old('email') }}" 
                                autocomplete="username" />
                        </div>
                        @error('email')
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
                            <input class="block w-full pl-10 pr-10 py-2 min-h-[44px] border @error('password') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors" 
                                id="password" 
                                name="password" 
                                placeholder="••••••••" 
                                required 
                                type="password" 
                                autocomplete="new-password" />
                            <button type="button" onclick="const p=document.getElementById('password'); p.type=p.type==='password'?'text':'password'; this.querySelector('span').innerText=p.type==='password'?'visibility_off':'visibility';" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-on-surface">
                                <span class="material-symbols-outlined">visibility_off</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 font-label-sm text-label-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2" for="password_confirmation">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined @error('password_confirmation') text-error @else text-on-surface-variant @enderror">lock_reset</span>
                            </div>
                            <input class="block w-full pl-10 pr-10 py-2 min-h-[44px] border @error('password_confirmation') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="••••••••" 
                                required 
                                type="password" 
                                autocomplete="new-password" />
                            <button type="button" onclick="const p=document.getElementById('password_confirmation'); p.type=p.type==='password'?'text':'password'; this.querySelector('span').innerText=p.type==='password'?'visibility_off':'visibility';" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-on-surface">
                                <span class="material-symbols-outlined">visibility_off</span>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 font-label-sm text-label-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors" href="{{ route('login') }}">
                            Sudah punya akun? Masuk
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm font-label-md text-label-md text-on-primary bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary min-h-[44px] items-center transition-colors" type="submit">
                        Daftar Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
