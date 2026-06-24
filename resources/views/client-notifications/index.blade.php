<x-app-layout>
    <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Client Notifications</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">{{ $notifications->total() }} notifications sent</span>
                    </div>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b text-left"><th class="py-2">Client</th><th>Type</th><th>Subject</th><th>Channel</th><th>Status</th><th>Sent At</th></tr></thead>
                        <tbody>
                            @forelse($notifications as $n)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 font-medium">{{ $n->client->full_name }}</td>
                                    <td><span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 capitalize">{{ str_replace('_', ' ', $n->type) }}</span></td>
                                    <td class="max-w-xs truncate">{{ $n->subject }}</td>
                                    <td><span class="text-xs px-2 py-0.5 rounded-full @if($n->channel === 'mail') bg-blue-100 text-blue-700 @else bg-gray-100 @endif">{{ $n->channel }}</span></td>
                                    <td><span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">{{ $n->status }}</span></td>
                                    <td class="text-gray-500">{{ $n->created_at->format('M d, Y g:i A') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-12 text-gray-500">No notifications sent yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $notifications->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
