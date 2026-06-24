<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">New Contract</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('contracts.store') }}" id="contract-form">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Client</label>
                        <select name="client_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select client…</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contract Type</label>
                        <select name="contract_type" id="contract_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="lot">Lot / Burial Plot</option>
                            <option value="columbary">Columbary Niche</option>
                            <option value="plan">Pre-Need Plan</option>
                        </select>
                    </div>

                    <div id="plot-fields">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Plot</label>
                                <select name="plot_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select plot…</option>
                                    @foreach($plots as $plot)
                                        <option value="{{ $plot->id }}" data-price="{{ $plot->price }}">{{ $plot->plot_number }} ({{ $plot->section ?? 'No section' }} — ₱{{ number_format($plot->price, 2) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lot Type</label>
                                <select name="lot_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="individual">Individual Lot</option>
                                    <option value="family">Family Lot</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contract Type (Lease)</label>
                                <select name="contract_type" id="lease_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="new">New (₱2,000 — 10 years)</option>
                                    <option value="renewal">Renewal</option>
                                </select>
                            </div>
                            <div id="area-field">
                                <label class="block text-sm font-medium text-gray-700">Lot Area (sqm)</label>
                                <input type="number" step="0.01" name="lot_area" value="{{ old('lot_area') }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Dimension / Location</label>
                            <input type="text" name="dimension" value="{{ old('dimension') }}" placeholder="e.g. 2m × 3m, Section A, Row 5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Commencement Date</label>
                                <input type="date" name="commencement_date" value="{{ old('commencement_date', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Expiration Date</label>
                                <input type="date" name="expiration_date" value="{{ old('expiration_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg hidden" id="rental-computation">
                            <h4 class="font-medium text-sm text-gray-700 mb-2">Rental Fee Computation</h4>
                            <div id="computation-result" class="text-sm"></div>
                        </div>
                    </div>

                    <div class="mb-4" id="columbary-field" style="display:none;">
                        <label class="block text-sm font-medium text-gray-700">Columbary Niche</label>
                        <select name="columbary_niche_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select niche…</option>
                            @foreach($niches ?? [] as $niche)
                                <option value="{{ $niche->id }}">{{ $niche->niche_number }} ({{ $niche->section ?? 'No section' }} — ₱{{ number_format($niche->price, 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4" id="plan-field" style="display:none;">
                        <label class="block text-sm font-medium text-gray-700">Pre-Need Plan</label>
                        <select name="pre_need_plan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select plan…</option>
                            @foreach($plans ?? [] as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} ({{ ucfirst($plan->type) }} — ₱{{ number_format($plan->price, 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contract Date</label>
                        <input type="date" name="contract_date" value="{{ old('contract_date', date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Total Amount (₱)</label>
                        <input type="number" step="0.01" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Payment Type</label>
                        <select name="payment_type" id="payment_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="cash">Cash</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="installment">Installment</option>
                        </select>
                    </div>
                    <div class="mb-4" id="installment-fields" style="display:none;">
                        <label class="block text-sm font-medium text-gray-700">Number of Installments (months)</label>
                        <input type="number" name="installments" value="6" min="2" max="60" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <hr class="my-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Official Receipt (AF 51) & Document References</h3>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">AF 51 / Official Receipt #</label>
                            <input type="text" name="af_51_number" value="{{ old('af_51_number') }}" placeholder="e.g. 123456" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">AF 51 Date</label>
                            <input type="date" name="af_51_date" value="{{ old('af_51_date', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Death Certificate Number</label>
                        <input type="text" name="death_certificate_number" value="{{ old('death_certificate_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('contracts.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Create Contract</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleContractType() {
            const t = document.getElementById('contract_type').value;
            document.getElementById('plot-fields').style.display = t === 'lot' ? 'block' : 'none';
            document.getElementById('columbary-field').style.display = t === 'columbary' ? 'block' : 'none';
            document.getElementById('plan-field').style.display = t === 'plan' ? 'block' : 'none';
        }
        document.getElementById('contract_type')?.addEventListener('change', toggleContractType);
        document.getElementById('payment_type')?.addEventListener('change', function() {
            document.getElementById('installment-fields').style.display = this.value === 'installment' ? 'block' : 'none';
        });

        function toggleLeaseFields() {
            const lotType = document.querySelector('[name="lot_type"]')?.value;
            const areaField = document.getElementById('area-field');
            if (areaField) {
                areaField.style.display = lotType === 'family' ? 'block' : 'none';
            }
        }
        document.querySelector('[name="lot_type"]')?.addEventListener('change', toggleLeaseFields);

        function computeRental() {
            const leaseType = document.getElementById('lease_type')?.value;
            if (leaseType !== 'renewal') return;

            const lotType = document.querySelector('[name="lot_type"]')?.value;
            const area = parseFloat(document.querySelector('[name="lot_area"]')?.value) || 0;

            fetch('{{ route("burial-permits.compute-rental") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ year_established: {{ date('Y') - 10 }}, lot_type: lotType, area: area })
            })
            .then(r => r.json())
            .then(data => {
                const el = document.getElementById('rental-computation');
                const result = document.getElementById('computation-result');
                el.style.display = 'block';

                if (data.forward_renewal) {
                    result.innerHTML = '<div class="text-green-700 font-medium">Forward Renewal (next 10 years):</div>' +
                        '<div class="mt-1">' + data.forward_renewal.breakdown + '</div>' +
                        '<div class="mt-2 font-semibold">Total: ₱' + Number(data.forward_renewal.fee).toLocaleString(undefined, {minimumFractionDigits: 2}) + '</div>' +
                        '<div class="text-xs text-gray-500 mt-1">Annual rate: ₱' + Number(data.forward_renewal.annual || 0).toLocaleString(undefined, {minimumFractionDigits: 2}) + '/yr</div>';
                } else if (data.type === 'new') {
                    result.innerHTML = '<div class="text-green-700 font-medium">New Lot Fee:</div>' +
                        '<div class="mt-1">' + data.breakdown + '</div>';
                }
            })
            .catch(() => {});
        }

        document.querySelector('[name="lot_type"]')?.addEventListener('change', computeRental);
        document.querySelector('[name="lot_area"]')?.addEventListener('change', computeRental);
        document.getElementById('lease_type')?.addEventListener('change', computeRental);
    </script>
</x-app-layout>
