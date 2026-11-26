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
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" type="image/png" href="{{ asset('favicon-48x48.png') }}" sizes="48x48">
    <link rel="icon" type="image/png" href="{{ asset('favicon-192x192.png') }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}" sizes="180x180">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SIBENGKEL - Sistem Informasi Bengkel Era Digital')">
    <meta property="og:description" content="@yield('meta_description', 'Kelola jadwal servis, pantau status pengerjaan secara real-time, dan akses riwayat perawatan kendaraan Anda dalam satu aplikasi canggih.')">
    <meta property="og:image" content="{{ asset('og-banner.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'SIBENGKEL - Sistem Informasi Bengkel Era Digital')">
    <meta property="twitter:description" content="@yield('meta_description', 'Kelola jadwal servis, pantau status pengerjaan secara real-time, dan akses riwayat perawatan kendaraan Anda dalam satu aplikasi canggih.')">
    <meta property="twitter:image" content="{{ asset('og-banner.png') }}">
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
<body class="bg-white dark:bg-black text-[#1d1d1f] dark:text-[#f5f5f7] font-body-md antialiased min-h-screen flex flex-col transition-colors duration-300">
    <!-- TopNavBar Component -->
    <nav class="flex justify-between items-center w-full h-14 px-4 md:px-margin-desktop sticky top-0 z-50 bg-white/80 dark:bg-black/75 backdrop-blur-xl border-b border-black/[0.08] dark:border-white/[0.1] text-[#1d1d1f] dark:text-[#f5f5f7] transition-colors duration-300">
        <a href="{{ url('/') }}" class="font-semibold text-base tracking-tight flex items-center gap-2 hover:opacity-80 text-[#1d1d1f] dark:text-[#f5f5f7]">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-6 object-contain brightness-0 dark:invert"> SIBENGKEL
        </a>
        <div class="hidden md:flex gap-7 items-center text-sm">
            <a class="nav-link font-medium text-[#1d1d1f] dark:text-white hover:text-[#ff6b00] transition-colors" href="{{ url('/#home') }}">Home</a>
            <a class="nav-link {{ request()->routeIs('public.status.*') ? 'font-semibold text-[#1d1d1f] dark:text-white' : 'text-[#6e6e73] dark:text-[#86868b]' }} hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ route('public.status.index') }}">Cek Status</a>
            <a class="nav-link text-[#6e6e73] dark:text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ url('/#services') }}">Services</a>
            <a class="nav-link text-[#6e6e73] dark:text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ url('/#features') }}">Features</a>
            <a class="nav-link text-[#6e6e73] dark:text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ url('/#katalog-sparepart') }}">Katalog Sparepart</a>
            <a class="nav-link text-[#6e6e73] dark:text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ url('/#testimonials') }}">Testimonial</a>
            <a class="nav-link text-[#6e6e73] dark:text-[#86868b] hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ route('contact.index') }}">Contact Us</a>
        </div>
        <div class="flex gap-2 md:gap-3 items-center">
            <!-- Theme Toggle -->
            <button onclick="toggleTheme(event)" class="flex items-center justify-center p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/10 transition-colors focus:outline-none text-[#1d1d1f] dark:text-[#f5f5f7]" aria-label="Toggle Dark Mode">
                <span class="material-symbols-outlined text-[20px] dark:hidden">dark_mode</span>
                <span class="material-symbols-outlined text-[20px] hidden dark:block">light_mode</span>
            </button>
            
            @if(Auth::guard('customer')->check())
                <a href="{{ route('public.dashboard') }}" class="bg-[#ff6b00] text-white hover:bg-[#e55f00] transition-colors text-xs md:text-sm h-9 px-4 rounded-full flex items-center justify-center font-medium">Portal Saya</a>
            @elseif(Auth::guard('web')->check())
                <a href="{{ route('dashboard') }}" class="bg-[#ff6b00] text-white hover:bg-[#e55f00] transition-colors text-xs md:text-sm h-9 px-4 rounded-full flex items-center justify-center font-medium">Dashboard Staff</a>
            @else
                <a href="{{ route('public.login') }}" class="text-[#1d1d1f] dark:text-[#f5f5f7] hover:text-[#ff6b00] transition-colors text-sm h-9 px-3 rounded-full hidden sm:flex items-center justify-center font-medium">Login</a>
                <a href="{{ route('public.register') }}" class="bg-[#ff6b00] text-white hover:bg-[#e55f00] transition-colors text-xs md:text-sm h-9 px-4 rounded-full flex items-center justify-center font-medium">Get Started</a>
            @endif
        </div>
    </nav>

    <main class="flex-1 flex flex-col w-full min-w-0">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <footer id="contact-us" class="flex flex-col md:flex-row justify-between items-center w-full px-margin-desktop py-10 gap-6 bg-[#f5f5f7] dark:bg-black border-t border-black/[0.08] dark:border-white/[0.1] mt-auto text-[#6e6e73] dark:text-[#86868b]">
        <div class="font-semibold text-sm text-[#1d1d1f] dark:text-[#f5f5f7] flex items-center gap-2">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-5 opacity-80 brightness-0 dark:invert"> SIBENGKEL
        </div>
        <div class="flex flex-wrap gap-5 justify-center text-xs">
            <a class="hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ route('public.page', 'privacy-policy') }}">Privacy Policy</a>
            <a class="hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ route('public.page', 'terms-of-service') }}">Terms of Service</a>
            <a class="hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ route('contact.index') }}">Contact Us</a>
            <a class="hover:text-[#1d1d1f] dark:hover:text-white transition-colors" href="{{ route('public.page', 'support') }}">Support</a>
            @if(!Auth::guard('web')->check())
                <a class="hover:text-[#1d1d1f] dark:hover:text-white transition-colors ml-2 border-l border-black/15 dark:border-white/20 pl-4" href="{{ route('login') }}">Staff Login</a>
            @endif
        </div>
        <div class="text-xs">
            © {{ date('Y') }} SIBENGKEL. All rights reserved.
        </div>
    </footer>
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
