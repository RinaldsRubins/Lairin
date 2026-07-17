@props(['variant' => 'default', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'text-lg',
        'md' => 'text-2xl lg:text-3xl',
        'lg' => 'text-3xl lg:text-4xl',
    ];
    $titleClass = $variant === 'light' ? 'text-white' : 'text-secondary-900';
@endphp

<span {{ $attributes->merge(['class' => ($sizes[$size] ?? $sizes['md']) . ' font-serif font-semibold tracking-[0.28em] ' . $titleClass . ' leading-none']) }}>
    LAIRIN
</span>
