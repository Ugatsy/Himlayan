<x-app-layout>
    <div>
        <div class="max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $client->full_name }}</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Full Name</dt><dd class="font-medium">{{ $client->full_name }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Contact Number</dt><dd class="font-medium">{{ $client->contact_number }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Email</dt><dd class="font-medium">{{ $client->email ?? '—' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">ID</dt><dd class="font-medium">{{ $client->id_type }}: {{ $client->id_number }}</dd></div>
                    <div class="col-span-2"><dt class="text-sm text-gray-500">Address</dt><dd class="font-medium">{{ $client->address }}</dd></div>
                </dl>
                <div class="mt-4 flex gap-4">
                    <a href="{{ route('clients.edit', $client) }}" class="text-brand-blue hover:text-brand-blue-dark">Edit</a>
                    <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Delete this client?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                    </form>
                </div>
            </div>

            @if($client->contracts->count())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Contracts ({{ $client->contracts->count() }})</h3>
                    @foreach($client->contracts as $contract)
                        <div class="border rounded-lg p-4 mb-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('contracts.show', $contract) }}" class="font-medium text-brand-blue hover:text-brand-blue-dark">Contract #{{ $contract->id }}</a>
                                    <span class="ml-2 text-sm text-gray-500">{{ $contract->plot->plot_number }} — ₱{{ number_format($contract->total_amount, 2) }}</span>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full
                                    @if($contract->status === 'active') bg-green-100 text-green-700
                                    @elseif($contract->status === 'completed') bg-brand-blue/10 text-brand-blue
                                    @else bg-gray-100 text-gray-600 @endif
                                ">{{ $contract->status }}</span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1">{{ $contract->contract_date->format('M d, Y') }} — {{ $contract->payment_type }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
