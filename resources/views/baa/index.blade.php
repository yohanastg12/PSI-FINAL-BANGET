@extends('layouts.baa')

@section('content')
<div class="card">

    <div class="card-header">
        Pending Tickets -  {{ auth()->user()->name }}
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Role</th>
                        <th>Submitted At</th>
                        @can("ticketing_approval")
                        <th>Action</th>
                        @endcan

                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->name }}</td>
                            <td>{{ $ticket->description }}</td>
                            <td>{{ $ticket->role }}</td>
                            <td>{{ $ticket->created_at->format('d M Y') }}</td>
                            @can("ticketing_approval")
                            <td>
                                <form action="{{ route('baa.tickets.approve', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this ticket?');">
                                    @csrf
                                    <button class="btn btn-xs btn-success">Approve</button>
                                </form>
                                <form action="{{ route('baa.tickets.reject', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this ticket?');">
                                    @csrf
                                    <button class="btn btn-xs btn-danger">Reject</button>
                                </form>
                            </td>   
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No pending tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
