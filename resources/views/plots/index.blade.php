<x-app-layout>
    <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Plots</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div style="display: flex; gap: 20px;">
                        <div style="width: 300px; flex-shrink: 0;">
                            <input type="text" id="search-input" placeholder="Search plot number…" style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
                            <div id="plot-list" style="max-height: 500px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 4px; padding: 8px;">
                                @foreach($plots as $plot)
                                    <div class="plot-entry" data-id="{{ $plot->id }}" style="padding: 8px; border-bottom: 1px solid #e5e7eb; cursor: pointer;">
                                        <div class="flex items-center justify-between">
                                            <strong>{{ $plot->plot_number }}</strong>
                                            <span class="badge" style="padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;
                                                @if($plot->status === 'occupied') background: #fee2e2; color: #991b1b;
                                                @elseif($plot->status === 'reserved') background: #fef3c7; color: #92400e;
                                                @elseif($plot->status === 'full') background: #fecaca; color: #7f1d1d;
                                                @else background: #d1fae5; color: #065f46;
                                                @endif
                                            ">{{ $plot->status }}</span>
                                        </div>
                                        <span style="display: block; font-size: 0.875rem; color: #6b7280;">
                                            {{ $plot->section ?? 'No section' }} — {{ $plot->burials_count }} burial(s)
                                        </span>
                                        <div class="flex gap-2 mt-1">
                                            <button type="button" class="btn-relocate text-xs px-2 py-0.5 rounded border border-amber-500 text-amber-700 hover:bg-amber-50" data-id="{{ $plot->id }}" title="Click map to reposition" style="cursor: pointer;">Relocate</button>
                                            <button type="button" class="btn-remove text-xs px-2 py-0.5 rounded border border-red-400 text-red-600 hover:bg-red-100" data-id="{{ $plot->id }}" title="Remove pin from map" style="cursor: pointer;">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('plots.create') }}" style="display: block; margin-top: 10px; padding: 10px; background: #2563eb; color: white; text-align: center; border: none; border-radius: 4px; text-decoration: none;">+ Add plot</a>
                        </div>
                        <div id="map" style="flex: 1; height: 600px; border: 2px solid #e5e7eb; border-radius: 4px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const PLOTS = @json($plotData);
        const UPDATE_URL = "{{ route('plots.position', ':id') }}";
        const CSRF = "{{ csrf_token() }}";

        const map = L.map('map', {
            center: [16.5253, 121.1906],
            zoom: 19,
            minZoom: 17,
            maxZoom: 21,
            maxBounds: L.latLngBounds([16.5217, 121.1862], [16.5290, 121.1951]),
            maxBoundsViscosity: 1.0,
        });

        const satellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google',
        });

        const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>',
        });

        const customTiles = L.tileLayer('/tiles/{z}/{x}/{y}.png', {
            minZoom: 20,
            maxZoom: 21,
            maxNativeZoom: 20,
            errorTileUrl: '/tiles/placeholder.png',
        }).setZIndex(10);

        satellite.addTo(map);
        customTiles.addTo(map);

        L.control.layers({
            'Satellite': satellite,
            'OpenStreetMap': osm,
        }, {
            'Cemetery tiles': customTiles,
        }, { position: 'topleft' }).addTo(map);

        const markers = [];
        const markerGroup = L.layerGroup().addTo(map);
        let markersVisible = true;
        let pinMode = false;
        let locked = false;

        function makeMarker(plot, draggable) {
            const color = plot.status === 'occupied' ? '#ef4444'
                : plot.status === 'reserved' ? '#f59e0b'
                : plot.status === 'full' ? '#dc2626' : '#22c55e';
            const icon = L.divIcon({
                className: '',
                html: `<div style="width:16px;height:16px;background:${color};border:2px solid #fff;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,.3);"></div>`,
                iconSize: [16, 16],
                iconAnchor: [8, 8],
            });
            const marker = L.marker([plot.lat, plot.lng], { draggable, icon })
                .bindPopup(`<b>${plot.plot_number}</b><br>${plot.section ?? ''}<br>Status: ${plot.status}<br>Burials: ${plot.burials_count}/${plot.capacity}`);
            marker._plotId = plot.id;
            marker._plotNumber = plot.plot_number;
            marker.on('dragend', function(e) {
                const { lat, lng } = e.target.getLatLng();
                const url = UPDATE_URL.replace(':id', plot.id);
                fetch(url, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                    body: JSON.stringify({ lat, lng })
                });
            });
            return marker;
        }

        PLOTS.forEach(plot => {
            if (!plot.lat && !plot.lng) return;
            const marker = makeMarker(plot, true);
            markerGroup.addLayer(marker);
            markers.push(marker);
        });

        // Control bar
        const ControlBar = L.Control.extend({
            onAdd() {
                const div = L.DomUtil.create('div', 'leaflet-bar');
                div.style.cssText = 'background:#fff;padding:4px;display:flex;flex-direction:column;gap:4px;';
                div.innerHTML = `
                    <button id="btn-toggle-markers" title="Toggle markers" style="width:34px;height:34px;cursor:pointer;border:1px solid #ccc;border-radius:2px;background:#fff;font-size:16px;line-height:1;">👁</button>
                    <button id="btn-pin" title="Pin new plot" style="width:34px;height:34px;cursor:pointer;border:1px solid #ccc;border-radius:2px;background:#fff;font-size:16px;line-height:1;">📌</button>
                    <button id="btn-lock" title="Lock markers" style="width:34px;height:34px;cursor:pointer;border:1px solid #ccc;border-radius:2px;background:#fff;font-size:16px;line-height:1;">🔒</button>
                `;
                return div;
            }
        });
        map.addControl(new ControlBar({ position: 'topright' }));

        document.getElementById('btn-toggle-markers').addEventListener('click', function() {
            markersVisible = !markersVisible;
            if (markersVisible) { markerGroup.addTo(map); this.style.background = '#fff'; }
            else { map.removeLayer(markerGroup); this.style.background = '#e5e7eb'; }
        });

        document.getElementById('btn-pin').addEventListener('click', function() {
            pinMode = !pinMode;
            this.style.background = pinMode ? '#fef3c7' : '#fff';
            map.getContainer().style.cursor = pinMode ? 'crosshair' : '';
        });

        document.getElementById('btn-lock').addEventListener('click', function() {
            locked = !locked;
            this.style.background = locked ? '#fee2e2' : '#fff';
            markers.forEach(m => m.dragging?.[locked ? 'disable' : 'enable']());
        });

        map.on('click', function(e) {
            if (!pinMode) return;
            const plotNumber = prompt('Plot number (e.g. AA-01):');
            if (!plotNumber) return;
            fetch('{{ route('plots.store') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({
                    plot_number: plotNumber,
                    lat: e.latlng.lat,
                    lng: e.latlng.lng,
                    status: 'available',
                    capacity: 1,
                })
            })
            .then(r => r.json())
            .then(data => {
                const plot = { id: data.id, plot_number: plotNumber, lat: e.latlng.lat, lng: e.latlng.lng, status: 'available', section: null, burials_count: 0, capacity: 1 };
                const marker = makeMarker(plot, !locked);
                markerGroup.addLayer(marker);
                markers.push(marker);
                pinMode = false;
                document.getElementById('btn-pin').style.background = '#fff';
                map.getContainer().style.cursor = '';
            })
            .catch(() => alert('Failed to create plot'));
        });

        document.getElementById('search-input')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.plot-entry').forEach(el => {
                el.style.display = el.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });

        document.querySelectorAll('.plot-entry').forEach(el => {
            el.addEventListener('click', function(e) {
                if (e.target.closest('button')) return;
                const id = parseInt(this.dataset.id);
                const marker = markers.find(m => m._plotId === id);
                if (marker) map.flyTo(marker.getLatLng(), 19, { duration: 1 });
            });
        });

        let relocateTarget = null;

        document.querySelectorAll('.btn-relocate').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = parseInt(this.dataset.id);
                const marker = markers.find(m => m._plotId === id);
                if (!marker) return;
                if (relocateTarget === id) {
                    relocateTarget = null;
                    this.textContent = 'Relocate';
                    this.style.background = '';
                    map.getContainer().style.cursor = '';
                    return;
                }
                relocateTarget = id;
                this.textContent = 'Cancel';
                this.style.background = '#fef3c7';
                map.getContainer().style.cursor = 'crosshair';
                map.flyTo(marker.getLatLng(), 20, { duration: 0.5 });
            });
        });

        map.on('click', function(e) {
            if (!relocateTarget) return;
            const plot = PLOTS.find(p => p.id === relocateTarget);
            if (!plot) return;
            const marker = markers.find(m => m._plotId === relocateTarget);
            if (!marker) return;
            const { lat, lng } = e.latlng;
            const url = UPDATE_URL.replace(':id', relocateTarget);
            fetch(url, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ lat, lng })
            }).then(r => {
                if (r.ok) {
                    marker.setLatLng([lat, lng]);
                    plot.lat = lat;
                    plot.lng = lng;
                }
            }).catch(() => alert('Failed to relocate'));
            relocateTarget = null;
            document.querySelectorAll('.btn-relocate').forEach(b => { b.textContent = 'Relocate'; b.style.background = ''; });
            map.getContainer().style.cursor = '';
        });

        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = parseInt(this.dataset.id);
                const plot = PLOTS.find(p => p.id === id);
                if (!confirm(`Remove pin for ${plot ? plot.plot_number : 'this plot'}?`)) return;
                fetch(`/plots/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF },
                }).then(r => {
                    if (r.ok) {
                        const marker = markers.find(m => m._plotId === id);
                        if (marker) { markerGroup.removeLayer(marker); markers.splice(markers.indexOf(marker), 1); }
                        const entry = document.querySelector(`.plot-entry[data-id="${id}"]`);
                        if (entry) entry.remove();
                    } else {
                        r.text().then(t => alert(t.includes('Cannot delete') ? 'Cannot delete plot with existing burials.' : 'Failed to remove pin'));
                    }
                }).catch(() => alert('Failed to remove pin'));
            });
        });
    </script>
</x-app-layout>
