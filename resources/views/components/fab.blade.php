@props(['route', 'icon'])

@push('fab')
{{-- FAB dipush ke luar <main> agar fixed positioning bekerja di semua device --}}
<a href="{{ $route }}"
   x-show="!mobileMenuOpen"
   x-transition:enter="transition ease-out duration-200"
   x-transition:enter-start="opacity-0 scale-75"
   x-transition:enter-end="opacity-100 scale-100"
   x-transition:leave="transition ease-in duration-150"
   x-transition:leave-start="opacity-100 scale-100"
   x-transition:leave-end="opacity-0 scale-75"
   class="md:hidden fixed bottom-20 right-4 z-[60] bg-secondary text-on-secondary w-14 h-14 rounded-2xl shadow-xl flex items-center justify-center hover:scale-105 active:scale-95 transition-transform">
    <span class="material-symbols-outlined text-[28px]">{{ $icon }}</span>
</a>
@endpush
