<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SIBENGKEL - Customer Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
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
<body class="bg-surface min-h-screen flex flex-col font-sans antialiased text-on-surface relative overflow-hidden">
    <!-- Navbar (simplified for auth) -->
    <nav class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 absolute top-0 z-50">
        <a href="{{ url('/') }}" class="font-headline-md text-headline-md tracking-tighter flex items-center gap-2 hover:opacity-80 transition-opacity text-primary">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-8 filter invert"> SIBENGKEL
        </a>
    </nav>

    <!-- Background Decor (Light/Welcoming) -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-20">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-fixed rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-secondary-fixed rounded-full blur-[100px]"></div>
    </div>
    
    <!-- Login Container -->
    <div class="flex-1 flex items-center justify-center w-full max-w-md px-margin-mobile md:px-0 z-10 mx-auto">
        <div class="w-full">
            <!-- Brand Header -->
            <div class="text-center mb-lg">
                <h1 class="font-headline-xl text-[40px] leading-[48px] font-bold tracking-[-0.02em] text-primary mb-xs">Portal Pelanggan</h1>
                <p class="font-body-md text-[16px] leading-[24px] font-normal text-on-surface-variant">Masuk untuk mengelola servis kendaraan Anda.</p>
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

            <!-- Login Card -->
            <div class="glass-card rounded-xl p-lg md:p-xl border border-outline-variant shadow-sm">
                <form action="{{ route('public.login.submit') }}" class="space-y-md" method="POST">
                    @csrf
                    <div class="space-y-xs">
                        <label class="block font-label-md text-[14px] leading-[20px] font-semibold text-on-surface" for="login">No. HP atau Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">person</span>
                            <input class="w-full pl-10 pr-3 py-3 rounded border border-outline-variant bg-surface-container-lowest focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors h-[44px] font-body-md text-on-surface placeholder:text-outline" 
                                id="login" name="login" placeholder="Contoh: 08123456789 atau email@domain.com" type="text" value="{{ old('login') }}" required/>
                        </div>
                    </div>
                    
                    <div class="space-y-xs">
                        <div class="flex justify-between items-center">
                            <label class="block font-label-md text-[14px] leading-[20px] font-semibold text-on-surface" for="password">Kata Sandi</label>
                            <a href="{{ route('public.forgot_password') }}" class="font-label-sm text-xs text-primary hover:underline font-semibold">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">lock</span>
                            <input class="w-full pl-10 pr-10 py-3 rounded border border-outline-variant bg-surface-container-lowest focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors h-[44px] font-body-md text-on-surface placeholder:text-outline" 
                                id="password" name="password" placeholder="••••••••" type="password" required/>
                        </div>
                    </div>
                    
                    <div class="pt-sm">
                        <button class="w-full bg-primary hover:bg-primary-container hover:text-on-primary-container text-on-primary font-label-md text-[14px] leading-[20px] font-semibold py-3 px-4 rounded h-[44px] transition-colors active:scale-[0.98] flex items-center justify-center gap-2" type="submit">
                            Masuk
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                    
                    <div class="text-center mt-md">
                        <p class="font-body-md text-[16px] leading-[24px] font-normal text-on-surface-variant">
                            Belum punya akun? 
                            <a class="text-primary hover:text-primary-container font-semibold transition-colors" href="{{ route('public.register') }}">Daftar di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
