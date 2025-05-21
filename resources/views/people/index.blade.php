@extends('layouts.app')

@section('content')
    <h1>People List</h1>
    <a href="{{ route('people.create') }}" class="btn btn-primary">Add New Person</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
                <tr>
                    <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                    <td>{{ $person->date_of_birth }}</td>
                    <td>{{ $person->creator->name }}</td>
                    <td>
                        <a href="{{ route('people.show', $person->id) }}" class="btn btn-info">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection