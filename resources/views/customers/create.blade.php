<x-app-layout>
    <div class="max-w-3xl mx-auto w-full">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('customers.index') }}" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">{{ isset($customer) ? 'Edit Pelanggan' : 'Tambah Pelanggan Baru' }}</h2>
        </div>

        <div class="bg-surface rounded-xl border border-outline-variant shadow-sm p-6 lg:p-8">
            <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($customer))
                    @method('PUT')
                @endif

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-on-surface">Nama Lengkap <span class="text-error">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $customer->name ?? '') }}" required
                        class="w-full h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                        placeholder="Contoh: Budi Santoso">
                    @error('name')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-on-surface">Nomor Telepon <span class="text-error">*</span></label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" required
                        class="w-full h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                        placeholder="Contoh: 081234567890">
                    @error('phone')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="address" class="block text-sm font-semibold text-on-surface">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full p-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                        placeholder="Masukkan alamat lengkap (opsional)">{{ old('address', $customer->address ?? '') }}</textarea>
                    @error('address')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-outline-variant mt-8">
                    <a href="{{ route('customers.index') }}" class="px-6 py-2 rounded-lg font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary text-on-primary h-11 px-8 rounded-lg font-semibold hover:opacity-90 transition-opacity shadow-sm">
                        {{ isset($customer) ? 'Simpan Perubahan' : 'Simpan Pelanggan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
