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
                            <div class="d-flex flex-column gap-1">
                                <form action="{{ route('baa.tickets.approve', $ticket->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm w-100 mb-1">Approve</button>
                                </form>
                                <button 
                                    type="button"
                                    class="btn btn-danger btn-sm w-100 reject-btn"
                                    data-toggle="modal"
                                    data-target="#rejectModal"
                                    data-action="{{ route('baa.ticket.reject', $ticket->id) }}">
                                    Reject
                                </button>
                            </div>
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
                            <td colspan="{{ $colspan }}">No pending tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="rejectForm" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan Ticket</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <textarea name="reject_reason" id="reject_reason" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Tolak Ticket</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- jQuery & Bootstrap JS (pastikan sudah ada di layout, jika belum tambahkan di sini) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#rejectModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var action = button.data('action');
        $('#rejectForm').attr('action', action);
        $('#reject_reason').val('');
    });
});
</script>
@endsection