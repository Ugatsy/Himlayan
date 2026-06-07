<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('New Inquiry') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('inquiries.store') }}">
                    @csrf
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Full Name</label><input type="text" name="full_name" value="{{ old('full_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Contact Number</label><input type="text" name="contact_number" value="{{ old('contact_number') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Email</label><input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Address</label><textarea name="address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Lot Interest</label>
                        <select name="lot_interest" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select lot type...</option>
                            <option value="Garden Lot" @selected(old('lot_interest') === 'Garden Lot')>Garden Lot</option>
                            <option value="Family Estate" @selected(old('lot_interest') === 'Family Estate')>Family Estate</option>
                            <option value="Lawn Lot" @selected(old('lot_interest') === 'Lawn Lot')>Lawn Lot</option>
                            <option value="Columbarium" @selected(old('lot_interest') === 'Columbarium')>Columbarium</option>
                        </select>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Message</label><textarea name="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('message') }}</textarea></div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('inquiries.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Save Inquiry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
