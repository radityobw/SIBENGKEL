@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-surface dark:bg-[#0a0a0a] text-on-surface dark:text-[#EDEDEC] py-20 lg:py-32 px-margin-mobile md:px-margin-desktop overflow-hidden flex-grow flex items-center md:min-h-[calc(100vh-64px)]" id="home">
        <!-- Interactive Hover Grid Effect -->
        <style>
            .interactive-grid-base {
                position: absolute;
                inset: 0;
                background-image: 
                    linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px);
                background-size: 50px 50px;
                pointer-events: none;
            }
            .dark .interactive-grid-base {
                background-image: 
                    linear-gradient(to right, rgba(255,255,255,0.02) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(255,255,255,0.02) 1px, transparent 1px);
            }
            .interactive-grid-glow {
                position: absolute;
                inset: 0;
                background-image: 
                    linear-gradient(to right, rgba(255,107,0,0.4) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(255,107,0,0.4) 1px, transparent 1px);
                background-size: 50px 50px;
                pointer-events: none;
                mask-image: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), black 0%, transparent 25%);
                -webkit-mask-image: radial-gradient(circle 300px at var(--mouse-x, 50%) var(--mouse-y, 50%), black 0%, transparent 100%);
                opacity: 0;
                transition: opacity 0.5s ease;
            }
            #home:hover .interactive-grid-glow {
                opacity: 1;
            }
        </style>
        <div class="interactive-grid-base"></div>
        <div class="interactive-grid-glow" id="grid-glow"></div>
        
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const homeSection = document.getElementById('home');
                const gridGlow = document.getElementById('grid-glow');
                
                homeSection.addEventListener('mousemove', (e) => {
                    const rect = homeSection.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    gridGlow.style.setProperty('--mouse-x', `${x}px`);
                    gridGlow.style.setProperty('--mouse-y', `${y}px`);
                });
            });
        </script>

        <!-- Abstract Modern Background Elements -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-3xl w-full mx-auto relative z-10 flex flex-col items-center text-center gap-8 md:gap-12">
            <div class="space-y-6 md:space-y-8 relative z-20 flex flex-col items-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/70 dark:bg-[#161615]/70 backdrop-blur-md border border-white/50 dark:border-white/10 shadow-sm text-sm font-semibold text-black dark:text-[#EDEDEC]">
                    <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                    Sistem Manajemen Bengkel Era Digital
                </div>
                <style>
                    .split-char {
                        display: inline-block;
                        opacity: 0;
                        transform: translateY(20px) scale(0.9);
                        animation: split-pop 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards paused;
                    }
                    .split-target.is-visible .split-char {
                        animation-play-state: running;
                    }
                    @keyframes split-pop {
                        to {
                            opacity: 1;
                            transform: translateY(0) scale(1);
                        }
                    }
                </style>
                <h1 class="split-target font-headline-lg-mobile lg:font-headline-xl text-headline-lg-mobile lg:text-[4rem] lg:leading-tight text-on-surface dark:text-[#EDEDEC] font-bold tracking-tight">
                    Transformasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-[#FF8F42]">Servis Kendaraan</span> Anda
                </h1>
                <p class="font-body-lg text-lg lg:text-xl text-on-surface-variant dark:text-gray-400 max-w-lg leading-relaxed mx-auto">
                    Kelola jadwal servis, pantau status pengerjaan secara real-time, dan akses riwayat perawatan kendaraan Anda dalam satu aplikasi canggih.
                </p>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const targets = document.querySelectorAll('.split-target');
                        
                        // 1. Process all nodes to wrap them in .split-char spans
                        targets.forEach(target => {
                            const nodes = Array.from(target.childNodes);
                            target.innerHTML = '';
                            let delay = 0;
                            
                            const processNode = (node, parent) => {
                                if (node.nodeType === Node.TEXT_NODE) {
                                    const words = node.textContent.split(/(\s+)/);
                                    words.forEach(word => {
                                        if (/^\s+$/.test(word)) {
                                            parent.appendChild(document.createTextNode(word));
                                        } else {
                                            const wordSpan = document.createElement('span');
                                            wordSpan.style.display = 'inline-block';
                                            wordSpan.style.whiteSpace = 'nowrap';
                                            const chars = word.split('');
                                            chars.forEach(char => {
                                                const span = document.createElement('span');
                                                span.textContent = char;
                                                span.className = 'split-char';
                                                span.style.animationDelay = `${delay}s`;
                                                wordSpan.appendChild(span);
                                                delay += 0.02;
                                            });
                                            parent.appendChild(wordSpan);
                                        }
                                    });
                                } else if (node.nodeType === Node.ELEMENT_NODE) {
                                    if (node.classList && node.classList.contains('bg-clip-text')) {
                                        const clone = node.cloneNode(true);
                                        clone.classList.add('split-char');
                                        clone.style.animationDelay = `${delay}s`;
                                        parent.appendChild(clone);
                                        delay += 0.3; // Tambah delay lebih besar untuk satu frasa/kata utuh
                                    } else {
                                        const clone = node.cloneNode(false);
                                        parent.appendChild(clone);
                                        Array.from(node.childNodes).forEach(child => processNode(child, clone));
                                    }
                                }
                            };
                            
                            nodes.forEach(node => processNode(node, target));
                        });
                        
                        // 2. Use Intersection Observer to trigger animations
                        const observer = new IntersectionObserver((entries, observer) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    entry.target.classList.add('is-visible');
                                    observer.unobserve(entry.target);
                                }
                            });
                        }, { threshold: 0.2 });
                        
                        targets.forEach(target => observer.observe(target));
                    });
                </script>
                <div class="flex flex-col sm:flex-row gap-4 pt-4 justify-center">
                    <style>
                        .border-glow {
                            position: relative;
                            z-index: 1;
                            overflow: hidden;
                        }
                        .border-glow::before {
                            content: '';
                            position: absolute;
                            top: 50%; left: 50%;
                            width: 300%; height: 300%;
                            background: conic-gradient(transparent, #f26b21, transparent 30%);
                            animation: rotate-glow 3s linear infinite;
                            z-index: -1;
                        }
                        @keyframes rotate-glow {
                            0% { transform: translate(-50%, -50%) rotate(0deg); }
                            100% { transform: translate(-50%, -50%) rotate(360deg); }
                        }
                    </style>
                    <a href="{{ route('public.login') }}" class="border-glow bg-primary text-on-primary hover:text-white transition-all duration-300 font-label-md text-label-md h-14 px-8 rounded-full flex items-center justify-center gap-2 group shadow-lg hover:shadow-primary/25">
                        <span class="absolute inset-[2px] rounded-full bg-primary z-10 transition-colors group-hover:bg-primary/90"></span>
                        <span class="relative z-20 flex items-center gap-2">
                            Portal Pelanggan
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform" style="font-variation-settings: 'FILL' 1;">arrow_forward</span>
                        </span>
                    </a>
                    <a href="{{ url('/cek-status') }}" class="bg-white/70 dark:bg-[#161615]/70 backdrop-blur-md text-on-surface dark:text-[#EDEDEC] hover:bg-white/90 dark:hover:bg-[#3E3E3A] border border-white/50 dark:border-white/10 transition-all duration-300 font-label-md text-label-md h-14 px-8 rounded-full flex items-center justify-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined">search</span>
                        Cek Status Servis
                    </a>
                </div>
                
                <div class="pt-8 flex flex-wrap justify-center items-center gap-4 md:gap-6 text-on-surface-variant dark:text-gray-400 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500">check_circle</span> Terpercaya
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500">check_circle</span> Transparan
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500">check_circle</span> Profesional
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-primary dark:bg-black relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
        <div class="max-w-screen-xl mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-white/10 text-center" id="stats-container">
                <div class="px-4">
                    <h3 class="text-4xl md:text-5xl font-bold text-white font-sora mb-2"><span class="count-up" data-target="{{ $stats['servis_selesai'] }}">0</span>+</h3>
                    <p class="text-white/80 text-sm md:text-base">Servis Selesai</p>
                </div>
                <div class="px-4">
                    <h3 class="text-4xl md:text-5xl font-bold text-white font-sora mb-2"><span class="count-up" data-target="{{ $stats['pelanggan'] }}">0</span>+</h3>
                    <p class="text-white/80 text-sm md:text-base">Pelanggan Setia</p>
                </div>
                <div class="px-4">
                    <h3 class="text-4xl md:text-5xl font-bold text-white font-sora mb-2"><span class="count-up" data-target="{{ $stats['mekanik'] }}">0</span></h3>
                    <p class="text-white/80 text-sm md:text-base">Mekanik Ahli</p>
                </div>
                <div class="px-4">
                    <h3 class="text-4xl md:text-5xl font-bold text-white font-sora mb-2"><span class="count-up" data-target="{{ $stats['kepuasan'] }}">0</span>%</h3>
                    <p class="text-white/80 text-sm md:text-base">Kepuasan Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.count-up');
            const speed = 200; // Semakin kecil semakin lambat, tapi karena pakai requestAnimationFrame kita akan mengatur durasi animasi

            const animateCountUp = (el) => {
                const target = +el.getAttribute('data-target');
                const duration = 2000; // 2 detik
                const start = performance.now();
                
                const updateCount = (currentTime) => {
                    const elapsed = currentTime - start;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    // Ease out quart function
                    const easeOut = 1 - Math.pow(1 - progress, 4);
                    const current = Math.floor(easeOut * target);
                    
                    el.innerText = current;
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateCount);
                    } else {
                        el.innerText = target;
                    }
                };
                
                requestAnimationFrame(updateCount);
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const targets = entry.target.querySelectorAll('.count-up');
                        targets.forEach(animateCountUp);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            const statsContainer = document.getElementById('stats-container');
            if (statsContainer) observer.observe(statsContainer);
        });
    </script>


    <!-- Services Section -->
    <section class="py-24 bg-surface-container-lowest dark:bg-[#0a0a0a] px-margin-mobile md:px-margin-desktop relative" id="services">
        <style>
            .spotlight-card {
                position: relative;
                overflow: hidden;
            }
            .spotlight-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background: radial-gradient(400px circle at var(--x, 0) var(--y, 0), rgba(255, 107, 0, 0.08), transparent 40%);
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s;
                z-index: 0;
            }
            .spotlight-card:hover::before {
                opacity: 1;
            }
            .spotlight-card > * {
                position: relative;
                z-index: 1;
            }
        </style>
        
        <div class="max-w-screen-xl mx-auto relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <h2 class="text-secondary font-semibold tracking-wider uppercase text-sm">Layanan Utama</h2>
                <h3 class="split-target font-headline-lg text-4xl lg:text-5xl font-bold text-on-surface dark:text-[#EDEDEC]">Solusi Otomotif <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-[#FF8F42]">Terpadu</span></h3>
                <p class="text-on-surface-variant dark:text-gray-400 text-lg">Kami menyediakan berbagai layanan perbaikan dan perawatan kendaraan dengan standar industri terdepan.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <div class="spotlight-card bg-white/70 dark:bg-[#161615]/70 backdrop-blur-md rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-white/50 dark:border-white/10 group">
                    <div class="w-16 h-16 bg-primary/10 dark:bg-[#EDEDEC]/10 text-primary dark:text-[#EDEDEC] rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary dark:group-hover:bg-[#EDEDEC] group-hover:text-white dark:group-hover:text-black transition-colors duration-300">
                        <span class="material-symbols-outlined text-3xl">build</span>
                    </div>
                    <h4 class="font-headline-md text-xl font-bold mb-3 dark:text-[#EDEDEC]">Servis Berkala</h4>
                    <p class="text-on-surface-variant dark:text-gray-400 leading-relaxed">Perawatan rutin dengan standar pabrikan untuk menjaga performa optimal kendaraan Anda.</p>
                </div>
                <!-- Card 2 -->
                <div class="spotlight-card bg-white/70 dark:bg-[#161615]/70 backdrop-blur-md rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-white/50 dark:border-white/10 group">
                    <div class="w-16 h-16 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:bg-secondary group-hover:text-white transition-colors duration-300">
                        <span class="material-symbols-outlined text-3xl">settings</span>
                    </div>
                    <h4 class="font-headline-md text-xl font-bold mb-3 dark:text-[#EDEDEC]">Ganti Suku Cadang</h4>
                    <p class="text-on-surface-variant dark:text-gray-400 leading-relaxed">Penyediaan suku cadang orisinal bergaransi resmi untuk keamanan jangka panjang.</p>
                </div>
                <!-- Card 3 -->
                <div class="spotlight-card bg-white/70 dark:bg-[#161615]/70 backdrop-blur-md rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-white/50 dark:border-white/10 group">
                    <div class="w-16 h-16 bg-primary/10 dark:bg-[#EDEDEC]/10 text-primary dark:text-[#EDEDEC] rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary dark:group-hover:bg-[#EDEDEC] group-hover:text-white dark:group-hover:text-black transition-colors duration-300">
                        <span class="material-symbols-outlined text-3xl">calendar_month</span>
                    </div>
                    <h4 class="font-headline-md text-xl font-bold mb-3 dark:text-[#EDEDEC]">Booking Online</h4>
                    <p class="text-on-surface-variant dark:text-gray-400 leading-relaxed">Sistem penjadwalan pintar untuk menghindari antrean panjang di bengkel.</p>
                </div>
                <!-- Card 4 -->
                <div class="spotlight-card bg-white/70 dark:bg-[#161615]/70 backdrop-blur-md rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-white/50 dark:border-white/10 group">
                    <div class="w-16 h-16 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:bg-secondary group-hover:text-white transition-colors duration-300">
                        <span class="material-symbols-outlined text-3xl">query_stats</span>
                    </div>
                    <h4 class="font-headline-md text-xl font-bold mb-3 dark:text-[#EDEDEC]">Pantau Status</h4>
                    <p class="text-on-surface-variant dark:text-gray-400 leading-relaxed">Akses *real-time* untuk melihat progres pengerjaan kendaraan Anda dari mana saja.</p>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const cards = document.querySelectorAll('.spotlight-card');
                cards.forEach(card => {
                    card.addEventListener('mousemove', e => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        card.style.setProperty('--x', `${x}px`);
                        card.style.setProperty('--y', `${y}px`);
                    });
                });
            });
        </script>
    </section>

    <!-- How it Works Section -->
    <section class="py-24 bg-surface dark:bg-[#111111] px-margin-mobile md:px-margin-desktop border-t border-outline-variant/30 dark:border-[#3E3E3A]/30 relative" id="features">
        <div id="alur-servis" class="absolute -top-24"></div>
        <div class="max-w-screen-xl mx-auto">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 space-y-8">
                    <div>
                        <h2 class="text-secondary font-semibold tracking-wider uppercase text-sm mb-4">Cara Kerja</h2>
                        <h3 class="split-target font-headline-lg text-4xl lg:text-5xl font-bold text-on-surface dark:text-[#EDEDEC] mb-6"><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-[#FF8F42]">Kemudahan</span> Dalam Tiga Langkah</h3>
                        <p class="text-on-surface-variant dark:text-gray-400 text-lg">Kami mendesain ulang pengalaman servis Anda menjadi jauh lebih praktis dan transparan.</p>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-full bg-surface-container-highest dark:bg-[#3E3E3A] text-on-surface dark:text-[#EDEDEC] flex items-center justify-center font-bold text-xl shrink-0 shadow-sm">1</div>
                            <div>
                                <h4 class="text-xl font-bold mb-2 dark:text-[#EDEDEC]">Booking Jadwal Servis</h4>
                                <p class="text-on-surface-variant dark:text-gray-400">Pilih waktu yang sesuai dengan kesibukan Anda melalui portal pelanggan kami tanpa perlu menelepon.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-xl shrink-0 shadow-lg shadow-secondary/30">2</div>
                            <div>
                                <h4 class="text-xl font-bold mb-2 dark:text-[#EDEDEC]">Pantau Pengerjaan</h4>
                                <p class="text-on-surface-variant dark:text-gray-400">Kendaraan dikerjakan oleh mekanik ahli. Anda dapat memantau status pengerjaannya secara real-time dari HP Anda.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-full bg-surface-container-high dark:bg-[#161615] border-2 border-outline-variant dark:border-[#EDEDEC] text-on-surface dark:text-[#EDEDEC] flex items-center justify-center font-bold text-xl shrink-0">3</div>
                            <div>
                                <h4 class="text-xl font-bold mb-2 dark:text-[#EDEDEC]">Selesai & Ambil Kendaraan</h4>
                                <p class="text-on-surface-variant dark:text-gray-400">Dapatkan notifikasi instan saat kendaraan siap. Riwayat dan invoice digital otomatis tersimpan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2 w-full">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl h-[500px]">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 hover:scale-105" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBqcFyfSaGZkAhCtijRJkrnP6PUW7V-24XDxsWZXgXekVLt5P1DbMak7qb1FnRHTch5HqA9JrtpbrFB-I8HWTrdgs_IW8uBHKcjpmYl6_DAqtx_bPRobMMLplGCY4MMepnV1ApYOjjIu8cKQCw-kAEWMOUGGJk80w7qvpjYDw-79hG9Stpou345AExteGRoggQax9SZ8K1PyJiIitezCajqNplnm537UTTL1Wgbd7iDLRY1SuNRR-K4Ow');"></div>
                        <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sparepart Catalog Section -->
    @if(isset($spareparts) && $spareparts->count() > 0)
    <section class="py-24 bg-surface-container-lowest dark:bg-[#0a0a0a] px-margin-mobile md:px-margin-desktop border-t border-outline-variant/30 dark:border-[#3E3E3A]/30" id="katalog-sparepart">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-secondary font-semibold tracking-wider uppercase text-sm mb-4">Suku Cadang Asli</h2>
                    <h3 class="split-target font-headline-lg text-4xl lg:text-5xl font-bold text-on-surface dark:text-[#EDEDEC] mb-4">Katalog <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-[#FF8F42]">Sparepart</span></h3>
                    <p class="text-on-surface-variant dark:text-gray-400 text-lg">Temukan suku cadang berkualitas tinggi untuk kendaraan Anda. Bisa dibeli langsung atau melalui pemesanan online.</p>
                </div>
                <a href="{{ route('public.sparepart.index') }}" class="group flex items-center gap-2 text-primary dark:text-[#EDEDEC] font-bold hover:text-primary/80 dark:hover:text-[#EDEDEC]/80 transition-colors shrink-0">
                    Lihat Semua
                    <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($spareparts as $item)
                    <div class="bg-white/70 dark:bg-[#161615]/70 backdrop-blur-md rounded-2xl p-4 shadow-sm border border-white/50 dark:border-white/10 hover:shadow-lg transition-all group flex flex-col h-full relative overflow-hidden">
                        <a href="{{ Auth::guard('customer')->check() ? route('public.sparepart.index') : route('public.login') }}" class="aspect-square bg-surface-container-lowest dark:bg-[#0a0a0a] rounded-xl mb-4 relative overflow-hidden flex items-center justify-center block">
                            @if($item->image_path)
                                <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <span class="material-symbols-outlined text-6xl text-outline-variant dark:text-[#3E3E3A] group-hover:scale-110 transition-transform duration-500">construction</span>
                            @endif
                            <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/5 transition-colors duration-300"></div>
                        </a>
                        <div class="flex flex-col flex-grow">
                            <span class="text-[10px] md:text-xs font-bold text-secondary uppercase tracking-widest mb-1">{{ $item->category }}</span>
                            <a href="{{ Auth::guard('customer')->check() ? route('public.sparepart.index') : route('public.login') }}" class="font-bold text-on-surface dark:text-[#EDEDEC] line-clamp-2 mb-2 flex-grow hover:text-primary transition-colors">
                                {{ $item->name }}
                            </a>
                            <div class="flex items-center justify-between mt-auto pt-2">
                                <p class="font-bold text-primary dark:text-[#FF8F42] text-sm md:text-base">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                @if(Auth::guard('customer')->check())
                                    <a href="{{ route('public.sparepart.index') }}" class="w-8 h-8 rounded-full bg-surface-container-highest dark:bg-[#3E3E3A] text-primary dark:text-[#EDEDEC] flex items-center justify-center hover:bg-primary dark:hover:bg-secondary hover:text-white transition-colors" title="Lihat di Katalog">
                                        <span class="material-symbols-outlined text-[18px] font-bold">add_shopping_cart</span>
                                    </a>
                                @else
                                    <a href="{{ route('public.login') }}" class="w-8 h-8 rounded-full bg-surface-container-highest dark:bg-[#3E3E3A] text-primary dark:text-[#EDEDEC] flex items-center justify-center hover:bg-primary dark:hover:bg-secondary hover:text-white transition-colors" title="Masuk untuk Membeli">
                                        <span class="material-symbols-outlined text-[18px] font-bold">login</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center md:hidden">
                <a href="{{ route('public.sparepart.index') }}" class="inline-flex items-center justify-center gap-2 w-full h-14 bg-surface-container-high dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-full text-on-surface dark:text-[#EDEDEC] font-bold hover:bg-surface-container-highest transition-colors">
                    Lihat Semua Sparepart
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Testimonials (Optional / Skeleton) -->
    @if(isset($testimonials) && count($testimonials) > 0)
    <section class="py-24 bg-surface-container-lowest dark:bg-[#0a0a0a] relative overflow-hidden" id="testimonials">
        <div class="max-w-screen-xl mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-secondary font-semibold tracking-wider uppercase text-sm mb-4">Ulasan Pelanggan</h2>
                <h3 class="split-target font-headline-lg text-4xl font-bold text-on-surface dark:text-[#EDEDEC]">Apa Kata <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-[#FF8F42]">Mereka?</span></h3>
            </div>
        </div>
            
        <!-- Horizontal Scrollable Container (Auto-scroll Ticker) -->
        <div class="relative w-full group">
            <div id="testimonial-scroll" class="flex overflow-x-auto gap-6 px-margin-mobile md:px-margin-desktop pb-8 pt-4 no-scrollbar w-full">
                <!-- Set 1 -->
                @foreach($testimonials as $testimonial)
                <div class="bg-white/70 dark:bg-[#161615]/70 backdrop-blur-md p-8 rounded-3xl shadow-sm hover:shadow-md border border-white/50 dark:border-white/10 relative flex flex-col shrink-0 w-[85vw] sm:w-[400px] transition-shadow">
                    <span class="material-symbols-outlined absolute top-6 right-6 text-5xl text-outline-variant/30 dark:text-outline-variant/10">format_quote</span>
                    <div class="flex gap-1 text-secondary mb-6">
                        @for($i = 0; $i < 5; $i++)
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $i < $testimonial->rating ? '1' : '0' }};">star</span>
                        @endfor
                    </div>
                    <p class="text-on-surface-variant dark:text-gray-400 italic mb-8 relative z-10 flex-grow whitespace-normal">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center gap-4 mt-auto">
                        <div class="w-12 h-12 bg-primary-container rounded-full flex items-center justify-center text-primary font-bold shrink-0 overflow-hidden border border-outline-variant/30 dark:border-[#3E3E3A]">
                            @if(optional($testimonial->customer)->profile_photo_url)
                                <img src="{{ $testimonial->customer->profile_photo_url }}" class="w-full h-full object-cover" alt="{{ $testimonial->customer_name }}">
                            @else
                                {{ strtoupper(substr($testimonial->customer_name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-on-surface dark:text-[#EDEDEC] truncate">{{ $testimonial->customer ? $testimonial->customer->name : $testimonial->customer_name }}</p>
                            @if($testimonial->vehicle)
                                <p class="text-sm text-on-surface-variant dark:text-gray-500 truncate">{{ $testimonial->vehicle }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Set 2 (for seamless infinite loop) -->
                @foreach($testimonials as $testimonial)
                <div class="bg-surface dark:bg-[#161615] p-8 rounded-3xl shadow-sm hover:shadow-md border border-outline-variant dark:border-[#3E3E3A] relative flex flex-col shrink-0 w-[85vw] sm:w-[400px] transition-shadow" aria-hidden="true">
                    <span class="material-symbols-outlined absolute top-6 right-6 text-5xl text-outline-variant/30 dark:text-outline-variant/10">format_quote</span>
                    <div class="flex gap-1 text-secondary mb-6">
                        @for($i = 0; $i < 5; $i++)
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $i < $testimonial->rating ? '1' : '0' }};">star</span>
                        @endfor
                    </div>
                    <p class="text-on-surface-variant dark:text-gray-400 italic mb-8 relative z-10 flex-grow whitespace-normal">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center gap-4 mt-auto">
                        <div class="w-12 h-12 bg-primary-container rounded-full flex items-center justify-center text-primary font-bold shrink-0 overflow-hidden border border-outline-variant/30 dark:border-[#3E3E3A]">
                            @if(optional($testimonial->customer)->profile_photo_url)
                                <img src="{{ $testimonial->customer->profile_photo_url }}" class="w-full h-full object-cover" alt="{{ $testimonial->customer_name }}">
                            @else
                                {{ strtoupper(substr($testimonial->customer_name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-on-surface dark:text-[#EDEDEC] truncate">{{ $testimonial->customer ? $testimonial->customer->name : $testimonial->customer_name }}</p>
                            @if($testimonial->vehicle)
                                <p class="text-sm text-on-surface-variant dark:text-gray-500 truncate">{{ $testimonial->vehicle }}</p>
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
                
                scrollContainer.addEventListener('mouseenter', () => isHovered = true);
                scrollContainer.addEventListener('mouseleave', () => isHovered = false);
                scrollContainer.addEventListener('touchstart', () => isHovered = true);
                scrollContainer.addEventListener('touchend', () => {
                    setTimeout(() => isHovered = false, 2000);
                });

                // Smooth scrolling ticker
                let scrollPos = 0;
                let lastTime = 0;
                
                const step = (time) => {
                    if (!isHovered) {
                        scrollPos += 1; // Kecepatan scroll
                        scrollContainer.scrollLeft = scrollPos;

                        // Reset position for infinite loop effect
                        if (scrollContainer.scrollLeft >= (scrollContainer.scrollWidth - scrollContainer.clientWidth) - 10) {
                            scrollPos = 0;
                            scrollContainer.scrollLeft = 0;
                        }
                    } else {
                        // Jika dihover/dislide manual, sync scrollPos dengan posisi asli agar tidak loncat
                        scrollPos = scrollContainer.scrollLeft;
                    }
                    requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            });
        </script>
    </section>
    @endif

    <!-- Final CTA Section -->
    <section class="py-24 bg-primary dark:bg-black relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://lh3.googleusercontent.com/aida-public/AB6AXuBqcFyfSaGZkAhCtijRJkrnP6PUW7V-24XDxsWZXgXekVLt5P1DbMak7qb1FnRHTch5HqA9JrtpbrFB-I8HWTrdgs_IW8uBHKcjpmYl6_DAqtx_bPRobMMLplGCY4MMepnV1ApYOjjIu8cKQCw-kAEWMOUGGJk80w7qvpjYDw-79hG9Stpou345AExteGRoggQax9SZ8K1PyJiIitezCajqNplnm537UTTL1Wgbd7iDLRY1SuNRR-K4Ow')] bg-cover bg-center mix-blend-overlay opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-primary dark:from-black to-transparent"></div>
        <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop relative z-10 text-center">
            <h2 class="split-target text-4xl md:text-5xl font-bold text-white mb-6 font-sora">Siap Merawat <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-[#FF8F42]">Kendaraan</span> Anda?</h2>
            <p class="text-xl text-white/90 mb-10 leading-relaxed">Bergabunglah dengan ribuan pelanggan lainnya dan rasakan pengalaman servis kendaraan yang modern, transparan, dan tanpa ribet.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('public.register') }}" class="bg-[#FF7A1F] text-white hover:bg-[#FF8F42] hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 font-bold text-lg h-16 px-10 rounded-full shadow-xl shadow-[#FF6B00]/30 flex items-center justify-center gap-2">
                    Daftar Sekarang
                </a>
                <a href="{{ route('public.login') }}" class="bg-transparent border-2 border-white text-white hover:bg-white/10 transition-all font-bold text-lg h-16 px-10 rounded-full flex items-center justify-center">
                    Masuk Portal
                </a>
            </div>
        </div>
    </section>

@endsection
