@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pesanan Sparepart') }}
        </h2>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID Order</th>
                            <th scope="col" class="px-6 py-3">Waktu</th>
                            <th scope="col" class="px-6 py-3">Pelanggan</th>
                            <th scope="col" class="px-6 py-3">Total Belanja</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    {{ $order->customer->name ?? '-' }}<br>
                                    <span class="text-xs text-gray-500">{{ $order->customer->phone ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs text-white
                                        @if($order->status == 'menunggu_pembayaran') bg-yellow-500
                                        @elseif($order->status == 'diproses') bg-blue-500
                                        @elseif($order->status == 'selesai') bg-green-500
                                        @else bg-red-500 @endif
                                    ">
                                        {{ str_replace('_', ' ', strtoupper($order->status)) }}
                                    </span>
                                    <div class="text-[10px] text-gray-500 mt-1">{{ $order->orderItems->count() }} item</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status pesanan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="text-xs border-gray-300 rounded p-1 mb-1" onchange="this.form.submit()">
                                            <option value="menunggu_pembayaran" {{ $order->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Bayar</option>
                                            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </form>
                                    <div class="mt-2 text-left bg-gray-50 p-2 rounded text-xs hidden" id="detail-{{ $order->id }}">
                                        @foreach($order->orderItems as $item)
                                            <div class="mb-1 border-b border-gray-200 pb-1">
                                                - {{ optional($item->sparePart)->name ?? 'Terhapus' }} ({{ $item->qty }}x)
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="document.getElementById('detail-{{ $order->id }}').classList.toggle('hidden')" class="text-[10px] text-indigo-600 hover:underline">Toggle Detail</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada pesanan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
