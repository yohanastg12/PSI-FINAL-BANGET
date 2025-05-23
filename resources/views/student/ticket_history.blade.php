{{-- filepath: c:\Users\HP\Documents\PSI BARU\del-schedule\resources\views\student\ticket_history.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Ticket Saya</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createTicketModal">
        Buat Ticket Baru
    </button>

    <table class="table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Role</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td>
                        {{ $ticket->description }}
                        @if($ticket->status == 'rejected' && $ticket->reject_reason)
                            <div class="mt-2 text-danger">
                                <strong>Alasan Ditolak:</strong> {{ $ticket->reject_reason }}
                            </div>
                        @endif
                    </td>
                    <td>{{ $ticket->role }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->created_at->format('d M Y') }}</td>
                    <td>
                        @if($ticket->status == 'pending')
                            <button 
                                type="button" 
                                class="btn btn-warning btn-sm edit-ticket-btn"
                                data-toggle="modal"
                                data-target="#editTicketModal"
                                data-id="{{ $ticket->id }}"
                                data-description="{{ $ticket->description }}"
                            >
                                Edit
                            </button>
                            <form action="{{ route('student.ticket.destroy', $ticket->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus ticket?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada ticket.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Buat Ticket Baru -->
<div class="modal fade" id="createTicketModal" tabindex="-1" role="dialog" aria-labelledby="createTicketModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('student.ticket.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createTicketModalLabel">Buat Ticket Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="role">Role</label>
            <input type="text" name="role" id="role" class="form-control" value="{{ Auth::user()->roles->pluck('title')->first() ?? 'Unknown' }}" readonly>
          </div>
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" readonly>
          </div>
          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Kirim Ticket</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Ticket -->
<div class="modal fade" id="editTicketModal" tabindex="-1" role="dialog" aria-labelledby="editTicketModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="editTicketForm" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editTicketModalLabel">Edit Ticket</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_description">Deskripsi</label>
            <textarea name="description" id="edit_description" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Pastikan jQuery & Bootstrap JS sudah ada -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.edit-ticket-btn').on('click', function() {
        var ticketId = $(this).data('id');
        var description = $(this).data('description');
        $('#editTicketForm').attr('action', '{{ url("/ticket") }}/' + ticketId);
        $('#edit_description').val(description);
    });
});
</script>
@endsection