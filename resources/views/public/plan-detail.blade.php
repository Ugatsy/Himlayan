@extends('layouts.public')

@section('title', $plan->name . ' — HIMLAYAN')

@section('content')
    <section class="pt-32 pb-24 bg-stone-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('public.plans') }}" class="inline-flex items-center text-sm text-emerald-700 hover:text-emerald-600 mb-8">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                Back to Plans
            </a>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                @if($plan->image)
                    <img src="{{ $plan->image }}" alt="{{ $plan->name }}" class="w-full h-64 object-cover">
                @endif
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-xs px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 capitalize font-semibold">{{ $plan->type }}</span>
                        <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold">Pre-Need Plan</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">{{ $plan->name }}</h1>
                    <p class="text-gray-600 text-lg mb-8">{{ $plan->description }}</p>

                    @if($plan->features)
                        <h2 class="text-xl font-bold text-gray-900 mb-4">What's Included</h2>
                        <div class="grid sm:grid-cols-2 gap-3 mb-8">
                            @foreach($plan->features as $feature)
                                <div class="flex items-start gap-3 p-3 bg-stone-50 rounded-lg">
                                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7"/></svg>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="pt-6 border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Plan Price</p>
                            <p class="text-3xl font-bold text-emerald-700">₱{{ number_format($plan->price, 2) }}</p>
                        </div>
                        <a href="{{ route('public.reserve.form', 'plan') }}?plan_id={{ $plan->id }}" class="inline-flex items-center px-6 py-3 bg-emerald-700 hover:bg-emerald-600 text-white font-semibold rounded-lg transition-colors shadow-lg">
                            Apply for This Plan
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
