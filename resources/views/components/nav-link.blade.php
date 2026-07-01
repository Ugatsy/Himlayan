@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-white/15 transition duration-150 ease-in-out whitespace-nowrap'
            : 'inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition duration-150 ease-in-out whitespace-nowrap';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>