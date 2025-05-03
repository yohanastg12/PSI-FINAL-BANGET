<?php
namespace App\Http\Controllers\baa;

use App\Ticket;
use App\Http\Controllers\Controller;


class BAAController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('status', 'pending')->get();
        return view('baa.index', compact('tickets'));

    }

    public function tickets()
    {
        $tickets = Ticket::where('status', 'pending')->get();
        return view('baa.index', compact('tickets'));
    }

    public function approve($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'approved';
        $ticket->approved_by = auth()->id(); 
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket approved successfully.');
    }

    public function reject($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'rejected';
        $ticket->approved_by = auth()->id(); // optional jika ingin tahu siapa yang menolak
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket berhasil ditolak.');
    }

    
}
