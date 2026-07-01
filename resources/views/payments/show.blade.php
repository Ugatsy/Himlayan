<x-app-layout>
    <div>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Payment — {{ $payment->receipt_number ?? "No receipt" }}</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Client</dt><dd class="font-medium">{{ $payment->contract->client->full_name }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Plot</dt><dd class="font-medium">{{ $payment->contract->plot->plot_number }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Amount Paid</dt><dd class="font-medium">₱{{ number_format($payment->amount_paid, 2) }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Payment Type</dt><dd class="font-medium">{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Reference Number</dt><dd class="font-medium">{{ $payment->reference_number ?? '—' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Receipt Number</dt><dd class="font-medium">{{ $payment->receipt_number ?? '—' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Payment Date</dt><dd class="font-medium">{{ $payment->paid_at->format('M d, Y g:i A') }}</dd></div>
                    @if($payment->notes)
                        <div class="col-span-2"><dt class="text-sm text-gray-500">Notes</dt><dd class="font-medium">{{ $payment->notes }}</dd></div>
                    @endif
                </dl>
                <div class="mt-6">
                    <form method="POST" action="{{ route('payments.destroy', $payment) }}" onsubmit="return confirm('Delete this payment?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">Delete Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
