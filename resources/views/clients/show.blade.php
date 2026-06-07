<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $client->full_name }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Full Name</dt><dd class="font-medium">{{ $client->full_name }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Contact Number</dt><dd class="font-medium">{{ $client->contact_number }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Email</dt><dd class="font-medium">{{ $client->email ?? '—' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">ID</dt><dd class="font-medium">{{ $client->id_type }}: {{ $client->id_number }}</dd></div>
                    <div class="col-span-2"><dt class="text-sm text-gray-500">Address</dt><dd class="font-medium">{{ $client->address }}</dd></div>
                </dl>
                <div class="mt-4 flex gap-4">
                    <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Delete this client?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </div>
            </div>

            @if($client->contracts->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Contracts ({{ $client->contracts->count() }})</h3>
                    @foreach($client->contracts as $contract)
                        <div class="border rounded-lg p-4 mb-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('contracts.show', $contract) }}" class="font-medium text-indigo-600 hover:text-indigo-900">Contract #{{ $contract->id }}</a>
                                    <span class="ml-2 text-sm text-gray-500">{{ $contract->plot->plot_number }} — ₱{{ number_format($contract->total_amount, 2) }}</span>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full
                                    @if($contract->status === 'active') bg-green-100 text-green-800
                                    @elseif($contract->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif
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
