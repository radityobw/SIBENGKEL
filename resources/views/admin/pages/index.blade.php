<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-sora font-bold text-on-background">Pengaturan Halaman</h1>
            <p class="text-on-surface-variant mt-1">Kelola konten statis seperti Privacy Policy dan Terms of Service.</p>
        </div>
    </div>

    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant text-on-surface-variant text-sm font-semibold uppercase tracking-wider">
                        <th class="px-6 py-4">Judul Halaman</th>
                        <th class="px-6 py-4">Slug / URL</th>
                        <th class="px-6 py-4">Terakhir Diperbarui</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($pages as $page)
                        <tr class="hover:bg-surface-container-lowest/50 transition-colors">
                            <td class="px-6 py-4 font-medium">{{ $page->title }}</td>
                            <td class="px-6 py-4 text-on-surface-variant font-mono text-sm">/{{ $page->slug }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $page->updated_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('pages.edit', $page) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary-container text-on-primary-container hover:bg-primary hover:text-on-primary rounded text-sm font-medium transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">edit</span> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-on-surface-variant">
                                Belum ada halaman yang ditambahkan. Silakan jalankan Seeder.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
