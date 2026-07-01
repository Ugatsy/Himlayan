<x-app-layout>
    <div>
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Profile</h1>
            <div class="space-y-6">
            <div class="p-4 sm:p-8 bg-white border border-gray-100 shadow sm:rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white border border-gray-100 shadow sm:rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white border border-gray-100 shadow sm:rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
