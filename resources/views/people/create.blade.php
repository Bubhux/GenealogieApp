<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Person
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('people.store') }}">
                        @csrf

                        <!-- First Name -->
                        <div class="mb-4">
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <!-- Middle Names -->
                        <div class="mb-4">
                            <x-input-label for="middle_names" :value="__('Middle Names (comma separated)')" />
                            <x-text-input id="middle_names" class="block mt-1 w-full" type="text" name="middle_names" :value="old('middle_names')" />
                            <x-input-error :messages="$errors->get('middle_names')" class="mt-2" />
                        </div>

                        <!-- Last Name -->
                        <div class="mb-4">
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <!-- Birth Name -->
                        <div class="mb-4">
                            <x-input-label for="birth_name" :value="__('Birth Name (if different)')" />
                            <x-text-input id="birth_name" class="block mt-1 w-full" type="text" name="birth_name" :value="old('birth_name')" />
                            <x-input-error :messages="$errors->get('birth_name')" class="mt-2" />
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-4">
                            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                            <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('people.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Create Person') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>