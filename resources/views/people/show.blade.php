<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Person Details: {{ $person->first_name }} {{ $person->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Person Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p><span class="font-semibold">First Name:</span> {{ $person->first_name }}</p>
                                <p><span class="font-semibold">Middle Names:</span> {{ $person->middle_names ?? 'None' }}</p>
                                <p><span class="font-semibold">Last Name:</span> {{ $person->last_name }}</p>
                            </div>
                            <div>
                                <p><span class="font-semibold">Birth Name:</span> {{ $person->birth_name }}</p>
                                <p><span class="font-semibold">Date of Birth:</span> {{ $person->date_of_birth ?? 'Unknown' }}</p>
                                <p><span class="font-semibold">Created By:</span> {{ $person->creator->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Parents Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Parents</h3>
                        @if($person->parents->count() > 0)
                            <ul class="list-disc pl-5">
                                @foreach($person->parents as $parent)
                                    <li>
                                        <a href="{{ route('people.show', $parent->id) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $parent->first_name }} {{ $parent->last_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No parents recorded.</p>
                        @endif
                    </div>

                    <!-- Children Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Children</h3>
                        @if($person->children->count() > 0)
                            <ul class="list-disc pl-5">
                                @foreach($person->children as $child)
                                    <li>
                                        <a href="{{ route('people.show', $child->id) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $child->first_name }} {{ $child->last_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No children recorded.</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('people.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>