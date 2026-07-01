<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1 mb-6">Overview of cemetery activity and metrics</p>

        @php $role = auth()->user()->role?->name; @endphp

        @switch($role)
            @case('super_admin')
                @include('dashboard.super-admin')
                @break
            @case('engr')
                @include('dashboard.engr')
                @break
            @default
                @include('dashboard.rcc-staff')
        @endswitch
    </div>
</x-app-layout>
