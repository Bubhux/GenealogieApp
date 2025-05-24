<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Proposer une nouvelle relation familiale
            @isset($person)
                pour — {{ $person->first_name }} {{ $person->last_name }}
            @endisset
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('modifications.store.relationship') }}">
                    @csrf

                    @isset($person)
                        <input type="hidden" name="suggested_person_id" value="{{ $person->id }}">
                    @endisset

                    <div class="mb-4">
                        <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent (optionnel)</label>
                        <select id="parent_id" name="parent_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionnez un parent (optionnel)</option>
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
                    </div>

                    <div class="mb-4">
                        <label for="child_id" class="block text-sm font-medium text-gray-700">Enfant (optionnel)</label>
                        <select id="child_id" name="child_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionnez un enfant (optionnel)</option>
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
                    </div>

                    <div class="mb-4">
                        <label for="relation_type" class="block text-sm font-medium text-gray-700">Type de relation</label>
                        <select id="relation_type" name="relation_type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionnez un type</option>
                            <option value="parent_only">Uniquement définir un parent</option>
                            <option value="child_only">Uniquement définir un enfant</option>
                            <option value="both">Définir une relation parent-enfant</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Raison de la relation</label>
                        <textarea id="reason" name="reason" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        <p class="mt-1 text-sm text-gray-500">Expliquez pourquoi cette relation est correcte</p>
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ route('people.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-800 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Annuler
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Proposer la relation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>