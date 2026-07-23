<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Lupa Password - SIBENGKEL</title>
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
<body class="bg-surface min-h-screen flex flex-col font-sans antialiased text-on-surface relative overflow-hidden">
    <!-- Navbar -->
    <nav class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 absolute top-0 z-50">
        <a href="{{ url('/') }}" class="font-headline-md text-headline-md tracking-tighter flex items-center gap-2 hover:opacity-80 transition-opacity text-primary font-sora font-bold">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-8 filter invert"> SIBENGKEL
        </a>
        <a href="{{ route('public.login') }}" class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Login
        </a>
    </nav>

    <!-- Background Decor -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-20">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-fixed rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-secondary-fixed rounded-full blur-[100px]"></div>
    </div>
    
    <!-- Forgot Password Step 1: Input Phone Number -->
    <div class="flex-1 flex items-center justify-center w-full max-w-md px-margin-mobile md:px-0 z-10 mx-auto py-12">
        <div class="w-full">
            <!-- Header -->
            <div class="text-center mb-lg">
                <div class="w-16 h-16 rounded-full bg-primary-container/30 text-primary mx-auto mb-3 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">phone_locked</span>
                </div>
                <h1 class="font-headline-xl text-2xl font-bold tracking-tight text-primary mb-xs font-sora">Lupa Password Akun</h1>
                <p class="font-body-md text-sm text-on-surface-variant">Langkah 1 dari 2: Masukkan nomor Telepon/WhatsApp terdaftar untuk meminta Kode OTP Verifikasi.</p>
            </div>
            
            @if ($errors->any())
                <div class="mb-4 bg-error-container text-on-error-container p-4 rounded-lg text-sm border border-outline-variant">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Step 1 -->
            <div class="glass-card rounded-xl p-6 md:p-8 border border-outline-variant shadow-sm space-y-5">
                <form action="{{ route('public.forgot_password.send_otp') }}" class="space-y-4" method="POST">
                    @csrf
                    
                    <div class="space-y-1">
                        <label class="block font-semibold text-xs text-on-surface" for="phone">Nomor Telepon Terdaftar <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">phone_iphone</span>
                            <input class="w-full pl-10 pr-3 py-3 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm text-on-surface placeholder:text-outline" 
                                id="phone" name="phone" placeholder="Contoh: 08123456789" type="text" value="{{ old('phone') }}" required/>
                        </div>
                    </div>
                    
                    <button class="w-full py-3 px-4 rounded-lg bg-primary hover:opacity-90 text-on-primary font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2" type="submit">
                        <span class="material-symbols-outlined text-lg">send</span> Minta Kode OTP Verifikasi
                    </button>
                </form>

                <div class="relative flex items-center justify-center my-4">
                    <div class="border-t border-outline-variant/60 w-full"></div>
                    <span class="bg-surface px-3 text-xs text-on-surface-variant font-medium absolute">atau butuh bantuan?</span>
                </div>

                <!-- WA Customer Support Option -->
                @php
                    $waNumber = \App\Models\Setting::get('admin_whatsapp', '628123456789');
                    $waText = \App\Models\Setting::get('admin_wa_text', 'Halo Admin SIBENGKEL, saya butuh bantuan reset password akun pelanggan saya.');
                    $waUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode($waText);
                @endphp
                <a href="{{ $waUrl }}" target="_blank" class="w-full py-2.5 px-4 rounded-lg border border-outline-variant bg-surface-container-low hover:bg-surface-container transition-colors font-medium text-xs text-on-surface flex items-center justify-center gap-2 text-center">
                    <span class="material-symbols-outlined text-green-600 text-lg">chat</span> Hubungi Admin via WhatsApp
                </a>
            </div>

            <div class="text-center mt-6">
                <p class="text-xs text-on-surface-variant">Sudah ingat password? <a href="{{ route('public.login') }}" class="text-primary font-bold hover:underline">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
