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
                                    <br><span class="text-xs font-normal text-on-surface-variant">{{ $booking->vehicle->plate_number ?? $booking->vehicle->plate_number ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($booking->preferred_date)->translatedFormat('d M Y') }}
                                    <br><span class="text-xs text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->preferred_time)->format('H:i') }} WIB</span>
                                </td>
                                <td class="px-6 py-4 text-xs max-w-xs truncate" title="{{ $booking->complaint }}">
                                    {{ $booking->complaint ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-bold text-white
                                        @if($booking->status == 'menunggu_konfirmasi') bg-amber-500
                                        @elseif($booking->status == 'disetujui') bg-blue-600
                                        @elseif($booking->status == 'dikonversi') bg-emerald-600
                                        @else bg-rose-600 @endif
                                    ">
                                        {{ str_replace('_', ' ', strtoupper($booking->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($booking->status == 'menunggu_konfirmasi')
                                        <button type="button" onclick="document.getElementById('modal-{{ $booking->id }}').classList.remove('hidden')" class="bg-primary hover:bg-primary/90 text-on-primary px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition-colors">
                                            Proses Booking
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div id="modal-{{ $booking->id }}" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center backdrop-blur-sm">
                                            <div class="bg-surface rounded-xl shadow-lg w-full max-w-md mx-4 overflow-hidden border border-outline-variant text-left">
                                                <div class="p-4 border-b border-outline-variant flex justify-between items-center bg-surface-container-lowest">
                                                    <h3 class="font-bold text-on-surface">Proses Booking #SB-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</h3>
                                                    <button type="button" onclick="document.getElementById('modal-{{ $booking->id }}').classList.add('hidden')" class="text-on-surface-variant hover:text-on-surface">
                                                        <span class="material-symbols-outlined">close</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="p-4 space-y-4">
                                                        <p class="text-sm text-on-surface-variant">Tentukan mekanik dan estimasi biaya awal sebelum menyetujui booking ini. Atau Anda dapat menolak booking ini.</p>
                                                        
                                                        <div>
                                                            <label class="block text-xs font-semibold text-on-surface mb-1">Mekanik Bertugas <span class="text-error">*</span></label>
                                                            <select name="mechanic_id" id="mechanic-{{ $booking->id }}" class="w-full border border-outline-variant rounded-lg p-2 text-sm bg-surface focus:ring-primary focus:border-primary" required>
                                                                <option value="">-- Pilih Mekanik --</option>
                                                                @foreach($mechanics as $mechanic)
                                                                    <option value="{{ $mechanic->id }}" 
                                                                        @if(Auth::user()->role === 'mekanik' && optional(Auth::user()->mechanic)->id === $mechanic->id) selected @endif>
                                                                        {{ $mechanic->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="block text-xs font-semibold text-on-surface mb-1">Estimasi Biaya (Rp) <span class="text-error">*</span></label>
                                                            <input type="number" name="cost" id="cost-{{ $booking->id }}" value="0" min="0" class="w-full border border-outline-variant rounded-lg p-2 text-sm bg-surface focus:ring-primary focus:border-primary" required>
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="block text-xs font-semibold text-on-surface mb-1">Keputusan</label>
                                                            <select name="status" class="w-full border border-outline-variant rounded-lg p-2 text-sm bg-surface focus:ring-primary focus:border-primary" required onchange="
                                                                if(this.value === 'ditolak') { 
                                                                    document.getElementById('mechanic-{{ $booking->id }}').required = false; 
                                                                    document.getElementById('cost-{{ $booking->id }}').required = false; 
                                                                } else { 
                                                                    document.getElementById('mechanic-{{ $booking->id }}').required = true; 
                                                                    document.getElementById('cost-{{ $booking->id }}').required = true; 
                                                                }">
                                                                <option value="disetujui">Setujui (Masuk Antrean Servis)</option>
                                                                <option value="ditolak">Tolak Booking</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="p-4 border-t border-outline-variant bg-surface-container-lowest flex justify-end gap-2">
                                                        <button type="button" onclick="document.getElementById('modal-{{ $booking->id }}').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-on-surface-variant hover:bg-surface-variant rounded-lg transition-colors">Batal</button>
                                                        <button type="submit" class="px-4 py-2 text-sm font-medium bg-primary text-on-primary hover:bg-primary/90 rounded-lg transition-colors">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif($booking->status == 'disetujui' && $booking->service_transaction_id)
                                        <a href="{{ route('transactions.edit', $booking->service_transaction_id) }}" class="inline-flex items-center gap-1 text-primary hover:underline text-xs font-bold">
                                            Lihat Transaksi <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                        </a>
                                    @elseif($booking->status == 'dikonversi')
                                        <!-- Fallback for incorrectly seeded data -->
                                        @if($booking->service_transaction_id)
                                            <a href="{{ route('transactions.edit', $booking->service_transaction_id) }}" class="inline-flex items-center gap-1 text-primary hover:underline text-xs font-bold">
                                                Lihat Transaksi <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </a>
                                        @else
                                            <span class="text-xs font-bold text-on-surface-variant">Data Seed Lama</span>
                                        @endif
                                    @elseif($booking->status == 'ditolak')
                                        <span class="text-xs font-bold text-error">Ditolak</span>
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
