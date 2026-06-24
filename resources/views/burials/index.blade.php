<x-app-layout>
    <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Burials</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">{{ $burials->count() }} burials</span>
                        <input type="text" id="search-burials" placeholder="Search by deceased name or plot…" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-64">
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('deceased.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium px-3 py-2">Deceased Registry</a>
                        <a href="{{ route('burials.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">+ Schedule Burial</a>
                    </div>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Deceased Name</th><th>Plot</th><th>Client</th><th>Date</th><th>Status</th><th></th></tr></thead>
                        <tbody id="burials-table-body">
                            @forelse($burials as $burial)
                                <tr class="border-b hover:bg-gray-50 burial-row">
                                    <td class="py-3"><a href="{{ route('burials.show', $burial) }}" class="text-indigo-600 hover:text-indigo-900 font-medium deceased-name">{{ $burial->deceased_name }}</a></td>
                                    <td class="plot-cell">{{ $burial->plot->plot_number }}</td>
                                    <td>{{ $burial->contract->client->full_name ?? '—' }}</td>
                                    <td>{{ $burial->burial_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-medium
                                            @if($burial->burial_status === 'completed') bg-green-100 text-green-700
                                            @elseif($burial->burial_status === 'scheduled') bg-blue-100 text-blue-700
                                            @else bg-gray-200 text-gray-700 @endif">
                                            @if($burial->burial_status === 'completed') <span class="w-1.5 h-1.5 rounded-full bg-green-1000"></span>
                                            @elseif($burial->burial_status === 'scheduled') <span class="w-1.5 h-1.5 rounded-full bg-blue-1000"></span> @endif
                                            {{ $burial->burial_status }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        @if($burial->burial_status === 'scheduled')
                                            <form method="POST" action="{{ route('burials.approve', $burial) }}" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3 font-medium">Approve</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('burials.edit', $burial) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-btn" data-url="{{ route('burials.destroy', $burial) }}" data-label="Delete this burial record?">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-row"><td colspan="6">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/></svg>
                                        <p class="text-gray-500 font-medium">No burials recorded</p>
                                        <p class="text-gray-500 text-sm mt-1">Schedule a burial when a plot is ready for interment.</p>
                                        <a href="{{ route('burials.create') }}" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 text-sm">+ Schedule Burial</a>
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
            var searchInput = document.getElementById('search-burials');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    var q = this.value.toLowerCase();
                    document.querySelectorAll('.burial-row').forEach(function(row) {
                        var name = row.querySelector('.deceased-name').textContent.toLowerCase();
                        var plot = row.querySelector('.plot-cell').textContent.toLowerCase();
                        row.style.display = name.includes(q) || plot.includes(q) ? '' : 'none';
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
