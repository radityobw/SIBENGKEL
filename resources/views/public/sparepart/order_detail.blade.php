@extends('layouts.customer')

@section('title', 'Detail Pesanan #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' - SIBENGKEL')
@section('page_title', 'Detail Pesanan')
@section('back_url', route('public.orders.index'))

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        @php
            $stripColor = match($order->status) {
                'menunggu_pembayaran' => 'bg-secondary',
                'diproses' => 'bg-primary',
                'selesai' => 'bg-green-500',
                'dibatalkan' => 'bg-error',
                default => 'bg-outline'
            };
        @endphp
        
        <div class="p-md border-b border-outline-variant bg-surface-container-low flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative">
            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $stripColor }}"></div>
            <div class="pl-2">
                <h2 class="text-headline-md font-bold text-primary">Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
                <p class="text-body-md text-on-surface-variant">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
            </div>
            <div>
                <span class="px-3 py-1 rounded text-xs font-bold uppercase tracking-wider text-white {{ $stripColor }}">
                    {{ str_replace('_', ' ', $order->status) }}
                </span>
            </div>
        </div>
        
        <div class="p-md border-b border-outline-variant">
            <h3 class="text-label-lg font-bold text-on-surface mb-4">Daftar Barang</h3>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-center py-2 border-b border-outline-variant/50 last:border-0">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-surface-container-low rounded overflow-hidden flex items-center justify-center shrink-0">
                                @if(optional($item->sparePart)->image_path)
                                    <img src="{{ Storage::url($item->sparePart->image_path) }}" alt="Img" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-on-surface-variant">construction</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-body-md">{{ optional($item->sparePart)->name ?? 'Produk Terhapus' }}</p>
                                <p class="text-body-sm text-on-surface-variant">{{ $item->qty }} x Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <p class="font-bold text-primary">Rp {{ number_format($item->qty * $item->price_at_purchase, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="p-md bg-surface-container-lowest">
            <div class="flex justify-between items-center bg-surface-container-low p-4 rounded-lg">
                <span class="font-bold text-body-lg text-on-surface">Total Pembayaran</span>
                <span class="font-headline-md text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            
            <div class="mt-6 p-4 border border-outline-variant rounded-lg bg-surface">
                <h4 class="font-bold text-label-md mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[18px]">info</span> Informasi Tambahan
                </h4>
                <p class="text-body-sm text-on-surface-variant">
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
