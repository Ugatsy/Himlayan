<x-app-layout>
    <div>
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Client: {{ $client->full_name }}</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('clients.update', $client) }}">
                    @csrf @method('PUT')
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Full Name</label><input type="text" name="full_name" value="{{ old('full_name', $client->full_name) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Contact Number</label><input type="text" name="contact_number" value="{{ old('contact_number', $client->contact_number) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Email</label><input type="email" name="email" value="{{ old('email', $client->email) }}" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Address</label><textarea name="address" rows="3" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">{{ old('address', $client->address) }}</textarea></div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700">ID Number</label><input type="text" name="id_number" value="{{ old('id_number', $client->id_number) }}" required class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue"></div>
                        <div><label class="block text-sm font-medium text-gray-700">ID Type</label><select name="id_type" class="mt-1 block w-full rounded-md bg-white border-gray-100 text-gray-900 shadow-sm focus:border-brand-blue focus:ring-brand-blue">
                            @foreach(['PhilSys','Passport','UMID',"Driver's License",'Others'] as $t)
                                <option value="{{ $t }}" {{ $client->id_type === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select></div>
                    </div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('clients.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                        <button type="submit" class="bg-brand-blue text-white px-4 py-2 rounded-xl hover:bg-brand-blue-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
