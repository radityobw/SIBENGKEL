<x-app-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-sora font-bold text-on-surface">Daftar Transaksi</h2>
            <p class="text-on-surface-variant mt-1 text-sm">Kelola dan pantau semua transaksi servis kendaraan.</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="hidden md:flex bg-secondary hover:bg-secondary/90 text-on-secondary py-2 px-4 rounded-lg items-center justify-center gap-2 shadow-sm border border-secondary transition-all active:scale-95 duration-200 min-h-[44px] shrink-0 font-medium text-sm">
            <span class="material-symbols-outlined">add</span>
            Buat Transaksi Baru
        </a>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('transactions.index') }}" method="GET" class="bg-surface-container-lowest dark:bg-[#161615] p-4 rounded-xl border border-outline-variant dark:border-[#3E3E3A] shadow-sm mb-8 flex flex-col md:flex-row gap-4 items-end">
        <div class="w-full md:w-1/3 flex flex-col gap-1">
            <label class="font-medium text-xs text-on-surface-variant dark:text-gray-400 uppercase tracking-wider">Status</label>
            <div class="relative">
                <select name="status" class="w-full pl-4 pr-10 py-2 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-on-surface dark:text-[#EDEDEC] appearance-none min-h-[44px]">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
            </div>
        </div>
        <button type="submit" class="w-full md:w-auto bg-surface-variant hover:bg-surface-variant/80 text-on-surface-variant py-2 px-4 rounded-lg flex items-center justify-center gap-2 border border-outline-variant transition-all min-h-[44px] font-medium text-sm">
            <span class="material-symbols-outlined">filter_list</span>
            Filter
        </button>
        @if(request('status'))
            <a href="{{ route('transactions.index') }}" class="w-full md:w-auto text-on-surface-variant py-2 px-4 rounded-lg flex items-center justify-center hover:bg-surface-variant transition-all min-h-[44px] font-medium text-sm">
                Reset
            </a>
        @endif
    </form>

    <!-- Data Table -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold min-w-[120px]">Tanggal</th>
                        <th class="p-4 font-semibold min-w-[150px]">Kendaraan</th>
                        <th class="p-4 font-semibold min-w-[200px]">Pelanggan</th>
                        <th class="p-4 font-semibold min-w-[200px]">Mekanik</th>
                        <th class="p-4 font-semibold min-w-[150px] text-right">Biaya</th>
                        <th class="p-4 font-semibold min-w-[120px] text-center">Status</th>
                        <th class="p-4 font-semibold min-w-[120px] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant text-sm">
                    @forelse($transactions as $tx)
                    <tr class="hover:bg-surface-container-low/50 transition-colors group {{ $loop->even ? 'bg-surface-bright' : '' }}">
                        <td class="p-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}</td>
                        <td class="p-4 font-medium text-on-surface whitespace-nowrap">{{ $tx->vehicle->plate_number }} <span class="text-xs text-on-surface-variant font-normal block">{{ $tx->vehicle->brand }} {{ $tx->vehicle->model }}</span></td>
                        <td class="p-4">
                            <span class="truncate max-w-[150px] font-medium text-on-surface block">{{ $tx->vehicle->customer->name }}</span>
                            <span class="text-xs text-on-surface-variant">{{ $tx->vehicle->customer->phone ?? '-' }}</span>
                        </td>
                        <td class="p-4">{{ $tx->mechanic ? $tx->mechanic->name : '-' }}</td>
                        <td class="p-4 text-right font-medium">Rp {{ number_format($tx->cost, 0, ',', '.') }}</td>
                        <td class="p-4 text-center">
                            @if($tx->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300">Pending</span>
                            @elseif($tx->status === 'proses')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-300">Proses</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">Selesai</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('transactions.invoice', $tx->id) }}" target="_blank" title="Cetak Nota" class="w-8 h-8 rounded-full inline-flex items-center justify-center text-on-surface-variant hover:bg-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-sm">print</span>
                                </a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('transactions.edit', $tx->id) }}" title="Edit" class="w-8 h-8 rounded-full inline-flex items-center justify-center text-on-surface-variant hover:bg-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $tx->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus" class="w-8 h-8 rounded-full inline-flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                                @endif
                                @if($tx->status !== 'selesai')
                                    <form action="{{ route('transactions.updateStatus', $tx->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $tx->status === 'pending' ? 'proses' : 'selesai' }}">
                                        <button type="submit" title="Update Status: {{ $tx->status === 'pending' ? 'Proses' : 'Selesai' }}" class="w-8 h-8 rounded-full inline-flex items-center justify-center text-on-surface-variant hover:bg-surface-variant hover:text-secondary transition-colors">
                                            <span class="material-symbols-outlined text-sm">update</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-on-surface-variant">
                            Belum ada data transaksi servis.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="p-4 border-t border-outline-variant flex items-center justify-between text-xs text-on-surface-variant bg-surface-container-lowest">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
    <x-fab route="{{ route('transactions.create') }}" icon="receipt_long" />

</x-app-layout>
