<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('New Contract') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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
                    <div class="mb-4" id="plot-field">
                        <label class="block text-sm font-medium text-gray-700">Plot</label>
                        <select name="plot_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select plot…</option>
                            @foreach($plots as $plot)
                                <option value="{{ $plot->id }}">{{ $plot->plot_number }} ({{ $plot->section ?? 'No section' }} — ₱{{ number_format($plot->price, 2) }})</option>
                            @endforeach
                        </select>
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
                        <input type="number" step="0.01" name="total_amount" value="{{ old('total_amount') }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
            document.getElementById('plot-field').style.display = t === 'lot' ? 'block' : 'none';
            document.getElementById('columbary-field').style.display = t === 'columbary' ? 'block' : 'none';
            document.getElementById('plan-field').style.display = t === 'plan' ? 'block' : 'none';
        }
        document.getElementById('contract_type')?.addEventListener('change', toggleContractType);
        document.getElementById('payment_type')?.addEventListener('change', function() {
            document.getElementById('installment-fields').style.display = this.value === 'installment' ? 'block' : 'none';
        });
    </script>
</x-app-layout>
