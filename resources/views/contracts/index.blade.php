<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Contracts') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-gray-600">{{ $contracts->count() }} contracts</span>
                    <a href="{{ route('contracts.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">+ New Contract</a>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Client</th><th>Service</th><th>Date</th><th>Amount</th><th>Payment</th><th>Status</th><th></th></tr></thead>
                        <tbody>
                            @forelse($contracts as $contract)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3"><a href="{{ route('contracts.show', $contract) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $contract->client->full_name }}</a></td>
                                    <td>
                                        @if($contract->plot) Plot: {{ $contract->plot->plot_number }}
                                        @elseif($contract->columbaryNiche) Niche: {{ $contract->columbaryNiche->niche_number }}
                                        @elseif($contract->preNeedPlan) Plan: {{ $contract->preNeedPlan->name }}
                                        @else — @endif
                                    </td>
                                    <td>{{ $contract->contract_date->format('M d, Y') }}</td>
                                    <td>₱{{ number_format($contract->total_amount, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $contract->payment_type)) }}</td>
                                    <td><span class="text-xs px-2 py-1 rounded-full @if($contract->status === 'active') bg-green-100 text-green-800 @elseif($contract->status === 'completed') bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif">{{ $contract->status }}</span></td>
                                    <td class="text-right">
                                        <a href="{{ route('contracts.edit', $contract) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form method="POST" action="{{ route('contracts.destroy', $contract) }}" class="inline" onsubmit="return confirm('Delete this contract?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="py-8 text-center text-gray-500">No contracts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
