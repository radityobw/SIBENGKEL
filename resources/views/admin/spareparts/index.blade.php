<x-app-layout>
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-2xl font-sora font-semibold text-on-surface leading-tight">
                {{ __('Katalog & Stok Sparepart') }}
            </h2>
            <p class="text-xs text-on-surface-variant mt-1">Cek ketersediaan stok produk dan harga eceran tertinggi (HET).</p>
        </div>
        @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.spareparts.create') }}" class="bg-primary hover:bg-primary/90 text-on-primary font-bold py-2 px-4 rounded-lg text-sm">
            Tambah Sparepart
        </a>
        @endif
    </div>

    <div class="max-w-7xl mx-auto w-full">
        
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-surface dark:bg-[#161615] overflow-hidden shadow-sm sm:rounded-lg border border-outline-variant dark:border-[#3E3E3A]">
            <div class="p-6 text-on-surface dark:text-[#EDEDEC] overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-on-surface-variant dark:text-gray-400 uppercase bg-surface-container-low dark:bg-[#111111] border-b border-outline-variant dark:border-[#3E3E3A]">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-16">Foto</th>
                            <th scope="col" class="px-6 py-3">Nama Produk</th>
                            <th scope="col" class="px-6 py-3">Kategori</th>
                            <th scope="col" class="px-6 py-3">Harga</th>
                            <th scope="col" class="px-6 py-3 text-center">Stok Available</th>
                            @if(Auth::user()->role === 'admin')
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($spareparts as $item)
                            <tr class="bg-surface dark:bg-[#161615] border-b border-outline-variant dark:border-[#3E3E3A] hover:bg-surface-container-lowest dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    @if($item->image_path)
                                        <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover rounded border border-outline-variant dark:border-[#3E3E3A]">
                                    @else
                                        <div class="w-10 h-10 bg-surface-container-high dark:bg-[#2A2A27] rounded flex items-center justify-center text-on-surface-variant dark:text-gray-400 text-xs">No Img</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-bold text-on-surface dark:text-[#EDEDEC]">{{ $item->name }}</td>
                                <td class="px-6 py-4"><span class="px-2.5 py-1 bg-surface-container-high dark:bg-[#2A2A27] rounded-lg text-xs font-semibold text-on-surface dark:text-[#EDEDEC]">{{ $item->category }}</span></td>
                                <td class="px-6 py-4 font-bold text-on-surface dark:text-[#EDEDEC]">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $item->stock <= 5 ? 'bg-error-container/40 dark:bg-red-900/40 text-error dark:text-red-400' : 'bg-[#10b981]/20 text-[#10b981] dark:text-emerald-400' }}">
                                        {{ $item->stock }} Pcs
                                    </span>
                                </td>
                                @if(Auth::user()->role === 'admin')
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.spareparts.edit', $item->id) }}" class="text-primary dark:text-amber-400 hover:underline mr-3 font-semibold transition-colors">Edit</a>
                                    <form action="{{ route('admin.spareparts.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-error dark:text-red-400 hover:underline font-semibold transition-colors">Hapus</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-on-surface-variant">Tidak ada data sparepart.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $spareparts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
