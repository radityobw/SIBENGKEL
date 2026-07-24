<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - SIBENGKEL</title>
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
    <nav class="flex justify-between items-center w-full px-margin-mobile md:px-8 py-4 absolute top-0 z-50">
        <a href="{{ url('/') }}" class="font-headline-md text-headline-md tracking-tighter flex items-center gap-2 hover:opacity-80 transition-opacity text-primary">
            <img src="{{ asset('logobengkel.png') }}" alt="Logo" class="h-8 filter invert"> SIBENGKEL
        </a>
        <a href="{{ url('/') }}" class="flex items-center gap-2 font-label-md text-primary hover:text-primary-container transition-colors bg-surface/50 backdrop-blur-sm px-4 py-2 rounded-full border border-outline-variant/50">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            <span class="hidden md:inline">Kembali</span>
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
                <h1 class="font-headline-xl text-[40px] leading-[48px] font-bold tracking-[-0.02em] text-primary mb-xs">Login Pegawai</h1>
                <p class="font-body-md text-[16px] leading-[24px] font-normal text-on-surface-variant">Masuk ke sistem manajemen bengkel.</p>
            </div>
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

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
                <form action="{{ route('login') }}" class="space-y-md" method="POST">
                    @csrf
                    <div class="space-y-xs">
                        <label class="block font-label-md text-[14px] leading-[20px] font-semibold text-on-surface" for="login">Username atau Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">person</span>
                            <input class="w-full pl-10 pr-3 py-3 rounded border border-outline-variant bg-surface-container-lowest focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors h-[44px] font-body-md text-on-surface placeholder:text-outline" 
                                id="login" name="login" placeholder="Masukkan username/email" type="text" value="{{ old('login') }}" required autofocus/>
                        </div>
                    </div>
                    
                    <div class="space-y-xs">
                        <div class="flex justify-between items-center">
                            <label class="block font-label-md text-[14px] leading-[20px] font-semibold text-on-surface" for="password">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="font-label-sm text-xs text-primary hover:underline font-semibold">Lupa Password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">lock</span>
                            <input class="w-full pl-10 pr-10 py-3 rounded border border-outline-variant bg-surface-container-lowest focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors h-[44px] font-body-md text-on-surface placeholder:text-outline" 
                                id="password" name="password" placeholder="••••••••" type="password" required/>
                        </div>
                    </div>
                    
                    <div class="flex items-center pt-2">
                        <input class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary bg-surface-container-lowest" 
                            id="remember_me" name="remember" type="checkbox" />
                        <label class="ml-2 block font-body-md text-sm text-on-surface-variant" for="remember_me">
                            Ingat saya
                        </label>
                    </div>

                    <div class="pt-sm">
                        <button class="w-full bg-primary hover:bg-primary-container hover:text-on-primary-container text-on-primary font-label-md text-[14px] leading-[20px] font-semibold py-3 px-4 rounded h-[44px] transition-colors active:scale-[0.98] flex items-center justify-center gap-2" type="submit">
                            Masuk Sistem
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded',()=>{document.querySelectorAll('input[type="password"]').forEach((e,t)=>{let n=e.parentElement,r=document.createElement('div');r.className='relative',n.insertBefore(r,e),r.appendChild(e);let o=document.createElement('button');o.type='button',o.id='pw-toggle-'+t,o.setAttribute('aria-label','Toggle visibility'),o.className='absolute inset-y-0 right-0 flex items-center px-3 text-on-surface-variant hover:text-secondary transition-colors',o.innerHTML='<span class="material-symbols-outlined text-[20px] select-none">visibility</span>',r.appendChild(o),e.style.paddingRight='2.5rem',o.addEventListener('click',()=>{let s=e.type==='password';e.type=s?'text':'password',o.querySelector('span').textContent=s?'visibility_off':'visibility'})})});
</script>
</body>
</html>
