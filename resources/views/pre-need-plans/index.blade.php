<x-app-layout>
    <div>
    <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Pre-Need Plans</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-gray-500">{{ $plans->count() }} plans</span>
                    <a href="{{ route('pre-need-plans.create') }}" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark text-sm">+ New Plan</a>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider"><th class="py-2 font-medium">Name</th><th class="font-medium">Type</th><th class="font-medium">Price</th><th class="font-medium">Status</th><th class="font-medium"></th></tr></thead>
                        <tbody>
                            @forelse($plans as $plan)
                                <tr class="border-b hover:bg-blue-50/50">
                                    <td class="py-3"><a href="{{ route('pre-need-plans.show', $plan) }}" class="text-brand-blue hover:text-brand-blue-dark font-medium">{{ $plan->name }}</a></td>
                                    <td><span class="text-xs px-2 py-1 rounded-full bg-brand-blue/10 text-brand-blue capitalize font-medium">{{ $plan->type }}</span></td>
                                    <td class="font-medium">₱{{ number_format($plan->price, 2) }}</td>
                                    <td>
                                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-medium
                                            @if($plan->is_active) bg-green-100 text-green-700
                                            @else bg-gray-100 text-gray-600 @endif">
                                            @if($plan->is_active) <span class="w-1.5 h-1.5 rounded-full bg-green-1000"></span> @endif
                                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('pre-need-plans.edit', $plan) }}" class="text-brand-blue hover:text-brand-blue-dark mr-3">Edit</a>
                                        <button type="button" class="text-red-500 hover:text-red-700 delete-btn" data-url="{{ route('pre-need-plans.destroy', $plan) }}" data-label="Delete this plan?">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="text-gray-500 font-medium">No plans yet</p>
                                        <p class="text-gray-500 text-sm mt-1">Create pre-need plans to offer to your clients.</p>
                                        <a href="{{ route('pre-need-plans.create') }}" class="inline-block mt-4 bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark text-sm">+ New Plan</a>
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
