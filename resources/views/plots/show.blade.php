<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Plot') }}: {{ $plot->plot_number }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-2 gap-4 mb-6">
                    <div><dt class="text-sm text-gray-500">Plot Number</dt><dd class="font-medium">{{ $plot->plot_number }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Section</dt><dd class="font-medium">{{ $plot->section ?? '—' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Coordinates</dt><dd class="font-medium">{{ $plot->lat }}, {{ $plot->lng }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2 py-1 text-xs font-semibold rounded-full
                        @if($plot->status === 'available') bg-green-100 text-green-800
                        @elseif($plot->status === 'reserved') bg-yellow-100 text-yellow-800
                        @elseif($plot->status === 'full') bg-red-200 text-red-900
                        @else bg-red-100 text-red-800 @endif
                    ">{{ $plot->status }}</span></dd></div>
                    <div><dt class="text-sm text-gray-500">Capacity</dt><dd class="font-medium">{{ $plot->capacity }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Current Occupants</dt><dd class="font-medium">{{ $plot->current_occupants }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Price</dt><dd class="font-medium">₱{{ number_format($plot->price, 2) }}</dd></div>
                </dl>

                @if($plot->burials->count())
                    <hr class="my-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Burials in this plot</h3>
                    <table class="w-full text-sm">
                        <thead><tr class="border-b"><th class="text-left py-2">Name</th><th class="text-left">Date</th><th class="text-left">Status</th></tr></thead>
                        <tbody>
                            @foreach($plot->burials as $burial)
                                <tr class="border-b">
                                    <td class="py-2">{{ $burial->deceased_name }}</td>
                                    <td>{{ $burial->burial_date->format('M d, Y') }}</td>
                                    <td><span class="text-xs px-2 py-1 rounded-full
                                        @if($burial->burial_status === 'completed') bg-green-100 text-green-800
                                        @elseif($burial->burial_status === 'scheduled') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif
                                    ">{{ $burial->burial_status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('plots.edit', $plot) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <form method="POST" action="{{ route('plots.destroy', $plot) }}" onsubmit="return confirm('Delete this plot?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
