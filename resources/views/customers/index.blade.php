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
            <a href="{{ route('customers.create') }}" class="hidden md:flex bg-secondary text-on-secondary h-11 px-6 rounded-lg font-semibold items-center gap-2 hover:opacity-90 transition-opacity shadow-sm">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Pelanggan
            </a>
        </div>
    </div>

    <!-- Desktop Table (Sembunyi di HP) -->
    <div class="hidden md:block bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold whitespace-nowrap">Nama</th>
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold whitespace-nowrap">No. Telepon</th>
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold whitespace-nowrap">Alamat</th>
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold text-center whitespace-nowrap">Jumlah Kendaraan</th>
                        @if(Auth::user()->role === 'admin')
                        <th class="py-4 px-6 text-sm text-on-surface-variant font-semibold text-right whitespace-nowrap">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-surface-container-lowest transition-colors group {{ $loop->even ? 'bg-surface-bright' : '' }}">
                        <td class="py-4 px-6 font-medium text-on-surface">
                            <div class="flex items-center gap-3">
                                @if($customer->profile_photo_url)
                                    <img src="{{ $customer->profile_photo_url }}" alt="{{ $customer->name }}" class="w-10 h-10 rounded-full object-cover shrink-0 border border-outline-variant">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-sm shrink-0 border border-outline-variant">
                                        {{ substr($customer->name, 0, 1) }}
                                    </div>
                                @endif
                                <span>{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant">{{ $customer->phone }}</td>
                        <td class="py-4 px-6 text-on-surface-variant truncate max-w-xs">{{ $customer->address ?: '-' }}</td>
                        <td class="py-4 px-6 text-center text-on-surface font-semibold">
                            {{ $customer->vehicles_count }}
                        </td>
                        @if(Auth::user()->role === 'admin')
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
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->role === 'admin' ? 5 : 4 }}" class="py-8 px-6 text-center text-on-surface-variant">Belum ada data pelanggan.</td>
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

    <!-- Mobile Card List (Hanya Muncul di HP) -->
    <div class="md:hidden grid grid-cols-1 gap-4 mb-6">
        @forelse($customers as $customer)
        <div class="bg-surface p-4 rounded-xl shadow-sm border border-outline-variant flex flex-col gap-2">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-sora font-semibold text-on-surface text-lg">{{ $customer->name }}</h3>
                    <p class="text-sm text-on-surface-variant flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">call</span> {{ $customer->phone }}
                    </p>
                </div>
                <div class="bg-primary-container text-on-primary-container px-2 py-1 rounded-md text-xs font-bold text-center">
                    {{ $customer->vehicles_count }}<br><span class="font-normal text-[10px]">Mobil/Motor</span>
                </div>
            </div>
            
            @if(Auth::user()->role === 'admin')
            <div class="flex justify-end gap-2 mt-2 pt-3 border-t border-outline-variant/50">
                <a href="{{ route('customers.edit', $customer->id) }}" class="p-2 text-primary hover:bg-primary-container rounded-lg">
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                </a>
                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-error hover:bg-error-container rounded-lg">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div class="text-center p-8 bg-surface rounded-xl border border-outline-variant text-on-surface-variant">Belum ada pelanggan.</div>
        @endforelse
        
        <!-- Mobile Pagination -->
        <div class="mt-2">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- Tambahkan Komponen FAB di paling bawah -->
    <x-fab route="{{ route('customers.create') }}" icon="person_add" />

</x-app-layout>
