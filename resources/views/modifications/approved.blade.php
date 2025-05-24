<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifications acceptées
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Barre de navigation secondaire -->
            <div class="mb-6 bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="flex space-x-4 px-4 py-3">
                    <x-nav-link :href="route('modifications.index')" :active="request()->routeIs('modifications.index')">
                        En attente
                    </x-nav-link>
                    <x-nav-link :href="route('modifications.approved')" :active="request()->routeIs('modifications.approved')">
                        Acceptées
                    </x-nav-link>
                    <x-nav-link :href="route('modifications.rejected')" :active="request()->routeIs('modifications.rejected')">
                        Refusées
                    </x-nav-link>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($modifications->isEmpty())
                        <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded">
                            Aucune modification acceptée pour le moment.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($modifications as $modification)
                                <a href="{{ route('modifications.show', $modification) }}"
                                   class="block p-4 bg-gray-50 rounded hover:bg-gray-100 transition">
                                    <div class="flex justify-between items-center mb-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            @if($modification->person)
                                                Modification de {{ $modification->person->full_name }}
                                            @else
                                                Nouvelle relation familiale
                                            @endif
                                        </h3>
                                        <span class="text-sm text-gray-500">Proposé par {{ $modification->user->name }}</span>
                                    </div>

                                    <p class="text-sm text-gray-700 mb-1">
                                        @if($modification->field)
                                            <strong>{{ $modification->field }}:</strong>
                                            {{ $modification->old_value }} → {{ $modification->new_value }}
                                        @else
                                            Ajout d'une relation parent-enfant
                                        @endif
                                    </p>

                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-xs text-green-600 font-semibold">
                                            Acceptée le {{ $modification->updated_at->format('d/m/Y H:i') }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $modification->approveVotesCount() }} votes favorables
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $modifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>