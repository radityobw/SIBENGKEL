<x-app-layout>
    <!-- Header -->
    <div>
        <h1 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">Dashboard Overview</h1>
        <p class="text-base text-on-surface-variant mt-1">Monitor workshop performance and active services.</p>
    </div>

    <!-- KPI Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- KPI 1 -->
        <div class="bg-surface rounded-lg p-6 border border-outline-variant shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Total Pelanggan</span>
                <div class="w-8 h-8 rounded bg-primary-fixed text-on-primary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">groups</span>
                </div>
            </div>
            <div class="text-4xl font-sora font-bold text-on-surface">{{ \App\Models\Customer::count() }}</div>
        </div>

        <!-- KPI 2 -->
        <div class="bg-surface rounded-lg p-6 border border-outline-variant shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Kendaraan Terdaftar</span>
                <div class="w-8 h-8 rounded bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">directions_car</span>
                </div>
            </div>
            <div class="text-4xl font-sora font-bold text-on-surface">{{ \App\Models\Vehicle::count() }}</div>
        </div>

        <!-- KPI 3 -->
        <div class="bg-surface rounded-lg p-6 border border-outline-variant shadow-sm flex flex-col justify-between h-[120px] relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-secondary-container"></div>
            <div class="flex justify-between items-start pl-2">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Mekanik Aktif</span>
                <div class="w-8 h-8 rounded bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">engineering</span>
                </div>
            </div>
            <div class="text-4xl font-sora font-bold text-on-surface pl-2">{{ \App\Models\Mechanic::count() }}</div>
        </div>

        <!-- KPI 4 -->
        <div class="bg-surface rounded-lg p-6 border border-outline-variant shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Pendapatan (Bulan Ini)</span>
                <div class="flex items-center gap-1 text-[12px] font-semibold text-[#166534] bg-[#dcfce7] px-2 py-1 rounded">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    Aktif
                </div>
            </div>
            <div class="text-2xl font-sora font-bold text-primary mt-auto">Rp {{ number_format(\App\Models\ServiceTransaction::whereMonth('transaction_date', date('m'))->sum('cost'), 0, ',', '.') }}</div>
        </div>
    </div>
</x-app-layout>
