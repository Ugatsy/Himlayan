<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Burial Permit #{{ $burialPermit->permit_number }}</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="border-2 border-dashed border-gray-300 p-8 rounded-lg">
                    <div class="text-center mb-6">
                        <h1 class="text-xl font-bold text-gray-900">BURIAL PERMIT</h1>
                        <p class="text-sm text-gray-500">AF 58</p>
                    </div>
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div class="col-span-2">
                            <dt class="text-gray-600">Permit Number</dt>
                            <dd class="font-mono font-bold text-lg">{{ $burialPermit->permit_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Deceased Name</dt>
                            <dd class="font-medium">{{ $burialPermit->deceased_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Date of Death</dt>
                            <dd class="font-medium">{{ $burialPermit->date_of_death->format('M d, Y') }}</dd>
                        </div>
                        @if($burialPermit->date_of_birth)
                        <div>
                            <dt class="text-gray-600">Date of Birth</dt>
                            <dd class="font-medium">{{ $burialPermit->date_of_birth->format('M d, Y') }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-gray-600">Death Certificate #</dt>
                            <dd class="font-medium">{{ $burialPermit->death_certificate_number ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Client</dt>
                            <dd class="font-medium">{{ $burialPermit->contract->client->full_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Plot</dt>
                            <dd class="font-medium">{{ $burialPermit->contract->plot?->plot_number ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Permit Fee</dt>
                            <dd class="font-medium">₱{{ number_format($burialPermit->burial_permit_fee, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Status</dt>
                            <dd>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full @if($burialPermit->status === 'issued') bg-blue-100 text-blue-800 @elseif($burialPermit->status === 'used') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">{{ $burialPermit->status }}</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Issued By</dt>
                            <dd class="font-medium">{{ $burialPermit->issuedBy->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-600">Issued At</dt>
                            <dd class="font-medium">{{ $burialPermit->issued_at?->format('M d, Y g:i A') ?? '—' }}</dd>
                        </div>
                    </dl>
                    @if($burialPermit->notes)
                        <div class="mt-4 p-3 bg-gray-50 rounded text-sm">
                            <span class="text-gray-500">Notes:</span>
                            <p class="mt-1">{{ $burialPermit->notes }}</p>
                        </div>
                    @endif
                </div>
                <div class="mt-4 flex gap-4">
                    <a href="{{ route('burial-permits.edit', $burialPermit) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <a href="{{ route('contracts.show', $burialPermit->contract) }}" class="text-indigo-600 hover:text-indigo-900">View Contract</a>
                    <button type="button" class="text-red-600 hover:text-red-900 delete-btn" data-url="{{ route('burial-permits.destroy', $burialPermit) }}" data-label="Delete this burial permit?">Delete</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
