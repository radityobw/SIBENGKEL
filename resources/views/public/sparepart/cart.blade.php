@extends('layouts.customer')

@section('title', 'Keranjang Belanja - SIBENGKEL')
@section('page_title', 'Keranjang Belanja')
@section('back_url', route('public.sparepart.index'))

@section('content')
@include('public.sparepart._nav')

<div class="flex flex-col lg:flex-row gap-lg">
    <!-- Items List -->
    <div class="flex-grow space-y-sm">
        @if(empty($cartItems))
            <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl p-xl text-center">
                <span class="material-symbols-outlined text-6xl text-outline dark:text-gray-500 mb-2">shopping_cart</span>
                <p class="text-body-lg text-on-surface-variant dark:text-gray-400 font-medium">Keranjang Anda masih kosong.</p>
                <p class="text-body-sm text-on-surface-variant dark:text-gray-400 mb-4">Mulai cari sparepart yang Anda butuhkan.</p>
                <a href="{{ route('public.sparepart.index') }}" class="inline-flex h-11 px-md bg-primary dark:bg-secondary text-on-primary dark:text-white rounded-DEFAULT text-label-md hover:opacity-90 items-center justify-center">Lihat Katalog</a>
            </div>
        @else
            @foreach($cartItems as $item)
                <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl p-sm flex flex-col sm:flex-row items-center gap-sm">
                    <div class="w-24 h-24 bg-surface-container-low dark:bg-[#111111] rounded-lg shrink-0 flex items-center justify-center overflow-hidden">
                        @if($item['sparepart']->image_path)
                            <img src="{{ Storage::url($item['sparepart']->image_path) }}" alt="{{ $item['sparepart']->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-4xl text-outline-variant">construction</span>
                        @endif
                    </div>
                    <div class="flex-grow text-center sm:text-left w-full sm:w-auto">
                        <h3 class="text-body-lg font-bold text-on-surface dark:text-[#EDEDEC]">{{ $item['sparepart']->name }}</h3>
                        <p class="text-body-sm text-on-surface-variant dark:text-gray-400 mb-2">Rp {{ number_format($item['sparepart']->price, 0, ',', '.') }}</p>
                        
                        <div class="flex items-center justify-center sm:justify-start gap-4">
                            <!-- Quantity indicator -->
                            <div class="flex items-center bg-surface dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded">
                                <span class="px-3 py-1 text-label-md font-bold dark:text-[#EDEDEC]">Qty: {{ $item['qty'] }}</span>
                            </div>
                            <!-- Remove button -->
                            <form action="{{ route('public.cart.remove', $item['sparepart']->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-error hover:text-error-container text-sm font-label-md flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">delete</span> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="w-full sm:w-auto text-center sm:text-right mt-2 sm:mt-0">
                        <p class="text-label-sm text-on-surface-variant dark:text-gray-400">Subtotal</p>
                        <p class="text-body-lg font-bold text-primary dark:text-[#EDEDEC]">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Summary -->
    @if(!empty($cartItems))
        <div class="w-full lg:w-80 shrink-0">
            <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl p-md sticky top-24">
                <h3 class="text-headline-md font-bold text-on-surface dark:text-[#EDEDEC] mb-4">Ringkasan Belanja</h3>
                <div class="space-y-2 mb-4 border-b border-outline-variant dark:border-[#3E3E3A] pb-4">
                    <div class="flex justify-between text-body-md text-on-surface-variant dark:text-gray-400">
                        <span>Total Harga ({{ array_sum(array_column($cartItems, 'qty')) }} barang)</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="flex justify-between text-body-lg font-bold text-primary dark:text-[#EDEDEC] mb-6">
                    <span>Total Belanja</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('public.checkout') }}" class="w-full h-11 bg-primary dark:bg-secondary text-white dark:text-white rounded-DEFAULT font-label-md hover:opacity-90 flex items-center justify-center gap-2 shadow-sm font-bold">
                    Lanjut Checkout
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
