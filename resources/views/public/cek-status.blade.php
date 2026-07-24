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
        <div class="bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl shadow-md w-full max-w-5xl flex flex-col md:flex-row overflow-hidden relative">
            <!-- Left Side: Interactive Form Area -->
            <div class="w-full md:w-1/2 p-lg md:p-xl flex flex-col justify-center z-10">
                <div class="mb-lg">
                    <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface dark:text-[#EDEDEC] mb-xs">Cek Status Servis</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant dark:text-gray-400">Lacak progres pengerjaan dan estimasi biaya kendaraan Anda secara real-time.</p>
                </div>
                
                <!-- Input Toggle (Pill Shape) -->
                <div class="flex p-base bg-surface-container dark:bg-[#0a0a0a] rounded-lg border border-outline-variant dark:border-[#3E3E3A] w-max mb-lg">
                    <button class="px-md py-xs rounded bg-primary dark:bg-secondary text-on-primary dark:text-white font-label-md text-label-md shadow-sm transition-all" id="btn-nopol">
                        No. Polisi
                    </button>
                    <button class="px-md py-xs rounded text-on-surface-variant dark:text-gray-400 font-label-md text-label-md hover:text-on-surface dark:hover:text-[#EDEDEC] transition-all" id="btn-notelp">
                        No. Telepon
                    </button>
                </div>

                <!-- Search Form -->
                <form action="{{ route('public.status.search') }}" method="GET" class="flex flex-col gap-md">
                    <input type="hidden" name="search_type" id="search-type" value="nopol">
                    
                    <div class="flex flex-col gap-base">
                        <label class="font-label-sm text-label-sm text-on-surface-variant dark:text-gray-400 uppercase tracking-wider" for="search-input" id="search-label">Nomor Polisi</label>
                        <div class="relative flex items-center h-[44px]">
                            <span class="material-symbols-outlined absolute left-sm text-outline dark:text-gray-500" id="search-icon">directions_car</span>
                            <input class="w-full h-full bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded-lg pl-[44px] pr-sm font-body-md text-body-md text-on-surface dark:text-[#EDEDEC] placeholder:text-outline dark:placeholder:text-gray-600 focus:border-primary dark:focus:border-secondary focus:ring-1 focus:ring-primary dark:focus:ring-secondary outline-none transition-colors uppercase" 
                                id="search-input" 
                                name="search_query"
                                placeholder="Contoh: B 1234 ABC" 
                                type="text"
                                required/>
                        </div>
                    </div>
                    <!-- Prominent Action Button (Primary) -->
                    <button class="mt-sm h-[44px] bg-primary dark:bg-secondary text-on-primary dark:text-white font-label-md text-label-md rounded-lg flex items-center justify-center gap-xs hover:bg-primary-container dark:hover:bg-secondary/80 hover:text-on-primary-container dark:hover:text-white transition-colors active:scale-[0.98]" type="submit">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'wght' 300;">search</span>
                        Cek Status
                    </button>
                </form>

                <!-- Helpful links / Info -->
                <div class="mt-xl border-t border-outline-variant dark:border-[#3E3E3A] pt-md flex items-start gap-sm text-on-surface-variant dark:text-gray-400">
                    <span class="material-symbols-outlined text-outline dark:text-gray-500 mt-[2px]">info</span>
                    <p class="font-label-sm text-label-sm">Pastikan nomor yang dimasukkan sesuai dengan data yang terdaftar pada faktur penerimaan kendaraan (Work Order).</p>
                </div>
            </div>
            
            <!-- Right Side: Lightweight Illustration & Esthetics -->
            <div class="w-full md:w-1/2 bg-surface-container-low dark:bg-[#111111] border-t md:border-t-0 md:border-l border-outline-variant dark:border-[#3E3E3A] relative hidden md:block overflow-hidden min-h-[400px]">
                <!-- Subtle geometric pattern background for industrial feel -->
                <div class="absolute inset-0 opacity-20 pointer-events-none dark:opacity-10" style="background-image: radial-gradient(circle at 2px 2px, currentColor 1px, transparent 0); background-size: 24px 24px;"></div>
                <!-- Main Illustration Image -->
                <div class="absolute inset-0 w-full h-full flex items-center justify-center p-xl">
                    <div class="w-full h-full bg-contain bg-center bg-no-repeat drop-shadow-sm opacity-90 dark:opacity-70 dark:mix-blend-lighten" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuARxwLWsbGAXlZFbwb8TrFEcn5PmSPO3Oan8-LgFsEwW3xZkoMV06ON9AkTC4-9lJEiuk0WRKRqvDR9vxKQxriVaTXQiMBSQstH8leFDJS8dc5bnEdov4lrBLc1EgArrzKTNWuJJxTnY-dZf-G2KiZF2lkh-XLHrfqLokrCxjb_DAxJiabN7zvPxa7dVd5oUlCASWT78blAlVkKK1rGXlDl4bmYzeualm98jlsOKHYCRSFztieAmq_5bg')"></div>
                </div>
                <!-- Decorative floating status chip -->
                <div class="absolute top-xl right-xl bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] px-sm py-xs rounded-full shadow-sm flex items-center gap-xs">
                    <div class="w-2 h-2 rounded-full bg-[#10b981]"></div>
                    <span class="font-label-sm text-label-sm text-on-surface dark:text-[#EDEDEC]">Sistem Online</span>
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

            const activeClasses = ['bg-primary', 'dark:bg-secondary', 'text-on-primary', 'dark:text-white', 'shadow-sm'];
            const inactiveClasses = ['text-on-surface-variant', 'dark:text-gray-400', 'hover:text-on-surface', 'dark:hover:text-[#EDEDEC]', 'bg-transparent'];

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
