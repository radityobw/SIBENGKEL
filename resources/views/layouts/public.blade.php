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
    </style>
</head>
<body class="bg-background text-on-background font-body-md antialiased min-h-screen flex flex-col">
    <!-- TopNavBar Component -->
    <nav class="flex justify-between items-center w-full px-margin-desktop py-4 sticky top-0 z-50 bg-primary/95 backdrop-blur-md border-b border-primary/50 text-on-primary">
        <a href="{{ url('/') }}" class="font-headline-md text-headline-md tracking-tighter flex items-center gap-2 hover:opacity-90">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-8"> SIBENGKEL
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
        <div class="flex gap-4 items-center">
            @if(Auth::guard('customer')->check())
                <a href="{{ route('public.dashboard') }}" class="bg-white text-primary hover:bg-secondary hover:text-on-secondary transition-colors font-label-md text-label-md h-[44px] px-6 rounded shadow-sm border border-transparent flex items-center justify-center">Portal Saya</a>
            @elseif(Auth::guard('web')->check())
                <a href="{{ route('dashboard') }}" class="bg-white text-primary hover:bg-secondary hover:text-on-secondary transition-colors font-label-md text-label-md h-[44px] px-6 rounded shadow-sm border border-transparent flex items-center justify-center">Dashboard Staff</a>
            @else
                <a href="{{ route('public.login') }}" class="hover:text-secondary transition-colors font-label-md text-label-md h-[44px] px-4 rounded flex items-center justify-center">Login</a>
                <a href="{{ route('public.register') }}" class="bg-secondary text-on-secondary hover:bg-white hover:text-primary transition-colors font-label-md text-label-md h-[44px] px-6 rounded shadow-sm border border-transparent flex items-center justify-center">Get Started</a>
            @endif
        </div>
    </nav>

    @yield('content')

    <!-- Footer Component -->
    <footer id="contact-us" class="flex flex-col md:flex-row justify-between items-center w-full px-margin-desktop py-12 gap-6 bg-primary border-t border-outline-variant/20 mt-auto">
        <div class="font-headline-md text-headline-md text-on-primary flex items-center gap-2">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-6 opacity-80"> SIBENGKEL
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
