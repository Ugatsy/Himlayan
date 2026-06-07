<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Contract') }} #{{ $contract->id }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Client</dt><dd class="font-medium"><a href="{{ route('clients.show', $contract->client) }}" class="text-indigo-600 hover:text-indigo-900">{{ $contract->client->full_name }}</a></dd></div>
                    @if($contract->plot)
                        <div><dt class="text-sm text-gray-500">Plot</dt><dd class="font-medium"><a href="{{ route('plots.show', $contract->plot) }}" class="text-indigo-600 hover:text-indigo-900">{{ $contract->plot->plot_number }}</a></dd></div>
                    @endif
                    @if($contract->columbaryNiche)
                        <div><dt class="text-sm text-gray-500">Columbary Niche</dt><dd class="font-medium"><a href="{{ route('columbary-niches.show', $contract->columbaryNiche) }}" class="text-indigo-600 hover:text-indigo-900">{{ $contract->columbaryNiche->niche_number }}</a></dd></div>
                    @endif
                    @if($contract->preNeedPlan)
                        <div><dt class="text-sm text-gray-500">Pre-Need Plan</dt><dd class="font-medium">{{ $contract->preNeedPlan->name }}</dd></div>
                    @endif
                    <div><dt class="text-sm text-gray-500">Contract Date</dt><dd class="font-medium">{{ $contract->contract_date->format('M d, Y') }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Total Amount</dt><dd class="font-medium">₱{{ number_format($contract->total_amount, 2) }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Payment Type</dt><dd class="font-medium">{{ ucfirst(str_replace('_', ' ', $contract->payment_type)) }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2 py-1 text-xs font-semibold rounded-full @if($contract->status === 'active') bg-green-100 text-green-800 @elseif($contract->status === 'completed') bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif">{{ $contract->status }}</span></dd></div>
                </dl>
                <div class="mt-4 flex gap-4">
                    <a href="{{ route('contracts.edit', $contract) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <a href="{{ route('contracts.pdf', $contract) }}" class="text-green-600 hover:text-green-900" target="_blank">Download PDF</a>
                    <form method="POST" action="{{ route('contracts.destroy', $contract) }}" onsubmit="return confirm('Delete this contract?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </div>
            </div>

            @if($contract->installmentSchedules->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Installment Schedule</h3>
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Due Date</th><th>Amount Due</th><th>Amount Paid</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($contract->installmentSchedules as $is)
                                <tr class="border-b">
                                    <td class="py-2">{{ $is->due_date->format('M d, Y') }}</td>
                                    <td>₱{{ number_format($is->amount_due, 2) }}</td>
                                    <td>₱{{ number_format($is->amount_paid, 2) }}</td>
                                    <td><span class="text-xs px-2 py-1 rounded-full @if($is->status === 'paid') bg-green-100 text-green-800 @elseif($is->status === 'overdue') bg-red-100 text-red-800 @elseif($is->status === 'partial') bg-yellow-100 text-yellow-800 @else bg-gray-100 text-gray-800 @endif">{{ $is->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($contract->payments->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Payments</h3>
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Date</th><th>Amount</th><th>Type</th><th>Reference</th><th>Receipt</th></tr></thead>
                        <tbody>
                            @foreach($contract->payments as $payment)
                                <tr class="border-b">
                                    <td class="py-2">{{ $payment->paid_at->format('M d, Y') }}</td>
                                    <td>₱{{ number_format($payment->amount_paid, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                                    <td>{{ $payment->reference_number ?? '—' }}</td>
                                    <td>{{ $payment->receipt_number ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($contract->burials->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Burials</h3>
                    @foreach($contract->burials as $burial)
                        <div class="border rounded-lg p-4 mb-2">
                            <div class="flex justify-between">
                                <span class="font-medium">{{ $burial->deceased_name }}</span>
                                <span class="text-xs px-2 py-1 rounded-full @if($burial->burial_status === 'completed') bg-green-100 text-green-800 @else bg-blue-100 text-blue-800 @endif">{{ $burial->burial_status }}</span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1">{{ $burial->burial_date->format('M d, Y g:i A') }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
