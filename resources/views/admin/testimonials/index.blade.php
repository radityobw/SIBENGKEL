<x-app-layout>
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-sora font-semibold text-on-surface">Daftar Ulasan</h2>
        <a href="{{ route('admin.testimonials.create') }}" class="hidden md:flex bg-primary text-on-primary hover:bg-primary/90 px-4 py-2 rounded-lg font-medium transition-colors items-center gap-2">
            <span class="material-symbols-outlined">add</span>
            Tambah Ulasan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant text-sm border-b border-outline-variant">
                        <th class="p-4 font-semibold">Pelanggan</th>
                        <th class="p-4 font-semibold">Kendaraan</th>
                        <th class="p-4 font-semibold">Bintang</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($testimonials as $testimonial)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="p-4">
                            <div class="font-medium text-on-surface">{{ $testimonial->customer_name }}</div>
                            <div class="text-xs text-on-surface-variant truncate max-w-xs" title="{{ $testimonial->content }}">{{ Str::limit($testimonial->content, 40) }}</div>
                        </td>
                        <td class="p-4 text-on-surface-variant">{{ $testimonial->vehicle ?? '-' }}</td>
                        <td class="p-4">
                            <div class="flex text-secondary text-sm">
                                @for($i = 0; $i < $testimonial->rating; $i++)
                                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1; font-size: 16px;">star</span>
                                @endfor
                            </div>
                        </td>
                        <td class="p-4">
                            @if($testimonial->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Disembunyikan</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-error hover:bg-error-container/50 rounded-lg transition-colors" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-on-surface-variant">
                            Belum ada ulasan yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($testimonials->hasPages())
        <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
            {{ $testimonials->links() }}
        </div>
        @endif
    </div>
</div>
    <x-fab route="{{ route('admin.testimonials.create') }}" icon="reviews" />

</x-app-layout>
