@extends('layouts.customer')

@section('title', 'Booking Servis Baru - SIBENGKEL')
@section('page_title', 'Booking Servis Baru')
@section('back_url', route('public.dashboard'))

@section('content')
<div class="w-full max-w-2xl bg-surface-container-lowest dark:bg-[#161615] border border-outline-variant dark:border-[#3E3E3A] rounded-xl shadow-sm overflow-hidden mb-lg mx-auto">
    <div class="p-sm md:p-md border-b border-outline-variant dark:border-[#3E3E3A] bg-surface-container-low dark:bg-[#111111] flex items-center gap-sm">
        <div class="bg-primary-container dark:bg-secondary/20 text-on-primary-container dark:text-secondary p-2 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">calendar_add_on</span>
        </div>
        <div>
            <h2 class="text-headline-md font-headline-md text-primary dark:text-[#EDEDEC]">Formulir Pendaftaran</h2>
            <p class="text-body-md font-body-md text-on-surface-variant dark:text-gray-400">Lengkapi data di bawah ini untuk menjadwalkan servis kendaraan Anda.</p>
        </div>
    </div>
    
    <form action="{{ route('public.booking.submit') }}" method="POST" class="p-sm md:p-md space-y-md">
        @csrf
        
        <!-- Field 1: Kendaraan -->
        <div class="space-y-base">
            <label class="text-label-md font-label-md text-on-surface dark:text-[#EDEDEC] block" for="vehicle_id">Pilih Kendaraan <span class="text-error">*</span></label>
            <div class="relative">
                <select class="w-full h-11 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded-DEFAULT px-sm text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] focus:border-primary dark:focus:border-secondary focus:ring-1 focus:ring-primary dark:focus:ring-secondary appearance-none pr-10" 
                    id="vehicle_id" name="vehicle_id" required>
                    <option disabled selected value="" class="dark:text-gray-500">Pilih kendaraan Anda...</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate_number }})
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-on-surface-variant dark:text-gray-400">
                    <span class="material-symbols-outlined">expand_more</span>
                </div>
            </div>
            @if($vehicles->isEmpty())
                <p class="text-sm text-error mt-1">Anda belum memiliki kendaraan terdaftar. Silakan hubungi admin.</p>
            @endif
        </div>

        <!-- Field 2 & 3: Tanggal & Waktu -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
            <!-- Tanggal -->
            <div class="space-y-base">
                <label class="text-label-md font-label-md text-on-surface dark:text-[#EDEDEC] block" for="preferred_date">Pilih Tanggal <span class="text-error">*</span></label>
                <div class="relative">
                    <input class="w-full h-11 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded-DEFAULT px-sm text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] focus:border-primary dark:focus:border-secondary focus:ring-1 focus:ring-primary dark:focus:ring-secondary [color-scheme:light_dark]" 
                        id="preferred_date" name="preferred_date" required type="date" min="{{ date('Y-m-d') }}" value="{{ old('preferred_date') }}"/>
                </div>
            </div>
            <!-- Jam -->
            <div class="space-y-base">
                <label class="text-label-md font-label-md text-on-surface dark:text-[#EDEDEC] block" for="preferred_time">Pilih Jam <span class="text-error">*</span></label>
                <div class="relative">
                    <input class="w-full h-11 bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded-DEFAULT px-sm text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] focus:border-primary dark:focus:border-secondary focus:ring-1 focus:ring-primary dark:focus:ring-secondary [color-scheme:light_dark]" 
                        id="preferred_time" name="preferred_time" required type="time" value="{{ old('preferred_time') }}"/>
                </div>
            </div>
        </div>

        <!-- Field 4: Keluhan -->
        <div class="space-y-base">
            <label class="text-label-md font-label-md text-on-surface dark:text-[#EDEDEC] block" for="complaint">Keluhan / Keperluan Servis <span class="text-error">*</span></label>
            <textarea class="w-full bg-surface-container-lowest dark:bg-[#111111] border border-outline-variant dark:border-[#3E3E3A] rounded-DEFAULT p-sm text-body-md font-body-md text-on-surface dark:text-[#EDEDEC] dark:placeholder:text-gray-500 focus:border-primary dark:focus:border-secondary focus:ring-1 focus:ring-primary dark:focus:ring-secondary resize-y" 
                id="complaint" name="complaint" placeholder="Deskripsikan keluhan, suara aneh pada mesin, atau jenis servis rutin yang dibutuhkan..." rows="4" required>{{ old('complaint') }}</textarea>
        </div>

        <!-- Actions -->
        <div class="pt-sm border-t border-outline-variant dark:border-[#3E3E3A] mt-sm flex flex-col sm:flex-row justify-end gap-sm">
            <a href="{{ route('public.dashboard') }}" class="h-11 px-sm border border-primary dark:border-[#EDEDEC] text-primary dark:text-[#EDEDEC] rounded-DEFAULT text-label-md font-label-md hover:bg-surface-container-low dark:hover:bg-[#3E3E3A] transition-colors flex items-center justify-center">
                Batal
            </a>
            <button class="h-11 px-md bg-secondary text-on-secondary rounded-DEFAULT text-label-md font-label-md hover:opacity-90 transition-opacity flex items-center justify-center gap-2 shadow-sm {{ $vehicles->isEmpty() ? 'opacity-50 cursor-not-allowed' : '' }}" type="submit" {{ $vehicles->isEmpty() ? 'disabled' : '' }}>
                <span class="material-symbols-outlined">send</span>
                Kirim Permintaan Booking
            </button>
        </div>
    </form>
</div>
@endsection
