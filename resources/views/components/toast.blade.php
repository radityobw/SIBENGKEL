@php
    $toasts = [];
    if (session('success')) $toasts[] = ['type' => 'success', 'message' => session('success')];
    if (session('error'))   $toasts[] = ['type' => 'error',   'message' => session('error')];
    if (session('warning')) $toasts[] = ['type' => 'warning', 'message' => session('warning')];
    if (session('info'))    $toasts[] = ['type' => 'info',    'message' => session('info')];
@endphp

@if(count($toasts) > 0)
<div id="toast-container" class="fixed bottom-24 lg:bottom-6 right-4 z-[9999] flex flex-col gap-3 pointer-events-none">
    @foreach($toasts as $i => $toast)
    @php
        $colors = [
            'success' => ['bg' => 'bg-[#022448]', 'border' => 'border-[#FF6B00]', 'icon_bg' => 'bg-[#FF6B00]', 'icon' => 'check_circle', 'text' => 'text-white'],
            'error'   => ['bg' => 'bg-[#3b0000]', 'border' => 'border-red-400',   'icon_bg' => 'bg-red-500',   'icon' => 'cancel',       'text' => 'text-white'],
            'warning' => ['bg' => 'bg-[#2d1f00]', 'border' => 'border-amber-400', 'icon_bg' => 'bg-amber-500', 'icon' => 'warning',      'text' => 'text-white'],
            'info'    => ['bg' => 'bg-[#001a2e]', 'border' => 'border-sky-400',   'icon_bg' => 'bg-sky-500',   'icon' => 'info',         'text' => 'text-white'],
        ];
        $c = $colors[$toast['type']] ?? $colors['info'];
    @endphp
    <div
        id="toast-{{ $i }}"
        role="alert"
        class="toast-item pointer-events-auto flex items-center gap-3 min-w-[280px] max-w-[360px] px-4 py-3 rounded-xl border {{ $c['bg'] }} {{ $c['border'] }} {{ $c['text'] }} shadow-2xl"
        style="animation: toastSlideIn 0.35s cubic-bezier(0.21,1.02,0.73,1) forwards;"
    >
        <div class="shrink-0 w-8 h-8 rounded-full {{ $c['icon_bg'] }} flex items-center justify-center">
            <span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings:'FILL' 1;">{{ $c['icon'] }}</span>
        </div>
        <p class="text-sm font-medium flex-1 leading-snug">{{ $toast['message'] }}</p>
        <button onclick="dismissToast('toast-{{ $i }}')" class="shrink-0 opacity-60 hover:opacity-100 transition-opacity">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    </div>
    @endforeach
</div>

<style>
    @keyframes toastSlideIn {
        from { opacity: 0; transform: translateX(100%) scale(0.9); }
        to   { opacity: 1; transform: translateX(0) scale(1); }
    }
    @keyframes toastSlideOut {
        from { opacity: 1; transform: translateX(0) scale(1); max-height: 80px; }
        to   { opacity: 0; transform: translateX(110%) scale(0.9); max-height: 0; }
    }
    .toast-exit {
        animation: toastSlideOut 0.3s ease-in forwards !important;
        overflow: hidden;
    }
</style>

<script>
    function dismissToast(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('toast-exit');
        setTimeout(() => el.remove(), 310);
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toast-item').forEach((toast, i) => {
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.classList.add('toast-exit');
                    setTimeout(() => toast.remove(), 310);
                }
            }, 4000 + (i * 600));
        });
    });
</script>
@endif
