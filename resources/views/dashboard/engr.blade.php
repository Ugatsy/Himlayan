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
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Map Capacity</div>
                <div class="mt-1 text-3xl font-bold text-brand-blue">{{ $totalPlots }}</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-brand-blue/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('cemetery.admin') }}" class="text-xs text-brand-blue hover:text-brand-blue-dark font-medium">Cemetery Map</a>
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

<!-- Row 2: Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="text-sm font-medium text-gray-500">Active Contracts</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">{{ $activeContracts }}</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="text-sm font-medium text-gray-500">Burial Permits Issued</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">{{ $issuedPermits }}</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="text-sm font-medium text-gray-500">New Inquiries</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">{{ $newInquiries }}</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-4 p-5">
        <div class="text-sm font-medium text-gray-500">Unread Notifications</div>
        <div class="mt-2 text-3xl font-bold text-gray-900">{{ $unreadNotifications }}</div>
        <div class="mt-2">
            <a href="{{ route('notifications.index') }}" class="text-sm text-brand-blue hover:text-brand-blue-dark font-medium">View</a>
        </div>
    </div>
</div>

<!-- Row 3: Recent Burials + Payments -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
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
</div>