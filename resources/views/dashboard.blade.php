<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Total Plots</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPlots }}</div>
                    <div class="mt-1 text-sm">
                        <span class="text-green-600">{{ $availablePlots }} available</span>
                        <span class="mx-1">·</span>
                        <span class="text-red-600">{{ $occupiedPlots }} occupied</span>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Occupancy Rate</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $occupancyRate }}%</div>
                    <div class="mt-1 text-sm text-gray-500">of cemetery is occupied</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Revenue</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="mt-1 text-sm text-gray-500">{{ $activeContracts }} active contracts</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Upcoming Burials</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $upcomingBurials }}</div>
                    <div class="mt-1 text-sm"><a href="{{ route('notifications.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ $unreadNotifications }} unread notifications →</a></div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">New Inquiries</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $newInquiries }}</div>
                    <div class="mt-1 text-sm">
                        <a href="{{ route('inquiries.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View all inquiries →</a>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Pre-Need Plans</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $activePlans }}</div>
                    <div class="mt-1 text-sm">
                        <a href="{{ route('pre-need-plans.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Manage plans →</a>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500">Available Niches</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $availableNiches }}</div>
                    <div class="mt-1 text-sm">
                        <a href="{{ route('columbary-niches.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View columbary →</a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-800">Recent Burials</h3>
                    </div>
                    <div class="p-6">
                        @forelse($recentBurials as $burial)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                <div>
                                    <span class="font-medium">{{ $burial->deceased_name }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $burial->plot->plot_number }}</span>
                                </div>
                                <span class="text-sm text-gray-500">{{ $burial->burial_date->format('M d, Y') }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No burials recorded yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-800">Recent Payments</h3>
                    </div>
                    <div class="p-6">
                        @forelse($recentPayments as $payment)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                <div>
                                    <span class="font-medium">{{ $payment->contract->client->full_name }}</span>
                                    <span class="text-sm text-gray-500 ml-2">₱{{ number_format($payment->amount_paid, 2) }}</span>
                                </div>
                                <span class="text-sm text-gray-500">{{ $payment->paid_at->format('M d, Y') }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No payments recorded yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
