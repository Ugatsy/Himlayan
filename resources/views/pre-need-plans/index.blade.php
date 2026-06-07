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
                                    <td>{{ ucfirst($plan->type) }}</td>
                                    <td>₱{{ number_format($plan->price, 2) }}</td>
                                    <td><span class="text-xs px-2 py-1 rounded-full @if($plan->is_active) bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">{{ $plan->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="text-right">
                                        <a href="{{ route('pre-need-plans.edit', $plan) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form method="POST" action="{{ route('pre-need-plans.destroy', $plan) }}" class="inline" onsubmit="return confirm('Delete this plan?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-8 text-center text-gray-500">No plans found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
