@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-3 py-2 rounded-lg text-sm font-medium text-white bg-white/15 transition duration-150 ease-in-out'
            : 'block px-3 py-2 rounded-lg text-sm font-medium text-white/70 hover:text-white hover:bg-white/10 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>