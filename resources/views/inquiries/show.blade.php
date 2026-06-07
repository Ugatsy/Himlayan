<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $inquiry->full_name }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <dl class="grid grid-cols-2 gap-4 flex-1">
                        <div><dt class="text-sm text-gray-500">Full Name</dt><dd class="font-medium">{{ $inquiry->full_name }}</dd></div>
                        <div><dt class="text-sm text-gray-500">Contact Number</dt><dd class="font-medium">{{ $inquiry->contact_number }}</dd></div>
                        <div><dt class="text-sm text-gray-500">Email</dt><dd class="font-medium">{{ $inquiry->email ?? '—' }}</dd></div>
                        <div><dt class="text-sm text-gray-500">Lot Interest</dt><dd class="font-medium">{{ $inquiry->lot_interest ?? '—' }}</dd></div>
                        <div><dt class="text-sm text-gray-500">Status</dt>
                            <dd>
                                <span class="text-xs px-2 py-1 rounded-full
                                    @if($inquiry->status === 'new') bg-yellow-100 text-yellow-800
                                    @elseif($inquiry->status === 'contacted') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif
                                ">{{ $inquiry->status }}</span>
                            </dd>
                        </div>
                        <div><dt class="text-sm text-gray-500">Date</dt><dd class="font-medium">{{ $inquiry->created_at->format('M d, Y h:i A') }}</dd></div>
                    </dl>
                </div>
                @if($inquiry->address)
                    <div class="mb-4"><dt class="text-sm text-gray-500">Address</dt><dd class="font-medium">{{ $inquiry->address }}</dd></div>
                @endif
                @if($inquiry->message)
                    <div class="mb-4"><dt class="text-sm text-gray-500">Message</dt><dd class="font-medium text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $inquiry->message }}</dd></div>
                @endif
                <div class="mt-6 flex items-center gap-4 pt-4 border-t">
                    <form method="POST" action="{{ route('inquiries.update', $inquiry) }}" class="flex items-center gap-2">
                        @csrf @method('PATCH')
                        <select name="status" class="rounded-md border-gray-300 text-sm">
                            <option value="new" @selected($inquiry->status === 'new')>New</option>
                            <option value="contacted" @selected($inquiry->status === 'contacted')>Contacted</option>
                            <option value="closed" @selected($inquiry->status === 'closed')>Closed</option>
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1.5 rounded-md text-sm hover:bg-indigo-700">Update Status</button>
                    </form>
                    <form method="POST" action="{{ route('inquiries.destroy', $inquiry) }}" class="inline" onsubmit="return confirm('Delete this inquiry?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
