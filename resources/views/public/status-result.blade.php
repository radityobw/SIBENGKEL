@extends('layouts.public')
@section('title', 'Status Servis Anda - SIBENGKEL')
@section('content')
    <!-- Main Content Canvas -->
    <main class="flex-1 w-full max-w-lg mx-auto p-margin-mobile flex flex-col gap-sm pb-xl mt-4">
        <!-- Primary Vehicle & Status Card -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-sm shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] relative overflow-hidden flex flex-col gap-md border-l-4 {{ $transaction->status === 'selesai' ? 'border-l-green-500' : 'border-l-primary-fixed' }}">
            <div class="flex justify-between items-start w-full">
                <div class="inline-flex items-center gap-1 {{ $transaction->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-primary-fixed text-on-primary-fixed' }} px-2 py-1 rounded font-label-sm text-label-sm uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">
                        {{ $transaction->status === 'selesai' ? 'check_circle' : 'build_circle' }}
                    </span>
                    {{ ucwords(str_replace('_', ' ', $transaction->status)) }}
                </div>
                <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">tag</span>
                    TRX-{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}
                </span>
            </div>
            
            <div class="flex flex-col gap-1">
                <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface font-bold tracking-tight uppercase">
                    {{ $transaction->vehicle->plate_number }}
                </h2>
                <p class="font-body-md text-body-md text-on-surface-variant flex items-center gap-xs capitalize">
                    <span class="material-symbols-outlined text-[18px]">directions_car</span>
                    {{ $transaction->vehicle->brand }} {{ $transaction->vehicle->model }}
                </p>
                <p class="font-label-sm text-label-sm text-on-surface-variant mt-2 border-t border-outline-variant pt-2">
                    <strong>Keluhan:</strong> {{ $transaction->complaint }}
                </p>
            </div>
        </div>

        <!-- Details Bento Grid -->
        <div class="grid grid-cols-1 gap-sm mt-xs">
            <!-- Mechanic Info -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-sm flex items-center gap-sm">
                <div class="w-12 h-12 rounded bg-surface-container-high flex items-center justify-center text-primary shrink-0 border border-outline-variant">
                    <span class="material-symbols-outlined text-[24px]">engineering</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Mekanik Kepala</span>
                    <span class="font-label-md text-label-md text-on-surface">{{ $transaction->mechanic->name ?? 'Belum Ditentukan' }}</span>
                </div>
            </div>
            
            <!-- Time & Cost Grid -->
            <div class="grid grid-cols-2 gap-sm">
                <!-- Est Time -->
                <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-sm flex flex-col gap-1">
                    <div class="flex items-center gap-1 text-on-surface-variant mb-1">
                        <span class="material-symbols-outlined text-[16px]">schedule</span>
                        <span class="font-label-sm text-label-sm">Update Terakhir</span>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface">{{ $transaction->updated_at->format('H:i') }} WIB</span>
                    <span class="font-label-sm text-label-sm text-secondary-container mt-auto">{{ $transaction->updated_at->format('d M Y') }}</span>
                </div>
                <!-- Est Cost -->
                <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-sm flex flex-col gap-1">
                    <div class="flex items-center gap-1 text-on-surface-variant mb-1">
                        <span class="material-symbols-outlined text-[16px]">payments</span>
                        <span class="font-label-sm text-label-sm">Total Biaya</span>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface">Rp {{ number_format($transaction->cost, 0, ',', '.') }}</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant mt-auto">Detail Tagihan (Opsional)</span>
                </div>
            </div>
        </div>

        <!-- Progress Timeline (Decorative/Structural) -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-sm mt-xs">
            <h3 class="font-label-md text-label-md text-on-surface mb-sm flex items-center gap-xs">
                <span class="material-symbols-outlined text-[18px]">checklist</span>
                Status Saat Ini
            </h3>
            
            <div class="flex flex-col gap-4 relative before:absolute before:inset-y-2 before:left-[11px] before:w-[2px] before:bg-surface-variant">
                @php
                    $statuses = ['menunggu', 'proses', 'selesai'];
                    $currentIndex = array_search($transaction->status, $statuses);
                    if ($currentIndex === false) $currentIndex = 0;
                @endphp

                @foreach($statuses as $index => $status)
                    <div class="flex gap-sm relative z-10">
                        @if($index < $currentIndex || ($status === 'selesai' && $currentIndex === 2))
                            <!-- Telah Lewati / Selesai Sepenuhnya -->
                            <div class="w-6 h-6 rounded-full {{ $status === 'selesai' ? 'bg-green-500 text-white' : 'bg-primary text-on-primary' }} flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[14px]">check</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-md text-label-md text-on-surface">{{ ucwords($status) }}</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">
                                    {{ $status === 'selesai' ? 'Servis telah tuntas' : 'Telah Selesai' }}
                                </span>
                            </div>
                        @elseif($index === $currentIndex)
                            <!-- Saat ini (Menunggu / Proses) -->
                            <div class="w-6 h-6 rounded-full bg-primary-fixed border-2 border-primary flex items-center justify-center shrink-0">
                                <div class="w-2 h-2 rounded-full bg-primary"></div>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-md text-label-md text-primary">{{ ucwords($status) }}</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">Sedang berlangsung...</span>
                            </div>
                        @else
                            <!-- Belum -->
                            <div class="w-6 h-6 rounded-full bg-surface-container-high border-2 border-outline-variant flex items-center justify-center shrink-0">
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-md text-label-md text-outline">{{ ucwords($status) }}</span>
                                <span class="font-label-sm text-label-sm text-outline-variant">Menunggu</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Button -->
        <a href="https://wa.me/6281234567890" target="_blank" class="w-full min-h-[44px] mt-sm bg-secondary text-on-secondary rounded flex items-center justify-center gap-xs font-label-md text-label-md py-3 shadow-md hover:bg-white hover:text-secondary transition-colors active:scale-[0.98]">
            <span class="material-symbols-outlined text-[20px]">forum</span>
            Hubungi Bengkel (WhatsApp)
        </a>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionId = {{ $transaction->id }};
            const currentStatus = '{{ $transaction->status }}';
            
            // Poll API every 10 seconds
            setInterval(() => {
                fetch(`/api/transactions/${transactionId}/status`)
                    .then(response => response.json())
                    .then(data => {
                        // Jika status dari server berbeda dengan status yang sedang ditampilkan
                        if (data.status && data.status !== currentStatus) {
                            // Reload halaman untuk merender ulang UI dengan status baru
                            window.location.reload();
                        }
                    })
                    .catch(error => console.error('Error polling status:', error));
            }, 10000);
        });
    </script>
@endsection
