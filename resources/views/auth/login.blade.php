<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - SIBENGKEL</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
        .dark .glass-card {
            background: rgba(22, 22, 21, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface dark:bg-[#0a0a0a] min-h-screen flex flex-col font-sans antialiased text-on-surface dark:text-[#EDEDEC] relative overflow-hidden transition-colors duration-300">
    <!-- Navbar (simplified for auth) -->
    <nav class="flex justify-between items-center w-full px-margin-mobile md:px-8 py-4 absolute top-0 z-50">
        <a href="{{ url('/') }}" class="font-headline-md text-headline-md tracking-tighter flex items-center gap-2 hover:opacity-80 transition-opacity text-primary dark:text-[#EDEDEC]">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-8 object-contain brightness-0 dark:invert"> SIBENGKEL
        </a>
        <a href="{{ url('/') }}" class="flex items-center gap-2 font-label-md text-primary dark:text-[#EDEDEC] hover:text-secondary transition-colors bg-surface/50 dark:bg-[#161615]/50 backdrop-blur-sm px-4 py-2 rounded-full border border-outline-variant/50 dark:border-[#3E3E3A]">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            <span class="hidden md:inline">Kembali</span>
        </a>
    </nav>

    <!-- Background Decor -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-20 dark:opacity-10">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-fixed rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-secondary-fixed rounded-full blur-[100px]"></div>
    </div>
    
    <!-- Login Container -->
    <div class="flex-1 flex items-center justify-center w-full max-w-md px-margin-mobile md:px-0 z-10 mx-auto">
        <div class="w-full">
            <!-- Brand Header -->
            <div class="text-center mb-lg">
                <h1 class="font-headline-xl text-[40px] leading-[48px] font-bold tracking-[-0.02em] text-primary dark:text-[#EDEDEC] mb-xs">Login Pegawai</h1>
                <p class="font-body-md text-[16px] leading-[24px] font-normal text-on-surface-variant dark:text-gray-400">Masuk ke sistem informasi bengkel.</p>
            </div>
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if ($errors->any())
                <div class="mb-4 bg-error-container text-on-error-container p-4 rounded text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Card -->
            <div class="glass-card rounded-xl p-lg md:p-xl border border-outline-variant dark:border-[#3E3E3A] shadow-sm relative group overflow-hidden magic-card">
                <!-- Magic Card Spotlight -->
                <div class="pointer-events-none absolute -inset-px opacity-0 transition duration-300 group-hover:opacity-100 z-0" 
                     style="background: radial-gradient(600px circle at var(--x, 0) var(--y, 0), rgba(242, 107, 33, 0.15), transparent 40%);"></div>
                
                <div class="relative z-10">
                    <form action="{{ route('login') }}" class="space-y-md" method="POST">
                        @csrf
                        <div class="space-y-xs">
                        <label class="block font-label-md text-[14px] leading-[20px] font-semibold text-on-surface dark:text-[#EDEDEC]" for="login">Username atau Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-gray-400">person</span>
                            <input class="w-full pl-10 pr-3 py-3 rounded border border-outline-variant dark:border-[#3E3E3A] bg-surface-container-lowest dark:bg-[#111111] focus:border-primary dark:focus:border-white focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600" 
                                id="login" name="login" placeholder="Masukkan username/email" type="text" value="{{ old('login') }}" required autofocus/>
                        </div>
                    </div>
                    
                    <div class="space-y-xs">
                        <div class="flex justify-between items-center">
                            <label class="block font-label-md text-[14px] leading-[20px] font-semibold text-on-surface dark:text-[#EDEDEC]" for="password">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="font-label-sm text-xs text-primary dark:text-[#FF8F42] hover:underline font-semibold">Lupa Password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-gray-400">lock</span>
                            <input class="w-full pl-10 pr-10 py-3 rounded border border-outline-variant dark:border-[#3E3E3A] bg-surface-container-lowest dark:bg-[#111111] focus:border-primary dark:focus:border-white focus:ring-1 focus:ring-primary outline-none transition-colors font-body-md text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600" 
                                id="password" name="password" placeholder="••••••••" type="password" required/>
                        </div>
                    </div>
                    
                    <div class="flex items-center pt-2">
                        <input class="h-4 w-4 rounded border-outline-variant dark:border-[#3E3E3A] text-primary focus:ring-primary bg-surface-container-lowest dark:bg-[#111111]" 
                            id="remember_me" name="remember" type="checkbox" />
                        <label class="ml-2 block font-body-md text-sm text-on-surface-variant dark:text-gray-400" for="remember_me">
                            Ingat saya
                        </label>
                    </div>

                    <div class="pt-sm">
                        <button class="w-full bg-primary dark:bg-white text-on-primary dark:text-black hover:bg-primary-container dark:hover:bg-gray-200 font-label-md text-[14px] leading-[20px] font-semibold py-3 px-4 rounded h-[44px] transition-colors active:scale-[0.98] flex items-center justify-center gap-2" type="submit">
                            Masuk Sistem
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('input[type="password"]').forEach((input, idx) => {
        if (input.dataset.pwToggled || (input.parentElement && input.parentElement.querySelector('button[aria-label="Toggle visibility"], button[onclick*="visibility"], span.material-symbols-outlined[style*="FILL"]'))) {
            return;
        }
        input.dataset.pwToggled = "true";
        
        let wrapper = input.parentNode;
        if (!wrapper || !wrapper.classList.contains("relative")) {
            wrapper = document.createElement("div");
            wrapper.className = "relative w-full flex items-center";
            Array.from(input.classList).forEach(cls => {
                if (cls.startsWith("mt-") || cls.startsWith("mb-") || cls.startsWith("my-")) {
                    wrapper.classList.add(cls);
                    input.classList.remove(cls);
                }
            });
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
        }

        const leftIcon = wrapper.querySelector("span.material-symbols-outlined, i");
        if (leftIcon) leftIcon.style.zIndex = "10";

        const btn = document.createElement("button");
        btn.type = "button";
        btn.id = "pw-toggle-" + idx;
        btn.setAttribute("aria-label", "Toggle visibility");
        btn.className = "absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center justify-center w-8 h-8 rounded-full text-on-surface-variant dark:text-gray-400 hover:text-primary dark:hover:text-white hover:bg-on-surface/5 dark:hover:bg-white/10 transition-all z-10";
        btn.innerHTML = '<span class="material-symbols-outlined text-[20px] select-none" style="font-variation-settings:\'FILL\' 0;">visibility</span>';
        wrapper.appendChild(btn);
        
        input.style.paddingRight = "2.75rem";
        
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
