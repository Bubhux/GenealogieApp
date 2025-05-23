<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de la modification
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-gray-100 px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-800">Détails de la modification</h3>
                </div>

                <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Informations</h4>
                        <p><strong>Proposé par:</strong> {{ $modification->user->name }}</p>
                        <p><strong>Date:</strong> {{ $modification->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Raison:</strong> {{ $modification->reason ?? 'Non spécifiée' }}</p>

                        @if($modification->person)
                            <h4 class="text-md font-semibold text-gray-700 mt-6 mb-2">Modification de personne</h4>
                            <p><strong>Personne:</strong> {{ $modification->person->full_name }}</p>
                            <p><strong>Champ:</strong> {{ $modification->field }}</p>
                            <p><strong>Ancienne valeur:</strong> {{ $modification->old_value }}</p>
                            <p><strong>Nouvelle valeur:</strong> {{ $modification->new_value }}</p>
                        @else
                            <h4 class="text-md font-semibold text-gray-700 mt-6 mb-2">Nouvelle relation</h4>
                            @php $relation = json_decode($modification->new_value) @endphp
                            <p><strong>Parent:</strong> {{ Person::find($relation->parent_id)->full_name }}</p>
                            <p><strong>Enfant:</strong> {{ Person::find($relation->child_id)->full_name }}</p>
                        @endif
                    </div>

                    <div>
                        <h4 class="text-md font-semibold text-gray-700 mb-2">Statut</h4>
                        @if($modification->status === 'pending')
                            <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-700 p-4 mb-4 rounded">
                                En attente de validation
                            </div>
                        @else
                            <div class="p-4 rounded mb-4 {{ $modification->status === 'approved' ? 'bg-green-100 border-l-4 border-green-400 text-green-700' : 'bg-red-100 border-l-4 border-red-400 text-red-700' }}">
                                Proposition {{ $modification->status === 'approved' ? 'approuvée' : 'rejetée' }}
                            </div>
                        @endif

                        <div class="flex items-center gap-4 mb-4">
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">{{ $modification->approveVotesCount() }} Acceptations</span>
                            <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full">{{ $modification->rejectVotesCount() }} Rejets</span>
                        </div>

                        @if(!$userVote && $modification->status === 'pending')
                            <form method="POST" action="{{ route('votes.store', $modification) }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block font-medium text-sm text-gray-700 mb-1">Votre vote</label>
                                    <div class="flex items-center gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="vote" value="1" checked class="form-radio text-green-600">
                                            <span class="ml-2">Accepter</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="vote" value="0" class="form-radio text-red-600">
                                            <span class="ml-2">Rejeter</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="comment" class="block font-medium text-sm text-gray-700 mb-1">Commentaire (optionnel)</label>
                                    <textarea id="comment" name="comment" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>

                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                                    Soumettre le vote
                                </button>
                            </form>
                        @elseif($userVote)
                            <div class="bg-blue-100 text-blue-800 p-4 rounded mb-4">
                                Vous avez déjà voté :
                                <strong>{{ $userVote->vote ? 'Accepté' : 'Rejeté' }}</strong>
                                @if($userVote->comment)
                                    <div class="mt-2">Votre commentaire : {{ $userVote->comment }}</div>
                                @endif
                            </div>
                        @endif

                        <h4 class="text-md font-semibold text-gray-700 mt-6 mb-2">Historique des votes</h4>
                        <ul class="divide-y divide-gray-200">
                            @forelse($modification->votes as $vote)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <strong>{{ $vote->user->name }}</strong>
                                            <span class="{{ $vote->vote ? 'text-green-600' : 'text-red-600' }}">
                                                ({{ $vote->vote ? 'Accepté' : 'Rejeté' }})
                                            </span>
                                            @if($vote->comment)
                                                <div class="mt-1 text-sm text-gray-600">{{ $vote->comment }}</div>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $vote->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-3 text-gray-500">Aucun vote pour le moment</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
