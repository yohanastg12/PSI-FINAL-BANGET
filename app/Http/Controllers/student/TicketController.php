<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Tampilkan form create ticket
    public function create()
    {
        $user = Auth::user();
        $roleName = $user->roles->pluck('title')->first() ?? 'Unknown';
        return view('student.ticketing', compact('user', 'roleName'));
    }

    // Simpan ticket baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|max:1000',
            'role' => 'required|string|max:100'
        ]);

        $data['name'] = Auth::user()->name;
        $data['status'] = 'pending';

        Ticket::create($data);

        return redirect()->route('student.ticket.history')->with('success', 'Ticket berhasil dibuat.');
    }

    // Riwayat ticket milik mahasiswa
    public function history()
    {
        $tickets = Ticket::where('name', Auth::user()->name)->orderBy('created_at', 'desc')->get();
        return view('student.ticket_history', compact('tickets'));
    }

    // Edit ticket (hanya jika pending)
    public function edit($id)
    {
        $ticket = Ticket::where('id', $id)
            ->where('name', Auth::user()->name)
            ->where('status', 'pending')
            ->firstOrFail();
        return view('student.ticket_edit', compact('ticket'));
    }

    // Update ticket
    public function update(Request $request, $id)
    {
        $ticket = Ticket::where('id', $id)
            ->where('name', Auth::user()->name)
            ->where('status', 'pending')
            ->firstOrFail();

        $data = $request->validate([
            'description' => 'required|string|max:1000',
        ]);
        $ticket->update($data);

        return redirect()->route('student.ticket.history')->with('success', 'Ticket berhasil diupdate.');
    }

    // Hapus ticket
    public function destroy($id)
    {
        $ticket = Ticket::where('id', $id)
            ->where('name', Auth::user()->name)
            ->where('status', 'pending')
            ->firstOrFail();
        $ticket->delete();

        return redirect()->route('student.ticket.history')->with('success', 'Ticket berhasil dihapus.');
    }
}