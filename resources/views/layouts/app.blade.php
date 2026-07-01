<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/himlayan-logo.png') }}">
        <title>@yield('title', config('app.name', 'HIMLAYAN'))</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
        <style>
            .badge-success { background: rgba(34, 197, 94, 0.15); color: #16a34a; }
            .badge-pending { background: rgba(254, 223, 1, 0.15); color: #a16207; }
            .badge-danger { background: rgba(239, 68, 68, 0.15); color: #dc2626; }
            .badge-default { background: rgba(107, 114, 128, 0.15); color: #6b7280; }
            .nav-pill-active { background: rgba(255,255,255,0.15); color: white; border-radius: 0.5rem; }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-700 bg-gray-50" x-data="{ mobileNavOpen: false, toast: { show: false, message: '', type: 'success' } }" x-init="
        @if(session('success'))
            toast = { show: true, message: '{{ addslashes(session('success')) }}', type: 'success' }; setTimeout(() => toast.show = false, 4000);
        @elseif(session('error'))
            toast = { show: true, message: '{{ addslashes(session('error')) }}', type: 'error' }; setTimeout(() => toast.show = false, 4000);
        @endif
    ">
        @include('layouts.navigation')

        <div class="pt-16 min-h-screen flex flex-col">
            <div x-show="toast.show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="fixed top-20 right-4 z-[100] max-w-sm" x-cloak>
                <div class="rounded-lg shadow-lg px-5 py-4 flex items-start gap-3" :class="toast.type === 'success' ? 'bg-brand-blue text-white' : 'bg-red-600 text-white'">
                    <svg x-show="toast.type === 'success'" class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <svg x-show="toast.type === 'error'" class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium" x-text="toast.message"></p>
                    <button @click="toast.show = false" class="shrink-0 ml-2 opacity-70 hover:opacity-100">&times;</button>
                </div>
            </div>

            <main class="py-6 px-4 sm:px-6 lg:px-8 flex-1">
                {{ $slot }}
            </main>

            <footer class="border-t border-gray-100 bg-white py-4 text-center text-xs text-gray-500 shrink-0">
                HIMLAYAN — Solano, Nueva Vizcaya
            </footer>
        </div>

        @stack('scripts')
    </body>
</html>