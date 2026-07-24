@extends('layouts.customer')

@section('title', 'Riwayat Pesanan - SIBENGKEL')
@section('page_title', 'Riwayat Pesanan')
@section('back_url', route('public.dashboard'))

@section('content')
@include('public.sparepart._nav')

<div class="space-y-sm">
    @if($orders->isEmpty())
        <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-lg p-xl text-center">
            <span class="material-symbols-outlined text-4xl text-outline dark:text-gray-500 mb-2">history</span>
            <p class="text-body-lg text-on-surface-variant dark:text-gray-400 mb-4">Anda belum memiliki riwayat pesanan sparepart.</p>
            <a href="{{ route('public.sparepart.index') }}" class="inline-flex h-11 px-md bg-primary dark:bg-secondary text-on-primary dark:text-white rounded-DEFAULT text-label-md hover:opacity-90 items-center justify-center">Mulai Belanja</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <!-- Status Strip -->
                @php
                    $stripColor = match($order->status) {
                        'menunggu_pembayaran' => 'bg-secondary',
                        'diproses' => 'bg-primary',
                        'selesai' => 'bg-green-500',
                        'dibatalkan' => 'bg-error',
                        default => 'bg-outline'
                    };
                @endphp
                
                <div class="p-sm md:p-md flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-outline-variant dark:border-[#3E3E3A] bg-surface-container-low dark:bg-[#111111] relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 {{ $stripColor }}"></div>
                    <div class="pl-2">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-label-md font-bold text-on-surface dark:text-[#EDEDEC]">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider text-white {{ $stripColor }}">
                                {{ str_replace('_', ' ', $order->status) }}
                            </span>
                        </div>
                        <p class="text-label-sm text-on-surface-variant dark:text-gray-400">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div class="text-left md:text-right pl-2 md:pl-0">
                        <p class="text-label-sm text-on-surface-variant dark:text-gray-400 mb-1">Total Belanja</p>
                        <p class="text-headline-md font-bold text-primary dark:text-[#EDEDEC]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <div class="p-sm md:p-md bg-surface-container-lowest dark:bg-[#161615] flex justify-between items-center">
                    <p class="text-body-sm text-on-surface-variant dark:text-gray-400">{{ $order->orderItems()->count() }} jenis barang</p>
                    <a href="{{ route('public.orders.show', $order->id) }}" class="text-primary dark:text-secondary hover:text-primary-container dark:hover:text-secondary/80 font-label-md text-sm flex items-center gap-1">
                        Lihat Detail <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
