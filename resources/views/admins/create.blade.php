<x-app-layout>
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-2">
            <a href="{{ route('admins.index') }}" class="text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-2xl md:text-3xl font-sora font-bold text-on-surface">Tambah Admin Baru</h2>
        </div>
        <p class="text-on-surface-variant text-sm ml-8">Buat akun administrator baru untuk sistem SIBENGKEL.</p>
    </div>

    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden max-w-3xl mx-auto w-full">
        <form action="{{ route('admins.store') }}" method="POST" class="p-6 md:p-8 flex flex-col gap-6">
            @csrf
            
            <!-- Nama Lengkap -->
            <div class="flex flex-col gap-2">
                <label for="name" class="font-semibold text-sm text-on-surface">Nama Lengkap <span class="text-error">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">person</span>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-on-surface transition-colors"
                        placeholder="Masukkan nama lengkap admin">
                </div>
                @error('name')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Username -->
            <div class="flex flex-col gap-2">
                <label for="username" class="font-semibold text-sm text-on-surface">Username <span class="text-error">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">badge</span>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required
                        class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-on-surface transition-colors"
                        placeholder="Contoh: adminbudi">
                </div>
                @error('username')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-2">
                <label for="email" class="font-semibold text-sm text-on-surface">Alamat Email <span class="text-error">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">mail</span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-on-surface transition-colors"
                        placeholder="admin@sibengkel.com">
                </div>
                @error('email')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div class="flex flex-col gap-2">
                    <label for="password" class="font-semibold text-sm text-on-surface">Password <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">lock</span>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-on-surface transition-colors"
                            placeholder="Minimal 8 karakter">
                    </div>
                    @error('password')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div class="flex flex-col gap-2">
                    <label for="password_confirmation" class="font-semibold text-sm text-on-surface">Konfirmasi Password <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">lock_check</span>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-on-surface transition-colors"
                            placeholder="Ulangi password">
                    </div>
                    @error('password_confirmation')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-outline-variant flex justify-end gap-3 mt-2">
                <a href="{{ route('admins.index') }}" class="py-2.5 px-6 rounded-lg font-medium text-sm text-on-surface-variant hover:bg-surface-variant transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary hover:bg-primary/90 text-on-primary py-2.5 px-6 rounded-lg font-medium text-sm flex items-center justify-center gap-2 shadow-sm transition-all active:scale-95">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Akun Admin
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
