<div class="flex items-center gap-2 mb-6 border-b border-outline-variant pb-3 overflow-x-auto">
    <a href="{{ route('public.sparepart.index') }}" class="px-4 py-2 rounded-xl font-bold text-sm flex items-center gap-2 transition-all whitespace-nowrap {{ request()->routeIs('public.sparepart.index') ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' }}">
        <span class="material-symbols-outlined text-[18px]">grid_view</span>
        Katalog Sparepart
    </a>
    
    @auth('customer')
    <a href="{{ route('public.cart') }}" class="relative px-4 py-2 rounded-xl font-bold text-sm flex items-center gap-2 transition-all whitespace-nowrap {{ request()->routeIs('public.cart') || request()->routeIs('public.checkout') ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' }}">
        <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
        Keranjang Belanja
        @php $cartCount = count(session()->get('cart', [])); @endphp
        @if($cartCount > 0)
            <span class="bg-secondary text-on-secondary px-2 py-0.5 rounded-full text-xs font-bold">{{ $cartCount }}</span>
        @endif
    </a>
    
    <a href="{{ route('public.orders.index') }}" class="px-4 py-2 rounded-xl font-bold text-sm flex items-center gap-2 transition-all whitespace-nowrap {{ request()->routeIs('public.orders.*') ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' }}">
        <span class="material-symbols-outlined text-[18px]">receipt_long</span>
        Riwayat Pesanan
    </a>
    @endauth
</div>
