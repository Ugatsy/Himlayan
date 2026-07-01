<x-app-layout>
    <div>
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $plan->name }}</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <span class="text-xs px-2 py-1 rounded-full @if($plan->type === 'burial') bg-brand-blue/10 text-brand-blue @elseif($plan->type === 'funeral') bg-brand-blue/10 text-brand-blue @else bg-green-100 text-green-700 @endif">{{ ucfirst($plan->type) }}</span>
                        <span class="ml-2 text-xs px-2 py-1 rounded-full @if($plan->is_active) bg-green-100 text-green-700 @else bg-gray-100 text-gray-600 @endif">{{ $plan->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">₱{{ number_format($plan->price, 2) }}</div>
                </div>
                <p class="text-gray-500 mb-6">{{ $plan->description }}</p>
                @if($plan->features)
                    <h3 class="font-semibold text-gray-900 mb-3">Features</h3>
                    <ul class="list-disc list-inside space-y-1 text-gray-500 mb-6">
                        @foreach($plan->features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="flex gap-4 pt-4 border-t">
                    <a href="{{ route('pre-need-plans.edit', $plan) }}" class="text-brand-blue hover:text-brand-blue-dark">Edit</a>
                    <form method="POST" action="{{ route('pre-need-plans.destroy', $plan) }}" onsubmit="return confirm('Delete this plan?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                    </form>
                </div>
            </div>

            @if($plan->contracts->count())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Contracts ({{ $plan->contracts->count() }})</h3>
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Client</th><th>Date</th><th>Amount</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($plan->contracts as $c)
                                <tr class="border-b">
                                    <td class="py-2"><a href="{{ route('contracts.show', $c) }}" class="text-brand-blue hover:text-brand-blue-dark">{{ $c->client->full_name }}</a></td>
                                    <td>{{ $c->contract_date->format('M d, Y') }}</td>
                                    <td>₱{{ number_format($c->total_amount, 2) }}</td>
                                    <td><span class="text-xs px-2 py-1 rounded-full @if($c->status === 'active') bg-green-100 text-green-700 @elseif($c->status === 'completed') bg-brand-blue/10 text-brand-blue @else bg-gray-100 text-gray-600 @endif">{{ $c->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
