@extends('layouts.customer')

@section('title', 'Edit Profil Saya - SIBENGKEL')
@section('page_title', 'Profil Akun Saya')
@section('back_url', route('public.dashboard'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        <div class="p-md border-b border-outline-variant bg-surface-container-low flex items-center gap-sm">
            <div class="w-16 h-16 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-lg overflow-hidden shrink-0 border-2 border-primary/20 relative group">
                @if($customer->profile_photo_url)
                    <img id="photo-preview-main" src="{{ $customer->profile_photo_url }}" class="w-full h-full object-cover">
                @else
                    <div id="photo-preview-placeholder-main" class="w-full h-full flex items-center justify-center">
                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                    </div>
                    <img id="photo-preview-main" src="" class="w-full h-full object-cover hidden">
                @endif
            </div>
            <div>
                <h2 class="text-headline-md font-bold text-primary">Edit Profil Akun</h2>
                <p class="text-body-md text-on-surface-variant">Perbarui informasi pribadi dan kata sandi Anda.</p>
            </div>
        </div>

        <form action="{{ route('public.profile.update') }}" method="POST" class="p-md space-y-md" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="profile_photo" class="block text-label-md font-bold text-on-surface mb-1">Foto Profil (Opsional)</label>
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*" onchange="previewCustomerPhoto(event)"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 dark:file:bg-secondary dark:hover:file:bg-secondary/90">
            </div>

            <div>
                <label for="name" class="block text-label-md font-bold text-on-surface mb-1">Nama Lengkap <span class="text-error">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                    class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface text-body-md focus:ring-1 focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="phone" class="block text-label-md font-bold text-on-surface mb-1">Nomor Telepon / WhatsApp <span class="text-error">*</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}" required
                    class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface text-body-md focus:ring-1 focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="email" class="block text-label-md font-bold text-on-surface mb-1">Alamat Email (Opsional)</label>
                <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                    class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface text-body-md focus:ring-1 focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="address" class="block text-label-md font-bold text-on-surface mb-1">Alamat Lengkap <span class="text-error">*</span></label>
                <textarea name="address" id="address" rows="3" required
                    class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface text-body-md focus:ring-1 focus:ring-primary focus:border-primary">{{ old('address', $customer->address) }}</textarea>
            </div>

            <hr class="border-outline-variant/50">

            <div class="space-y-sm">
                <h3 class="text-label-lg font-bold text-on-surface">Ubah Password (Opsional)</h3>
                <p class="text-body-sm text-on-surface-variant mb-2">Biarkan kosong jika tidak ingin mengubah password akun.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
                    <div>
                        <label for="password" class="block text-label-md font-bold text-on-surface mb-1">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface text-body-md focus:ring-1 focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-label-md font-bold text-on-surface mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface text-body-md focus:ring-1 focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-sm pt-sm">
                <a href="{{ route('public.dashboard') }}" class="h-11 px-6 border border-outline text-on-surface-variant rounded-DEFAULT font-label-md hover:bg-surface-container-low flex items-center justify-center">Batal</a>
                <button type="submit" class="h-11 px-8 bg-primary text-on-primary rounded-DEFAULT font-label-md hover:opacity-90 flex items-center justify-center gap-2 shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewCustomerPhoto(event) {
        if (event.target.files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(){
                const preview = document.getElementById('photo-preview-main');
                const placeholder = document.getElementById('photo-preview-placeholder-main');
                preview.src = reader.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
