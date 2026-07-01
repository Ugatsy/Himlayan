<x-app-layout>
    <div>
    <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Burial Permits (AF 58)</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500">{{ $permits->count() }} permits</span>
                        <input type="text" id="search-permits" placeholder="Search by deceased name or permit #…" class="rounded-lg bg-white border-gray-200 text-gray-900 placeholder-gray-500 text-sm shadow-sm focus:border-brand-blue focus:ring-brand-blue w-64">
                    </div>
                    <a href="{{ route('burial-permits.create') }}" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark text-sm">+ Issue Burial Permit</a>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider"><th class="py-2 font-medium">Permit #</th><th class="font-medium">Deceased</th><th class="font-medium">Client</th><th class="font-medium">Date Issued</th><th class="font-medium">Fee</th><th class="font-medium">Status</th><th class="font-medium"></th></tr></thead>
                        <tbody id="permits-table-body">
                            @forelse($permits as $permit)
                                <tr class="border-b hover:bg-blue-50/50 permit-row">
                                    <td class="py-3 font-mono text-xs"><a href="{{ route('burial-permits.show', $permit) }}" class="text-brand-blue hover:text-brand-blue-dark font-medium permit-number">{{ $permit->permit_number }}</a></td>
                                    <td class="deceased-name">{{ $permit->deceased_name }}</td>
                                    <td>{{ $permit->contract->client->full_name ?? '—' }}</td>
                                    <td>{{ $permit->issued_at?->format('M d, Y') ?? '—' }}</td>
                                    <td>₱{{ number_format($permit->burial_permit_fee, 2) }}</td>
                                    <td>
                                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-medium
                                            @if($permit->status === 'issued') bg-brand-blue/10 text-brand-blue
                                            @elseif($permit->status === 'used') bg-green-100 text-green-700
                                            @else bg-gray-100 text-gray-600 @endif">
                                            {{ $permit->status }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('burial-permits.show', $permit) }}" class="text-brand-blue hover:text-brand-blue-dark mr-3">View</a>
                                        <a href="{{ route('burial-permits.edit', $permit) }}" class="text-brand-blue hover:text-brand-blue-dark mr-3">Edit</a>
                                        <button type="button" class="text-red-500 hover:text-red-700 delete-btn" data-url="{{ route('burial-permits.destroy', $permit) }}" data-label="Delete this burial permit?">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="text-gray-500 font-medium">No burial permits issued</p>
                                        <p class="text-gray-500 text-sm mt-1">Issue an AF 58 Burial Permit before interment.</p>
                                        <a href="{{ route('burial-permits.create') }}" class="inline-block mt-4 bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark text-sm">+ Issue Burial Permit</a>
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
            var searchInput = document.getElementById('search-permits');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    var q = this.value.toLowerCase();
                    document.querySelectorAll('.permit-row').forEach(function(row) {
                        var name = row.querySelector('.deceased-name').textContent.toLowerCase();
                        var num = row.querySelector('.permit-number').textContent.toLowerCase();
                        row.style.display = name.includes(q) || num.includes(q) ? '' : 'none';
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
