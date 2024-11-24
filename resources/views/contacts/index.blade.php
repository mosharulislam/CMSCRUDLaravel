@extends('layout')

@section('content')
<h1>CRUD Operations</h1>

<h2>Add a New Record</h2>
<form action="{{ route('contacts.manualInsert') }}" method="POST">
    @csrf
    <input type="text" name="name" class="form-control mb-2" placeholder="Enter name" required>
    <input type="text" name="phone" class="form-control mb-2" placeholder="Enter phone number" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Enter email address" required>
    <button type="submit" class="btn btn-primary">Add Record</button>
</form>
<!-- Random Insert Form -->
<h2>Insert Random Data</h2>
<form action="{{ route('contacts.randomInsert') }}" method="POST">
    @csrf
    <div>
        <label for="num_records">How many records to insert?</label>
        <input type="number" id="num_records" name="num_records" required min="1" placeholder="Enter number of records">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Insert</button>
</form>
<h2>Edit Specific Number of Records</h2>
<form action="{{ route('contacts.editMultiple') }}" method="POST">
    @csrf
    <div>
        <label for="num_records">How many records to edit?</label>
        <input type="number" id="num_records" name="num_records" required min="1" placeholder="Enter number of records">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Edit Records</button>
</form>
<h2>Delete Specific Number of Records</h2>
<form action="{{ route('contacts.deleteMultiple') }}" method="POST">
    @csrf
    <div>
        <label for="num_records">How many records to delete?</label>
        <input type="number" id="num_records" name="num_records" required min="1" placeholder="Enter number of records">
    </div>
    <button type="submit" class="btn btn-danger mt-2">Delete Records</button>
</form>
<h2>All Records</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($contacts->isEmpty())
            <tr>
                <td colspan="6" class="text-center">No records found.</td>
            </tr>
        @else
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->created_at }}</td>
                    <td>
                        <a href="{{ route('contacts.editForm', $contact->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('contacts.delete', $contact->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


<h2>Speed Test Logs</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Operation</th>
            <th>Number of Records</th>
            <th>Execution Time (seconds)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->operation }}</td>
                <td>{{ $log->num_records }}</td>
                <td>{{ $log->execution_time }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
