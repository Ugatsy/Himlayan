<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Add Plot</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('plots.store') }}">
                    @csrf
                    <div class="grid lg:grid-cols-2 gap-8">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Click on the map to place the plot</p>
                            <div id="map" style="height: 450px; border: 2px solid #e5e7eb; border-radius: 6px;"></div>
                            <p class="text-xs text-gray-500 mt-2">Click anywhere on the map to set the location. Drag the marker to fine-tune.</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Plot Number</label>
                                <input type="text" name="plot_number" value="{{ old('plot_number') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Section</label>
                                <input type="text" name="section" value="{{ old('section') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Latitude</label>
                                    <input type="text" name="lat" id="lat-input" value="{{ old('lat') }}" readonly class="mt-1 block w-full rounded-md bg-gray-50 border-gray-300 shadow-sm text-gray-600 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Longitude</label>
                                    <input type="text" name="lng" id="lng-input" value="{{ old('lng') }}" readonly class="mt-1 block w-full rounded-md bg-gray-50 border-gray-300 shadow-sm text-gray-600 text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Capacity</label>
                                    <input type="number" name="capacity" value="{{ old('capacity', 1) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Price (₱)</label>
                                    <input type="number" step="0.01" name="price" value="{{ old('price', 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="available">Available</option>
                                    <option value="reserved">Reserved</option>
                                    <option value="occupied">Occupied</option>
                                    <option value="full">Full</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                            </div>
                            <div class="flex items-center justify-end gap-4 pt-2">
                                <a href="{{ route('plots.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map', {
            center: [16.5253, 121.1906],
            zoom: 19,
            minZoom: 17,
            maxZoom: 20,
            maxBounds: L.latLngBounds([16.5217, 121.1862], [16.5290, 121.1951]),
            maxBoundsViscosity: 1.0,
        });

        L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google',
        }).addTo(map);

        let marker = null;

        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            document.getElementById('lat-input').value = lat.toFixed(6);
            document.getElementById('lng-input').value = lng.toFixed(6);
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                marker.on('dragend', function() {
                    const pos = marker.getLatLng();
                    document.getElementById('lat-input').value = pos.lat.toFixed(6);
                    document.getElementById('lng-input').value = pos.lng.toFixed(6);
                });
            }
            map.setView([lat, lng], 20, { animate: true });
        });
    </script>
</x-app-layout>
