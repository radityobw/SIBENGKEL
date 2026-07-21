<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">Daftar Pelanggan</h2>
        <div class="flex w-full md:w-auto items-center gap-4">
            <!-- Search Bar -->
            <form action="{{ route('customers.index') }}" method="GET" class="relative flex-1 md:w-80">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input name="search" value="{{ $search }}" class="w-full h-11 pl-10 pr-4 bg-surface border border-outline-variant rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" placeholder="Cari pelanggan..." type="text"/>
            </form>
            <!-- Action Button -->
            <a href="{{ route('customers.create') }}" class="bg-secondary text-on-secondary h-11 px-6 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap hover:opacity-90 transition-opacity shadow-sm">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Pelanggan
            </a>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold whitespace-nowrap">Nama</th>
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold whitespace-nowrap">No. Telepon</th>
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold whitespace-nowrap">Alamat</th>
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold text-center whitespace-nowrap">Jumlah Kendaraan</th>
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-surface-container-lowest transition-colors group {{ $loop->even ? 'bg-surface-bright' : '' }}">
                        <td class="py-4 px-6 font-medium text-on-surface">{{ $customer->name }}</td>
                        <td class="py-4 px-6 text-on-surface-variant">{{ $customer->phone }}</td>
                        <td class="py-4 px-6 text-on-surface-variant truncate max-w-xs">{{ $customer->address ?: '-' }}</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-container text-on-primary-container font-semibold text-sm">{{ $customer->vehicles_count }}</span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('customers.edit', $customer->id) }}" class="p-2 text-primary hover:bg-primary-container rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-error hover:bg-error-container rounded-lg transition-colors" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 px-6 text-center text-on-surface-variant">Belum ada data pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="border-t border-outline-variant px-6 py-4 bg-surface">
            {{ $customers->links() }}
        </div>
    </div>
</x-app-layout>
