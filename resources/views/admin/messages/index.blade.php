<x-app-layout>
<div class="px-margin-mobile md:px-margin-desktop py-6 w-full max-w-[1400px] mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="font-headline-sm text-headline-sm font-bold text-on-background">Pesan Masuk</h1>
            <p class="text-body-md text-on-surface-variant">Pesan dari halaman Contact Us</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-primary-container text-on-primary-container p-4 rounded-lg mb-6 flex items-start gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-surface border border-outline-variant rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-lowest border-b border-outline-variant">
                        <th class="p-4 font-bold text-on-surface-variant">Pengirim</th>
                        <th class="p-4 font-bold text-on-surface-variant">Pesan</th>
                        <th class="p-4 font-bold text-on-surface-variant">Tanggal</th>
                        <th class="p-4 font-bold text-on-surface-variant text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($messages as $message)
                        <tr class="hover:bg-surface-container-lowest transition-colors {{ $message->is_read ? 'opacity-70' : 'bg-primary/5 font-semibold' }}">
                            <td class="p-4 align-top">
                                <div class="text-on-surface">{{ $message->name }}</div>
                                <div class="text-sm text-on-surface-variant">{{ $message->email }}</div>
                                @if(!$message->is_read)
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs bg-error text-white font-bold">Baru</span>
                                @endif
                            </td>
                            <td class="p-4 align-top max-w-[400px]">
                                <div class="text-on-surface whitespace-pre-wrap">{{ $message->message }}</div>
                            </td>
                            <td class="p-4 align-top text-sm text-on-surface-variant">
                                {{ $message->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="p-4 align-top text-center">
                                <div class="flex justify-center gap-2">
                                    @if(!$message->is_read)
                                        <form action="{{ route('admin.messages.read', $message) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center hover:opacity-80 transition-opacity" title="Tandai Sudah Dibaca">
                                                <span class="material-symbols-outlined text-[18px]">mark_email_read</span>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-full bg-error text-white flex items-center justify-center hover:opacity-80 transition-opacity" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50 block">inbox</span>
                                Belum ada pesan yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($messages->hasPages())
            <div class="p-4 border-t border-outline-variant">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
</x-app-layout>
