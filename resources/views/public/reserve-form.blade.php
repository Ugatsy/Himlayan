@extends('layouts.public')

@section('title', 'Reserve Online — HIMLAYAN')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #reserve-map { height: 350px; border-radius: 12px; border: 2px solid #e5e7eb; }
    </style>

    <section class="pt-32 pb-24 bg-stone-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                @switch($type)
                    @case('lot') Reserve a Memorial Lot @break
                    @case('columbary') Reserve a Columbary Niche @break
                    @case('plan') Apply for a Pre-Need Plan @break
                @endswitch
            </h1>
            <p class="text-gray-600 mb-8">Fill out the form below and our team will contact you within 24 hours to confirm your reservation.</p>

            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6 font-medium">{{ session('error') }}</div>
            @endif

            <div class="grid lg:grid-cols-5 gap-8">
                @if($type === 'lot' && $plotData->isNotEmpty())
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <p class="text-sm font-medium text-gray-700 mb-3">Click a lot on the map to select it</p>
                            <div id="reserve-map"></div>
                        </div>
                    </div>
                @endif

                <div class="@if($type === 'lot' && $plotData->isNotEmpty()) lg:col-span-2 @else lg:col-span-2 mx-auto w-full max-w-2xl @endif">
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <form method="POST" action="{{ route('public.reserve.store') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">

                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2 sm:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                    <input type="text" name="full_name" value="{{ old('full_name') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number *</label>
                                    <input type="text" name="contact_number" value="{{ old('contact_number') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>

                            @if($type === 'lot')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Lot *</label>
                                    <select name="plot_id" id="plot-select" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                        <option value="">Choose a lot...</option>
                                        @foreach($plots as $plot)
                                            <option value="{{ $plot->id }}" data-lat="{{ $plot->lat }}" data-lng="{{ $plot->lng }}" @selected(old('plot_id') == $plot->id)>
                                                {{ $plot->plot_number }} — {{ $plot->section ?? 'No section' }} — ₱{{ number_format($plot->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($type === 'columbary')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Niche *</label>
                                    <select name="columbary_niche_id" id="niche-select" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                        <option value="">Choose a niche...</option>
                                        @foreach($niches as $niche)
                                            <option value="{{ $niche->id }}" @selected(old('columbary_niche_id') == $niche->id)>
                                                {{ $niche->niche_number }} — {{ $niche->section ?? 'No section' }} — Row {{ $niche->row ?? '—' }} — ₱{{ number_format($niche->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($type === 'plan')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Plan *</label>
                                    <select name="pre_need_plan_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                        <option value="">Choose a plan...</option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}" @selected(request('plan_id') == $plan->id || old('pre_need_plan_id') == $plan->id)>
                                                {{ $plan->name }} — {{ ucfirst($plan->type) }} — ₱{{ number_format($plan->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Message</label>
                                <textarea name="message" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors shadow-lg">
                                Submit Reservation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    @if($type === 'lot' && $plotData->isNotEmpty())
        (function() {
            const PLOTS = @json($plotData);
            const map = L.map('reserve-map', {
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

            const markers = [];
            const markerGroup = L.layerGroup().addTo(map);
            let selectedId = null;

            PLOTS.forEach(function(plot) {
                if (!plot.lat && !plot.lng) return;
                var icon = L.divIcon({
                    className: '',
                    html: '<div style="width:18px;height:18px;background:#22c55e;border:3px solid #fff;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,0.3);"></div>',
                    iconSize: [18, 18],
                    iconAnchor: [9, 9],
                });
                var marker = L.marker([plot.lat, plot.lng], { icon: icon })
                    .bindPopup('<b>' + plot.plot_number + '</b><br>' + (plot.section || '') + '<br>\u20B1' + Number(plot.price).toLocaleString());
                marker._plotId = plot.id;
                marker.on('click', function() { selectPlot(this._plotId); });
                markerGroup.addLayer(marker);
                markers.push(marker);
            });

            function selectPlot(id) {
                selectedId = id;
                document.getElementById('plot-select').value = id;
                markers.forEach(function(m) {
                    var el = m.getElement();
                    if (el) el.style.filter = m._plotId === id ? 'brightness(1.5) drop-shadow(0 0 4px #000)' : '';
                });
                var marker = markers.find(function(m) { return m._plotId === id; });
                if (marker) {
                    map.flyTo(marker.getLatLng(), 20, { duration: 0.5 });
                    map.once('moveend', function() { marker.openPopup(); });
                }
            }

            document.getElementById('plot-select').addEventListener('change', function() {
                var id = parseInt(this.value);
                if (!id) return;
                selectPlot(id);
            });
        })();
    @endif
    </script>
@endsection
