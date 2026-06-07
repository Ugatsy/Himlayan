<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Burial') }}: {{ $burial->deceased_name }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('burials.update', $burial) }}">
                    @csrf @method('PUT')
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Deceased Name</label><input type="text" name="deceased_name" value="{{ old('deceased_name', $burial->deceased_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Plot</label>
                        <select name="plot_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($plots as $plot)
                                <option value="{{ $plot->id }}" {{ $burial->plot_id === $plot->id ? 'selected' : '' }}>{{ $plot->plot_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contract</label>
                        <select name="contract_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($contracts as $contract)
                                <option value="{{ $contract->id }}" {{ $burial->contract_id === $contract->id ? 'selected' : '' }}>{{ $contract->client->full_name }} — {{ $contract->plot->plot_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', $burial->date_of_birth?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                        <div><label class="block text-sm font-medium text-gray-700">Date of Death</label><input type="date" name="date_of_death" value="{{ old('date_of_death', $burial->date_of_death->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Burial Date & Time</label><input type="datetime-local" name="burial_date" value="{{ old('burial_date', $burial->burial_date->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Status</label><select name="burial_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach(['scheduled','completed','cancelled'] as $bs)
                            <option value="{{ $bs }}" {{ $burial->burial_status === $bs ? 'selected' : '' }}>{{ ucfirst($bs) }}</option>
                        @endforeach
                    </select></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Notes</label><textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $burial->notes) }}</textarea></div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('burials.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
