<x-app-layout>
    <div>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Contract #{{ $contract->id }}</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('contracts.update', $contract) }}">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Client</label>
                        <select name="client_id" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $contract->client_id === $client->id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Plot</label>
                        <select name="plot_id" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="">No plot</option>
                            @foreach($plots as $plot)
                                <option value="{{ $plot->id }}" {{ $contract->plot_id === $plot->id ? 'selected' : '' }}>{{ $plot->plot_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lot Type</label>
                            <select name="lot_type" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                                <option value="">—</option>
                                <option value="individual" {{ $contract->lot_type === 'individual' ? 'selected' : '' }}>Individual</option>
                                <option value="family" {{ $contract->lot_type === 'family' ? 'selected' : '' }}>Family</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lease Type</label>
                            <select name="contract_type" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                                <option value="new" {{ $contract->contract_type === 'new' ? 'selected' : '' }}>New</option>
                                <option value="renewal" {{ $contract->contract_type === 'renewal' ? 'selected' : '' }}>Renewal</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lot Area (sqm)</label>
                            <input type="number" step="0.01" name="lot_area" value="{{ old('lot_area', $contract->lot_area) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dimension</label>
                            <input type="text" name="dimension" value="{{ old('dimension', $contract->dimension) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                        </div>
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Commencement Date</label>
                            <input type="date" name="commencement_date" value="{{ old('commencement_date', $contract->commencement_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Expiration Date</label>
                            <input type="date" name="expiration_date" value="{{ old('expiration_date', $contract->expiration_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Columbary Niche</label>
                        <select name="columbary_niche_id" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="">No niche</option>
                            @foreach($niches ?? [] as $niche)
                                <option value="{{ $niche->id }}" {{ $contract->columbary_niche_id === $niche->id ? 'selected' : '' }}>{{ $niche->niche_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pre-Need Plan</label>
                        <select name="pre_need_plan_id" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="">No plan</option>
                            @foreach($plans ?? [] as $plan)
                                <option value="{{ $plan->id }}" {{ $contract->pre_need_plan_id === $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Contract Date</label><input type="date" name="contract_date" value="{{ old('contract_date', $contract->contract_date->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Total Amount (₱)</label><input type="number" step="0.01" name="total_amount" value="{{ old('total_amount', $contract->total_amount) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Payment Type</label>
                        <select name="payment_type" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            @foreach(['cash','credit_card','installment'] as $pt)
                                <option value="{{ $pt }}" {{ $contract->payment_type === $pt ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $pt)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            @foreach(['active','completed','cancelled'] as $st)
                                <option value="{{ $st }}" {{ $contract->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr class="my-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Official Receipt (AF 51) & Documents</h3>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">AF 51 / OR #</label>
                            <input type="text" name="af_51_number" value="{{ old('af_51_number', $contract->af_51_number) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">AF 51 Date</label>
                            <input type="date" name="af_51_date" value="{{ old('af_51_date', $contract->af_51_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Death Certificate Number</label>
                        <input type="text" name="death_certificate_number" value="{{ old('death_certificate_number', $contract->death_certificate_number) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                    </div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('contracts.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                        <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
