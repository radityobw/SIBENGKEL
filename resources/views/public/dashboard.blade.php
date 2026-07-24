@extends('layouts.customer')

@section('title', 'Customer Dashboard - SIBENGKEL')
@section('page_title', 'Halo, ' . strtok($customer->name, ' ') . '!')

@section('content')
<!-- Booking Aktif Section -->
<section class="flex flex-col gap-sm">
    <div class="flex justify-between items-end">
        <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-on-background">Booking Aktif & Riwayat</h2>
    </div>

    @if($bookings->isEmpty())
        <div class="industrial-card rounded-lg p-md text-center py-12">
            <span class="material-symbols-outlined text-4xl text-outline mb-2">event_busy</span>
            <p class="text-body-lg text-on-surface-variant font-medium">Belum ada data booking.</p>
            <p class="text-body-md text-on-surface-variant mb-4">Ajukan servis pertama untuk kendaraan Anda hari ini.</p>
            <a href="{{ route('public.booking.form') }}" class="inline-flex h-11 px-md bg-primary text-on-primary rounded-DEFAULT text-label-md font-label-md hover:opacity-90 transition-opacity items-center justify-center gap-2">
                Booking Sekarang
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="industrial-card rounded-lg p-sm md:p-md relative overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <!-- Status Strip -->
                    @php
                        $stripColor = match($booking->status) {
                            'menunggu_konfirmasi' => 'bg-secondary',
                            'disetujui' => 'bg-primary',
                            'dikonversi' => 'bg-green-500',
                            'ditolak' => 'bg-error',
                            default => 'bg-outline'
                        };
                        $statusText = match($booking->status) {
                            'menunggu_konfirmasi' => 'Menunggu',
                            'disetujui' => 'Disetujui',
                            'dikonversi' => 'Dikonversi ke Transaksi',
                            'ditolak' => 'Ditolak',
                            default => 'Unknown'
                        };
                    @endphp
                    <div class="absolute left-0 top-0 bottom-0 w-1 {{ $stripColor }}"></div>
                    
                    <div class="flex flex-col sm:flex-row sm:justify-between items-start gap-4">
                        <div>
                            <div class="flex items-center gap-xs mb-base">
                                <span class="px-2 py-1 {{ $stripColor }} {{ $booking->status == 'dikonversi' ? 'text-white' : 'text-white' }} rounded text-[10px] font-bold uppercase tracking-wider">
                                    {{ $statusText }}
                                </span>
                                <span class="text-label-sm font-label-sm text-on-surface-variant">ID: #SB-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h3 class="text-body-lg font-body-lg font-semibold text-primary">Booking Servis</h3>
                            <p class="text-body-md font-body-md text-on-surface-variant">{{ optional($booking->vehicle)->brand ?? '-' }} {{ optional($booking->vehicle)->model ?? '-' }} ({{ optional($booking->vehicle)->plate_number ?? '-' }})</p>
                            <p class="text-body-sm text-on-surface-variant italic mt-1 max-w-lg">{{ $booking->complaint }}</p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-label-sm font-label-sm text-on-surface-variant">Jadwal Diajukan</p>
                            <p class="text-body-lg font-body-lg font-semibold text-primary">{{ \Carbon\Carbon::parse($booking->preferred_date)->translatedFormat('d M Y') }}</p>
                            <p class="text-body-md text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->preferred_time)->format('H:i') }} WIB</p>
                            
                            @if($booking->service_transaction_id)
                                <a href="{{ route('public.status.result', $booking->service_transaction_id) }}" class="mt-2 text-label-sm text-primary hover:underline flex items-center gap-1 sm:justify-end">
                                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span> Lihat Progres Servis
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

<!-- Kendaraan Saya Section -->
<section class="flex flex-col gap-sm">
    <div class="flex justify-between items-end">
        <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-on-background">Kendaraan Saya</h2>
    </div>

    @if($vehicles->isEmpty())
        <div class="industrial-card rounded-lg p-md text-center py-8">
            <p class="text-body-md text-on-surface-variant">Kendaraan Anda belum terdaftar. Silakan hubungi admin bengkel pada kunjungan pertama Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
            @foreach($vehicles as $vehicle)
                <div class="industrial-card rounded-lg p-sm flex items-center gap-sm cursor-pointer hover:shadow-md transition-all active:scale-[0.98]">
                    <div class="w-16 h-16 rounded bg-surface-container-low border border-outline-variant flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[32px] text-outline">
                            {{ stripos($vehicle->model, 'motor') !== false || stripos($vehicle->brand, 'honda') !== false ? 'two_wheeler' : 'directions_car' }}
                        </span>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-body-lg font-body-lg font-semibold text-primary">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-body-md font-body-md text-on-surface-variant mb-xs">Tahun {{ $vehicle->year }}</p>
                        <div class="inline-flex px-2 py-0.5 border border-outline-variant rounded bg-surface text-label-md font-label-md font-bold text-on-background tracking-widest">
                            {{ $vehicle->plate_number }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
