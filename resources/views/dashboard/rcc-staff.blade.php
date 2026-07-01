<!-- Row 1: Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Plots</div>
                <div class="mt-1 text-3xl font-bold text-brand-blue">{{ $totalPlots }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
            </div>
        </div>
        <div class="mt-3 flex gap-3 text-xs">
            <span class="text-green-600 font-medium">{{ $availablePlots }} avail</span>
            <span class="text-gray-300">|</span>
            <span class="text-amber-600 font-medium">{{ $reservedPlots }} reserved</span>
            <span class="text-gray-300">|</span>
            <span class="text-red-600 font-medium">{{ $occupiedPlots }} occ</span>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Occupancy Rate</div>
                <div class="mt-1 text-3xl font-bold text-brand-blue">{{ $occupancyRate }}%</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
            <div class="bg-brand-blue h-2 rounded-full" style="width: {{ $occupancyRate }}%"></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Revenue</div>
                <div class="mt-1 text-3xl font-bold text-brand-blue">₱{{ number_format($totalRevenue, 2) }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('payments.index') }}" class="text-xs text-brand-blue hover:text-brand-blue-dark font-medium">View payments</a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Upcoming Burials</div>
                <div class="mt-1 text-3xl font-bold text-brand-blue">{{ $upcomingBurials }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('burials.create') }}" class="text-xs text-brand-blue hover:text-brand-blue-dark font-medium">Schedule</a>
        </div>
    </div>
</div>

<!-- Row 2: Secondary Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">New Inquiries</div>
                <div class="mt-1 text-3xl font-bold text-brand-blue">{{ $newInquiries }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('inquiries.index') }}" class="text-xs text-brand-blue hover:text-brand-blue-dark font-medium">View</a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Burial Permits Issued</div>
                <div class="mt-1 text-3xl font-bold text-brand-blue">{{ $issuedPermits }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('burial-permits.create') }}" class="text-xs text-brand-blue hover:text-brand-blue-dark font-medium">Issue New</a>
        </div>
    </div>
    <!-- Yellow accent card: Pending Signatures -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-t-4 border-t-brand-yellow">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pending Signatures</div>
                <div class="mt-1 text-3xl font-bold text-gray-900">{{ $pendingTreasurer + $pendingMayor }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-yellow/15 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
        </div>
        <div class="mt-3 flex gap-3 text-xs">
            <span class="text-gray-600">{{ $pendingTreasurer }} Treasurer</span>
            <span class="text-gray-300">|</span>
            <span class="text-gray-600">{{ $pendingMayor }} Mayor</span>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Unread Notifications</div>
                <div class="mt-1 text-3xl font-bold text-brand-blue">{{ $unreadNotifications }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('notifications.index') }}" class="text-xs text-brand-blue hover:text-brand-blue-dark font-medium">View</a>
        </div>
    </div>
</div>

<!-- Row 3: Recent Burials + Payments + Notifications -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Recent Burials</h3>
            <a href="{{ route('burials.index') }}" class="text-sm text-brand-blue hover:text-brand-blue-dark font-medium">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($recentBurials as $burial)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                    <div>
                        <div class="font-medium text-gray-900">{{ $burial->deceased_name }}</div>
                        <div class="text-sm text-gray-500">{{ $burial->plot?->plot_number }} &middot; {{ $burial->burial_date?->format('M d, Y') }}</div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full @if($burial->burial_status === 'completed') badge-success @elseif($burial->burial_status === 'scheduled') bg-brand-blue/10 text-brand-blue @else badge-default @endif">{{ $burial->burial_status }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">No burials recorded yet.</p>
            @endforelse
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Recent Payments</h3>
            <a href="{{ route('payments.index') }}" class="text-sm text-brand-blue hover:text-brand-blue-dark font-medium">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                    <div>
                        <div class="font-medium text-gray-900">{{ $payment->contract?->client?->full_name ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-500">₱{{ number_format($payment->amount_paid, 2) }} &middot; {{ $payment->paid_at?->format('M d, Y') }}</div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $payment->payment_type }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">No payments recorded yet.</p>
            @endforelse
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Notifications</h3>
            <a href="{{ route('notifications.index') }}" class="text-sm text-brand-blue hover:text-brand-blue-dark font-medium">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($notifications as $notification)
                <div class="py-2 border-b border-gray-100 last:border-0 @if(!$notification->is_read) bg-brand-blue/5 -mx-3 px-3 rounded @endif">
                    <div class="flex items-start gap-2">
                        <span class="shrink-0 mt-0.5">
                            @if($notification->type === 'burial_reminder')
                                <svg class="w-4 h-4 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            @elseif(in_array($notification->type, ['installment_due', 'overdue']))
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @else
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
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

<!-- Row 4: Installments Alerts -->
@if(($overdueInstallments->count() || $dueInstallments->count()))
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    @if($overdueInstallments->count())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5 border-l-4 border-red-400">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-red-700">Overdue Installments</h3>
        </div>
        <div class="space-y-3">
            @foreach($overdueInstallments as $installment)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                    <div>
                        <div class="font-medium text-gray-900">{{ $installment->contract?->client?->full_name }}</div>
                        <div class="text-sm text-gray-500">₱{{ number_format($installment->amount_due, 2) }} &middot; due {{ $installment->due_date?->format('M d, Y') }}</div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Overdue</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif
    @if($dueInstallments->count())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5 border-l-4 border-amber-400">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-amber-700">Upcoming Installment Due Dates</h3>
        </div>
        <div class="space-y-3">
            @foreach($dueInstallments as $installment)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                    <div>
                        <div class="font-medium text-gray-900">{{ $installment->contract?->client?->full_name }}</div>
                        <div class="text-sm text-gray-500">₱{{ number_format($installment->amount_due, 2) }} &middot; due {{ $installment->due_date?->format('M d, Y') }}</div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Upcoming</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endif