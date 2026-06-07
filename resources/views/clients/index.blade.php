<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Clients') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-gray-600">{{ $clients->count() }} clients</span>
                    <a href="{{ route('clients.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">+ Add Client</a>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Name</th><th>Contact</th><th>ID Type</th><th>Contracts</th><th></th></tr></thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3"><a href="{{ route('clients.show', $client) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $client->full_name }}</a></td>
                                    <td>{{ $client->contact_number }}</td>
                                    <td>{{ $client->id_type }}</td>
                                    <td>{{ $client->contracts_count ?? $client->contracts->count() }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form method="POST" action="{{ route('clients.destroy', $client) }}" class="inline" onsubmit="return confirm('Delete this client?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-8 text-center text-gray-500">No clients found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
