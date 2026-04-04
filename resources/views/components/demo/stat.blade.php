@blaze(fold: true, unsafe: ['label', 'value', 'caption', 'tone'])

@props([
    'label',
    'value',
    'caption' => null,
    'tone' => 'slate',
])

@php
    $accentClasses = match ($tone) {
        'sky' => 'from-sky-500/18 via-sky-500/8 to-transparent',
        'emerald' => 'from-emerald-500/18 via-emerald-500/8 to-transparent',
        'amber' => 'from-amber-500/18 via-amber-500/8 to-transparent',
        default => 'from-zinc-500/15 via-zinc-500/6 to-transparent',
    };
@endphp

<div class="relative overflow-hidden rounded-2xl border border-zinc-200/70 bg-white/90 p-5 shadow-sm shadow-zinc-950/5 backdrop-blur">
    <div class="absolute inset-x-0 top-0 h-14 bg-gradient-to-r {{ $accentClasses }}"></div>
    <div class="relative space-y-2">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-zinc-500">{{ $label }}</p>
        <p class="text-3xl font-semibold tracking-tight text-zinc-950">{{ $value }}</p>

        @if ($caption)
            <p class="text-sm leading-6 text-zinc-600">{{ $caption }}</p>
        @endif
    </div>
</div>
