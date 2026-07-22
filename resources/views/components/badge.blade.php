@props(['status'])

@php
    $classes = match($status) {
        'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        'proses'  => 'bg-blue-100 text-blue-800 border-blue-300',
        default   => 'bg-amber-100 text-amber-800 border-amber-300',
    };
    $label = ucfirst($status);
@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold border {{ $classes }}">
    {{ $label }}
</span>
