<x-app-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-on-surface font-sora">Pengaturan Sistem</h1>
            <p class="text-sm text-on-surface-variant">Kelola konfigurasi kontak bantuan dan pesan WhatsApp default.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span> {{ session('success') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="mb-4 bg-error-container text-on-error-container px-4 py-3 rounded-lg text-sm font-semibold flex items-center gap-2 border border-outline-variant">
            <span class="material-symbols-outlined">error</span> Terjadi kesalahan saat menyimpan.
        </div>
    @endif

    <div class="bg-surface border border-outline-variant rounded-xl shadow-sm overflow-hidden max-w-3xl mx-auto w-full">
        <div class="px-6 py-4 border-b border-outline-variant bg-surface-container-lowest flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">contact_support</span>
            <h2 class="font-semibold text-on-surface font-sora">Kontak Bantuan & WhatsApp</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Nomor WhatsApp Admin -->
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-2" for="admin_whatsapp">Nomor WhatsApp Bengkel (Menerima Chat) <span class="text-error">*</span></label>
                    <p class="text-xs text-on-surface-variant mb-2">Gunakan format 62 tanpa spasi atau + (Contoh: 628123456789).</p>
                    <div class="relative max-w-md">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">phone</span>
                        <input type="text" name="admin_whatsapp" id="admin_whatsapp" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-outline-variant bg-surface focus:ring-1 focus:ring-primary focus:border-primary text-sm transition-colors" value="{{ old('admin_whatsapp', $settings['admin_whatsapp']) }}" required>
                    </div>
                    @error('admin_whatsapp') <span class="text-error text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="border-t border-outline-variant pt-6"></div>

                <!-- Pesan WA Default: Lupa Password Pelanggan -->
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-2" for="admin_wa_text">Teks Pesan WhatsApp (Tombol Bantuan Pelanggan) <span class="text-error">*</span></label>
                    <p class="text-xs text-on-surface-variant mb-2">Teks yang akan otomatis terisi saat pelanggan menekan tombol "Hubungi Admin via WhatsApp" di halaman Lupa Password Pelanggan.</p>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-3 text-outline">chat</span>
                        <textarea name="admin_wa_text" id="admin_wa_text" rows="3" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-outline-variant bg-surface focus:ring-1 focus:ring-primary focus:border-primary text-sm transition-colors" required>{{ old('admin_wa_text', $settings['admin_wa_text']) }}</textarea>
                    </div>
                    @error('admin_wa_text') <span class="text-error text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="border-t border-outline-variant pt-6"></div>

                <!-- Pesan WA Default: Lupa Password Admin/Mekanik -->
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-2" for="superadmin_wa_text">Teks Pesan WhatsApp (Tombol Bantuan Staf Internal) <span class="text-error">*</span></label>
                    <p class="text-xs text-on-surface-variant mb-2">Teks yang akan otomatis terisi saat staf/mekanik menekan tombol "Hubungi Super Admin" di halaman Lupa Password Admin.</p>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-3 text-outline">shield_person</span>
                        <textarea name="superadmin_wa_text" id="superadmin_wa_text" rows="3" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-outline-variant bg-surface focus:ring-1 focus:ring-primary focus:border-primary text-sm transition-colors" required>{{ old('superadmin_wa_text', $settings['superadmin_wa_text']) }}</textarea>
                    </div>
                    @error('superadmin_wa_text') <span class="text-error text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-on-primary font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors flex items-center gap-2 text-sm">
                        <span class="material-symbols-outlined text-lg">save</span> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
