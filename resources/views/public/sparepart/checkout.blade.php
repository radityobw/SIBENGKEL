@extends('layouts.customer')

@section('title', 'Checkout - SIBENGKEL')
@section('page_title', 'Checkout Pesanan')
@section('back_url', route('public.cart'))

@section('content')
@include('public.sparepart._nav')

<div class="max-w-3xl mx-auto">
    <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl overflow-hidden shadow-sm">
        <div class="p-md border-b border-outline-variant dark:border-[#3E3E3A] bg-surface-container-low dark:bg-[#111111] flex items-center gap-sm">
            <div class="bg-primary-container dark:bg-secondary/20 text-on-primary-container dark:text-secondary p-2 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined">receipt_long</span>
            </div>
            <div>
                <h2 class="text-headline-md font-bold text-primary dark:text-[#EDEDEC]">Konfirmasi Pesanan</h2>
                <p class="text-body-md text-on-surface-variant dark:text-gray-400">Periksa kembali pesanan Anda sebelum dibuat.</p>
            </div>
        </div>
        
        <div class="p-md">
            <h3 class="text-label-lg font-bold text-on-surface dark:text-[#EDEDEC] mb-4">Daftar Barang</h3>
            <div class="space-y-4 mb-6">
                @foreach($cartItems as $item)
                    <div class="flex justify-between items-center py-2 border-b border-outline-variant/50 dark:border-[#3E3E3A]/50 last:border-0">
                        <div>
                            <p class="font-bold text-body-md dark:text-[#EDEDEC]">{{ $item['sparepart']->name }}</p>
                            <p class="text-body-sm text-on-surface-variant dark:text-gray-400">{{ $item['qty'] }} x Rp {{ number_format($item['sparepart']->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-bold text-primary dark:text-[#EDEDEC]">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="bg-surface-container dark:bg-[#111111] p-4 rounded-lg mb-6">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-body-lg text-on-surface dark:text-[#EDEDEC]">Total Pembayaran</span>
                    <span class="font-headline-md text-primary dark:text-[#EDEDEC]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-label-lg font-bold text-on-surface dark:text-[#EDEDEC] mb-2">Metode Pembayaran</h3>
                <div class="p-4 border border-outline-variant dark:border-[#3E3E3A] rounded-lg bg-surface dark:bg-[#111111]">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary mt-0.5">store</span>
                        <div>
                            <p class="font-bold text-body-md dark:text-[#EDEDEC]">Bayar di Bengkel (COD)</p>
                            <p class="text-body-sm text-on-surface-variant dark:text-gray-400">Pembayaran dilakukan secara langsung saat mengambil sparepart di bengkel.</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('public.checkout.process') }}" method="POST" class="flex justify-end gap-sm">
                @csrf
                <a href="{{ route('public.cart') }}" class="h-11 px-6 border border-outline dark:border-[#3E3E3A] text-on-surface-variant dark:text-gray-300 rounded-DEFAULT font-label-md hover:bg-surface-container-low dark:hover:bg-[#3E3E3A] flex items-center justify-center">Kembali</a>
                <button type="submit" class="h-11 px-8 bg-secondary text-on-secondary rounded-DEFAULT font-label-md hover:opacity-90 flex items-center justify-center gap-2 shadow-sm" onclick="this.disabled=true;this.innerHTML='Memproses...';this.form.submit();">
                    Buat Pesanan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
