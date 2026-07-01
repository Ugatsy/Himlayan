<x-app-layout>
    <div>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Create Pre-Need Plan</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('pre-need-plans.store') }}" class="space-y-4">
                    @csrf
                    <div><label class="block text-sm font-medium text-gray-700">Name</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div><label class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" class="w-full rounded-lg bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            <option value="burial" @selected(old('type') === 'burial')>Burial</option>
                            <option value="funeral" @selected(old('type') === 'funeral')>Funeral</option>
                            <option value="memorial" @selected(old('type') === 'memorial')>Memorial</option>
                        </select>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700">Price (₱)</label><input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="w-full rounded-lg bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div><label class="block text-sm font-medium text-gray-700">Description</label><textarea name="description" rows="4" class="w-full rounded-lg bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">{{ old('description') }}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700">Features (one per line)</label><textarea name="features" rows="4" class="w-full rounded-lg bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue" placeholder="24/7 security&#10;Landscaped garden&#10;Perpetual care">{{ old('features') }}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700">Image URL</label><input type="text" name="image" value="{{ old('image') }}" class="w-full rounded-lg bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div><label class="inline-flex items-center"><input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-100 text-brand-blue shadow-sm focus:ring-brand-blue"><span class="ml-2 text-sm text-gray-700">Active</span></label></div>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark">Create</button>
                        <a href="{{ route('pre-need-plans.index') }}" class="text-gray-500 px-6 py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
