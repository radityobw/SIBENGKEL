<x-app-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-sora font-semibold text-on-surface leading-tight">
            {{ __('Edit Sparepart') }}
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

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('admin.spareparts.update', $sparepart->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $sparepart->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                            <input type="text" name="category" id="category" value="{{ old('category', $sparepart->category) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" id="price" value="{{ old('price', (int)$sparepart->price) }}" required min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Saat Ini <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $sparepart->stock) }}" required min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $sparepart->description) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Foto Produk Baru (Opsional)</label>
                        @if($sparepart->image_path)
                            <div class="mb-2">
                                <img src="{{ Storage::url($sparepart->image_path) }}" alt="Current Image" class="h-24 w-24 object-cover rounded border">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 dark:file:bg-secondary dark:hover:file:bg-secondary/90">
                        <p class="mt-1 text-sm text-gray-500">Abaikan jika tidak ingin mengubah foto.</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.spareparts.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md text-sm font-medium hover:bg-gray-300">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-indigo-700">Perbarui Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
