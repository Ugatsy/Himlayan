<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/heritage-logo.png') }}">
        <title>@yield('title', config('app.name', 'Heritage Memorial Park'))</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="font-sans antialiased" x-data="{ toast: { show: false, message: '', type: 'success' } }" x-init="
        @if(session('success'))
            toast = { show: true, message: '{{ addslashes(session('success')) }}', type: 'success' }; setTimeout(() => toast.show = false, 4000);
        @elseif(session('error'))
            toast = { show: true, message: '{{ addslashes(session('error')) }}', type: 'error' }; setTimeout(() => toast.show = false, 4000);
        @endif
    ">
        <div class="min-h-screen bg-gray-100 flex flex-col">
            @include('layouts.navigation')

            <div x-show="toast.show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="fixed top-20 right-4 z-[100] max-w-sm" x-cloak>
                <div class="rounded-lg shadow-lg px-5 py-4 flex items-start gap-3" :class="toast.type === 'success' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white'">
                    <svg x-show="toast.type === 'success'" class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <svg x-show="toast.type === 'error'" class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium" x-text="toast.message"></p>
                    <button @click="toast.show = false" class="shrink-0 ml-2 opacity-70 hover:opacity-100">&times;</button>
                </div>
            </div>

            @isset($header)
                <header class="bg-white shadow mt-16 lg:mt-20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1">
                {{ $slot }}
            </main>

            @include('partials.public-footer')
        </div>

        @stack('scripts')
    </body>
</html>
