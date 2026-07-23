<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-sora font-semibold text-on-surface leading-tight">
            {{ __('Kelola Booking Servis Masuk') }}
        </h2>
    </div>

    <div class="max-w-7xl mx-auto w-full">
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
            <div class="p-6 text-on-surface overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-on-surface-variant uppercase bg-surface-container-low">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID Booking</th>
                            <th scope="col" class="px-6 py-3">Pelanggan</th>
                            <th scope="col" class="px-6 py-3">Kendaraan</th>
                            <th scope="col" class="px-6 py-3">Jadwal Diajukan</th>
                            <th scope="col" class="px-6 py-3">Keluhan</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="bg-surface border-b border-outline-variant/40 hover:bg-surface-container-low">
                                <td class="px-6 py-4 font-bold text-primary">#SB-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 font-semibold">
                                    {{ $booking->customer->name ?? '-' }}
                                    <br><span class="text-xs font-normal text-on-surface-variant">{{ $booking->customer->phone ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 font-semibold">
                                    {{ $booking->vehicle->brand ?? '-' }} {{ $booking->vehicle->model ?? '-' }}
                                    <br><span class="text-xs font-normal text-on-surface-variant">{{ $booking->vehicle->plate_number ?? $booking->vehicle->nomor_polisi ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($booking->preferred_date)->translatedFormat('d M Y') }}
                                    <br><span class="text-xs text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->preferred_time)->format('H:i') }} WIB</span>
                                </td>
                                <td class="px-6 py-4 text-xs max-w-xs truncate" title="{{ $booking->complaint }}">
                                    {{ $booking->complaint ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold text-white
                                        @if($booking->status == 'menunggu_konfirmasi') bg-amber-500
                                        @elseif($booking->status == 'disetujui') bg-blue-600
                                        @elseif($booking->status == 'dikonversi') bg-emerald-600
                                        @else bg-rose-600 @endif
                                    ">
                                        {{ str_replace('_', ' ', strtoupper($booking->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($booking->status != 'dikonversi')
                                        <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui status booking ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="text-xs border border-outline-variant rounded-lg p-1.5 bg-surface text-on-surface focus:ring-primary" onchange="this.form.submit()">
                                                <option value="" disabled selected>Ubah Status</option>
                                                @if($booking->status != 'disetujui')
                                                    <option value="disetujui">Setujui</option>
                                                @endif
                                                <option value="dikonversi">Konversi ke Transaksi Servis</option>
                                                <option value="ditolak">Tolak</option>
                                            </select>
                                        </form>
                                    @else
                                        @if($booking->service_transaction_id)
                                            <a href="{{ route('transactions.edit', $booking->service_transaction_id) }}" class="inline-flex items-center gap-1 text-primary hover:underline text-xs font-bold">
                                                Lihat Transaksi <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-on-surface-variant">Belum ada booking servis dari pelanggan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
