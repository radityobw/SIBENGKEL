@props(['route', 'icon'])

<!-- Tombol ini hanya muncul di layar kecil (HP) dan melayang di pojok kanan bawah -->
<a href="{{ $route }}" class="lg:hidden fixed bottom-24 right-4 z-50 bg-secondary text-on-secondary w-14 h-14 rounded-2xl shadow-lg flex items-center justify-center hover:scale-105 active:scale-95 transition-all">
    <span class="material-symbols-outlined text-[28px]">{{ $icon }}</span>
</a>
