<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SIBENGKEL - Customer Login</title>
    
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
                    <a href="{{ url('/') }}" class="flex items-center gap-2 text-on-primary hover:opacity-80 transition-opacity w-fit">
                        <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-10 md:h-12 object-contain brightness-0 invert">
                        <h1 class="font-headline-xl text-headline-xl text-on-primary tracking-tight">SIBENGKEL</h1>
                    </a>
                    <p class="font-headline-md text-headline-md text-primary-fixed mt-4 max-w-md">Layanan Servis Profesional & Terpercaya untuk Kendaraan Anda.</p>
                </div>
                <div class="text-on-primary/60 font-label-md text-label-md">
                    © {{ date('Y') }} SIBENGKEL. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-[45%] flex flex-col bg-surface relative z-10 min-h-screen">
            <!-- Mobile Navbar (visible only on small screens) -->
            <header class="lg:hidden flex items-center justify-between px-4 h-16 w-full bg-primary shrink-0 shadow-sm">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-on-primary hover:opacity-80 transition-opacity">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 invert">
                    <h2 class="text-xl font-sora font-bold text-on-primary tracking-tight">SIBENGKEL</h2>
                </a>
                <a href="{{ url('/') }}" class="flex items-center gap-1 text-on-primary/80 hover:text-on-primary transition-colors text-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Kembali</span>
                </a>
            </header>

            <!-- Desktop Back Button (visible only on large screens) -->
            <div class="hidden lg:flex absolute top-6 right-8 z-50">
                <a href="{{ url('/') }}" class="flex items-center gap-2 font-label-md text-on-surface-variant hover:text-primary transition-colors px-4 py-2 rounded-full border border-outline-variant/50 hover:bg-surface-container">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            <div class="flex-1 flex items-center justify-center p-4 md:p-lg">
                <div class="w-full max-w-md bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6 md:p-12">
                    <div class="mb-lg text-center md:text-left">
                        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Portal Pelanggan</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Silakan masuk untuk mengelola servis kendaraan Anda.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 bg-error-container text-on-error-container p-4 rounded text-sm">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('public.login.submit') }}" class="space-y-md">
                        @csrf
                        
                        <!-- Login Field -->
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-2" for="login">No. HP atau Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined @error('login') text-error @else text-on-surface-variant @enderror">person</span>
                                </div>
                                <input class="block w-full pl-10 pr-3 py-3 min-h-[44px] border @error('login') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors placeholder-on-surface-variant/50" 
                                    id="login" 
                                    name="login" 
                                    placeholder="Contoh: 08123456789 atau email@domain.com" 
                                    required 
                                    type="text" 
                                    value="{{ old('login') }}" 
                                    autofocus />
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block font-label-md text-label-md text-on-surface" for="password">Password</label>
                                <a href="{{ route('public.forgot_password') }}" class="font-label-sm text-xs text-primary hover:underline font-semibold">Lupa Password?</a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined @error('password') text-error @else text-on-surface-variant @enderror">lock</span>
                                </div>
                                <input class="block w-full pl-10 pr-10 py-3 min-h-[44px] border @error('password') border-error @else border-outline-variant @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors" 
                                    id="password" 
                                    name="password" 
                                    placeholder="••••••••" 
                                    required 
                                    type="password" />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-sm">
                            <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm font-label-md text-label-md text-on-primary bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary min-h-[44px] items-center transition-colors" type="submit">
                                Masuk
                            </button>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="font-body-md text-sm text-on-surface-variant">
                                Belum punya akun? 
                                <a class="text-primary hover:text-primary-container font-semibold transition-colors" href="{{ route('public.register') }}">Daftar di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
