<x-app-layout>
    <div>
    <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Clients</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500">{{ $clients->count() }} clients</span>
                        <input type="text" id="search-clients" placeholder="Search by name or contact…" class="rounded-lg bg-white border-gray-200 text-gray-900 placeholder-gray-500 text-sm shadow-sm focus:border-brand-blue focus:ring-brand-blue w-64">
                    </div>
                    <a href="{{ route('clients.create') }}" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark text-sm">+ Add Client</a>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider"><th class="py-2 font-medium">Name</th><th class="font-medium">Contact</th><th class="font-medium">ID Type</th><th class="font-medium">Contracts</th><th class="font-medium"></th></tr></thead>
                        <tbody id="clients-table-body">
                            @forelse($clients as $client)
                                <tr class="border-b hover:bg-blue-50/50 client-row">
                                    <td class="py-3"><a href="{{ route('clients.show', $client) }}" class="text-brand-blue hover:text-brand-blue-dark font-medium">{{ $client->full_name }}</a></td>
                                    <td class="contact-cell">{{ $client->contact_number }}</td>
                                    <td>{{ $client->id_type }}</td>
                                    <td>{{ $client->contracts_count ?? $client->contracts->count() }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('clients.edit', $client) }}" class="text-brand-blue hover:text-brand-blue-dark mr-3">Edit</a>
                                        <button type="button" class="text-red-500 hover:text-red-700 delete-btn" data-url="{{ route('clients.destroy', $client) }}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-row"><td colspan="5">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <p class="text-gray-500 font-medium">No clients yet</p>
                                        <p class="text-gray-500 text-sm mt-1">Start by adding your first client.</p>
                                        <a href="{{ route('clients.create') }}" class="inline-block mt-4 bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark text-sm">+ Add Client</a>
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
            var searchInput = document.getElementById('search-clients');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    var q = this.value.toLowerCase();
                    document.querySelectorAll('.client-row').forEach(function(row) {
                        var name = row.querySelector('a').textContent.toLowerCase();
                        var contact = row.querySelector('.contact-cell').textContent.toLowerCase();
                        row.style.display = name.includes(q) || contact.includes(q) ? '' : 'none';
                    });
                });
            }
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (confirm('Delete this client? This action cannot be undone.')) {
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = this.dataset.url;
                        form.innerHTML = '@csrf @method("DELETE")';
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
