<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $burial->deceased_name }}</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-600">Deceased Name</dt><dd class="font-medium">{{ $burial->deceased_name }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Plot</dt><dd class="font-medium"><a href="{{ route('plots.show', $burial->plot) }}" class="text-indigo-600 hover:text-indigo-900">{{ $burial->plot->plot_number }}</a></dd></div>
                    <div><dt class="text-sm text-gray-600">Date of Birth</dt><dd class="font-medium">{{ $burial->date_of_birth?->format('M d, Y') ?? '—' }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Date of Death</dt><dd class="font-medium">{{ $burial->date_of_death->format('M d, Y') }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Burial Date</dt><dd class="font-medium">{{ $burial->burial_date->format('M d, Y g:i A') }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Status</dt><dd><span class="px-2 py-1 text-xs font-semibold rounded-full @if($burial->burial_status === 'completed') bg-green-100 text-green-800 @elseif($burial->burial_status === 'scheduled') bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif">{{ $burial->burial_status }}</span></dd></div>
                    <div><dt class="text-sm text-gray-600">Scheduled By</dt><dd class="font-medium">{{ $burial->scheduledBy->name ?? '—' }}</dd></div>
                    <div><dt class="text-sm text-gray-600">Approved At</dt><dd class="font-medium">{{ $burial->approved_at?->format('M d, Y g:i A') ?? 'Not yet approved' }}</dd></div>
                    @if($burial->notes)
                        <div class="col-span-2"><dt class="text-sm text-gray-600">Notes</dt><dd class="font-medium">{{ $burial->notes }}</dd></div>
                    @endif
                </dl>
                <div class="mt-4 flex gap-4">
                    <a href="{{ route('burials.edit', $burial) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    @if($burial->burial_status === 'scheduled')
                        <form method="POST" action="{{ route('burials.approve', $burial) }}" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('burials.destroy', $burial) }}" onsubmit="return confirm('Delete this burial?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">Contract</h3>
                <p><a href="{{ route('contracts.show', $burial->contract) }}" class="text-indigo-600 hover:text-indigo-900">Contract #{{ $burial->contract->id }}</a> — {{ $burial->contract->client->full_name }}</p>
            </div>

            <div id="map" style="height: 300px; border-radius: 8px; border: 2px solid #e5e7eb;"></div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const lat = {{ $burial->plot->lat }};
        const lng = {{ $burial->plot->lng }};
        if (lat || lng) {
            const map = L.map('map', { center: [lat, lng], zoom: 18, zoomControl: true });
            L.tileLayer('/tiles/{z}/{x}/{y}.png', { maxZoom: 20, maxNativeZoom: 20 }).addTo(map);
            L.marker([lat, lng]).addTo(map).bindPopup('<b>{{ $burial->plot->plot_number }}</b>').openPopup();
        }
    </script>
</x-app-layout>
