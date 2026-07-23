@extends('layouts.public')
@section('title', 'Cek Status Servis - SIBENGKEL')
@section('content')
    <!-- Main Content Canvas -->
    <main class="flex-1 flex flex-col items-center justify-center p-margin-mobile md:p-margin-desktop">
        
        @if(session('error'))
        <div class="mb-4 bg-error-container text-on-error-container p-4 rounded-lg w-full max-w-5xl">
            {{ session('error') }}
        </div>
        @endif

        <!-- Centered Card Container (Industrial Minimalism & Tonal Layering) -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-md w-full max-w-5xl flex flex-col md:flex-row overflow-hidden relative">
            <!-- Left Side: Interactive Form Area -->
            <div class="w-full md:w-1/2 p-lg md:p-xl flex flex-col justify-center z-10">
                <div class="mb-lg">
                    <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-xs">Cek Status Servis</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant">Lacak progres pengerjaan dan estimasi biaya kendaraan Anda secara real-time.</p>
                </div>
                
                <!-- Input Toggle (Pill Shape) -->
                <div class="flex p-base bg-surface-container rounded-lg border border-outline-variant w-max mb-lg">
                    <button class="px-md py-xs rounded bg-primary text-on-primary font-label-md text-label-md shadow-sm transition-all" id="btn-nopol">
                        No. Polisi
                    </button>
                    <button class="px-md py-xs rounded text-on-surface-variant font-label-md text-label-md hover:text-on-surface transition-all" id="btn-notelp">
                        No. Telepon
                    </button>
                </div>

                <!-- Search Form -->
                <form action="{{ route('public.status.search') }}" method="GET" class="flex flex-col gap-md">
                    <input type="hidden" name="search_type" id="search-type" value="nopol">
                    
                    <div class="flex flex-col gap-base">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="search-input" id="search-label">Nomor Polisi</label>
                        <div class="relative flex items-center h-[44px]">
                            <span class="material-symbols-outlined absolute left-sm text-outline" id="search-icon">directions_car</span>
                            <input class="w-full h-full bg-surface-container-lowest border border-outline-variant rounded-lg pl-[44px] pr-sm font-body-md text-body-md text-on-surface placeholder:text-outline focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors uppercase" 
                                id="search-input" 
                                name="search_query"
                                placeholder="Contoh: B 1234 ABC" 
                                type="text"
                                required/>
                        </div>
                    </div>
                    <!-- Prominent Action Button (Primary) -->
                    <button class="mt-sm h-[44px] bg-primary text-on-primary font-label-md text-label-md rounded-lg flex items-center justify-center gap-xs hover:bg-primary-container hover:text-on-primary-container transition-colors active:scale-[0.98]" type="submit">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'wght' 300;">search</span>
                        Cek Status
                    </button>
                </form>

                <!-- Helpful links / Info -->
                <div class="mt-xl border-t border-outline-variant pt-md flex items-start gap-sm text-on-surface-variant">
                    <span class="material-symbols-outlined text-outline mt-[2px]">info</span>
                    <p class="font-label-sm text-label-sm">Pastikan nomor yang dimasukkan sesuai dengan data yang terdaftar pada faktur penerimaan kendaraan (Work Order).</p>
                </div>
            </div>
            
            <!-- Right Side: Lightweight Illustration & Esthetics -->
            <div class="w-full md:w-1/2 bg-surface-container-low border-t md:border-t-0 md:border-l border-outline-variant relative hidden md:block overflow-hidden min-h-[400px]">
                <!-- Subtle geometric pattern background for industrial feel -->
                <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, #c4c6cf 1px, transparent 0); background-size: 24px 24px;"></div>
                <!-- Main Illustration Image -->
                <div class="absolute inset-0 w-full h-full flex items-center justify-center p-xl">
                    <div class="w-full h-full bg-contain bg-center bg-no-repeat drop-shadow-sm" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuARxwLWsbGAXlZFbwb8TrFEcn5PmSPO3Oan8-LgFsEwW3xZkoMV06ON9AkTC4-9lJEiuk0WRKRqvDR9vxKQxriVaTXQiMBSQstH8leFDJS8dc5bnEdov4lrBLc1EgArrzKTNWuJJxTnY-dZf-G2KiZF2lkh-XLHrfqLokrCxjb_DAxJiabN7zvPxa7dVd5oUlCASWT78blAlVkKK1rGXlDl4bmYzeualm98jlsOKHYCRSFztieAmq_5bg')"></div>
                </div>
                <!-- Decorative floating status chip -->
                <div class="absolute top-xl right-xl bg-surface-container-lowest border border-outline-variant px-sm py-xs rounded-full shadow-sm flex items-center gap-xs">
                    <div class="w-2 h-2 rounded-full bg-[#10b981]"></div>
                    <span class="font-label-sm text-label-sm text-on-surface">Sistem Online</span>
                </div>
            </div>
        </div>
    </main>
    

    <!-- Simple JS for micro-interactions (Toggle behavior) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnNopol = document.getElementById('btn-nopol');
            const btnNotelp = document.getElementById('btn-notelp');
            const inputField = document.getElementById('search-input');
            const label = document.getElementById('search-label');
            const icon = document.getElementById('search-icon');
            const typeInput = document.getElementById('search-type');

            const activeClasses = ['bg-primary', 'text-on-primary', 'shadow-sm'];
            const inactiveClasses = ['text-on-surface-variant', 'hover:text-on-surface', 'bg-transparent'];

            function setToggle(activeBtn, inactiveBtn, labelText, placeholderText, iconName, typeValue) {
                // Update buttons
                activeBtn.classList.remove(...inactiveClasses);
                activeBtn.classList.add(...activeClasses);
                inactiveBtn.classList.remove(...activeClasses);
                inactiveBtn.classList.add(...inactiveClasses);
                
                // Update Input UI
                label.textContent = labelText;
                inputField.placeholder = placeholderText;
                icon.textContent = iconName;
                typeInput.value = typeValue;
                inputField.value = '';
                inputField.focus();
            }

            btnNopol.addEventListener('click', () => {
                setToggle(btnNopol, btnNotelp, 'NOMOR POLISI', 'Contoh: B 1234 ABC', 'directions_car', 'nopol');
                inputField.classList.add('uppercase');
            });

            btnNotelp.addEventListener('click', () => {
                setToggle(btnNotelp, btnNopol, 'NOMOR TELEPON', 'Contoh: 081234567890', 'phone_iphone', 'notelp');
                inputField.classList.remove('uppercase');
            });
        });
    </script>
@endsection
