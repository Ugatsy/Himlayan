<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pre-Need Plans') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-gray-600">{{ $plans->count() }} plans</span>
                    <a href="{{ route('pre-need-plans.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">+ New Plan</a>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Name</th><th>Type</th><th>Price</th><th>Status</th><th></th></tr></thead>
                        <tbody>
                            @forelse($plans as $plan)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3"><a href="{{ route('pre-need-plans.show', $plan) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $plan->name }}</a></td>
                                    <td><span class="text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-700 capitalize font-medium">{{ $plan->type }}</span></td>
                                    <td class="font-medium">₱{{ number_format($plan->price, 2) }}</td>
                                    <td>
                                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-medium
                                            @if($plan->is_active) bg-green-100 text-green-700
                                            @else bg-gray-100 text-gray-600 @endif">
                                            @if($plan->is_active) <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> @endif
                                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('pre-need-plans.edit', $plan) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-btn" data-url="{{ route('pre-need-plans.destroy', $plan) }}" data-label="Delete this plan?">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5">
                                    <div class="py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="text-gray-500 font-medium">No plans yet</p>
                                        <p class="text-gray-400 text-sm mt-1">Create pre-need plans to offer to your clients.</p>
                                        <a href="{{ route('pre-need-plans.create') }}" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 text-sm">+ New Plan</a>
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
