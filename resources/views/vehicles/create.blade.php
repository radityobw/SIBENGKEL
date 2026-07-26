<x-app-layout>
    <div class="max-w-3xl mx-auto w-full">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('vehicles.index') }}" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">{{ isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru' }}</h2>
        </div>

        <div class="bg-surface rounded-xl border border-outline-variant shadow-sm p-6 lg:p-8">
            <form action="{{ isset($vehicle) ? route('vehicles.update', $vehicle->id) : route('vehicles.store') }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($vehicle))
                    @method('PUT')
                @endif

                <div class="space-y-2">
                    <label for="customer_id" class="block text-sm font-semibold text-on-surface">Pemilik (Pelanggan) <span class="text-error">*</span></label>
                    <select id="customer_id" name="customer_id" required
                        class="w-full h-11 px-4 bg-surface dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded-lg text-on-surface dark:text-[#EDEDEC] focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ (old('customer_id', $vehicle->customer_id ?? '') == $customer->id) ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="plate_number" class="block text-sm font-semibold text-on-surface">Nomor Polisi <span class="text-error">*</span></label>
                    <input type="text" id="plate_number" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number ?? '') }}" required
                        class="w-full h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow uppercase" 
                        placeholder="Contoh: B 1234 XYZ">
                    @error('plate_number')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="brand" class="block text-sm font-semibold text-on-surface">Merek <span class="text-error">*</span></label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand', $vehicle->brand ?? '') }}" required
                            class="w-full h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                            placeholder="Contoh: Honda">
                        @error('brand')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="model" class="block text-sm font-semibold text-on-surface">Model / Tipe <span class="text-error">*</span></label>
                        <input type="text" id="model" name="model" value="{{ old('model', $vehicle->model ?? '') }}" required
                            class="w-full h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                            placeholder="Contoh: Vario 150">
                        @error('model')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="year" class="block text-sm font-semibold text-on-surface">Tahun Pembuatan <span class="text-error">*</span></label>
                    <input type="number" id="year" name="year" value="{{ old('year', $vehicle->year ?? '') }}" required
                        min="1900" max="{{ date('Y')+1 }}"
                        class="w-full md:w-1/2 h-11 px-4 bg-surface border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
                        placeholder="Contoh: 2022">
                    @error('year')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-outline-variant mt-8">
                    <a href="{{ route('vehicles.index') }}" class="px-6 py-2 rounded-lg font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary text-on-primary h-11 px-8 rounded-lg font-semibold hover:opacity-90 transition-opacity shadow-sm">
                        {{ isset($vehicle) ? 'Simpan Perubahan' : 'Simpan Kendaraan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
