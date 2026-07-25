<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice INV-{{ date('Y') }}-{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }} - SIBENGKEL</title>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-sora { font-family: 'Sora', sans-serif; }
        @media print {
            body {
                background-color: white !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
            * {
                border-color: #000 !important;
            }
            .text-on-surface-variant {
                color: #000 !important;
            }
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex justify-center py-8 print:py-0">
    <!-- Action Bar (No Print) -->
    <div class="fixed top-4 right-4 flex gap-2 no-print">
        <a href="{{ route('transactions.index') }}" class="h-11 px-4 bg-surface text-on-surface rounded border border-outline flex items-center gap-2 hover:bg-surface-variant transition-colors font-medium text-sm">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_back</span>
            Kembali
        </a>
        <button class="h-11 px-4 bg-primary text-on-primary rounded border border-primary flex items-center gap-2 hover:bg-primary/90 transition-colors font-medium text-sm" onclick="window.print()">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">print</span>
            Print Invoice
        </button>
    </div>

    <!-- A4 Container -->
    <div class="w-full max-w-[210mm] bg-white mx-auto p-[20mm] flex flex-col gap-8 print:p-0 shadow-lg print:shadow-none">
        <!-- Header Section -->
        <header class="flex justify-between items-start border-b border-black pb-4">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <img src="/logobengkel.png" alt="SIBENGKEL Logo" class="h-12 object-contain invert">
                </div>
                <div>
                    <h1 class="text-3xl font-sora font-bold text-primary tracking-tight uppercase">SIBENGKEL</h1>
                    <p class="text-xs font-medium text-black mt-1">INVOICE / NOTA SERVIS</p>
                </div>
            </div>
            <div class="text-right text-sm font-semibold text-black flex flex-col gap-1">
                <p class="font-bold">SIBENGKEL</p>
                <p>Jl. Industri No. 123</p>
                <p>Jakarta, Indonesia</p>
                <p>+62 21 555 1234</p>
            </div>
        </header>

        <!-- Metadata Row -->
        <div class="flex justify-between items-center text-sm border border-black p-2">
            <div class="flex gap-6">
                <div><span class="font-semibold mr-1">No. Invoice:</span> INV-{{ date('Y') }}-{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="flex gap-6">
                <div><span class="font-semibold mr-1">Tanggal:</span> {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</div>
                <div><span class="font-semibold mr-1">Tipe:</span> {{ ucfirst($transaction->type) }}</div>
            </div>
        </div>

        <!-- Section 1: Customer & Vehicle Info -->
        <div class="grid grid-cols-2 gap-4 border-t border-b border-black py-4">
            <div class="flex flex-col gap-1">
                <h2 class="text-sm font-semibold text-black uppercase tracking-wider mb-2">Informasi Pelanggan</h2>
                <div class="grid grid-cols-[100px_1fr] text-sm">
                    <span class="font-semibold">Nama:</span>
                    <span>{{ $transaction->vehicle->customer->name }}</span>
                </div>
                <div class="grid grid-cols-[100px_1fr] text-sm">
                    <span class="font-semibold">Telepon:</span>
                    <span>{{ $transaction->vehicle->customer->phone ?? '-' }}</span>
                </div>
            </div>
            <div class="flex flex-col gap-1 border-l border-black pl-4">
                <h2 class="text-sm font-semibold text-black uppercase tracking-wider mb-2">Informasi Kendaraan</h2>
                <div class="grid grid-cols-[100px_1fr] text-sm">
                    <span class="font-semibold">Plat Nomor:</span>
                    <span>{{ $transaction->vehicle->plate_number }}</span>
                </div>
                <div class="grid grid-cols-[100px_1fr] text-sm">
                    <span class="font-semibold">Model:</span>
                    <span>{{ $transaction->vehicle->brand }} {{ $transaction->vehicle->model }} ({{ $transaction->vehicle->year }})</span>
                </div>
            </div>
        </div>

        <!-- Section 2: Service / Sparepart Details -->
        <div class="flex-grow">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black">
                        <th class="py-2 px-1 text-sm font-semibold text-black uppercase tracking-wider w-[70%]">Deskripsi Pekerjaan / Keluhan</th>
                        <th class="py-2 px-1 text-sm font-semibold text-black uppercase tracking-wider w-[30%] text-right">Biaya (Rp)</th>
                    </tr>
                </thead>
                <tbody class="text-sm border-b border-black">
                    <tr class="border-b border-gray-300">
                        <td class="py-3 px-1 whitespace-pre-line">{{ $transaction->complaint }}</td>
                        <td class="py-3 px-1 text-right">{{ number_format($transaction->cost, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Section 3: Summary -->
        <div class="flex justify-end pt-4 border-b border-black pb-4">
            <div class="w-1/2 flex flex-col gap-2">
                <div class="flex justify-between text-xl font-sora font-bold text-primary mt-2 pt-2 border-t border-black px-1">
                    <span>Total Keseluruhan</span>
                    <span>Rp {{ number_format($transaction->cost, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Section 4: Signatures -->
        <div class="flex justify-between mt-12 pt-8 px-8">
            <div class="flex flex-col items-center gap-12 w-48">
                <span class="text-sm font-semibold text-black">Pelanggan</span>
                <div class="w-full border-b border-black"></div>
                <span class="text-sm">( {{ $transaction->vehicle->customer->name }} )</span>
            </div>
            <div class="flex flex-col items-center gap-12 w-48">
                <span class="text-sm font-semibold text-black">Mekanik / Kasir</span>
                <div class="w-full border-b border-black"></div>
                <span class="text-sm">( {{ $transaction->mechanic->name ?? $transaction->user->name ?? 'Admin' }} )</span>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-auto pt-8 pb-4 text-xs font-semibold text-black border-t border-black">
            <p>Terima kasih telah mempercayakan kendaraan Anda pada SIBENGKEL.</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
        </div>
    </div>
</body>
</html>
