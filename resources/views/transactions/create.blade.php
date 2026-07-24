<x-app-layout>
    <div class="mb-8 hidden md:flex items-center gap-4">
        <a href="{{ route('transactions.index') }}" class="text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest rounded-full p-2 transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_back</span>
        </a>
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface mb-1">Input Transaksi Baru</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Catat rincian layanan atau penjualan bengkel.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden w-full max-w-4xl mx-auto">
        <form action="{{ route('transactions.store') }}" class="space-y-8" method="POST">
            @csrf
            <div class="p-6 md:p-8 space-y-8">
                <!-- Section 1: Vehicle & Customer -->
                <section>
                    <h2 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">directions_car</span>
                        Detail Kendaraan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface mb-2" for="vehicle_id">Pilih Kendaraan <span class="text-error">*</span></label>
                            <div class="relative">
                                <select class="block w-full pl-3 pr-10 py-3 border @error('vehicle_id') border-error @else border-outline @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary focus:border-primary font-body-md text-body-md min-h-[44px]" id="vehicle_id" name="vehicle_id" required>
                                    <option value="">-- Cari Plat Nomor / Pemilik --</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->plate_number }} - {{ $vehicle->customer->name }} ({{ $vehicle->brand }} {{ $vehicle->model }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_id')
                                    <p class="mt-1 text-sm text-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-t border-outline-variant"/>

                <!-- Section 2: Service Details -->
                <section>
                    <h2 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">build</span>
                        Informasi Layanan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface mb-3">Jenis Transaksi <span class="text-error">*</span></label>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <label class="relative flex cursor-pointer rounded-lg border border-outline p-4 focus:outline-none w-full hover:bg-surface-container-low transition-colors has-[:checked]:bg-primary-container has-[:checked]:border-primary has-[:checked]:text-on-primary-container min-h-[44px] items-center">
                                    <input class="sr-only" name="type" type="radio" value="servis" {{ old('type', 'servis') == 'servis' ? 'checked' : '' }}/>
                                    <span class="material-symbols-outlined mr-3">home_repair_service</span>
                                    <span class="font-label-md text-label-md flex-1">Servis / Perbaikan</span>
                                    <span class="material-symbols-outlined opacity-0 check-icon">check_circle</span>
                                </label>
                                <label class="relative flex cursor-pointer rounded-lg border border-outline p-4 focus:outline-none w-full hover:bg-surface-container-low transition-colors has-[:checked]:bg-primary-container has-[:checked]:border-primary has-[:checked]:text-on-primary-container min-h-[44px] items-center">
                                    <input class="sr-only" name="type" type="radio" value="penjualan" {{ old('type') == 'penjualan' ? 'checked' : '' }}/>
                                    <span class="material-symbols-outlined mr-3">shopping_cart</span>
                                    <span class="font-label-md text-label-md flex-1">Penjualan Sparepart</span>
                                    <span class="material-symbols-outlined opacity-0 check-icon">check_circle</span>
                                </label>
                            </div>
                            <style>input:checked ~ .check-icon { opacity: 1; }</style>
                            @error('type')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block font-label-md text-label-md text-on-surface mb-2" for="mechanic_id">Mekanik Bertugas</label>
                            <div class="relative">
                                <select class="block w-full pl-3 pr-10 py-3 border @error('mechanic_id') border-error @else border-outline @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary focus:border-primary font-body-md text-body-md appearance-none min-h-[44px]" id="mechanic_id" name="mechanic_id">
                                    <option value="">-- Pilih Mekanik --</option>
                                    @foreach($mechanics as $mechanic)
                                        <option value="{{ $mechanic->id }}" {{ old('mechanic_id') == $mechanic->id ? 'selected' : '' }}>{{ $mechanic->name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-outline">
                                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">expand_more</span>
                                </div>
                            </div>
                            @error('mechanic_id')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block font-label-md text-label-md text-on-surface mb-2" for="transaction_date">Tanggal Transaksi <span class="text-error">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-outline" style="font-variation-settings: 'FILL' 0;">calendar_today</span>
                                </div>
                                <input class="block w-full pl-10 pr-3 py-3 border @error('transaction_date') border-error @else border-outline @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary focus:border-primary font-body-md text-body-md min-h-[44px]" id="transaction_date" name="transaction_date" type="date" value="{{ old('transaction_date', date('Y-m-d')) }}" required/>
                            </div>
                            @error('transaction_date')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface mb-2" for="complaint">Keluhan / Deskripsi Layanan <span class="text-error">*</span></label>
                            <textarea class="block w-full p-3 border @error('complaint') border-error @else border-outline @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary focus:border-primary font-body-md text-body-md" id="complaint" name="complaint" placeholder="Jelaskan keluhan pelanggan atau rincian pekerjaan yang akan dilakukan..." rows="4" required>{{ old('complaint') }}</textarea>
                            @error('complaint')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface mb-2" for="cost">Estimasi Biaya</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-on-surface-variant font-body-md sm:text-sm">Rp</span>
                                </div>
                                <input class="block w-full rounded-lg border @error('cost') border-error @else border-outline @enderror pl-10 pr-12 py-3 bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-primary font-body-md text-body-md text-right min-h-[44px]" id="cost" name="cost" placeholder="0" type="number" step="0.01" value="{{ old('cost', 0) }}" required/>
                            </div>
                            @error('cost')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface mb-2" for="status">Status Pengerjaan <span class="text-error">*</span></label>
                            <div class="relative">
                                <select class="block w-full pl-3 pr-10 py-3 border @error('status') border-error @else border-outline @enderror rounded-lg bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary focus:border-primary font-body-md text-body-md appearance-none min-h-[44px]" id="status" name="status" required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-outline">
                                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">expand_more</span>
                                </div>
                            </div>
                            @error('status')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer Actions -->
            <div class="bg-surface-container px-6 py-4 flex flex-col-reverse sm:flex-row justify-end items-center gap-3 border-t border-outline-variant rounded-b-xl">
                <a href="{{ route('transactions.index') }}" class="w-full sm:w-auto px-6 py-3 border border-outline text-on-surface bg-transparent rounded-lg font-label-md text-label-md font-semibold hover:bg-surface-container-highest transition-colors min-h-[44px] flex justify-center">
                    Batal
                </a>
                <button class="w-full sm:w-auto px-6 py-3 bg-secondary text-on-secondary rounded-lg font-label-md text-label-md font-semibold hover:bg-secondary/90 transition-colors shadow-sm min-h-[44px] flex items-center justify-center gap-2" type="submit">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
