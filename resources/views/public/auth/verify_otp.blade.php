<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Verifikasi OTP Reset Password - SIBENGKEL</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface dark:bg-[#0a0a0a] min-h-screen flex flex-col font-sans antialiased text-on-surface dark:text-[#EDEDEC] relative overflow-hidden transition-colors duration-300">
    <!-- Navbar -->
    <nav class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 absolute top-0 z-50">
        <a href="{{ url('/') }}" class="font-headline-md text-headline-md tracking-tighter flex items-center gap-2 hover:opacity-80 transition-opacity text-primary font-sora font-bold">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-8 dark:brightness-0 dark:invert"> SIBENGKEL
        </a>
        <a href="{{ route('public.forgot_password') }}" class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Ubah Email
        </a>
    </nav>

    <!-- Background Decor -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-20">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-fixed rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-secondary-fixed rounded-full blur-[100px]"></div>
    </div>
    
    <!-- Forgot Password Step 2: Input OTP & New Password -->
    <div class="flex-1 flex items-center justify-center w-full max-w-md px-margin-mobile md:px-0 z-10 mx-auto py-12">
        <div class="w-full">
            <!-- Header -->
            <div class="text-center mb-lg">
                <div class="w-16 h-16 rounded-full bg-secondary/50 text-secondary mx-auto mb-3 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">mark_email_read</span>
                </div>
                <h1 class="font-headline-xl text-2xl font-bold tracking-tight text-primary mb-xs font-sora">Verifikasi Kode OTP</h1>
                <p class="font-body-md text-sm text-on-surface-variant">Langkah 2 dari 2: Masukkan kode OTP 6-digit untuk email <span class="font-bold text-primary">{{ $email }}</span>.</p>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-300 text-green-900 p-4 rounded-xl text-sm font-medium shadow-sm flex items-start gap-2">
                    <span class="material-symbols-outlined text-green-600 text-lg shrink-0 mt-0.5">check_circle</span>
                    <div>
                        <p class="font-bold mb-1">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            
            @if ($errors->any())
                <div class="mb-4 bg-error-container text-on-error-container p-4 rounded-lg text-sm border border-outline-variant">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Step 2 -->
            <div class="glass-card rounded-xl p-6 md:p-8 border border-outline-variant shadow-sm space-y-5">
                <form action="{{ route('public.forgot_password.reset') }}" class="space-y-4" method="POST">
                    @csrf
                    
                    <div class="space-y-1">
                        <label class="block font-semibold text-xs text-on-surface" for="otp">Kode OTP (6 Digit) <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">pin</span>
                            <input class="w-full pl-10 pr-3 py-3 rounded-lg border border-outline-variant dark:border-[#3E3E3A] bg-surface dark:bg-[#111111] focus:border-primary dark:focus:border-white focus:ring-1 focus:ring-primary outline-none transition-colors text-lg font-mono font-bold tracking-widest text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600" 
                                id="otp" name="otp" placeholder="123456" maxlength="6" type="text" required autofocus/>
                        </div>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="block font-semibold text-xs text-on-surface" for="password">Password Baru <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">lock</span>
                            <input class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-outline-variant dark:border-[#3E3E3A] bg-surface dark:bg-[#111111] focus:border-primary dark:focus:border-white focus:ring-1 focus:ring-primary outline-none transition-colors text-sm text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600" 
                                id="password" name="password" placeholder="Minimal 8 karakter" type="password" required/>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block font-semibold text-xs text-on-surface" for="password_confirmation">Konfirmasi Password Baru <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">lock</span>
                            <input class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-outline-variant dark:border-[#3E3E3A] bg-surface dark:bg-[#111111] focus:border-primary dark:focus:border-white focus:ring-1 focus:ring-primary outline-none transition-colors text-sm text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600" 
                                id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" type="password" required/>
                        </div>
                    </div>
                    
                    <button class="w-full py-3 px-4 rounded-lg bg-primary dark:bg-secondary hover:opacity-90 text-white dark:text-white font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2" type="submit">
                        <span class="material-symbols-outlined text-lg">check_circle</span> Verifikasi & Simpan Password
                    </button>
                </form>
            </div>

            <div class="text-center mt-6">
                <p class="text-xs text-on-surface-variant">Tidak menerima kode OTP? <a href="{{ route('public.forgot_password') }}" class="text-primary font-bold hover:underline">Kirim Ulang OTP</a></p>
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
});
</script>
</body>
</html>
