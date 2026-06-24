<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Burial Permit</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('burial-permits.update', $burialPermit) }}">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contract</label>
                        <select name="contract_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($contracts as $contract)
                                <option value="{{ $contract->id }}" @selected($contract->id === $burialPermit->contract_id)>{{ $contract->client->full_name }} — {{ $contract->plot?->plot_number ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Deceased Name</label>
                        <input type="text" name="deceased_name" value="{{ old('deceased_name', $burialPermit->deceased_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $burialPermit->date_of_birth?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Death</label>
                            <input type="date" name="date_of_death" value="{{ old('date_of_death', $burialPermit->date_of_death->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Death Certificate Number</label>
                        <input type="text" name="death_certificate_number" value="{{ old('death_certificate_number', $burialPermit->death_certificate_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Burial Permit Fee (₱)</label>
                        <input type="number" step="0.01" name="burial_permit_fee" value="{{ old('burial_permit_fee', $burialPermit->burial_permit_fee) }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="issued" @selected($burialPermit->status === 'issued')>Issued</option>
                            <option value="used" @selected($burialPermit->status === 'used')>Used</option>
                            <option value="cancelled" @selected($burialPermit->status === 'cancelled')>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $burialPermit->notes) }}</textarea>
                    </div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('burial-permits.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update Permit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
