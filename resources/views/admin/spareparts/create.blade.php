<x-app-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-sora font-semibold text-on-surface leading-tight">
            {{ __('Tambah Sparepart Baru') }}
        </h2>
    </div>

    <div class="max-w-7xl mx-auto w-full">
        
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-surface overflow-hidden shadow-sm sm:rounded-lg border border-outline-variant">
            <div class="p-6 text-on-surface">
                <form action="{{ route('admin.spareparts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-on-surface mb-1">Nama Produk <span class="text-error">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full bg-surface-container-low rounded-md border-outline-variant shadow-sm focus:border-primary focus:ring-primary text-on-surface">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-on-surface mb-1">Kategori <span class="text-error">*</span></label>
                            <input type="text" name="category" id="category" value="{{ old('category') }}" required placeholder="Contoh: Oli, Ban, Kampas Rem" class="w-full bg-surface-container-low rounded-md border-outline-variant shadow-sm focus:border-primary focus:ring-primary text-on-surface">
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-on-surface mb-1">Harga Jual (Rp) <span class="text-error">*</span></label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" class="w-full bg-surface-container-low rounded-md border-outline-variant shadow-sm focus:border-primary focus:ring-primary text-on-surface">
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-on-surface mb-1">Stok Awal <span class="text-error">*</span></label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" required min="0" class="w-full bg-surface-container-low rounded-md border-outline-variant shadow-sm focus:border-primary focus:ring-primary text-on-surface">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-on-surface mb-1">Deskripsi Produk</label>
                        <textarea name="description" id="description" rows="3" class="w-full bg-surface-container-low rounded-md border-outline-variant shadow-sm focus:border-primary focus:ring-primary text-on-surface">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-on-surface mb-1">Foto Produk</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 dark:file:bg-secondary dark:hover:file:bg-secondary/90 cursor-pointer">
                        <p class="mt-1 text-sm text-on-surface-variant">Maksimal 2MB. Format JPG, PNG.</p>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-outline-variant pt-4 mt-2">
                        <a href="{{ route('admin.spareparts.index') }}" class="bg-surface-container-highest text-on-surface py-2 px-4 rounded-md text-sm font-medium hover:bg-surface-variant transition-colors">Batal</a>
                        <button type="submit" class="bg-primary text-on-primary py-2 px-4 rounded-md text-sm font-medium hover:bg-primary/90 transition-colors">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
