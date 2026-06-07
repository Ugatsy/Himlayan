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
                                    <td>₱{{ number_format($payment->amount_paid, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                                    <td>{{ $payment->paid_at->format('M d, Y') }}</td>
                                    <td class="text-right">
                                        <form method="POST" action="{{ route('payments.destroy', $payment) }}" class="inline" onsubmit="return confirm('Delete this payment?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="py-8 text-center text-gray-500">No payments recorded.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
