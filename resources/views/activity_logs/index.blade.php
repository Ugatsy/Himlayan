<x-app-layout>
    <div>
        <div class="max-w-5xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Activity Log</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($logs as $log)
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 rounded-full mt-2
                                    @if($log->type === 'burial') bg-red-1000
                                    @elseif($log->type === 'payment') bg-green-1000
                                    @elseif($log->type === 'contract') bg-blue-1000
                                    @elseif($log->type === 'plot') bg-yellow-1000
                                    @else bg-gray-500 @endif
                                "></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">{{ $log->description }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $log->created_at->format('M d, Y g:i A') }}
                                        @if($log->user) by {{ $log->user->name }} @endif
                                    </p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">{{ $log->type }}</span>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">No activity recorded yet.</p>
                        @endforelse
                    </div>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
