<x-app-layout>
    <x-slot name="header" class="flex justify-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
            {{ __('Actualización Información de ciudadano') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap gap-6">
            <div class="flex-[3] min-w-[300px] p-2 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto ">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="flex-[1] min-w-[300px] p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
