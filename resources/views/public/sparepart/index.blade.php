@extends('layouts.customer')

@section('title', 'Katalog Sparepart - SIBENGKEL')
@section('page_title', 'Katalog Sparepart')
@section('back_url', route('public.dashboard'))

@section('content')
@include('public.sparepart._nav')

<!-- Search and Filter -->
<div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl p-sm md:p-md mb-lg shadow-sm">
    <form action="{{ route('public.sparepart.index') }}" method="GET" class="flex flex-col md:flex-row gap-sm">
        <div class="flex-grow">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-on-surface-variant dark:text-gray-400">search</span>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama sparepart..." 
                    class="w-full pl-10 pr-3 py-2 border border-outline-variant dark:border-[#3E3E3A] rounded-lg bg-surface dark:bg-[#111111] text-body-md text-on-surface dark:text-[#EDEDEC] dark:placeholder:text-gray-500 focus:ring-1 focus:ring-primary dark:focus:ring-secondary focus:border-primary dark:focus:border-secondary">
            </div>
        </div>
        <div class="w-full md:w-64">
            <select name="category" onchange="this.form.submit()" class="w-full py-2 border border-outline-variant dark:border-[#3E3E3A] rounded-lg bg-surface dark:bg-[#111111] text-body-md text-on-surface dark:text-[#EDEDEC] focus:ring-1 focus:ring-primary dark:focus:ring-secondary focus:border-primary dark:focus:border-secondary">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-primary text-on-primary px-sm py-2 rounded-lg font-label-md hover:opacity-90">Cari</button>
        <a href="{{ route('public.cart') }}" class="relative bg-secondary text-white px-sm py-2 rounded-lg font-label-md flex items-center justify-center gap-xs hover:bg-[#FF8F42] transition-colors shadow-sm">
            <span class="material-symbols-outlined">shopping_cart</span>
            <span class="hidden md:inline">Keranjang</span>
            @php $cartCount = count(session()->get('cart', [])); @endphp
            @if($cartCount > 0)
                <span class="absolute -top-2 -right-2 bg-white text-secondary w-5 h-5 flex items-center justify-center rounded-full text-[10px] font-bold shadow-sm border border-secondary">
                    {{ $cartCount }}
                </span>
            @endif
        </a>
    </form>
</div>

<!-- Product Grid -->
@if($spareparts->isEmpty())
    <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-lg p-xl text-center">
        <span class="material-symbols-outlined text-4xl text-outline dark:text-gray-500 mb-2">inventory_2</span>
        <p class="text-body-lg text-on-surface-variant dark:text-gray-400">Tidak ada sparepart yang ditemukan.</p>
    </div>
@else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-sm md:gap-md">
        @foreach($spareparts as $item)
            <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl overflow-hidden hover:shadow-md transition-all flex flex-col group">
                <div class="aspect-square bg-surface-container-low dark:bg-[#111111] relative overflow-hidden flex items-center justify-center border-b border-outline-variant dark:border-[#3E3E3A]">
                    @if($item->image_path)
                        <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <span class="material-symbols-outlined text-6xl text-outline-variant dark:text-gray-600">construction</span>
                    @endif
                    @if($item->stock <= 0)
                        <div class="absolute inset-0 bg-surface/80 dark:bg-black/60 flex items-center justify-center">
                            <span class="bg-error text-on-error px-2 py-1 rounded font-bold text-xs uppercase tracking-wider">Habis</span>
                        </div>
                    @endif
                </div>
                <div class="p-sm flex flex-col flex-grow">
                    <span class="text-[10px] font-bold text-secondary uppercase tracking-widest mb-1">{{ $item->category }}</span>
                    <h3 class="text-body-md font-bold text-on-surface dark:text-[#EDEDEC] line-clamp-2 mb-1 flex-grow">{{ $item->name }}</h3>
                    <p class="text-body-lg font-bold text-primary dark:text-[#EDEDEC] mb-3">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    
                    <form action="{{ route('public.cart.add') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="spare_part_id" value="{{ $item->id }}">
                        <input type="hidden" name="qty" value="1">
                        <button type="submit" class="w-full h-10 bg-secondary text-white rounded-lg font-label-sm hover:opacity-90 flex items-center justify-center gap-1 {{ $item->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $item->stock <= 0 ? 'disabled' : '' }}>
                            <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                            Tambah
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-lg">
        {{ $spareparts->links() }}
    </div>
@endif
@endsection
