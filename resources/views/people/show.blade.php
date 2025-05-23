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
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium">Parents</h3>
                            <a href="{{ route('relationships.create') }}?child_id={{ $person->id }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-100 border border-transparent rounded-md text-xs text-blue-800 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                               + Add Parent
                            </a>
                        </div>
                        <div class="mt-2">
                            @if($person->parents->count() > 0)
                                <ul class="divide-y divide-gray-200">
                                    @foreach($person->parents as $parent)
                                        <li class="py-2">
                                            <a href="{{ route('people.show', $parent->id) }}" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                        {{ $parent->first_name }} {{ $parent->last_name }}
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-4">
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No parents</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by adding a parent relationship.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('relationships.create') }}?child_id={{ $person->id }}" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                           <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                               <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                           </svg>
                                           Add Parent
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Children Section -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium">Children</h3>
                            <a href="{{ route('relationships.create') }}?parent_id={{ $person->id }}" 
                               class="inline-flex items-center px-3 py-1 bg-green-100 border border-transparent rounded-md text-xs text-green-800 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                               + Add Child
                            </a>
                        </div>
                        <div class="mt-2">
                            @if($person->children->count() > 0)
                                <ul class="divide-y divide-gray-200">
                                    @foreach($person->children as $child)
                                        <li class="py-2">
                                            <a href="{{ route('people.show', $child->id) }}" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                                        {{ $child->first_name }} {{ $child->last_name }}
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-4">
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No children</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by adding a child relationship.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('relationships.create') }}?parent_id={{ $person->id }}" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                           <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                               <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                           </svg>
                                           Add Child
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('people.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>