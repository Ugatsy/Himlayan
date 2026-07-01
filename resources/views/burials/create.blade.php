<x-app-layout>
    <div>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Schedule Burial</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('burials.store') }}">
                    @csrf
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Deceased Name</label><input type="text" name="deceased_name" value="{{ old('deceased_name') }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Plot</label>
                        <select name="plot_id" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="">Select plot…</option>
                            @foreach($plots as $plot)
                                <option value="{{ $plot->id }}">{{ $plot->plot_number }} ({{ $plot->section ?? 'No section' }} — {{ $plot->current_occupants }}/{{ $plot->capacity }} occupants)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contract</label>
                        <select name="contract_id" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="">Select contract…</option>
                            @foreach($contracts as $contract)
                                <option value="{{ $contract->id }}">{{ $contract->client->full_name }} — {{ $contract->plot->plot_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                        <div><label class="block text-sm font-medium text-gray-700">Date of Death</label><input type="date" name="date_of_death" value="{{ old('date_of_death') }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Burial Date & Time</label><input type="datetime-local" name="burial_date" value="{{ old('burial_date') }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="burial_status" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Notes</label><textarea name="notes" rows="2" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">{{ old('notes') }}</textarea></div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('burials.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                        <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark">Schedule Burial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
