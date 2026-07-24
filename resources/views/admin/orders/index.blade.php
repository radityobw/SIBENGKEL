<x-app-layout>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">Pesanan Online</h1>
            <p class="text-base text-on-surface-variant mt-1">Kelola pesanan sparepart dari pelanggan portal.</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-secondary">shopping_bag</span>
            <span>{{ $orders->total() }} total pesanan</span>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-surface-container-low border-b border-outline-variant text-on-surface-variant text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">ID Order</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Pelanggan</th>
                        <th class="px-4 py-3">Item</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="px-4 py-3 font-mono font-bold text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3 text-on-surface-variant whitespace-nowrap">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-on-surface">{{ $order->customer->name ?? '-' }}</p>
                            <p class="text-xs text-on-surface-variant">{{ $order->customer->phone ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-xs text-on-surface-variant space-y-0.5">
                                @foreach($order->orderItems->take(2) as $item)
                                    <div>• {{ optional($item->sparePart)->name ?? 'Terhapus' }} ({{ $item->qty }}x)</div>
                                @endforeach
                                @if($order->orderItems->count() > 2)
                                    <div class="text-secondary font-semibold">+{{ $order->orderItems->count() - 2 }} lainnya</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-on-surface">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusMap = [
                                    'menunggu_pembayaran' => ['label' => 'Menunggu Bayar', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
                                    'diproses'           => ['label' => 'Diproses',        'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
                                    'selesai'            => ['label' => 'Selesai',          'class' => 'bg-green-100 text-green-800 border-green-200'],
                                    'dibatalkan'         => ['label' => 'Dibatalkan',       'class' => 'bg-red-100 text-red-800 border-red-200'],
                                ];
                                $s = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100 text-gray-800 border-gray-200'];
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-bold border {{ $s['class'] }}">{{ $s['label'] }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs border border-outline-variant rounded-lg px-2 py-1.5 bg-surface text-on-surface focus:ring-1 focus:ring-primary focus:border-primary cursor-pointer">
                                    <option value="menunggu_pembayaran" {{ $order->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Bayar</option>
                                    <option value="diproses"           {{ $order->status == 'diproses'           ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai"            {{ $order->status == 'selesai'            ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan"         {{ $order->status == 'dibatalkan'         ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-5xl text-outline mb-2 block">shopping_bag</span>
                            Belum ada pesanan masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-4 py-3 border-t border-outline-variant bg-surface-container-low">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
