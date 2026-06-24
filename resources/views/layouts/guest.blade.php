@extends('layouts.public')

@section('title', config('app.name', 'HIMLAYAN'))

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center px-4 pt-24 pb-16">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
@endsection
