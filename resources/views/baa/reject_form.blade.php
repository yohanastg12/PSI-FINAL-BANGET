@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Alasan Penolakan Ticket</h3>
    <form action="{{ route('baa.ticket.reject', $ticket->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="reject_reason">Alasan Penolakan</label>
            <textarea name="reject_reason" id="reject_reason" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-danger mt-3">Tolak Ticket</button>
    </form>
</div>
@endsection
