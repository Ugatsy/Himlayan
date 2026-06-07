<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Inquiries') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-gray-600">{{ $inquiries->count() }} inquiries</span>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Name</th><th>Contact</th><th>Lot Interest</th><th>Status</th><th>Date</th><th></th></tr></thead>
                        <tbody>
                            @forelse($inquiries as $inquiry)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3"><a href="{{ route('inquiries.show', $inquiry) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $inquiry->full_name }}</a></td>
                                    <td>{{ $inquiry->contact_number }}</td>
                                    <td>{{ $inquiry->lot_interest ?? '—' }}</td>
                                    <td>
                                        <span class="text-xs px-2 py-1 rounded-full
                                            @if($inquiry->status === 'new') bg-yellow-100 text-yellow-800
                                            @elseif($inquiry->status === 'contacted') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif
                                        ">{{ $inquiry->status }}</span>
                                    </td>
                                    <td>{{ $inquiry->created_at->format('M d, Y') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('inquiries.show', $inquiry) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                        <form method="POST" action="{{ route('inquiries.destroy', $inquiry) }}" class="inline" onsubmit="return confirm('Delete this inquiry?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-8 text-center text-gray-500">No inquiries yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
