<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Burials') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-gray-600">{{ $burials->count() }} burials</span>
                    <a href="{{ route('burials.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">+ Schedule Burial</a>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Deceased Name</th><th>Plot</th><th>Client</th><th>Date</th><th>Status</th><th></th></tr></thead>
                        <tbody>
                            @forelse($burials as $burial)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3"><a href="{{ route('burials.show', $burial) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $burial->deceased_name }}</a></td>
                                    <td>{{ $burial->plot->plot_number }}</td>
                                    <td>{{ $burial->contract->client->full_name ?? '—' }}</td>
                                    <td>{{ $burial->burial_date->format('M d, Y') }}</td>
                                    <td><span class="text-xs px-2 py-1 rounded-full @if($burial->burial_status === 'completed') bg-green-100 text-green-800 @elseif($burial->burial_status === 'scheduled') bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif">{{ $burial->burial_status }}</span></td>
                                    <td class="text-right">
                                        @if($burial->burial_status === 'scheduled')
                                            <form method="POST" action="{{ route('burials.approve', $burial) }}" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('burials.edit', $burial) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form method="POST" action="{{ route('burials.destroy', $burial) }}" class="inline" onsubmit="return confirm('Delete this burial?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-8 text-center text-gray-500">No burials recorded.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
