<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password Admin & Mekanik - SIBENGKEL</title>
    
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
                <div class="bg-cover bg-center w-full h-full opacity-40 mix-blend-overlay" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCp8N7Qg_QuXbYy6Syl2edvPnrnJuUm1VnM4OZs36sP_-PHJNbPXaGkkpfjuH4bdBMNggcsAm1YlC91XHlvhvm8TU6iapaN5Y-MsPaPv2tqzYaBbQZ4g-GEYq1Z6aOcgVkkAs24dF6ytKVxiWCSQviV8FLYL4PmR8bdM0kVl0F1Kq-dv1N_aYngSz8YHmDHcNhRSUTHLKYj5yJ1Z9o5n5tVXi8vIas1XQUGcN-z1ArtctdgwS_UDKueSA')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 to-primary/30"></div>
            </div>
            <!-- Content overlay -->
            <div class="relative z-10 p-xl flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-2 text-on-primary">
                        <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-10 md:h-12 object-contain brightness-0 invert">
                        <h1 class="font-headline-xl text-headline-xl text-on-primary tracking-tight">SIBENGKEL</h1>
                    </div>
                    <p class="font-headline-md text-headline-md text-primary-fixed mt-4 max-w-md">Pemulihan Keamanan Akun Sistem Informasi Bengkel.</p>
                </div>
                <div class="text-on-primary/60 font-label-md text-label-md">
                    © {{ date('Y') }} SIBENGKEL. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right Side: Forgot Password Form -->
        <div class="w-full lg:w-[45%] flex flex-col bg-surface relative z-10 min-h-screen">
            <!-- Mobile Navbar -->
            <header class="lg:hidden flex items-center justify-between px-4 h-16 w-full bg-primary shrink-0 shadow-sm">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 invert">
                    <h2 class="text-xl font-sora font-bold text-on-primary tracking-tight">SIBENGKEL</h2>
                </div>
                <a href="{{ route('login') }}" class="text-xs text-on-primary font-semibold hover:underline">Kembali</a>
            </header>

            <div class="flex-1 flex items-center justify-center p-4 md:p-lg">
                <div class="w-full max-w-md bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6 md:p-12">
                    <div class="mb-6">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-xs text-primary font-semibold hover:underline mb-4">
                            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Halaman Login
                        </a>
                        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2 font-sora font-bold">Lupa Password Admin</h2>
                        <p class="font-body-md text-sm text-on-surface-variant">Masukkan email terdaftar Anda untuk menerima tautan instruksi pemulihan kata sandi.</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-xs font-semibold">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 bg-error-container text-on-error-container p-4 rounded-lg text-xs font-medium">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label class="block font-label-md text-xs font-semibold text-on-surface mb-2" for="email">Alamat Email Terdaftar <span class="text-error">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-on-surface-variant text-lg">mail</span>
                                </div>
                                <input class="block w-full pl-10 pr-3 py-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-sm transition-colors" 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="admin@sibengkel.com" 
                                    required 
                                    autofocus />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm font-label-md text-sm font-bold text-on-primary bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary min-h-[44px] items-center transition-colors gap-2" type="submit">
                            <span class="material-symbols-outlined text-lg">send</span> Kirim Tautan Reset Password
                        </button>
                    </form>

                    <div class="relative flex items-center justify-center my-6">
                        <div class="border-t border-outline-variant/60 w-full"></div>
                        <span class="bg-surface-container-lowest px-3 text-xs text-on-surface-variant font-medium absolute">bantuan internal</span>
                    </div>

                    <!-- Super Admin Help Button -->
                    @php
                        $superWaNumber = \App\Models\Setting::get('admin_whatsapp', '628123456789');
                        $superWaText = \App\Models\Setting::get('superadmin_wa_text', 'Halo Super Admin SIBENGKEL, saya staf/mekanik butuh reset password akun.');
                        $superWaUrl = 'https://wa.me/' . $superWaNumber . '?text=' . urlencode($superWaText);
                    @endphp
                    <a href="{{ $superWaUrl }}" target="_blank" class="w-full py-2.5 px-4 rounded-lg border border-outline-variant bg-surface hover:bg-surface-container transition-colors font-semibold text-xs text-on-surface flex items-center justify-center gap-2 text-center shadow-xs">
                        <span class="material-symbols-outlined text-green-600 text-lg">chat</span> Hubungi Super Admin / Pemilik Bengkel
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
