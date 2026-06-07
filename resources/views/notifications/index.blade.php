<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Notifications') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-gray-600">{{ $notifications->total() }} notifications</span>
                    <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                        @csrf
                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Mark all as read</button>
                    </form>
                </div>
                <div class="p-6">
                    @forelse($notifications as $notification)
                        <div class="flex items-start gap-4 py-4 border-b border-gray-100 last:border-0 @if(!$notification->is_read) bg-indigo-50/50 -mx-6 px-6 @endif">
                            <div class="shrink-0 mt-1">
                                <span class="w-2.5 h-2.5 rounded-full block @if($notification->type === 'burial_reminder') bg-blue-500 @elseif($notification->type === 'installment_due') bg-yellow-500 @elseif($notification->type === 'overdue') bg-red-500 @else bg-gray-400 @endif @if(!$notification->is_read) ring-2 ring-offset-1 ring-indigo-400 @endif"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900">{{ $notification->title }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->body }}</p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if($notification->link)
                                        <a href="{{ $notification->link }}" class="text-xs text-indigo-600 hover:text-indigo-900">View details</a>
                                    @endif
                                </div>
                            </div>
                            @if(!$notification->is_read)
                                <form method="POST" action="{{ route('notifications.mark-read', $notification) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-gray-500 hover:text-gray-700 whitespace-nowrap">Mark read</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">No notifications yet.</p>
                    @endforelse
                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
