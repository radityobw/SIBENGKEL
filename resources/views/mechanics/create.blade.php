<x-app-layout>
    <div class="max-w-3xl mx-auto w-full">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('mechanics.index') }}" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">{{ isset($mechanic) ? 'Edit Mekanik' : 'Tambah Mekanik Baru' }}</h2>
        </div>

        <div class="bg-surface rounded-xl border border-outline-variant shadow-sm p-6 lg:p-8">
            <form action="{{ isset($mechanic) ? route('mechanics.update', $mechanic->id) : route('mechanics.store') }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($mechanic))
                    @method('PUT')
                @endif

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-on-surface">Nama Lengkap <span class="text-error">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $mechanic->name ?? '') }}" required
                        class="w-full h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                        placeholder="Contoh: Agus Teknis">
                    @error('name')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-on-surface">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $mechanic->phone ?? '') }}"
                        class="w-full h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                        placeholder="Contoh: 089876543210 (Opsional)">
                    @error('phone')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="expertise" class="block text-sm font-semibold text-on-surface">Spesialisasi / Keahlian</label>
                    <input type="text" id="expertise" name="expertise" value="{{ old('expertise', $mechanic->expertise ?? '') }}"
                        class="w-full h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                        placeholder="Contoh: Spesialis Mesin & Injeksi (Opsional)">
                    @error('expertise')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-outline-variant mt-8">
                    <a href="{{ route('mechanics.index') }}" class="px-6 py-2 rounded-lg font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary text-on-primary h-11 px-8 rounded-lg font-semibold hover:opacity-90 transition-opacity shadow-sm">
                        {{ isset($mechanic) ? 'Simpan Perubahan' : 'Simpan Mekanik' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
