@extends('layouts.public')

@section('title', 'Find a Loved One — Heritage Memorial Park')

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map { height: 500px; border-radius: 12px; border: 2px solid #e5e7eb; }
        .result-card { background: white; padding: 16px; border-radius: 8px; margin-bottom: 8px; cursor: pointer; border: 2px solid transparent; transition: border-color 0.2s; display: flex; justify-content: space-between; align-items: center; }
        .result-card:hover { border-color: #065f46; }
        .result-card .name { font-weight: 600; font-size: 1.1rem; }
        .result-card .meta { font-size: 0.875rem; color: #6b7280; }
        .result-card .plot-badge { background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; }
        .no-results { text-align: center; padding: 40px; color: #9ca3af; }
    </style>
@endpush

@section('content')
    <div class="min-h-screen pt-20 pb-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center py-10">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Find a Loved One</h1>
                <p class="text-gray-500 mt-2">Search by deceased name or plot number</p>
            </div>

            <div class="max-w-xl mx-auto mb-8 flex gap-2">
                <input type="text" id="q" placeholder="Enter name or plot number…" autofocus
                    class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl text-base focus:border-emerald-600 focus:outline-none transition-colors">
                <button onclick="search()" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-600 text-white font-medium rounded-xl transition-colors">Search</button>
            </div>

            <div id="results"></div>
            <div id="map"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        const map = L.map('map', {
            center: [16.5253, 121.1906],
            zoom: 18,
            minZoom: 17,
            maxZoom: 20,
            maxBounds: L.latLngBounds([16.5217, 121.1862], [16.5290, 121.1951]),
            maxBoundsViscosity: 1.0,
        });

        L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '&copy; Google',
        }).addTo(map);

        const markersLayer = L.layerGroup().addTo(map);

        function makePinIcon(color) {
            return L.divIcon({
                className: '',
                html: `<div style="width:18px;height:18px;background:${color};border:3px solid #fff;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,0.3);"></div>`,
                iconSize: [18, 18],
                iconAnchor: [9, 9],
            });
        }

        async function search() {
            const q = document.getElementById('q').value.trim();
            if (q.length < 2) return;

            markersLayer.clearLayers();

            const res = await fetch('/find/search?q=' + encodeURIComponent(q));
            const results = await res.json();
            const container = document.getElementById('results');
            container.innerHTML = '';

            if (results.length === 0) {
                container.innerHTML = '<div class="no-results">No results found. Try a different name.</div>';
                return;
            }

            results.forEach(r => {
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div>
                        <div class="name">${r.name}</div>
                        <div class="meta">${r.dates ?? ''} ${r.section ? '— ' + r.section : ''}</div>
                    </div>
                    <div class="plot-badge">${r.plot_number}</div>
                `;
                card.addEventListener('click', () => flyTo(r));
                container.appendChild(card);
            });

            flyTo(results[0]);
        }

        function flyTo(r) {
            markersLayer.clearLayers();
            map.flyTo([r.lat, r.lng], 20, { duration: 1.5 });
            L.marker([r.lat, r.lng], { icon: makePinIcon('#22c55e') }).addTo(markersLayer)
                .bindPopup(`<b>${r.name}</b><br>${r.plot_number}${r.section ? '<br>' + r.section : ''}`)
                .openPopup();
        }

        document.getElementById('q').addEventListener('keydown', e => { if (e.key === 'Enter') search(); });
    </script>
    @endpush
@endsection
