<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'SIBENGKEL')</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html { scroll-behavior: smooth; }
        .industrial-grid {
            background-image: linear-gradient(to right, #E2E8F0 1px, transparent 1px), linear-gradient(to bottom, #E2E8F0 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .dark .industrial-grid {
            background-image: linear-gradient(to right, #3E3E3A 1px, transparent 1px), linear-gradient(to bottom, #3E3E3A 1px, transparent 1px);
        }
    </style>
    <script>
        // Dark mode setup
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</head>
<body class="bg-background dark:bg-[#0a0a0a] text-on-background dark:text-[#EDEDEC] font-body-md antialiased min-h-screen flex flex-col transition-colors duration-300">
    <!-- TopNavBar Component -->
    <nav class="flex justify-between items-center w-full px-4 md:px-margin-desktop py-3 md:py-4 sticky top-0 z-50 bg-primary/95 dark:bg-[#0a0a0a]/95 backdrop-blur-md border-b border-primary/50 dark:border-[#3E3E3A]/50 text-on-primary dark:text-[#EDEDEC]">
        <a href="{{ url('/') }}" class="font-headline-md text-lg md:text-headline-md tracking-tighter flex items-center gap-1.5 md:gap-2 hover:opacity-90">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-6 md:h-8 filter invert brightness-0"> SIBENGKEL
        </a>
        <div class="hidden md:flex gap-6 items-center">
            <a class="nav-link {{ request()->is('/') ? 'font-bold text-on-primary' : 'text-on-primary/80' }} hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#home') }}">Home</a>
            <a class="nav-link {{ request()->routeIs('public.status.*') ? 'font-bold text-on-primary' : 'text-on-primary/80' }} hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ route('public.status.index') }}">Cek Status</a>
            <a class="nav-link text-on-primary/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#services') }}">Services</a>
            <a class="nav-link text-on-primary/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#features') }}">Features</a>
            <a class="nav-link text-on-primary/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#katalog-sparepart') }}">Katalog Sparepart</a>
            <a class="nav-link text-on-primary/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#testimonials') }}">Testimonial</a>
            <a class="nav-link text-on-primary/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ route('contact.index') }}">Contact Us</a>
        </div>
        <div class="flex gap-2 md:gap-4 items-center">
            <!-- Theme Toggle -->
            <button onclick="toggleTheme()" class="flex items-center justify-center p-2 rounded-full hover:bg-white/10 dark:hover:bg-white/5 transition-colors focus:outline-none" aria-label="Toggle Dark Mode">
                <span class="material-symbols-outlined text-[20px] dark:hidden">dark_mode</span>
                <span class="material-symbols-outlined text-[20px] hidden dark:block">light_mode</span>
            </button>
            
            @if(Auth::guard('customer')->check())
                <a href="{{ route('public.dashboard') }}" class="bg-white dark:bg-[#161615] text-primary dark:text-[#EDEDEC] hover:bg-secondary hover:text-on-secondary transition-colors font-label-md text-xs md:text-label-md h-[36px] md:h-[44px] px-3 md:px-6 rounded shadow-sm border border-transparent dark:border-[#3E3E3A] flex items-center justify-center">Portal Saya</a>
            @elseif(Auth::guard('web')->check())
                <a href="{{ route('dashboard') }}" class="bg-white dark:bg-[#161615] text-primary dark:text-[#EDEDEC] hover:bg-secondary hover:text-on-secondary transition-colors font-label-md text-xs md:text-label-md h-[36px] md:h-[44px] px-3 md:px-6 rounded shadow-sm border border-transparent dark:border-[#3E3E3A] flex items-center justify-center">Dashboard Staff</a>
            @else
                <a href="{{ route('public.login') }}" class="hover:text-secondary transition-colors font-label-md text-sm md:text-label-md h-[36px] md:h-[44px] px-2 md:px-4 rounded flex items-center justify-center hidden sm:flex">Login</a>
                <a href="{{ route('public.register') }}" class="bg-secondary text-on-secondary hover:bg-white dark:hover:bg-[#161615] hover:text-primary dark:hover:text-[#EDEDEC] dark:hover:border-[#3E3E3A] transition-colors font-label-md text-xs md:text-label-md h-[36px] md:h-[44px] px-3 md:px-6 rounded shadow-sm border border-transparent flex items-center justify-center">Get Started</a>
            @endif
        </div>
    </nav>

    @yield('content')

    <!-- Footer Component -->
    <footer id="contact-us" class="flex flex-col md:flex-row justify-between items-center w-full px-margin-desktop py-12 gap-6 bg-primary dark:bg-black border-t border-outline-variant/20 dark:border-[#3E3E3A]/20 mt-auto">
        <div class="font-headline-md text-headline-md text-on-primary flex items-center gap-2">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-6 opacity-80 filter invert brightness-0"> SIBENGKEL
        </div>
        <div class="flex flex-wrap gap-4 justify-center">
            <a class="font-label-sm text-label-sm text-on-primary/80 hover:text-secondary-fixed transition-colors cursor-pointer" href="{{ route('public.page', 'privacy-policy') }}">Privacy Policy</a>
            <a class="font-label-sm text-label-sm text-on-primary/80 hover:text-secondary-fixed transition-colors cursor-pointer" href="{{ route('public.page', 'terms-of-service') }}">Terms of Service</a>
            <a class="font-label-sm text-label-sm text-on-primary/80 hover:text-secondary-fixed transition-colors cursor-pointer" href="{{ route('contact.index') }}">Contact Us</a>
            <a class="font-label-sm text-label-sm text-on-primary/80 hover:text-secondary-fixed transition-colors cursor-pointer" href="{{ route('public.page', 'support') }}">Support</a>
            @if(!Auth::guard('web')->check())
                <a class="font-label-sm text-label-sm text-on-primary/80 hover:text-secondary-fixed transition-colors cursor-pointer ml-4 border-l border-on-primary/30 pl-4" href="{{ route('login') }}">Staff Login</a>
            @endif
        </div>
        <div class="font-label-sm text-label-sm text-on-primary/80">
            © {{ date('Y') }} SIBENGKEL Industrial Systems. All rights reserved.
        </div>
    </footer>
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
