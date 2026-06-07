<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Client') }}: {{ $client->full_name }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('clients.update', $client) }}">
                    @csrf @method('PUT')
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Full Name</label><input type="text" name="full_name" value="{{ old('full_name', $client->full_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Contact Number</label><input type="text" name="contact_number" value="{{ old('contact_number', $client->contact_number) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Email</label><input type="email" name="email" value="{{ old('email', $client->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700">Address</label><textarea name="address" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $client->address) }}</textarea></div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700">ID Number</label><input type="text" name="id_number" value="{{ old('id_number', $client->id_number) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                        <div><label class="block text-sm font-medium text-gray-700">ID Type</label><select name="id_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(['PhilSys','Passport','UMID',"Driver's License",'Others'] as $t)
                                <option value="{{ $t }}" {{ $client->id_type === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select></div>
                    </div>
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('clients.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
