<x-app-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-sora font-bold text-primary">Manajemen Admin</h2>
            <p class="text-on-surface-variant mt-1 text-sm">Kelola akun administrator sistem.</p>
        </div>
        <a href="{{ route('admins.create') }}" class="bg-secondary hover:bg-secondary/90 text-on-secondary py-2 px-4 rounded-lg flex items-center justify-center gap-2 shadow-sm border border-secondary transition-all active:scale-95 duration-200 min-h-[44px] shrink-0 font-medium text-sm">
            <span class="material-symbols-outlined">add</span>
            Tambah Admin Baru
        </a>
    </div>

    @if(session('error'))
        <div class="bg-error-container text-on-error-container p-4 rounded-lg font-medium border border-error mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold min-w-[200px]">Nama Lengkap</th>
                        <th class="p-4 font-semibold min-w-[150px]">Username</th>
                        <th class="p-4 font-semibold min-w-[200px]">Email</th>
                        <th class="p-4 font-semibold min-w-[150px]">Tgl Dibuat</th>
                        <th class="p-4 font-semibold min-w-[100px] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant text-sm">
                    @forelse($admins as $admin)
                    <tr class="hover:bg-surface-container-low/50 transition-colors group {{ $loop->even ? 'bg-surface-bright' : '' }}">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-sm shrink-0 border border-outline-variant">
                                    {{ substr($admin->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-on-surface">{{ $admin->name }}</span>
                                    @if($admin->id === Auth::id())
                                        <span class="text-[10px] font-bold bg-primary text-on-primary px-2 py-0.5 rounded-full inline-block mt-1 w-max">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-medium">{{ $admin->username }}</td>
                        <td class="p-4">{{ $admin->email }}</td>
                        <td class="p-4 whitespace-nowrap">{{ $admin->created_at->format('d M Y') }}</td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admins.edit', $admin->id) }}" title="Edit" class="w-8 h-8 rounded-full inline-flex items-center justify-center text-on-surface-variant hover:bg-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                @if($admin->id !== Auth::id())
                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun Admin ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus" class="w-8 h-8 rounded-full inline-flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                                @else
                                <span class="w-8 h-8 rounded-full inline-flex items-center justify-center text-outline cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-on-surface-variant">
                            Belum ada akun admin lain.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($admins->hasPages())
        <div class="p-4 border-t border-outline-variant flex items-center justify-between text-xs text-on-surface-variant bg-surface-container-lowest">
            {{ $admins->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
