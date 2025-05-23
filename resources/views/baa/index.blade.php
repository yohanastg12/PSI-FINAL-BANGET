<?php
    $colspan = auth()->user()->can('ticketing_approval') ? 6 : 5;
    $user = Auth::user();
    $roleId = Auth::user()->roles->first()->id ?? null;
?>

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
                        <th>Status</th>
                        <th>Submitted At</th>
                        @can("ticketing_approval")
                        <th>Action</th>
                        @endcan

                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $ticketList = (isset($ticketAdmin) && $roleId == 1) ? $ticketAdmin : (isset($tickets) ? $tickets : collect());
                    ?>
                    @forelse ($ticketList as $ticket)
                        <tr>
                            <td>{{ $ticket->name }}</td>
                            <td>{{ $ticket->description }}</td>
                            <td>{{ $ticket->role }}</td>
                            <td>{{  $ticket->status }}</td>
                            <td>{{ $ticket->created_at->format('d M Y') }}</td>
                    @can("ticketing_approval")
                    <td>
                        @if($ticket->status == 'pending')
                            <form action="{{ route('baa.tickets.approve', $ticket->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to approve this ticket?');">
                                @csrf
                                <button class="btn btn-xs btn-success">Approve</button>
                            </form>
                            <a href="{{ route('baa.ticket.reject.form', $ticket->id) }}" class="btn btn-danger">Reject</a>
                        @elseif($ticket->status == 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($ticket->status == 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    @endcan
                        </tr>
                    @empty
                        <tr>
                            <!-- <td colspan="4">No pending tickets found.</td> -->
                            <td colspan="{{ $colspan }}">No pending tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
