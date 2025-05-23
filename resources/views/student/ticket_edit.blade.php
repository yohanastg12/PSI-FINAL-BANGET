@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Ticket</h2>
    <form action="{{ route('student.ticket.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $ticket->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('student.ticket.history') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection