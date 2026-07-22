<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">Daftar Mekanik</h2>
        <div class="flex w-full md:w-auto items-center gap-4">
            <!-- Search Bar -->
            <form action="{{ route('mechanics.index') }}" method="GET" class="relative flex-1 md:w-80">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input name="search" value="{{ $search }}" class="w-full h-11 pl-10 pr-4 bg-surface border border-outline-variant rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" placeholder="Cari mekanik atau keahlian..." type="text"/>
            </form>
            <!-- Action Button -->
            <a href="{{ route('mechanics.create') }}" class="hidden md:flex bg-secondary text-on-secondary h-11 px-6 rounded-lg font-semibold items-center gap-2 whitespace-nowrap hover:opacity-90 transition-opacity shadow-sm">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Mekanik
            </a>
        </div>
    </div>

    <!-- Mechanics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($mechanics as $mechanic)
        <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm hover:border-primary/50 transition-colors group flex flex-col">
            <div class="p-6 flex-1 flex flex-col items-center text-center">
                <!-- Avatar Placeholder -->
                <div class="w-20 h-20 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-sora text-2xl font-bold mb-4 shadow-inner">
                    {{ substr($mechanic->name, 0, 1) }}
                </div>
                
                <h3 class="text-lg font-sora font-semibold text-on-surface">{{ $mechanic->name }}</h3>
                <p class="text-sm text-on-surface-variant flex items-center gap-1 mt-1">
                    <span class="material-symbols-outlined text-[16px]">call</span>
                    {{ $mechanic->phone ?: '-' }}
                </p>
                
                <div class="mt-4 pt-4 border-t border-outline-variant/50 w-full">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider block mb-2">Spesialisasi</span>
                    <span class="inline-block bg-surface-container-high px-3 py-1 rounded-full text-xs text-on-surface font-medium border border-outline-variant/30">
                        {{ $mechanic->expertise ?: 'Umum' }}
                    </span>
                </div>
            </div>
            
            <div class="bg-surface-container-low border-t border-outline-variant p-3 flex justify-around">
                <a href="{{ route('mechanics.edit', $mechanic->id) }}" class="flex-1 flex items-center justify-center gap-2 text-primary font-semibold text-sm hover:bg-primary-container py-2 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Edit
                </a>
                <div class="w-px bg-outline-variant my-1"></div>
                <form action="{{ route('mechanics.destroy', $mechanic->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mekanik ini?');" class="flex-1 flex">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center gap-2 text-error font-semibold text-sm hover:bg-error-container py-2 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-on-surface-variant bg-surface rounded-xl border border-outline-variant shadow-sm">
            <span class="material-symbols-outlined text-4xl mb-2 opacity-50">engineering</span>
            <p>Belum ada data mekanik terdaftar.</p>
        </div>
        @endforelse
    </div>

    @if($mechanics->hasPages())
    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $mechanics->links() }}
    </div>
    @endif

    <x-fab route="{{ route('mechanics.create') }}" icon="engineering" />
</x-app-layout>
