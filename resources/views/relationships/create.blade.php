<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Créer une relation parent-enfant
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('relationships.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Parent Selection -->
                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700">
                                    Parent
                                    <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="parent_id"
                                    name="parent_id"
                                    required
                                    class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">Sélectionnez un parent</option>
                                    @foreach($people as $person)
                                        <option 
                                            value="{{ $person->id }}" 
                                            {{ old('parent_id', request('parent_id')) == $person->id ? 'selected' : '' }}
                                            class="py-1"
                                        >
                                            {{ $person->first_name }} {{ $person->last_name }}
                                            @if($person->date_of_birth)
                                                ({{ \Carbon\Carbon::parse($person->date_of_birth)->format('Y') }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Child Selection -->
                            <div>
                                <label for="child_id" class="block text-sm font-medium text-gray-700">
                                    Enfant
                                    <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="child_id"
                                    name="child_id"
                                    required
                                    class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">Sélectionnez un enfant</option>
                                    @foreach($people as $person)
                                        <option 
                                            value="{{ $person->id }}"
                                            {{ old('child_id', request('child_id')) == $person->id ? 'selected' : '' }}
                                            class="py-1"
                                        >
                                            {{ $person->first_name }} {{ $person->last_name }}
                                            @if($person->date_of_birth)
                                                ({{ \Carbon\Carbon::parse($person->date_of_birth)->format('Y') }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('child_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a 
                                href="{{ url()->previous() }}" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Annuler
                            </a>
                            <button 
                                type="submit" 
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Créer la relation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>