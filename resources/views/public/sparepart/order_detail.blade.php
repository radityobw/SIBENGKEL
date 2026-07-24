@extends('layouts.customer')

@section('title', 'Detail Pesanan #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' - SIBENGKEL')
@section('page_title', 'Detail Pesanan')
@section('back_url', route('public.orders.index'))

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl overflow-hidden shadow-sm">
        @php
            $stripColor = match($order->status) {
                'menunggu_pembayaran' => 'bg-secondary',
                'diproses' => 'bg-primary',
                'selesai' => 'bg-green-500',
                'dibatalkan' => 'bg-error',
                default => 'bg-outline'
            };
        @endphp
        
        <div class="p-md border-b border-outline-variant dark:border-[#3E3E3A] bg-surface-container-low dark:bg-[#111111] flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative">
            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $stripColor }}"></div>
            <div class="pl-2">
                <h2 class="text-headline-md font-bold text-primary dark:text-[#EDEDEC]">Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
                <p class="text-body-md text-on-surface-variant dark:text-gray-400">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
            </div>
            <div>
                <span class="px-3 py-1 rounded text-xs font-bold uppercase tracking-wider text-white {{ $stripColor }}">
                    {{ str_replace('_', ' ', $order->status) }}
                </span>
            </div>
        </div>
        
        <div class="p-md border-b border-outline-variant dark:border-[#3E3E3A] bg-surface-container-lowest dark:bg-[#161615]">
            <h3 class="text-label-lg font-bold text-on-surface dark:text-[#EDEDEC] mb-4">Daftar Barang</h3>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-center py-2 border-b border-outline-variant/50 dark:border-[#3E3E3A]/50 last:border-0">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-surface-container-low dark:bg-[#111111] rounded overflow-hidden flex items-center justify-center shrink-0">
                                @if(optional($item->sparePart)->image_path)
                                    <img src="{{ Storage::url($item->sparePart->image_path) }}" alt="Img" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-on-surface-variant dark:text-gray-500">construction</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-body-md dark:text-[#EDEDEC]">{{ optional($item->sparePart)->name ?? 'Produk Terhapus' }}</p>
                                <p class="text-body-sm text-on-surface-variant dark:text-gray-400">{{ $item->qty }} x Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <p class="font-bold text-primary dark:text-[#EDEDEC]">Rp {{ number_format($item->qty * $item->price_at_purchase, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="p-md bg-surface-container-lowest dark:bg-[#161615]">
            <div class="flex justify-between items-center bg-surface-container-low dark:bg-[#111111] p-4 rounded-lg">
                <span class="font-bold text-body-lg text-on-surface dark:text-[#EDEDEC]">Total Pembayaran</span>
                <span class="font-headline-md text-primary dark:text-[#EDEDEC]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            
            <div class="mt-6 p-4 border border-outline-variant dark:border-[#3E3E3A] rounded-lg bg-surface dark:bg-[#111111]">
                <h4 class="font-bold text-label-md dark:text-[#EDEDEC] mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[18px]">info</span> Informasi Tambahan
                </h4>
                <p class="text-body-sm text-on-surface-variant dark:text-gray-400">
                    @if($order->status == 'menunggu_pembayaran')
                        Pesanan Anda sedang menunggu proses konfirmasi. Silakan lakukan pembayaran di lokasi bengkel saat mengambil barang.
                    @elseif($order->status == 'diproses')
                        Pesanan Anda sedang kami siapkan dan dapat diambil di bengkel kapan saja pada jam kerja.
                    @elseif($order->status == 'selesai')
                        Pesanan telah selesai dan barang sudah diambil. Terima kasih telah berbelanja di SIBENGKEL!
                    @else
                        Pesanan ini telah dibatalkan. Hubungi admin jika Anda memiliki pertanyaan lebih lanjut.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
