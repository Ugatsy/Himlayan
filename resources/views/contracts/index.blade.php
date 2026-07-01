<x-app-layout>
    <div>
    <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Contracts &amp; Billing</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500">{{ $contracts->count() }} contracts</span>
                        <input type="text" id="search-contracts" placeholder="Search by client name…" class="rounded-lg bg-white border-gray-200 text-gray-900 placeholder-gray-500 text-sm shadow-sm focus:border-brand-blue focus:ring-brand-blue w-64">
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('payments.index') }}" class="text-brand-blue hover:text-brand-blue-dark text-sm font-medium px-3 py-2">View Payments</a>
                        <a href="{{ route('contracts.create') }}" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark text-sm">+ New Contract</a>
                    </div>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider"><th class="py-2 font-medium">Client</th><th class="font-medium">Service</th><th class="font-medium">Type</th><th class="font-medium">Date</th><th class="font-medium">Amount</th><th class="font-medium">Payment</th><th class="font-medium">Signatories</th><th class="font-medium">Status</th><th class="font-medium"></th></tr></thead>
                        <tbody id="contracts-table-body">
                            @forelse($contracts as $contract)
                                <tr class="border-b hover:bg-blue-50/50 contract-row">
                                    <td class="py-3"><a href="{{ route('contracts.show', $contract) }}" class="text-brand-blue hover:text-brand-blue-dark font-medium client-name">{{ $contract->client->full_name }}</a></td>
                                    <td>
                                        @if($contract->plot) Plot: {{ $contract->plot->plot_number }}
                                        @elseif($contract->columbaryNiche) Niche: {{ $contract->columbaryNiche->niche_number }}
                                        @elseif($contract->preNeedPlan) Plan: {{ $contract->preNeedPlan->name }}
                                        @else — @endif
                                    </td>
                                    <td class="text-xs">
                                        @if($contract->lot_type)
                                            <span class="capitalize">{{ $contract->lot_type }}</span>
                                            <span class="text-gray-500">·</span>
                                            <span class="capitalize">{{ $contract->contract_type ?? 'new' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $contract->contract_date->format('M d, Y') }}</td>
                                    <td>₱{{ number_format($contract->total_amount, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $contract->payment_type)) }}</td>
                                    <td class="text-xs">
                                        <div class="flex items-center gap-0.5">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $contract->prepared_by ? 'bg-green-1000' : 'bg-gray-300' }}"></span>
                                            <span class="text-gray-500">→</span>
                                            <span class="w-1.5 h-1.5 rounded-full {{ $contract->approved_by_treasurer_at ? 'bg-green-1000' : 'bg-gray-300' }}"></span>
                                            <span class="text-gray-500">→</span>
                                            <span class="w-1.5 h-1.5 rounded-full {{ $contract->approved_by_mayor_at ? 'bg-green-1000' : 'bg-gray-300' }}"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-medium
                                            @if($contract->status === 'active') bg-green-100 text-green-700
                                            @elseif($contract->status === 'completed') bg-brand-blue/10 text-brand-blue
                                            @else bg-gray-100 text-gray-600 @endif">
                                            @if($contract->status === 'active') <span class="w-1.5 h-1.5 rounded-full bg-green-1000"></span>
                                            @elseif($contract->status === 'completed') <span class="w-1.5 h-1.5 rounded-full bg-blue-1000"></span> @endif
                                            {{ $contract->status }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('contracts.show', $contract) }}" class="text-brand-blue hover:text-brand-blue-dark mr-3">View</a>
                                        <a href="{{ route('contracts.edit', $contract) }}" class="text-brand-blue hover:text-brand-blue-dark mr-3">Edit</a>
                                        <button type="button" class="text-red-500 hover:text-red-700 delete-btn" data-url="{{ route('contracts.destroy', $contract) }}" data-label="Delete this contract?">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-row"><td colspan="9">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="text-gray-500 font-medium">No contracts yet</p>
                                        <p class="text-gray-500 text-sm mt-1">Create a contract when a client reserves a lot or plan.</p>
                                        <a href="{{ route('contracts.create') }}" class="inline-block mt-4 bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark text-sm">+ New Contract</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('search-contracts');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    var q = this.value.toLowerCase();
                    document.querySelectorAll('.contract-row').forEach(function(row) {
                        var name = row.querySelector('.client-name').textContent.toLowerCase();
                        row.style.display = name.includes(q) ? '' : 'none';
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
