<x-app-layout>
    <div>
    <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Deceased Registry</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500">{{ $deceasedList->count() }} records</span>
                        <input type="text" id="search-deceased" placeholder="Search by name or plot…" class="rounded-lg bg-white border-gray-200 text-gray-900 placeholder-gray-500 text-sm shadow-sm focus:border-brand-blue focus:ring-brand-blue w-64">
                    </div>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider"><th class="py-2 font-medium">Deceased Name</th><th class="font-medium">Date of Birth</th><th class="font-medium">Date of Death</th><th class="font-medium">Plot</th><th class="font-medium">Client</th><th class="font-medium">Source</th></tr></thead>
                        <tbody id="deceased-table-body">
                            @forelse($deceasedList as $deceased)
                                <tr class="border-b hover:bg-blue-50/50 deceased-row">
                                    <td class="py-3 font-medium deceased-name">{{ $deceased['name'] }}</td>
                                    <td>{{ $deceased['date_of_birth']?->format('M d, Y') ?? '—' }}</td>
                                    <td>{{ $deceased['date_of_death']?->format('M d, Y') ?? '—' }}</td>
                                    <td>{{ $deceased['plot'] ?? '—' }} {{ $deceased['section'] ? '(' . $deceased['section'] . ')' : '' }}</td>
                                    <td>{{ $deceased['client'] ?? '—' }}</td>
                                    <td><span class="text-xs px-2 py-1 rounded-full @if($deceased['source'] === 'Burial Record') bg-green-100 text-green-700 @else bg-brand-blue/10 text-brand-blue @endif">{{ $deceased['source'] }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="6">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        <p class="text-gray-500 font-medium">No deceased records found</p>
                                        <p class="text-gray-500 text-sm mt-1">Records will appear once burials are completed or permits are issued.</p>
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
            var searchInput = document.getElementById('search-deceased');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    var q = this.value.toLowerCase();
                    document.querySelectorAll('.deceased-row').forEach(function(row) {
                        var name = row.querySelector('.deceased-name').textContent.toLowerCase();
                        row.style.display = name.includes(q) ? '' : 'none';
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
