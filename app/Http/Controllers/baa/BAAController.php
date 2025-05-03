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

    
}
