<x-app-layout>
<div class="max-w-2xl mx-auto w-full">
    <div class="mb-6">
        <a href="{{ route('admin.testimonials.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-1 font-medium transition-colors">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            Kembali
        </a>
    </div>
    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="customer_name" class="block font-label-md text-on-surface mb-2">Nama Pelanggan <span class="text-error">*</span></label>
            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $testimonial->customer_name) }}" required
                class="w-full h-11 px-4 bg-surface-container-low border border-outline-variant rounded-lg text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            @error('customer_name')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="vehicle" class="block font-label-md text-on-surface mb-2">Kendaraan</label>
            <input type="text" name="vehicle" id="vehicle" value="{{ old('vehicle', $testimonial->vehicle) }}" placeholder="Contoh: Honda Vario 150"
                class="w-full h-11 px-4 bg-surface-container-low border border-outline-variant rounded-lg text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            @error('vehicle')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="rating" class="block font-label-md text-on-surface mb-2">Bintang (1-5) <span class="text-error">*</span></label>
            <select name="rating" id="rating" required class="w-full h-11 px-4 bg-surface-container-low border border-outline-variant rounded-lg text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                <option value="5" {{ old('rating', $testimonial->rating) == '5' ? 'selected' : '' }}>5 Bintang (Sangat Puas)</option>
                <option value="4" {{ old('rating', $testimonial->rating) == '4' ? 'selected' : '' }}>4 Bintang (Puas)</option>
                <option value="3" {{ old('rating', $testimonial->rating) == '3' ? 'selected' : '' }}>3 Bintang (Cukup)</option>
                <option value="2" {{ old('rating', $testimonial->rating) == '2' ? 'selected' : '' }}>2 Bintang (Kurang)</option>
                <option value="1" {{ old('rating', $testimonial->rating) == '1' ? 'selected' : '' }}>1 Bintang (Sangat Kurang)</option>
            </select>
            @error('rating')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block font-label-md text-on-surface mb-2">Isi Ulasan <span class="text-error">*</span></label>
            <textarea name="content" id="content" rows="4" required
                class="w-full p-4 bg-surface-container-low border border-outline-variant rounded-lg text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none">{{ old('content', $testimonial->content) }}</textarea>
            @error('content')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}
                class="w-5 h-5 text-primary border-outline-variant rounded focus:ring-primary">
            <label for="is_active" class="font-body-md text-on-surface">Tampilkan di Landing Page</label>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-outline-variant">
            <a href="{{ route('admin.testimonials.index') }}" class="px-6 py-2 rounded-lg font-medium text-on-surface-variant hover:bg-surface-container transition-colors">Batal</a>
            <button type="submit" class="bg-primary text-on-primary hover:bg-primary/90 px-6 py-2 rounded-lg font-medium transition-colors">Simpan Perubahan</button>
        </div>
    </form>
</div>
</x-app-layout>
