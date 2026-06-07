@extends('layouts.public')

@section('title', 'Columbarium — Coming Soon — Heritage Memorial Park')

@section('content')
    <section class="min-h-screen flex items-center justify-center bg-gray-900 text-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-24 h-24 mx-auto mb-8 rounded-full bg-emerald-600/20 flex items-center justify-center">
                <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold mb-4">Coming Soon</h1>
            <p class="text-xl text-gray-300 mb-2">Heritage Columbarium</p>
            <p class="text-gray-400 max-w-md mx-auto">Our columbarium is currently under development. We'll be offering modern columbary niches soon — check back later.</p>
        </div>
    </section>
@endsection
