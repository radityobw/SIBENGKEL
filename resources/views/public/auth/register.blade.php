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
                        <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600 transition-colors" 
                            id="name" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required type="text"/>
                    </div>
                    
                    <!-- Phone Number -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="phone">Nomor Telepon</label>
                        <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600 transition-colors" 
                            id="phone" name="phone" placeholder="Contoh: 081234567890" value="{{ old('phone') }}" required type="tel"/>
                    </div>
                    
                    <!-- Email -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="email">Alamat Email <span class="text-secondary">*</span></label>
                        <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600 transition-colors" 
                            id="email" name="email" placeholder="Contoh: email@domain.com" value="{{ old('email') }}" type="email" required/>
                    </div>
                    
                    <!-- Address -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="address">Alamat Domisili</label>
                        <textarea class="w-full px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600 transition-colors" 
                            id="address" name="address" placeholder="Masukkan alamat domisili" required rows="2">{{ old('address') }}</textarea>
                    </div>
                    
                    <!-- Password -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="password">Kata Sandi</label>
                        <div class="relative">
                            <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600 transition-colors pr-12" 
                                id="password" name="password" placeholder="Minimal 8 karakter" required type="password"/>
                        </div>
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="flex flex-col gap-base">
                        <label class="font-label-md text-label-md text-on-surface dark:text-[#EDEDEC]" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input class="w-full min-h-[44px] px-sm py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-body-md font-body-md text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600 transition-colors pr-12" 
                                id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required type="password"/>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-lg pt-4 flex flex-col gap-md border-t border-outline-variant/30 dark:border-[#3E3E3A]">
                        <button class="w-full min-h-[44px] bg-primary dark:bg-secondary text-white dark:text-white font-label-md text-label-md rounded flex items-center justify-center hover:bg-primary/90 dark:hover:bg-secondary/90 active:scale-[0.98] transition-all shadow-sm font-bold" type="submit">
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
});
</script>
</body>
</html>
