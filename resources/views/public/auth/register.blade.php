<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Daftar Akun - SIBENGKEL</title>
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface dark:bg-[#0a0a0a] text-on-surface dark:text-[#EDEDEC] antialiased min-h-screen transition-colors duration-300">
    <div class="flex min-h-screen w-full relative">
        <!-- Absolute Back Button to Home -->
        <a href="{{ url('/') }}" class="absolute top-4 right-4 lg:right-8 z-50 flex items-center gap-2 font-label-md text-on-surface-variant dark:text-gray-400 hover:text-primary dark:hover:text-white transition-colors px-4 py-2 rounded-full border border-outline-variant/50 dark:border-[#3E3E3A] hover:bg-surface-container dark:hover:bg-[#161615] shadow-sm bg-surface/90 dark:bg-[#161615]/90 backdrop-blur-sm" aria-label="Kembali ke Beranda">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            <span class="hidden md:inline">Kembali</span>
        </a>

        <!-- Left Side: Brand & Image (Hidden on Mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#0a0a0a] border-r border-outline-variant dark:border-[#3E3E3A] overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center opacity-75" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCdtUP9mYLAR3ClPkheJUDecWoQ6z5lkuTrZwYS_bSZwHa3Gkvb_IFbCD1lT11M_s88GeqFjRNAjejo5tbslWYqBPTSLiUi_gmUZQOWQ1RGBBotR1iGCQCces-MP_BvX8s9E2HMwQFny84Pg_uGK1nOfJxTwgGzf_9spKClAAhvTYFZjrgyYEARMrEhsKpJ9xKH8JWJkdxFdTNNJTGKvDWDoEMUic7-AnpXvZ5Q-_9nFhFXkmF9QkhfxQ')"></div>
            <!-- Subtle semi-dark gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
            <div class="relative z-10 p-xl flex flex-col justify-between h-full w-full">
                <!-- Brand Anchor -->
                <div class="flex items-center gap-2 text-on-primary dark:text-[#EDEDEC] mt-0">
                    <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-10 object-contain brightness-0 invert">
                    <span class="font-headline-lg text-headline-lg tracking-tighter">SIBENGKEL</span>
                </div>
                <!-- Value Proposition -->
                <div class="text-on-primary dark:text-[#EDEDEC] max-w-md">
                    <h2 class="font-headline-xl text-headline-xl mb-4">Servis Lebih Mudah, Transparan & Terpercaya.</h2>
                    <p class="font-body-lg text-body-lg opacity-90">Bergabunglah hari ini untuk memantau riwayat servis, mendapatkan estimasi akurat, dan merawat kendaraan Anda dengan standar industri terbaik.</p>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Registration Form -->
        <div class="flex-1 flex flex-col justify-center px-margin-mobile py-8 sm:px-12 md:px-24 lg:px-16 xl:px-32 bg-surface dark:bg-[#0a0a0a] overflow-y-auto">
            <!-- Mobile Brand Header (Visible only on small screens) -->
            <div class="lg:hidden flex items-center gap-2 text-primary dark:text-[#EDEDEC] mb-6 justify-center mt-2">
                <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-8 object-contain brightness-0 dark:invert">
                <span class="font-headline-lg-mobile text-headline-lg-mobile tracking-tighter">SIBENGKEL</span>
            </div>
            
            <div class="w-full max-w-md mx-auto lg:mx-0">
                <div class="mb-lg">
                    <h1 class="font-headline-xl text-headline-xl text-on-surface dark:text-[#EDEDEC] mb-xs">Daftar Akun</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant dark:text-gray-400">Silakan lengkapi data diri Anda di bawah ini.</p>
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

                <form action="{{ route('public.register.submit') }}" method="POST" class="space-y-sm flex flex-col">
                    @csrf
                    <!-- Full Name -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="name">Nama Lengkap</label>
                        <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] transition-colors" 
                            id="name" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required type="text"/>
                    </div>
                    
                    <!-- Phone Number -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="phone">Nomor Telepon</label>
                        <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] transition-colors" 
                            id="phone" name="phone" placeholder="Contoh: 081234567890" value="{{ old('phone') }}" required type="tel"/>
                    </div>
                    
                    <!-- Email -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="email">Alamat Email <span class="text-secondary">*</span></label>
                        <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] transition-colors" 
                            id="email" name="email" placeholder="Contoh: email@domain.com" value="{{ old('email') }}" type="email" required/>
                    </div>
                    
                    <!-- Address -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="address">Alamat Domisili</label>
                        <textarea class="w-full px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] transition-colors" 
                            id="address" name="address" placeholder="Masukkan alamat domisili" required rows="2">{{ old('address') }}</textarea>
                    </div>
                    
                    <!-- Password -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="password">Kata Sandi</label>
                        <div class="relative">
                            <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] transition-colors pr-12" 
                                id="password" name="password" placeholder="Minimal 8 karakter" required type="password"/>
                        </div>
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] transition-colors pr-12" 
                                id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required type="password"/>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-lg pt-4 flex flex-col gap-md border-t border-outline-variant/30 dark:border-[#3E3E3A]">
                        <button class="w-full min-h-[44px] bg-primary dark:bg-white text-on-primary dark:text-black font-label-md text-label-md rounded flex items-center justify-center hover:bg-primary-container dark:hover:bg-gray-200 active:scale-[0.98] transition-all shadow-sm font-bold" type="submit">
                            Daftar Sekarang
                        </button>
                        <div class="text-center font-body-md text-body-md text-on-surface-variant dark:text-gray-400">
                            Sudah punya akun? <a class="text-primary dark:text-[#FF8F42] font-bold hover:underline" href="{{ route('public.login') }}">Masuk di sini</a>
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
});
</script>
</body>
</html>
