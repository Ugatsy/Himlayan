<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Pre-Need Plan</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('pre-need-plans.update', $plan) }}" class="space-y-4">
                    @csrf @method('PUT')
                    <div><label class="block text-sm font-medium text-gray-700">Name</label><input type="text" name="name" value="{{ old('name', $plan->name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div><label class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="burial" @selected(old('type', $plan->type) === 'burial')>Burial</option>
                            <option value="funeral" @selected(old('type', $plan->type) === 'funeral')>Funeral</option>
                            <option value="memorial" @selected(old('type', $plan->type) === 'memorial')>Memorial</option>
                        </select>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700">Price (₱)</label><input type="number" step="0.01" name="price" value="{{ old('price', $plan->price) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div><label class="block text-sm font-medium text-gray-700">Description</label><textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $plan->description) }}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700">Features (one per line)</label><textarea name="features" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : $plan->features) }}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700">Image URL</label><input type="text" name="image" value="{{ old('image', $plan->image) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div><label class="inline-flex items-center"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $plan->is_active)) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"><span class="ml-2 text-sm text-gray-700">Active</span></label></div>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Update</button>
                        <a href="{{ route('pre-need-plans.index') }}" class="text-gray-600 px-6 py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
