<x-app-layout>
    <div>
    <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Inquiries</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-500">{{ $inquiries->count() }} inquiries</span>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider"><th class="py-2 font-medium">Name</th><th class="font-medium">Contact</th><th class="font-medium">Lot Interest</th><th class="font-medium">Status</th><th class="font-medium">Date</th><th class="font-medium"></th></tr></thead>
                        <tbody>
                            @forelse($inquiries as $inquiry)
                                <tr class="border-b hover:bg-blue-50/50">
                                    <td class="py-3"><a href="{{ route('inquiries.show', $inquiry) }}" class="text-brand-blue hover:text-brand-blue-dark font-medium">{{ $inquiry->full_name }}</a></td>
                                    <td>{{ $inquiry->contact_number }}</td>
                                    <td>{{ $inquiry->lot_interest ?? '—' }}</td>
                                    <td>
                                        <span class="text-xs px-2 py-1 rounded-full
                                            @if($inquiry->status === 'new') bg-amber-100 text-amber-700
                                            @elseif($inquiry->status === 'contacted') bg-brand-blue/10 text-brand-blue
                                            @else bg-gray-100 text-gray-600 @endif
                                        ">{{ $inquiry->status }}</span>
                                    </td>
                                    <td>{{ $inquiry->created_at->format('M d, Y') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('inquiries.show', $inquiry) }}" class="text-brand-blue hover:text-brand-blue-dark mr-3">View</a>
                                        <button type="button" class="text-red-500 hover:text-red-700 delete-btn" data-url="{{ route('inquiries.destroy', $inquiry) }}" data-label="Delete this inquiry?">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                        <p class="text-gray-500 font-medium">No inquiries yet</p>
                                        <p class="text-gray-500 text-sm mt-1">Inquiries from the website contact form will appear here.</p>
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
