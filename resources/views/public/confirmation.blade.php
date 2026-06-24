@extends('layouts.public')

@section('title', 'Reservation Submitted — HIMLAYAN')

@section('content')
    <section class="pt-32 pb-24 bg-stone-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if(session('success'))
                <div class="bg-emerald-100 text-emerald-800 p-4 rounded-lg mb-8 font-medium">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm p-12">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Thank You!</h1>
                <p class="text-gray-600 mb-8">Your reservation has been submitted successfully. Our team will contact you within 24 hours to confirm and discuss the next steps.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-emerald-700 hover:bg-emerald-600 text-white font-semibold rounded-lg transition-colors">Return to Home</a>
                    <a href="{{ route('public.lots') }}" class="inline-flex items-center px-6 py-3 border border-emerald-700 text-emerald-700 font-semibold rounded-lg hover:bg-emerald-50 transition-colors">Browse More Lots</a>
                </div>
            </div>
        </div>
    </section>
@endsection
