<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
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
