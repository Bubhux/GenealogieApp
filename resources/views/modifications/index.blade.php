<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifications en attente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if($modifications->isEmpty())
                <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded">
                    Aucune modification en attente de validation.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($modifications as $modification)
                        <a href="{{ route('modifications.show', $modification) }}"
                           class="block p-4 bg-white shadow rounded hover:bg-gray-50 transition">
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

                            <span class="text-xs text-gray-500">
                                Statut: En attente ({{ $modification->approveVotesCount() }} ✔ / {{ $modification->rejectVotesCount() }} ✖)
                            </span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $modifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
