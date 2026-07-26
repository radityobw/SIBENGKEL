<x-app-layout>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl lg:text-3xl font-sora font-semibold text-on-surface">Dashboard Overview</h1>
        <p class="text-base text-on-surface-variant mt-1">Monitor workshop performance and active services.</p>
    </div>

    <!-- KPI Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 {{ Auth::user()->role === 'admin' ? 'xl:grid-cols-4' : 'xl:grid-cols-3' }} gap-6 mb-6">
        <!-- KPI 1 -->
        <div class="bg-surface dark:bg-[#111111] rounded-lg p-6 border border-outline-variant dark:border-[#3E3E3A] shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Total Pelanggan</span>
                <div class="w-8 h-8 rounded bg-primary-fixed text-on-primary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">groups</span>
                </div>
            </div>
            <div class="text-4xl font-sora font-bold text-on-surface">{{ number_format($totalCustomers) }}</div>
        </div>

        <!-- KPI 2 -->
        <div class="bg-surface dark:bg-[#111111] rounded-lg p-6 border border-outline-variant dark:border-[#3E3E3A] shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Kendaraan Terdaftar</span>
                <div class="w-8 h-8 rounded bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">directions_car</span>
                </div>
            </div>
            <div class="text-4xl font-sora font-bold text-on-surface">{{ number_format($totalVehicles) }}</div>
        </div>

        <!-- KPI 3 -->
        <div class="bg-surface dark:bg-[#111111] rounded-lg p-6 border border-outline-variant dark:border-[#3E3E3A] shadow-sm flex flex-col justify-between h-[120px] relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-secondary"></div>
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
        <div class="bg-surface dark:bg-[#111111] rounded-lg p-6 border border-outline-variant dark:border-[#3E3E3A] shadow-sm flex flex-col justify-between h-[120px]">
            <div class="flex justify-between items-start">
                <span class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider">Pendapatan (Bulan Ini)</span>
                <div class="flex items-center gap-1 text-[12px] font-semibold text-[#166534] bg-[#dcfce7] px-2 py-1 rounded">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    Aktif
                </div>
            </div>
            <div class="text-2xl font-sora font-bold text-on-surface mt-auto">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        @endif
    </div>

    <!-- Bento Grid Content (Charts & Tables) -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        @if(Auth::user()->role === 'admin')
        <!-- Left: Line Chart Placeholder / Real Chart -->
        <div class="xl:col-span-1 bg-surface dark:bg-[#111111] rounded-lg border border-outline-variant dark:border-[#3E3E3A] shadow-sm flex flex-col h-[400px]">
            <div class="p-6 border-b border-outline-variant dark:border-[#3E3E3A] flex justify-between items-center">
                <h3 class="text-lg font-sora font-semibold text-on-surface">Tren Pendapatan (7 Hari)</h3>
            </div>
            <div class="p-6 flex-1 relative w-full h-full">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('revenueTrendChart');
                if(!ctx) return;
                
                const labels = {!! json_encode($revenueTrend['labels'] ?? []) !!};
                const dataPoints = {!! json_encode($revenueTrend['data'] ?? []) !!};
                
                const isDark = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
                const primaryColor = isDark ? '#FF8F42' : '#FF6B00';
                const bgColor = isDark ? 'rgba(255, 143, 66, 0.1)' : 'rgba(255, 107, 0, 0.1)';
                const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
                const textColor = isDark ? '#A1A09A' : '#706f6c';

                let chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: dataPoints,
                            borderColor: primaryColor,
                            backgroundColor: bgColor,
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: primaryColor,
                            pointBorderColor: isDark ? '#111111' : '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: textColor,
                                    callback: function(value) {
                                        if (value === 0) return '0';
                                        return 'Rp ' + (value/1000) + 'k';
                                    }
                                },
                                grid: {
                                    color: gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: textColor,
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });

                // Optional: Watch for dark mode changes if there's a theme toggle
                const observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (mutation.attributeName === 'class') {
                            const isDarkNow = document.documentElement.classList.contains('dark');
                            chart.data.datasets[0].borderColor = isDarkNow ? '#FF8F42' : '#FF6B00';
                            chart.data.datasets[0].backgroundColor = isDarkNow ? 'rgba(255, 143, 66, 0.1)' : 'rgba(255, 107, 0, 0.1)';
                            chart.data.datasets[0].pointBackgroundColor = isDarkNow ? '#FF8F42' : '#FF6B00';
                            chart.data.datasets[0].pointBorderColor = isDarkNow ? '#111111' : '#fff';
                            chart.options.scales.x.ticks.color = isDarkNow ? '#A1A09A' : '#706f6c';
                            chart.options.scales.y.ticks.color = isDarkNow ? '#A1A09A' : '#706f6c';
                            chart.options.scales.y.grid.color = isDarkNow ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
                            chart.update();
                        }
                    });
                });
                observer.observe(document.documentElement, { attributes: true });
            });
        </script>
        @endif

        <!-- Right: Recent Transactions -->
        <div class="{{ Auth::user()->role === 'admin' ? 'xl:col-span-2' : 'xl:col-span-3' }} bg-surface dark:bg-[#111111] rounded-lg border border-outline-variant dark:border-[#3E3E3A] shadow-sm flex flex-col overflow-hidden h-auto xl:h-[400px]">
            <div class="p-6 border-b border-outline-variant dark:border-[#3E3E3A] flex justify-between items-center bg-surface-bright dark:bg-[#161615]">
                <h3 class="text-lg font-sora font-semibold text-on-surface">Transaksi Servis Terkini</h3>
                <a href="{{ route('transactions.index') }}" class="text-sm font-semibold text-on-surface hover:underline h-8 px-2 flex items-center">Lihat Semua</a>
            </div>
            
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="border-b border-outline-variant dark:border-[#3E3E3A] bg-surface-container-low dark:bg-[#0a0a0a] text-sm text-on-surface-variant dark:text-gray-400">
                            <th class="p-4 font-semibold">No. Polisi</th>
                            <th class="p-4 font-semibold">Pelanggan</th>
                            <th class="p-4 font-semibold">Mekanik</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-on-surface">
                        @forelse($latestTransactions as $transaction)
                        <tr class="border-b border-outline-variant/50 dark:border-[#3E3E3A]/50 hover:bg-surface-container-low dark:hover:bg-[#161615] transition-colors h-14">
                            <td class="p-4 font-medium">{{ $transaction->vehicle->plate_number ?? '-' }}</td>
                            <td class="p-4">{{ $transaction->vehicle->customer->name ?? '-' }}</td>
                            <td class="p-4 flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-surface-container-high flex items-center justify-center text-on-surface text-xs font-bold">
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
                <div class="p-4 border-b border-outline-variant dark:border-[#3E3E3A] flex justify-between items-center bg-surface dark:bg-[#111111] hover:bg-surface-container-lowest dark:hover:bg-[#161615] transition-colors">
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
                    <div class="font-semibold text-on-surface">
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
