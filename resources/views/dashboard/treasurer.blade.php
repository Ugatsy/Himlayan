<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-sm font-medium text-gray-500">Total Revenue</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">₱{{ number_format($totalRevenue, 2) }}</div>
        <div class="mt-1 text-sm text-gray-500">All payments collected</div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-sm font-medium text-gray-500">Contracts Pending Your Approval</div>
        <div class="mt-2 text-3xl font-bold text-amber-600">{{ $pendingTreasurer }}</div>
        <div class="mt-1 text-sm">
            <a href="{{ route('contracts.index') }}?status=pending_treasurer" class="text-indigo-600 hover:text-indigo-900">Review contracts</a>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="text-sm font-medium text-gray-500">Active Contracts</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">{{ $activeContracts }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Recent Payments</h3>
            <a href="{{ route('payments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                    <div>
                        <div class="font-medium text-gray-900">{{ $payment->contract?->client?->full_name ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-500">₱{{ number_format($payment->amount_paid, 2) }} · {{ $payment->paid_at?->format('M d, Y') }}</div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $payment->payment_type }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">No payments recorded yet.</p>
            @endforelse
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Contracts Awaiting Treasurer</h3>
            <a href="{{ route('contracts.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all</a>
        </div>
        @php
            $pendingContracts = \App\Models\Contract::whereNotNull('prepared_by')
                ->whereNull('approved_by_treasurer_at')
                ->with('client')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        @endphp
        <div class="space-y-3">
            @forelse($pendingContracts as $contract)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                    <div>
                        <div class="font-medium text-gray-900">{{ $contract->client?->full_name }}</div>
                        <div class="text-sm text-gray-500">{{ $contract->plot?->plot_number }} · {{ $contract->contract_date?->format('M d, Y') }}</div>
                    </div>
                    <a href="{{ route('contracts.show', $contract) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Review</a>
                </div>
            @empty
                <p class="text-sm text-gray-500">No contracts pending your approval.</p>
            @endforelse
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Notifications</h3>
            <a href="{{ route('notifications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($notifications as $notification)
                <div class="py-2 border-b border-gray-100 last:border-0 @if(!$notification->is_read) bg-blue-50 -mx-3 px-3 rounded @endif">
                    <div class="flex items-start gap-2">
                        <span class="shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate">{{ $notification->title }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ $notification->body }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $notification->created_at?->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No notifications.</p>
            @endforelse
        </div>
    </div>
</div>
