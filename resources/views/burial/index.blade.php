<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Burial Map') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="app" style="display: flex; gap: 20px;">
                        <!-- Sidebar -->
                        <div id="sidebar" style="width: 300px; flex-shrink: 0;">
                            <input type="text" id="search-input" placeholder="Search name or plot…" style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
                            <div id="burial-list" style="max-height: 500px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 4px; padding: 8px;">
                                @foreach($spots as $spot)
                                    <div class="entry" data-id="{{ $spot->id }}" style="padding: 8px; border-bottom: 1px solid #e5e7eb; cursor: pointer;">
                                        <strong>{{ $spot->name }}</strong>
                                        <span style="display: block; font-size: 0.875rem; color: #6b7280;">{{ $spot->plot_number }}</span>
                                        <span class="badge" style="display: inline-block; padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;
                                            @if($spot->status === 'occupied') background: #fee2e2; color: #991b1b;
                                            @elseif($spot->status === 'reserved') background: #fef3c7; color: #92400e;
                                            @else background: #d1fae5; color: #065f46;
                                            @endif
                                        ">{{ $spot->status }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <button onclick="openModal()" style="margin-top: 10px; width: 100%; padding: 10px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">+ Add burial spot</button>
                        </div>

                        <!-- Map Canvas -->
                        <div id="map-area" style="flex: 1;">
                            <svg id="map-svg" viewBox="0 0 520 380" style="width: 100%; border: 2px solid #e5e7eb; border-radius: 4px; background: #f9fafb;">
                                <g id="markers-layer"></g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('burial._modal')

    @if(session('success'))
        <div style="position: fixed; bottom: 20px; right: 20px; background: #065f46; color: white; padding: 12px 24px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <script>
        const SPOTS = @json($spots);
        const UPDATE_POSITION_URL = "{{ route('burial-spots.position', ':id') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/map.js') }}"></script>
</x-app-layout>