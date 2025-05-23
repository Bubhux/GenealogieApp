<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Proposer une modification pour — {{ $person->first_name }} {{ $person->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('modifications.store.person', $person) }}">
                        @csrf

                        <div class="mb-4">
                            <label for="field" class="block text-sm font-medium text-gray-700">Champ à modifier</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" id="field" name="field" required>
                                <option value="">Sélectionnez un champ</option>
                                <option value="first_name">Prénom</option>
                                <option value="last_name">Nom de famille</option>
                                <option value="birth_name">Nom de naissance</option>
                                <option value="middle_names">Deuxième prénom</option>
                                <option value="date_of_birth">Date de naissance</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="new_value" class="block text-sm font-medium text-gray-700">Nouvelle valeur</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" id="new_value" name="new_value" required>
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="block text-sm font-medium text-gray-700">Raison de la modification</label>
                            <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" id="reason" name="reason" rows="3"></textarea>
                            <p class="mt-1 text-sm text-gray-500">Expliquez pourquoi cette modification est nécessaire</p>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('people.show', $person) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Proposer la modification
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>