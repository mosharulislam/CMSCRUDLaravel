@extends('layout')

@section('content')
<h1>Edit Record</h1>

<form action="{{ route('contacts.update', $contact->id) }}" method="POST">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $contact->name }}" required>
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="{{ $contact->phone }}" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $contact->email }}" required>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Update</button>
</form>
@endsection
