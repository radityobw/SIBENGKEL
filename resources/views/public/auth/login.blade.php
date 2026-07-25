<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SIBENGKEL - Customer Login</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-background dark:bg-[#0a0a0a] min-h-screen flex text-on-surface dark:text-[#EDEDEC] antialiased transition-colors duration-300">
    <!-- Split Screen Layout -->
    <div class="flex w-full min-h-screen">
        <!-- Left Side: Image/Branding (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-[55%] relative bg-[#0a0a0a] flex-col justify-between overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <div class="bg-cover bg-center w-full h-full opacity-75" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCp8N7Qg_QuXbYy6Syl2edvPnrnJuUm1VnM4OZs36sP_-PHJNbPXaGkkpfjuH4bdBMNggcsAm1YlC91XHlvhvm8TU6iapaN5Y-MsPaPv2tqzYaBbQZ4g-GEYq1Z6aOcgVkkAs24dF6ytKVxiWCSQviV8FLYL4PmR8bdM0kVl0F1Kq-dv1N_aYngSz8YHmDHcNhRSUTHLKYj5yJ1Z9o5n5tVXi8vIas1XQUGcN-z1ArtctdgwS_UDKueSA')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
            </div>
            <!-- Content overlay -->
            <div class="relative z-10 p-xl flex flex-col h-full justify-between">
                <div>
                    <a href="{{ url('/') }}" class="flex items-center gap-2 text-on-primary dark:text-[#EDEDEC] hover:opacity-80 transition-opacity w-fit">
                        <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-10 md:h-12 object-contain brightness-0 invert">
                        <h1 class="font-headline-xl text-headline-xl text-on-primary dark:text-[#EDEDEC] tracking-tight">SIBENGKEL</h1>
                    </a>
                    <p class="font-headline-md text-headline-md text-primary-fixed dark:text-gray-300 mt-4 max-w-md">Layanan Servis Profesional & Terpercaya untuk Kendaraan Anda.</p>
                </div>
                <div class="text-on-primary/60 dark:text-gray-400 font-label-md text-label-md">
                    © {{ date('Y') }} SIBENGKEL. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-[45%] flex flex-col bg-surface dark:bg-[#0a0a0a] relative z-10 min-h-screen">
            <!-- Mobile Navbar (visible only on small screens) -->
            <header class="lg:hidden flex items-center justify-between px-4 h-16 w-full bg-primary dark:bg-[#161615] shrink-0 shadow-sm">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-on-primary dark:text-[#EDEDEC] hover:opacity-80 transition-opacity">
                    <img src="{{ asset('logobengkel.png') }}" alt="SIBENGKEL Logo" class="h-6 object-contain brightness-0 invert">
                    <h2 class="text-xl font-sora font-bold text-on-primary dark:text-[#EDEDEC] tracking-tight">SIBENGKEL</h2>
                </a>
                <a href="{{ url('/') }}" class="flex items-center gap-1 text-on-primary/80 dark:text-[#EDEDEC]/80 hover:text-on-primary transition-colors text-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Kembali</span>
                </a>
            </header>

            <!-- Desktop Back Button (visible only on large screens) -->
            <div class="hidden lg:flex absolute top-6 right-8 z-50">
                <a href="{{ url('/') }}" class="flex items-center gap-2 font-label-md text-on-surface-variant dark:text-gray-400 hover:text-primary dark:hover:text-white transition-colors px-4 py-2 rounded-full border border-outline-variant/50 dark:border-[#3E3E3A] hover:bg-surface-container dark:hover:bg-[#161615]">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            <div class="flex-1 flex items-center justify-center p-4 md:p-lg">
                <div class="w-full max-w-md bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl shadow-sm p-6 md:p-12 relative group overflow-hidden magic-card">
                    <!-- Magic Card Spotlight -->
                    <div class="pointer-events-none absolute -inset-px opacity-0 transition duration-300 group-hover:opacity-100 z-0" 
                         style="background: radial-gradient(600px circle at var(--x, 0) var(--y, 0), rgba(242, 107, 33, 0.15), transparent 40%);"></div>
                    
                    <div class="relative z-10">
                        <div class="mb-lg text-center md:text-left">
                            <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface dark:text-[#EDEDEC] mb-2">Portal Pelanggan</h2>
                            <p class="font-body-md text-body-md text-on-surface-variant dark:text-gray-400">Silakan masuk untuk mengelola servis kendaraan Anda.</p>
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
                            <label class="block font-label-md text-label-md text-on-surface dark:text-[#EDEDEC] mb-2" for="login">No. HP atau Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined @error('login') text-error @else text-on-surface-variant dark:text-gray-400 @enderror">person</span>
                                </div>
                                <input class="block w-full pl-10 pr-3 py-3 border @error('login') border-error @else border-outline-variant dark:border-[#3E3E3A] @enderror rounded-lg bg-surface-container-lowest dark:bg-[#111111] text-on-surface dark:text-white focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors placeholder:text-outline dark:placeholder:text-gray-600" 
                                    id="login" 
                                    name="login" 
                                    placeholder="Masukkan No. HP atau Email" 
                                    required 
                                    type="text" 
                                    value="{{ old('login') }}" 
                                    autofocus />
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="password">Password</label>
                                <a href="{{ route('public.forgot_password') }}" class="font-label-sm text-xs text-primary dark:text-[#FF8F42] hover:underline font-semibold">Lupa Password?</a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined @error('password') text-error @else text-on-surface-variant dark:text-gray-400 @enderror">lock</span>
                                </div>
                                <input class="block w-full pl-10 pr-10 py-3 border @error('password') border-error @else border-outline-variant dark:border-[#3E3E3A] @enderror rounded-lg bg-surface-container-lowest dark:bg-[#111111] text-on-surface dark:text-white focus:ring-1 focus:ring-primary focus:border-primary font-body-md text-body-md transition-colors placeholder:text-outline dark:placeholder:text-gray-600" 
                                    id="password" 
                                    name="password" 
                                    placeholder="••••••••" 
                                    required 
                                    type="password" />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-sm">
                            <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm font-label-md text-label-md text-on-primary dark:text-black bg-primary dark:bg-white hover:bg-primary-container dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary min-h-[44px] items-center transition-colors font-bold" type="submit">
                                Masuk
                            </button>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="font-body-md text-sm text-on-surface-variant dark:text-gray-400">
                                Belum punya akun? 
                                <a class="text-primary dark:text-[#FF8F42] hover:underline font-semibold transition-colors" href="{{ route('public.register') }}">Daftar di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
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
        btn.className = "absolute inset-y-0 right-0 flex items-center px-3 text-on-surface-variant dark:text-gray-400 hover:text-secondary transition-colors";
        btn.innerHTML = '<span class="material-symbols-outlined text-[20px] select-none" style="font-variation-settings:\'FILL\' 0;">visibility</span>';
        parent.appendChild(btn);
        input.style.paddingRight = "2.5rem";
        btn.addEventListener("click", () => {
            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";
            btn.querySelector("span").textContent = isHidden ? "visibility_off" : "visibility";
        });
    });

    // Magic Card Effect
    document.querySelectorAll('.magic-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--x', `${e.clientX - rect.left}px`);
            card.style.setProperty('--y', `${e.clientY - rect.top}px`);
        });
    });
});
</script>
</body>
</html>
