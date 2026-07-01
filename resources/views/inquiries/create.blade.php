<x-app-layout>
    <div>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">New Inquiry</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('inquiries.store') }}">
                    @csrf
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Full Name</label><input type="text" name="full_name" value="{{ old('full_name') }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Contact Number</label><input type="text" name="contact_number" value="{{ old('contact_number') }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Email</label><input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Address</label><textarea name="address" rows="2" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">{{ old('address') }}</textarea></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Lot Interest</label>
                        <select name="lot_interest" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="">Select lot type...</option>
                            <option value="Garden Lot" @selected(old('lot_interest') === 'Garden Lot')>Garden Lot</option>
                            <option value="Family Estate" @selected(old('lot_interest') === 'Family Estate')>Family Estate</option>
                            <option value="Lawn Lot" @selected(old('lot_interest') === 'Lawn Lot')>Lawn Lot</option>
                            <option value="Columbarium" @selected(old('lot_interest') === 'Columbarium')>Columbarium</option>
                        </select>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Message</label><textarea name="message" rows="4" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">{{ old('message') }}</textarea></div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('inquiries.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                        <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark">Save Inquiry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
