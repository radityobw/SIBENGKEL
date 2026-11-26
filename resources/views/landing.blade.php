@extends('layouts.public')

@section('title', 'SIBENGKEL - Sistem Informasi Bengkel Era Digital')
@section('meta_description', 'SIBENGKEL adalah sistem informasi bengkel terpadu yang memudahkan Anda untuk cek status servis, booking online, dan membeli sparepart.')
@section('meta_keywords', 'sibengkel, sistem informasi bengkel, servis mobil, bengkel terpercaya')

@section('content')
    <style>
        #sibengkel-hero-3d {
            position: relative;
            width: 100%;
            max-width: 440px;
            aspect-ratio: 1 / 1;
            border-radius: 28px;
            background: radial-gradient(circle at 50% 42%, #ffffff 0%, #f1f1f4 72%, #e8e8ed 100%);
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
            cursor: grab;
            user-select: none;
            touch-action: pan-y;
            overflow: hidden;
        }
        .dark #sibengkel-hero-3d {
            background: radial-gradient(ellipse 74% 72% at 50% 48%, #43444f 0%, #202128 42%, #0d0d11 76%, #050506 100%);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.48);
        }
        #sibengkel-hero-3d:active { cursor: grabbing; }
        #sibengkel-hero-canvas {
            position: relative;
            z-index: 2;
            width: 100%;
            height: 100%;
            display: block;
            opacity: 0;
            transition: opacity 0.45s ease;
        }
        #sibengkel-hero-3d.is-ready #sibengkel-hero-canvas { opacity: 1; }
        #sibengkel-hero-3d .hero-3d-fallback {
            position: absolute;
            inset: 0;
            margin: auto;
            width: 168px;
            height: 168px;
            object-fit: contain;
            z-index: 1;
        }
        #sibengkel-hero-3d.is-ready .hero-3d-fallback {
            display: none;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <!-- Hero Section -->
    <section class="bg-white dark:bg-black text-[#1d1d1f] dark:text-[#f5f5f7] py-16 lg:py-24 px-margin-mobile md:px-margin-desktop flex-grow flex items-center md:min-h-[calc(100vh-56px)]" id="home">
        <div class="max-w-screen-xl w-full mx-auto grid grid-cols-1 lg:grid-cols-12 items-center gap-12 lg:gap-16">
            <div class="lg:col-span-7 min-w-0 space-y-6 flex flex-col items-center lg:items-start text-center lg:text-left">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#ff6b00]">
                    Sistem Informasi Bengkel Era Digital
                </p>
                <h1 class="text-4xl sm:text-5xl lg:text-[3.75rem] lg:leading-[1.06] font-bold tracking-[-0.035em] text-[#1d1d1f] dark:text-white">
                    Transformasi Servis <span class="text-[#ff6b00]">Kendaraan</span> Anda
                </h1>
                <p class="text-lg text-[#6e6e73] dark:text-[#a1a1a6] max-w-xl leading-relaxed">
                    Kelola jadwal servis, pantau status pengerjaan secara real-time, dan akses riwayat perawatan kendaraan Anda dalam satu aplikasi terpadu.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 pt-2 justify-center lg:justify-start">
                    <a href="{{ Auth::guard('customer')->check() ? route('public.dashboard') : route('public.login') }}" class="bg-[#ff6b00] hover:bg-[#e55f00] text-white font-semibold text-sm h-12 px-7 rounded-full inline-flex items-center justify-center gap-2 transition-colors">
                        <span>Portal Pelanggan</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                    <a href="{{ url('/cek-status') }}" class="bg-black/[0.04] dark:bg-white/[0.08] hover:bg-black/[0.08] dark:hover:bg-white/[0.14] text-[#1d1d1f] dark:text-[#f5f5f7] border border-black/[0.08] dark:border-white/[0.12] font-medium text-sm h-12 px-7 rounded-full inline-flex items-center justify-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                        Cek Status Servis
                    </a>
                </div>
                <div class="pt-3 flex flex-wrap justify-center lg:justify-start items-center gap-5 text-[#6e6e73] dark:text-[#86868b] text-xs font-medium">
                    <span class="inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#30d158]"></span> Terpercaya</span>
                    <span class="inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#30d158]"></span> Transparan</span>
                    <span class="inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-[#30d158]"></span> Profesional</span>
                </div>
            </div>

            <div class="lg:col-span-5 flex justify-center w-full">
                <div id="sibengkel-hero-3d" data-model="{{ asset('models/sibengkel.glb') }}" aria-label="Model 3D Emblem SIBENGKEL">
                    <div class="pointer-events-none absolute top-5 left-5 right-5 flex justify-between items-center z-10 text-xs font-medium text-[#6e6e73] dark:text-[#86868b]">
                        <span class="px-3 py-1 rounded-full bg-white/80 dark:bg-white/[0.08] border border-black/[0.06] dark:border-white/[0.1] text-[#1d1d1f] dark:text-[#f5f5f7]">SIBENGKEL 3D</span>
                        <span>Drag to inspect</span>
                    </div>
                    <img src="{{ asset('logobengkel.png') }}" alt="Logo SIBENGKEL" class="hero-3d-fallback" />
                    <canvas id="sibengkel-hero-canvas"></canvas>
                    <div class="pointer-events-none absolute bottom-5 left-5 right-5 flex justify-between z-10 font-mono text-[11px] text-[#6e6e73] dark:text-[#86868b]">
                        <span>sibengkel.glb</span>
                        <span>Workshop emblem</span>
                    </div>
                </div>
            </div>
        </div>
        <script type="importmap">
        {
            "imports": {
                "three": "https://cdn.jsdelivr.net/npm/three@0.170.0/build/three.module.js",
                "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.170.0/examples/jsm/"
            }
        }
        </script>
        <script type="module" src="{{ asset('js/sibengkel-3d.js') }}"></script>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-[#f5f5f7] dark:bg-[#0d0d0e] border-y border-black/[0.06] dark:border-white/[0.08]">
        <div class="max-w-screen-xl mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center" id="stats-container">
                <div class="px-4">
                    <h3 class="text-4xl md:text-5xl font-bold tracking-tight text-[#1d1d1f] dark:text-white mb-2 tabular-nums"><span class="count-up" data-target="{{ $stats['servis_selesai'] }}">0</span>+</h3>
                    <p class="text-[#6e6e73] dark:text-[#86868b] text-sm">Servis Selesai</p>
                </div>
                <div class="px-4">
                    <h3 class="text-4xl md:text-5xl font-bold tracking-tight text-[#1d1d1f] dark:text-white mb-2 tabular-nums"><span class="count-up" data-target="{{ $stats['pelanggan'] }}">0</span>+</h3>
                    <p class="text-[#6e6e73] dark:text-[#86868b] text-sm">Pelanggan Setia</p>
                </div>
                <div class="px-4">
                    <h3 class="text-4xl md:text-5xl font-bold tracking-tight text-[#1d1d1f] dark:text-white mb-2 tabular-nums"><span class="count-up" data-target="{{ $stats['mekanik'] }}">0</span></h3>
                    <p class="text-[#6e6e73] dark:text-[#86868b] text-sm">Mekanik Ahli</p>
                </div>
                <div class="px-4">
                    <h3 class="text-4xl md:text-5xl font-bold tracking-tight text-[#1d1d1f] dark:text-white mb-2 tabular-nums"><span class="count-up" data-target="{{ $stats['kepuasan'] }}">0</span>%</h3>
                    <p class="text-[#6e6e73] dark:text-[#86868b] text-sm">Kepuasan Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const animateCountUp = (el) => {
                const target = +el.getAttribute('data-target');
                const duration = 1400;
                const start = performance.now();
                const updateCount = (currentTime) => {
                    const progress = Math.min((currentTime - start) / duration, 1);
                    const easeOut = 1 - Math.pow(1 - progress, 4);
                    el.innerText = progress < 1 ? Math.floor(easeOut * target) : target;
                    if (progress < 1) requestAnimationFrame(updateCount);
                };
                requestAnimationFrame(updateCount);
            };
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.querySelectorAll('.count-up').forEach(animateCountUp);
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.4 });
            const statsContainer = document.getElementById('stats-container');
            if (statsContainer) observer.observe(statsContainer);
        });
    </script>

    <!-- Services Section -->
    <section class="py-24 bg-white dark:bg-black px-margin-mobile md:px-margin-desktop" id="services">
        <div class="max-w-screen-xl mx-auto">
            <div class="max-w-2xl mb-14 space-y-3">
                <p class="text-xs font-semibold uppercase tracking-[0.1em] text-[#ff6b00]">Layanan Utama</p>
                <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-[#1d1d1f] dark:text-white">Solusi Otomotif Terpadu</h2>
                <p class="text-[#6e6e73] dark:text-[#86868b] text-lg">Layanan perbaikan dan perawatan kendaraan dengan standar pengerjaan transparan.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-[#f5f5f7] dark:bg-[#161617] rounded-3xl p-7 border border-black/[0.05] dark:border-white/[0.08]">
                    <div class="w-11 h-11 bg-white dark:bg-[#1d1d1f] text-[#ff6b00] rounded-2xl flex items-center justify-center mb-5 border border-black/[0.06] dark:border-white/[0.08]">
                        <span class="material-symbols-outlined text-2xl">build</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-[#1d1d1f] dark:text-white">Servis Berkala</h3>
                    <p class="text-sm text-[#6e6e73] dark:text-[#86868b] leading-relaxed">Perawatan rutin dengan standar pabrikan untuk menjaga performa optimal kendaraan Anda.</p>
                </div>
                <div class="bg-[#f5f5f7] dark:bg-[#161617] rounded-3xl p-7 border border-black/[0.05] dark:border-white/[0.08]">
                    <div class="w-11 h-11 bg-white dark:bg-[#1d1d1f] text-[#ff6b00] rounded-2xl flex items-center justify-center mb-5 border border-black/[0.06] dark:border-white/[0.08]">
                        <span class="material-symbols-outlined text-2xl">settings</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-[#1d1d1f] dark:text-white">Ganti Suku Cadang</h3>
                    <p class="text-sm text-[#6e6e73] dark:text-[#86868b] leading-relaxed">Penyediaan suku cadang orisinal bergaransi resmi untuk keamanan jangka panjang.</p>
                </div>
                <div class="bg-[#f5f5f7] dark:bg-[#161617] rounded-3xl p-7 border border-black/[0.05] dark:border-white/[0.08]">
                    <div class="w-11 h-11 bg-white dark:bg-[#1d1d1f] text-[#ff6b00] rounded-2xl flex items-center justify-center mb-5 border border-black/[0.06] dark:border-white/[0.08]">
                        <span class="material-symbols-outlined text-2xl">calendar_month</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-[#1d1d1f] dark:text-white">Booking Online</h3>
                    <p class="text-sm text-[#6e6e73] dark:text-[#86868b] leading-relaxed">Sistem penjadwalan teratur untuk menghindari antrean panjang di bengkel.</p>
                </div>
                <div class="bg-[#f5f5f7] dark:bg-[#161617] rounded-3xl p-7 border border-black/[0.05] dark:border-white/[0.08]">
                    <div class="w-11 h-11 bg-white dark:bg-[#1d1d1f] text-[#ff6b00] rounded-2xl flex items-center justify-center mb-5 border border-black/[0.06] dark:border-white/[0.08]">
                        <span class="material-symbols-outlined text-2xl">query_stats</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-[#1d1d1f] dark:text-white">Pantau Status</h3>
                    <p class="text-sm text-[#6e6e73] dark:text-[#86868b] leading-relaxed">Akses real-time untuk melihat progres pengerjaan kendaraan Anda dari mana saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section class="py-24 bg-[#f5f5f7] dark:bg-[#0d0d0e] px-margin-mobile md:px-margin-desktop border-t border-black/[0.06] dark:border-white/[0.08] relative" id="features">
        <div id="alur-servis" class="absolute -top-20"></div>
        <div class="max-w-screen-xl mx-auto">
            <div class="max-w-2xl mb-14 space-y-3">
                <p class="text-xs font-semibold uppercase tracking-[0.1em] text-[#ff6b00]">Cara Kerja</p>
                <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-[#1d1d1f] dark:text-white">Kemudahan Dalam Tiga Langkah</h2>
                <p class="text-[#6e6e73] dark:text-[#86868b] text-lg">Pengalaman servis yang dirancang menjadi praktis, terukur, dan transparan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-[#161617] rounded-3xl p-8 border border-black/[0.05] dark:border-white/[0.08]">
                    <span class="inline-flex w-9 h-9 rounded-full bg-[#f5f5f7] dark:bg-[#1d1d1f] text-[#1d1d1f] dark:text-white items-center justify-center font-semibold text-sm mb-5">01</span>
                    <h3 class="text-xl font-semibold mb-2 text-[#1d1d1f] dark:text-white">Booking Jadwal Servis</h3>
                    <p class="text-sm text-[#6e6e73] dark:text-[#86868b] leading-relaxed">Pilih waktu yang sesuai dengan kesibukan Anda melalui portal pelanggan tanpa perlu menelepon.</p>
                </div>
                <div class="bg-white dark:bg-[#161617] rounded-3xl p-8 border border-black/[0.05] dark:border-white/[0.08]">
                    <span class="inline-flex w-9 h-9 rounded-full bg-[#ff6b00] text-white items-center justify-center font-semibold text-sm mb-5">02</span>
                    <h3 class="text-xl font-semibold mb-2 text-[#1d1d1f] dark:text-white">Pantau Pengerjaan</h3>
                    <p class="text-sm text-[#6e6e73] dark:text-[#86868b] leading-relaxed">Kendaraan dikerjakan oleh mekanik ahli dan status pengerjaannya dapat dipantau langsung secara real-time.</p>
                </div>
                <div class="bg-white dark:bg-[#161617] rounded-3xl p-8 border border-black/[0.05] dark:border-white/[0.08]">
                    <span class="inline-flex w-9 h-9 rounded-full bg-[#f5f5f7] dark:bg-[#1d1d1f] text-[#1d1d1f] dark:text-white items-center justify-center font-semibold text-sm mb-5">03</span>
                    <h3 class="text-xl font-semibold mb-2 text-[#1d1d1f] dark:text-white">Selesai &amp; Ambil Kendaraan</h3>
                    <p class="text-sm text-[#6e6e73] dark:text-[#86868b] leading-relaxed">Dapatkan notifikasi saat kendaraan siap, dengan riwayat servis dan invoice digital yang tersimpan rapi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sparepart Catalog Section -->
    @if(isset($spareparts) && $spareparts->count() > 0)
    <section class="py-24 bg-white dark:bg-black px-margin-mobile md:px-margin-desktop border-t border-black/[0.06] dark:border-white/[0.08]" id="katalog-sparepart">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
                <div class="max-w-2xl space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-[#ff6b00]">Suku Cadang Asli</p>
                    <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-[#1d1d1f] dark:text-white">Katalog Sparepart</h2>
                    <p class="text-[#6e6e73] dark:text-[#86868b] text-lg">Suku cadang berkualitas untuk kendaraan Anda, tersedia untuk pemesanan langsung via portal.</p>
                </div>
                <a href="{{ Auth::guard('customer')->check() ? route('public.sparepart.index') : route('public.login') }}" class="inline-flex items-center gap-1.5 text-[#0071e3] dark:text-[#ff9447] text-sm font-medium hover:underline shrink-0">
                    <span>Lihat Semua</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach($spareparts as $item)
                    <div class="bg-[#f5f5f7] dark:bg-[#161617] rounded-3xl p-4 border border-black/[0.05] dark:border-white/[0.08] flex flex-col h-full transition-colors">
                        <a href="{{ Auth::guard('customer')->check() ? route('public.sparepart.index') : route('public.login') }}" class="aspect-square bg-white dark:bg-[#0d0d0e] rounded-2xl mb-4 relative overflow-hidden flex items-center justify-center block">
                            @if($item->image_path)
                                <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-5xl text-[#86868b]">construction</span>
                            @endif
                        </a>
                        <div class="flex flex-col flex-grow px-1">
                            <span class="text-[11px] font-semibold text-[#ff6b00] uppercase tracking-wider mb-1">{{ $item->category }}</span>
                            <a href="{{ Auth::guard('customer')->check() ? route('public.sparepart.index') : route('public.login') }}" class="font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] line-clamp-2 mb-3 flex-grow hover:text-[#ff6b00] transition-colors">
                                {{ $item->name }}
                            </a>
                            <div class="flex items-center justify-between mt-auto pt-2 border-t border-black/[0.06] dark:border-white/[0.08]">
                                <p class="font-semibold text-[#1d1d1f] dark:text-[#f5f5f7] text-sm md:text-base tabular-nums">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                @if(Auth::guard('customer')->check())
                                    <a href="{{ route('public.sparepart.index') }}" class="w-8 h-8 rounded-full bg-white dark:bg-[#1d1d1f] text-[#1d1d1f] dark:text-[#f5f5f7] flex items-center justify-center hover:bg-[#ff6b00] hover:text-white transition-colors" title="Lihat di Katalog">
                                        <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                                    </a>
                                @else
                                    <a href="{{ route('public.login') }}" class="w-8 h-8 rounded-full bg-white dark:bg-[#1d1d1f] text-[#1d1d1f] dark:text-[#f5f5f7] flex items-center justify-center hover:bg-[#ff6b00] hover:text-white transition-colors" title="Masuk untuk Membeli">
                                        <span class="material-symbols-outlined text-[18px]">login</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Testimonials Section -->
    @if(isset($testimonials) && count($testimonials) > 0)
    <section class="py-24 bg-[#f5f5f7] dark:bg-[#0d0d0e] border-t border-black/[0.06] dark:border-white/[0.08] overflow-hidden" id="testimonials">
        <div class="max-w-screen-xl mx-auto px-margin-mobile md:px-margin-desktop mb-12">
            <p class="text-xs font-semibold uppercase tracking-[0.1em] text-[#ff6b00] mb-2">Ulasan Pelanggan</p>
            <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-[#1d1d1f] dark:text-white">Apa Kata Mereka</h2>
        </div>

        <div class="relative w-full">
            <div id="testimonial-scroll" class="flex overflow-x-auto gap-5 px-margin-mobile md:px-margin-desktop pb-6 no-scrollbar w-full">
                @foreach($testimonials as $testimonial)
                <div class="bg-white dark:bg-[#161617] p-7 rounded-3xl border border-black/[0.05] dark:border-white/[0.08] flex flex-col shrink-0 w-[85vw] sm:w-[380px]">
                    <div class="flex gap-1 text-[#ff6b00] mb-5">
                        @for($i = 0; $i < 5; $i++)
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' {{ $i < $testimonial->rating ? '1' : '0' }};">star</span>
                        @endfor
                    </div>
                    <p class="text-[#424245] dark:text-[#a1a1a6] text-sm leading-relaxed mb-7 flex-grow whitespace-normal">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center gap-3 mt-auto">
                        <div class="w-10 h-10 bg-[#f5f5f7] dark:bg-[#1d1d1f] rounded-full flex items-center justify-center text-[#1d1d1f] dark:text-white text-xs font-semibold shrink-0 overflow-hidden border border-black/[0.06] dark:border-white/[0.1]">
                            @if(optional($testimonial->customer)->profile_photo_url)
                                <img src="{{ $testimonial->customer->profile_photo_url }}" class="w-full h-full object-cover" alt="{{ $testimonial->customer_name }}">
                            @else
                                {{ strtoupper(substr($testimonial->customer_name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-sm text-[#1d1d1f] dark:text-[#f5f5f7] truncate">{{ $testimonial->customer ? $testimonial->customer->name : $testimonial->customer_name }}</p>
                            @if($testimonial->vehicle)
                                <p class="text-xs text-[#6e6e73] dark:text-[#86868b] truncate">{{ $testimonial->vehicle }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach($testimonials as $testimonial)
                <div class="bg-white dark:bg-[#161617] p-7 rounded-3xl border border-black/[0.05] dark:border-white/[0.08] flex flex-col shrink-0 w-[85vw] sm:w-[380px]" aria-hidden="true">
                    <div class="flex gap-1 text-[#ff6b00] mb-5">
                        @for($i = 0; $i < 5; $i++)
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' {{ $i < $testimonial->rating ? '1' : '0' }};">star</span>
                        @endfor
                    </div>
                    <p class="text-[#424245] dark:text-[#a1a1a6] text-sm leading-relaxed mb-7 flex-grow whitespace-normal">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center gap-3 mt-auto">
                        <div class="w-10 h-10 bg-[#f5f5f7] dark:bg-[#1d1d1f] rounded-full flex items-center justify-center text-[#1d1d1f] dark:text-white text-xs font-semibold shrink-0 overflow-hidden border border-black/[0.06] dark:border-white/[0.1]">
                            @if(optional($testimonial->customer)->profile_photo_url)
                                <img src="{{ $testimonial->customer->profile_photo_url }}" class="w-full h-full object-cover" alt="{{ $testimonial->customer_name }}">
                            @else
                                {{ strtoupper(substr($testimonial->customer_name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-sm text-[#1d1d1f] dark:text-[#f5f5f7] truncate">{{ $testimonial->customer ? $testimonial->customer->name : $testimonial->customer_name }}</p>
                            @if($testimonial->vehicle)
                                <p class="text-xs text-[#6e6e73] dark:text-[#86868b] truncate">{{ $testimonial->vehicle }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const scrollContainer = document.getElementById('testimonial-scroll');
                if(!scrollContainer) return;
                let isHovered = false;
                let isDown = false;
                let startX;
                let scrollLeft;
                let scrollPos = 0;

                scrollContainer.addEventListener('mouseenter', () => isHovered = true);
                scrollContainer.addEventListener('mouseleave', () => {
                    isHovered = false;
                    isDown = false;
                });
                scrollContainer.addEventListener('touchstart', () => isHovered = true);
                scrollContainer.addEventListener('touchend', () => {
                    setTimeout(() => isHovered = false, 2000);
                });
                scrollContainer.addEventListener('mousedown', (e) => {
                    isDown = true;
                    isHovered = true;
                    startX = e.pageX - scrollContainer.offsetLeft;
                    scrollLeft = scrollContainer.scrollLeft;
                });
                scrollContainer.addEventListener('mouseup', () => {
                    isDown = false;
                    isHovered = false;
                });
                scrollContainer.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - scrollContainer.offsetLeft;
                    scrollContainer.scrollLeft = scrollLeft - (x - startX) * 1.5;
                    scrollPos = scrollContainer.scrollLeft;
                });

                const getHalfWidth = () => scrollContainer.scrollWidth / 2;
                const step = () => {
                    const half = getHalfWidth();
                    if (!isHovered && half > 0) {
                        scrollPos += 0.55;
                        if (scrollPos >= half) scrollPos = 0;
                        scrollContainer.scrollLeft = scrollPos;
                    } else if (half > 0) {
                        scrollPos = scrollContainer.scrollLeft % half;
                    }
                    requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            });
        </script>
    </section>
    @endif

    <!-- Final CTA Section -->
    <section class="py-24 bg-white dark:bg-black border-t border-black/[0.06] dark:border-white/[0.08]">
        <div class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop text-center">
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-[#1d1d1f] dark:text-white mb-4">Siap Merawat Kendaraan Anda?</h2>
            <p class="text-lg text-[#6e6e73] dark:text-[#86868b] mb-8 leading-relaxed">Daftar sekarang untuk menjadwalkan servis, memantau progres pengerjaan, dan mengakses riwayat kendaraan secara transparan.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('public.register') }}" class="bg-[#ff6b00] hover:bg-[#e55f00] text-white font-semibold text-sm h-12 px-8 rounded-full inline-flex items-center justify-center transition-colors">
                    Daftar Sekarang
                </a>
                <a href="{{ route('public.login') }}" class="bg-black/[0.04] dark:bg-white/[0.08] hover:bg-black/[0.08] dark:hover:bg-white/[0.14] text-[#1d1d1f] dark:text-[#f5f5f7] border border-black/[0.08] dark:border-white/[0.12] font-medium text-sm h-12 px-8 rounded-full inline-flex items-center justify-center transition-colors">
                    Masuk Portal
                </a>
            </div>
        </div>
    </section>

@endsection
