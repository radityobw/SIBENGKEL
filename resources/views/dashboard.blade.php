<x-app-layout>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">Dashboard Overview</h1>
        <p class="text-base text-on-surface-variant mt-1">Monitor workshop performance and active services.</p>
    </div>

    <!-- KPI Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 {{ Auth::user()->role === 'admin' ? 'xl:grid-cols-4' : 'xl:grid-cols-3' }} gap-6 mb-6">
        <!-- KPI 1 -->
        <div class="bg-surface rounded-lg p-6 border border-outline-variant shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Total Pelanggan</span>
                <div class="w-8 h-8 rounded bg-primary-fixed text-on-primary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">groups</span>
                </div>
            </div>
            <div class="text-4xl font-sora font-bold text-on-surface">{{ number_format($totalCustomers) }}</div>
        </div>

        <!-- KPI 2 -->
        <div class="bg-surface rounded-lg p-6 border border-outline-variant shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Kendaraan Terdaftar</span>
                <div class="w-8 h-8 rounded bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">directions_car</span>
                </div>
            </div>
            <div class="text-4xl font-sora font-bold text-on-surface">{{ number_format($totalVehicles) }}</div>
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
            <div class="text-4xl font-sora font-bold text-on-surface pl-2">{{ number_format($totalMechanics) }}</div>
        </div>

        @if(Auth::user()->role === 'admin')
        <!-- KPI 4 -->
        <div class="bg-surface rounded-lg p-6 border border-outline-variant shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Pendapatan (Bulan Ini)</span>
                <div class="flex items-center gap-1 text-[12px] font-semibold text-[#166534] bg-[#dcfce7] px-2 py-1 rounded">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    Aktif
                </div>
            </div>
            <div class="text-2xl font-sora font-bold text-primary mt-auto">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        @endif
    </div>

    <!-- Bento Grid Content (Charts & Tables) -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        @if(Auth::user()->role === 'admin')
        <!-- Left: Line Chart Placeholder -->
        <div class="xl:col-span-1 bg-surface rounded-lg border border-outline-variant shadow-sm flex flex-col h-[400px]">
            <div class="p-6 border-b border-outline-variant flex justify-between items-center">
                <h3 class="text-lg font-sora font-semibold text-on-surface">Tren Pendapatan</h3>
                <span class="material-symbols-outlined text-outline">more_vert</span>
            </div>
            <div class="p-6 flex-1 relative flex flex-col items-center justify-center">
                <!-- Simple visual placeholder for a chart -->
                <div class="w-full h-full flex items-end justify-between px-2 gap-1 relative opacity-70">
                    <!-- Background Grid Lines -->
                    <div class="absolute inset-0 flex flex-col justify-between pointer-events-none opacity-20 border-b border-outline-variant">
                        <div class="border-t border-outline-variant w-full h-0"></div>
                        <div class="border-t border-outline-variant w-full h-0"></div>
                        <div class="border-t border-outline-variant w-full h-0"></div>
                        <div class="border-t border-outline-variant w-full h-0"></div>
                    </div>
                    <!-- Bars simulating line chart points -->
                    <div class="w-full bg-primary/20 rounded-t-sm h-[30%] relative group"><div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-primary"></div></div>
                    <div class="w-full bg-primary/30 rounded-t-sm h-[45%] relative group"><div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-primary"></div></div>
                    <div class="w-full bg-primary/40 rounded-t-sm h-[40%] relative group"><div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-primary"></div></div>
                    <div class="w-full bg-primary/50 rounded-t-sm h-[60%] relative group"><div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-primary"></div></div>
                    <div class="w-full bg-primary/60 rounded-t-sm h-[55%] relative group"><div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-primary"></div></div>
                    <div class="w-full bg-primary/70 rounded-t-sm h-[80%] relative group"><div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-primary"></div></div>
                    <div class="w-full bg-primary/80 rounded-t-sm h-[95%] relative group"><div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-primary"></div></div>
                    
                    <svg class="absolute inset-0 w-full h-full pointer-events-none" preserveAspectRatio="none" viewBox="0 0 100 100">
                        <polyline fill="none" points="7,70 21,55 35,60 50,40 64,45 78,20 92,5" stroke="#022448" stroke-linejoin="round" stroke-width="2"></polyline>
                    </svg>
                </div>
                <div class="flex justify-between w-full text-xs text-on-surface-variant mt-4">
                    <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Right: Recent Transactions -->
        <div class="{{ Auth::user()->role === 'admin' ? 'xl:col-span-2' : 'xl:col-span-3' }} bg-surface rounded-lg border border-outline-variant shadow-sm flex flex-col overflow-hidden h-auto xl:h-[400px]">
            <div class="p-6 border-b border-outline-variant flex justify-between items-center bg-surface-bright">
                <h3 class="text-lg font-sora font-semibold text-on-surface">Transaksi Servis Terkini</h3>
                <a href="#" class="text-sm font-semibold text-primary hover:underline h-8 px-2 flex items-center">Lihat Semua</a>
            </div>
            
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="border-b border-outline-variant bg-surface-container-low text-sm text-on-surface-variant">
                            <th class="p-4 font-semibold">No. Polisi</th>
                            <th class="p-4 font-semibold">Pelanggan</th>
                            <th class="p-4 font-semibold">Mekanik</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-on-surface">
                        @forelse($latestTransactions as $transaction)
                        <tr class="border-b border-outline-variant/50 hover:bg-surface-container-low transition-colors h-14">
                            <td class="p-4 font-medium">{{ $transaction->vehicle->plate_number ?? '-' }}</td>
                            <td class="p-4">{{ $transaction->vehicle->customer->name ?? '-' }}</td>
                            <td class="p-4 flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                                    {{ substr($transaction->mechanic->name ?? 'M', 0, 1) }}
                                </div>
                                {{ $transaction->mechanic->name ?? '-' }}
                            </td>
                            <td class="p-4">
                                <x-badge :status="$transaction->status" />
                            </td>
                            <td class="p-4 text-right font-medium">Rp {{ number_format($transaction->cost, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-on-surface-variant">Belum ada transaksi servis.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card List -->
            <div class="md:hidden flex flex-col">
                @forelse($latestTransactions as $transaction)
                <div class="p-4 border-b border-outline-variant flex justify-between items-center bg-surface hover:bg-surface-container-lowest transition-colors">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                            <span class="font-sora font-semibold text-on-surface">{{ $transaction->vehicle->plate_number ?? '-' }}</span>
                            <x-badge :status="$transaction->status" />
                        </div>
                        <span class="text-sm text-on-surface-variant">{{ $transaction->vehicle->customer->name ?? '-' }}</span>
                        <div class="text-xs text-on-surface-variant flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">engineering</span>
                            {{ $transaction->mechanic->name ?? '-' }}
                        </div>
                    </div>
                    <div class="font-semibold text-primary">
                        Rp {{ number_format($transaction->cost, 0, ',', '.') }}
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-on-surface-variant">Belum ada transaksi servis.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
