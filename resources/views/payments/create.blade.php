<x-app-layout>
    <div>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Record Payment</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contract</label>
                        <select name="contract_id" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="">Select contract…</option>
                            @foreach($contracts as $contract)
                                <option value="{{ $contract->id }}">{{ $contract->client->full_name }} — {{ $contract->plot->plot_number }} (₱{{ number_format($contract->total_amount, 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Amount Paid (₱)</label><input type="number" step="0.01" name="amount_paid" value="{{ old('amount_paid') }}" min="0.01" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Payment Type</label>
                        <select name="payment_type" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="cash">Cash</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="installment">Installment</option>
                        </select>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Reference Number</label><input type="text" name="reference_number" value="{{ old('reference_number') }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Receipt Number</label><input type="text" name="receipt_number" value="{{ old('receipt_number') }}" placeholder="Auto-generated if empty" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Payment Date</label><input type="datetime-local" name="paid_at" value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Notes</label><textarea name="notes" rows="2" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">{{ old('notes') }}</textarea></div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('payments.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                        <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
