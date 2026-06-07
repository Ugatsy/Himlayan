<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Payments') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-gray-600">{{ $payments->count() }} payments</span>
                    <a href="{{ route('payments.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">+ Record Payment</a>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Receipt</th><th>Client</th><th>Plot</th><th>Amount</th><th>Type</th><th>Date</th><th></th></tr></thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3">{{ $payment->receipt_number ?? '—' }}</td>
                                    <td><a href="{{ route('payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $payment->contract->client->full_name }}</a></td>
                                    <td>{{ $payment->contract->plot->plot_number }}</td>
                                    <td class="font-medium">₱{{ number_format($payment->amount_paid, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                                    <td>{{ $payment->paid_at->format('M d, Y') }}</td>
                                    <td class="text-right">
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-btn" data-url="{{ route('payments.destroy', $payment) }}" data-label="Delete this payment record?">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-gray-500 font-medium">No payments recorded</p>
                                        <p class="text-gray-400 text-sm mt-1">Record a payment when a client makes a transaction.</p>
                                        <a href="{{ route('payments.create') }}" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 text-sm">+ Record Payment</a>
                                    </div>
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.delete-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (confirm(this.dataset.label || 'Delete this?')) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.dataset.url;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
