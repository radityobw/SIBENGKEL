@extends('layouts.customer')

@section('title', 'Customer Dashboard - SIBENGKEL')
@section('page_title', 'Halo, ' . strtok($customer->name, ' ') . '!')

@section('content')
<!-- Booking Aktif Section -->
<section class="flex flex-col gap-sm">
    <div class="flex justify-between items-end">
        <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-on-background dark:text-[#EDEDEC]">Booking Aktif & Riwayat</h2>
    </div>

    @if($bookings->isEmpty())
        <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-lg p-md text-center py-12">
            <span class="material-symbols-outlined text-4xl text-outline dark:text-gray-500 mb-2">event_busy</span>
            <p class="text-body-lg text-on-surface-variant dark:text-gray-400 font-medium">Belum ada data booking.</p>
            <p class="text-body-md text-on-surface-variant dark:text-gray-400 mb-4">Ajukan servis pertama untuk kendaraan Anda hari ini.</p>
            <a href="{{ route('public.booking.form') }}" class="inline-flex h-11 px-md bg-primary dark:bg-secondary text-on-primary dark:text-white rounded-DEFAULT text-label-md font-label-md hover:opacity-90 transition-opacity items-center justify-center gap-2">
                Booking Sekarang
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-lg p-sm md:p-md relative overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <!-- Status Strip -->
                    @php
                        $actualStatus = $booking->status;
                        if ($actualStatus == 'disetujui' && $booking->transaction) {
                            $actualStatus = 'transaksi_' . $booking->transaction->status;
                        }

                        $stripColor = match($actualStatus) {
                            'menunggu_konfirmasi' => 'bg-secondary',
                            'disetujui', 'transaksi_pending' => 'bg-primary',
                            'transaksi_proses' => 'bg-amber-500',
                            'transaksi_selesai', 'dikonversi' => 'bg-green-500',
                            'ditolak' => 'bg-error',
                            default => 'bg-outline'
                        };
                        $statusText = match($actualStatus) {
                            'menunggu_konfirmasi' => 'Menunggu',
                            'disetujui' => 'Disetujui',
                            'transaksi_pending' => 'Menunggu Mekanik',
                            'transaksi_proses' => 'Sedang Dikerjakan',
                            'transaksi_selesai' => 'Servis Selesai',
                            'dikonversi' => 'Dikonversi',
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
                                <span class="text-label-sm font-label-sm text-on-surface-variant dark:text-gray-400">ID: #SB-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h3 class="text-body-lg font-body-lg font-semibold text-primary dark:text-[#EDEDEC]">Booking Servis</h3>
                            <p class="text-body-md font-body-md text-on-surface-variant dark:text-gray-400">{{ optional($booking->vehicle)->brand ?? '-' }} {{ optional($booking->vehicle)->model ?? '-' }} ({{ optional($booking->vehicle)->plate_number ?? '-' }})</p>
                            <p class="text-body-sm text-on-surface-variant dark:text-gray-500 italic mt-1 max-w-lg">{{ $booking->complaint }}</p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-label-sm font-label-sm text-on-surface-variant dark:text-gray-400">Jadwal Diajukan</p>
                            <p class="text-body-lg font-body-lg font-semibold text-primary dark:text-[#EDEDEC]">{{ \Carbon\Carbon::parse($booking->preferred_date)->translatedFormat('d M Y') }}</p>
                            <p class="text-body-md text-on-surface-variant dark:text-gray-400">{{ \Carbon\Carbon::parse($booking->preferred_time)->format('H:i') }} WIB</p>
                            
                            @if($booking->service_transaction_id)
                                <a href="{{ route('public.status.result', $booking->service_transaction_id) }}" class="mt-2 text-label-sm text-primary dark:text-secondary hover:underline flex items-center gap-1 sm:justify-end">
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
        <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg-mobile md:font-headline-lg text-on-background dark:text-[#EDEDEC]">Kendaraan Saya</h2>
    </div>

    @if($vehicles->isEmpty())
        <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-lg p-md text-center py-8">
            <p class="text-body-md text-on-surface-variant dark:text-gray-400">Kendaraan Anda belum terdaftar. Silakan hubungi admin bengkel pada kunjungan pertama Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
            @foreach($vehicles as $vehicle)
                <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-lg p-sm flex items-center gap-sm cursor-pointer hover:shadow-md transition-all active:scale-[0.98]">
                    <div class="w-16 h-16 rounded bg-surface-container-low dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[32px] text-outline dark:text-gray-500">
                            {{ stripos($vehicle->model, 'motor') !== false || stripos($vehicle->brand, 'honda') !== false ? 'two_wheeler' : 'directions_car' }}
                        </span>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-body-lg font-body-lg font-semibold text-primary dark:text-[#EDEDEC] uppercase">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-body-md font-body-md text-on-surface-variant dark:text-gray-400 mb-xs">Tahun {{ $vehicle->year }}</p>
                        <div class="inline-flex px-2 py-0.5 border border-outline-variant dark:border-[#3E3E3A] rounded bg-surface dark:bg-[#111111] text-label-md font-label-md font-bold text-on-background dark:text-[#EDEDEC] tracking-widest">
                            {{ $vehicle->plate_number }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
