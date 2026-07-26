<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'SIBENGKEL - Sistem Informasi Bengkel Era Digital')</title>
    <meta name="title" content="@yield('title', 'SIBENGKEL - Sistem Informasi Bengkel Era Digital')">
    <meta name="description" content="@yield('meta_description', 'Kelola jadwal servis, pantau status pengerjaan secara real-time, dan akses riwayat perawatan kendaraan Anda dalam satu aplikasi canggih.')">
    <meta name="keywords" content="@yield('meta_keywords', 'sibengkel, sistem informasi bengkel, servis mobil, bengkel terpercaya')">
    <meta name="author" content="SIBENGKEL">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SIBENGKEL - Sistem Informasi Bengkel Era Digital')">
    <meta property="og:description" content="@yield('meta_description', 'Kelola jadwal servis, pantau status pengerjaan secara real-time, dan akses riwayat perawatan kendaraan Anda dalam satu aplikasi canggih.')">
    <meta property="og:image" content="{{ asset('logobengkel.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'SIBENGKEL - Sistem Informasi Bengkel Era Digital')">
    <meta property="twitter:description" content="@yield('meta_description', 'Kelola jadwal servis, pantau status pengerjaan secara real-time, dan akses riwayat perawatan kendaraan Anda dalam satu aplikasi canggih.')">
    <meta property="twitter:image" content="{{ asset('logobengkel.png') }}">
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
        html.theme-transitioning::view-transition-old(root),
        html.theme-transitioning::view-transition-new(root) {
            animation: none;
            mix-blend-mode: normal;
        }
        html.theme-transitioning::view-transition-old(root) { z-index: 1; }
        html.theme-transitioning::view-transition-new(root) { z-index: 2; }
    </style>
    <script>
        // Landing & Public pages default to Dark Mode
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
        
        function toggleTheme(event) {
            const doToggle = () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            };

            if (!document.startViewTransition || !event) {
                doToggle();
                return;
            }

            let x = window.innerWidth / 2;
            let y = window.innerHeight / 2;
            if (event) {
                if (event.clientX !== undefined && event.clientY !== undefined && (event.clientX !== 0 || event.clientY !== 0)) {
                    x = event.clientX;
                    y = event.clientY;
                } else if (event.touches && event.touches.length > 0) {
                    x = event.touches[0].clientX;
                    y = event.touches[0].clientY;
                } else {
                    const btn = event.currentTarget || (event.target && event.target.closest ? event.target.closest('button') : event.target);
                    if (btn) {
                        const rect = btn.getBoundingClientRect();
                        x = rect.left + rect.width / 2;
                        y = rect.top + rect.height / 2;
                    }
                }
            }
            const w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
            const h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
            const endRadius = Math.hypot(Math.max(x, w - x), Math.max(y, h - y));

            document.documentElement.classList.add('theme-transitioning');
            const transition = document.startViewTransition(doToggle);
            transition.ready.then(() => {
                document.documentElement.animate(
                    {
                        clipPath: [
                            `circle(0px at ${x}px ${y}px)`,
                            `circle(${endRadius}px at ${x}px ${y}px)`
                        ],
                    },
                    {
                        duration: 500,
                        easing: 'ease-in-out',
                        pseudoElement: '::view-transition-new(root)',
                    }
                );
            });
            transition.finished.finally(() => {
                document.documentElement.classList.remove('theme-transitioning');
            });
        }
    </script>
</head>
<body class="bg-background dark:bg-[#0a0a0a] text-on-background dark:text-[#EDEDEC] font-body-md antialiased min-h-screen flex flex-col transition-colors duration-300">
    <!-- TopNavBar Component -->
    <nav class="flex justify-between items-center w-full px-4 md:px-margin-desktop py-3 md:py-4 sticky top-0 z-50 bg-white/70 dark:bg-[#0a0a0a]/75 backdrop-blur-xl border-b border-white/50 dark:border-white/10 shadow-sm text-black dark:text-[#EDEDEC] transition-all duration-300">
        <a href="{{ url('/') }}" class="font-headline-md text-lg md:text-headline-md tracking-tighter flex items-center gap-1.5 md:gap-2 hover:opacity-90 text-black dark:text-[#EDEDEC]">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-6 md:h-8 object-contain brightness-0 dark:invert"> SIBENGKEL
        </a>
        <div class="hidden md:flex gap-6 items-center">
            <a class="nav-link font-bold text-black dark:text-white hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#home') }}">Home</a>
            <a class="nav-link {{ request()->routeIs('public.status.*') ? 'font-bold text-black dark:text-white' : 'text-gray-700 dark:text-[#EDEDEC]/80' }} hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ route('public.status.index') }}">Cek Status</a>
            <a class="nav-link text-gray-700 dark:text-[#EDEDEC]/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#services') }}">Services</a>
            <a class="nav-link text-gray-700 dark:text-[#EDEDEC]/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#features') }}">Features</a>
            <a class="nav-link text-gray-700 dark:text-[#EDEDEC]/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#katalog-sparepart') }}">Katalog Sparepart</a>
            <a class="nav-link text-gray-700 dark:text-[#EDEDEC]/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ url('/#testimonials') }}">Testimonial</a>
            <a class="nav-link text-gray-700 dark:text-[#EDEDEC]/80 hover:text-secondary transition-colors font-body-md text-body-md pb-1 active:scale-95 duration-200" href="{{ route('contact.index') }}">Contact Us</a>
        </div>
        <div class="flex gap-2 md:gap-4 items-center">
            <!-- Theme Toggle -->
            <button onclick="toggleTheme(event)" class="flex items-center justify-center p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/10 transition-colors focus:outline-none text-black dark:text-[#EDEDEC]" aria-label="Toggle Dark Mode">
                <span class="material-symbols-outlined text-[20px] dark:hidden">dark_mode</span>
                <span class="material-symbols-outlined text-[20px] hidden dark:block">light_mode</span>
            </button>
            
            @if(Auth::guard('customer')->check())
                <a href="{{ route('public.dashboard') }}" class="bg-primary dark:bg-secondary text-white dark:text-white hover:bg-primary/90 dark:hover:bg-secondary/90 transition-colors font-label-md text-xs md:text-label-md h-[36px] md:h-[44px] px-3 md:px-6 rounded shadow-sm border border-transparent flex items-center justify-center font-bold">Portal Saya</a>
            @elseif(Auth::guard('web')->check())
                <a href="{{ route('dashboard') }}" class="bg-primary dark:bg-secondary text-white dark:text-white hover:bg-primary/90 dark:hover:bg-secondary/90 transition-colors font-label-md text-xs md:text-label-md h-[36px] md:h-[44px] px-3 md:px-6 rounded shadow-sm border border-transparent flex items-center justify-center font-bold">Dashboard Staff</a>
            @else
                <a href="{{ route('public.login') }}" class="text-on-surface dark:text-[#EDEDEC] hover:text-secondary dark:hover:text-secondary transition-colors font-label-md text-sm md:text-label-md h-[36px] md:h-[44px] px-2 md:px-4 rounded flex items-center justify-center hidden sm:flex font-bold">Login</a>
                <a href="{{ route('public.register') }}" class="bg-secondary text-white dark:bg-secondary dark:text-white hover:bg-[#e05d14] dark:hover:bg-[#e05d14] transition-colors font-label-md text-xs md:text-label-md h-[36px] md:h-[44px] px-3 md:px-6 rounded shadow-sm border border-transparent flex items-center justify-center font-bold">Get Started</a>
            @endif
        </div>
    </nav>

    <main class="flex-1 flex flex-col w-full min-w-0">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <footer id="contact-us" class="flex flex-col md:flex-row justify-between items-center w-full px-margin-desktop py-12 gap-6 bg-[#1b1b18] dark:bg-black border-t border-gray-800 dark:border-[#3E3E3A]/20 mt-auto text-white">
        <div class="font-headline-md text-headline-md text-white flex items-center gap-2">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-6 opacity-80 filter invert brightness-0"> SIBENGKEL
        </div>
        <div class="flex flex-wrap gap-4 justify-center">
            <a class="font-label-sm text-label-sm text-white/80 hover:text-secondary transition-colors cursor-pointer" href="{{ route('public.page', 'privacy-policy') }}">Privacy Policy</a>
            <a class="font-label-sm text-label-sm text-white/80 hover:text-secondary transition-colors cursor-pointer" href="{{ route('public.page', 'terms-of-service') }}">Terms of Service</a>
            <a class="font-label-sm text-label-sm text-white/80 hover:text-secondary transition-colors cursor-pointer" href="{{ route('contact.index') }}">Contact Us</a>
            <a class="font-label-sm text-label-sm text-white/80 hover:text-secondary transition-colors cursor-pointer" href="{{ route('public.page', 'support') }}">Support</a>
            @if(!Auth::guard('web')->check())
                <a class="font-label-sm text-label-sm text-white/80 hover:text-secondary transition-colors cursor-pointer ml-4 border-l border-white/30 pl-4" href="{{ route('login') }}">Staff Login</a>
            @endif
        </div>
        <div class="font-label-sm text-label-sm text-white/80">
            © {{ date('Y') }} SIBENGKEL Industrial Systems. All rights reserved.
        </div>
    </footer>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('input[type="password"]').forEach((input, idx) => {
        if (input.dataset.pwToggled || (input.parentElement && input.parentElement.querySelector('button[aria-label="Toggle visibility"], button[onclick*="visibility"], span.material-symbols-outlined[style*="FILL"]'))) {
            return;
        }
        input.dataset.pwToggled = "true";
        
        const wrapper = document.createElement("div");
        wrapper.className = "relative w-full flex items-center";
        
        Array.from(input.classList).forEach(cls => {
            if (cls.startsWith("mt-") || cls.startsWith("mb-") || cls.startsWith("my-")) {
                wrapper.classList.add(cls);
                input.classList.remove(cls);
            }
        });

        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

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

    // Scrollspy for navbar
    if (window.location.pathname === '/') {
        const sections = document.querySelectorAll("section[id]");
        const navLinks = document.querySelectorAll(".nav-link");
        
        window.addEventListener("scroll", () => {
            let current = "home";
            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                if (scrollY >= sectionTop - 200) {
                    current = section.getAttribute("id");
                }
            });

            if (scrollY < 100) {
                current = "home";
            }

            navLinks.forEach((link) => {
                const href = link.getAttribute("href");
                if (href && href.includes("#")) {
                    link.classList.remove("font-bold", "text-black", "dark:text-white");
                    link.classList.add("text-gray-700", "dark:text-[#EDEDEC]/80");
                    if (href.includes("#" + current)) {
                        link.classList.add("font-bold", "text-black", "dark:text-white");
                        link.classList.remove("text-gray-700", "dark:text-[#EDEDEC]/80");
                    }
                }
            });
        });
    }
});
</script>
    @if(session('confetti'))
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var end = Date.now() + (2 * 1000);
                var colors = ['#f26b21', '#f97316', '#ffffff'];
                (function frame() {
                    confetti({ particleCount: 3, angle: 60, spread: 55, origin: { x: 0 }, colors: colors, zIndex: 100000 });
                    confetti({ particleCount: 3, angle: 120, spread: 55, origin: { x: 1 }, colors: colors, zIndex: 100000 });
                    if (Date.now() < end) requestAnimationFrame(frame);
                }());
            });
        </script>
    @endif
</body>
</html>
