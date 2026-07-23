<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('pages.index') }}" class="w-10 h-10 rounded-full flex items-center justify-center bg-surface-container border border-outline-variant hover:bg-surface-container-high transition-colors text-on-surface-variant">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-sora font-bold text-on-background">Edit Halaman</h1>
                <p class="text-on-surface-variant mt-1">/{{ $page->slug }}</p>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
        <form action="{{ route('pages.update', $page) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-2">Judul Halaman <span class="text-error">*</span></label>
                <input type="text" name="title" value="{{ old('title', $page->title) }}" class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required>
                @error('title')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold mb-2">Konten (HTML Mendukung)</label>
                <textarea name="content" rows="15" class="w-full bg-surface border border-outline-variant rounded-lg px-4 py-3 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-mono text-sm" placeholder="Gunakan HTML untuk formatting, misalnya <h2>, <p>, atau <ul>...">{{ old('content', $page->content) }}</textarea>
                @error('content')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-on-surface-variant mt-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">info</span>
                    Anda dapat menggunakan tag HTML untuk merapikan teks.
                </p>
            </div>

            <div class="flex justify-end pt-4 border-t border-outline-variant">
                <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-bold shadow-sm hover:opacity-90 transition-opacity flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
