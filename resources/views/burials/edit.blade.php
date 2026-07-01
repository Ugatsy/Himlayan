<x-app-layout>
    <div>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Burial: {{ $burial->deceased_name }}</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('burials.update', $burial) }}">
                    @csrf @method('PUT')
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Deceased Name</label><input type="text" name="deceased_name" value="{{ old('deceased_name', $burial->deceased_name) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Plot</label>
                        <select name="plot_id" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            @foreach($plots as $plot)
                                <option value="{{ $plot->id }}" {{ $burial->plot_id === $plot->id ? 'selected' : '' }}>{{ $plot->plot_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contract</label>
                        <select name="contract_id" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            @foreach($contracts as $contract)
                                <option value="{{ $contract->id }}" {{ $burial->contract_id === $contract->id ? 'selected' : '' }}>{{ $contract->client->full_name }} — {{ $contract->plot->plot_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', $burial->date_of_birth?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                        <div><label class="block text-sm font-medium text-gray-700">Date of Death</label><input type="date" name="date_of_death" value="{{ old('date_of_death', $burial->date_of_death->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Burial Date & Time</label><input type="datetime-local" name="burial_date" value="{{ old('burial_date', $burial->burial_date->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Status</label><select name="burial_status" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                        @foreach(['scheduled','completed','cancelled'] as $bs)
                            <option value="{{ $bs }}" {{ $burial->burial_status === $bs ? 'selected' : '' }}>{{ ucfirst($bs) }}</option>
                        @endforeach
                    </select></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Notes</label><textarea name="notes" rows="2" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">{{ old('notes', $burial->notes) }}</textarea></div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('burials.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                        <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
