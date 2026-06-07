<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Activity Log') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($logs as $log)
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 rounded-full mt-2
                                    @if($log->type === 'burial') bg-red-500
                                    @elseif($log->type === 'payment') bg-green-500
                                    @elseif($log->type === 'contract') bg-blue-500
                                    @elseif($log->type === 'plot') bg-yellow-500
                                    @else bg-gray-500 @endif
                                "></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">{{ $log->description }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $log->created_at->format('M d, Y g:i A') }}
                                        @if($log->user) by {{ $log->user->name }} @endif
                                    </p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-700">{{ $log->type }}</span>
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
