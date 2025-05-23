@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Ticket Saya</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('student.ticket.create') }}" class="btn btn-primary mb-3">Buat Ticket Baru</a>
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
                            <a href="{{ route('student.ticket.edit', $ticket->id) }}" class="btn btn-warning btn-sm">Edit</a>
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
@endsection