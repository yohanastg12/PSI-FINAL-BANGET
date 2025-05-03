<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TicketController extends Controller
{
    public function index()
    {
        $tickets = session('tickets', []); 
        return view('student.Preference.ticketing', compact('tickets'));
    }

    public function store(Request $request)
    {
        dd($request);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'role' => 'required|string|max:100'
        ]);
    
    
        // Simpan ke session
        $tickets = session('tickets', []);
        $tickets[] = $data;
        session(['tickets' => $tickets]);
    
        return redirect()->route('baa.dashboard')->with('success', 'Ticket berhasil disimpan.');

    }

    public function add(Request $request)
    {
        dd($request);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'role' => 'required|string|max:100'
        ]);
    
    
        // Simpan ke session
        $tickets = session('tickets', []);
        $tickets[] = $data;
        session(['tickets' => $tickets]);
    
        return redirect()->route('baa.dashboard')->with('success', 'Ticket berhasil disimpan.');

    }
    
    
    
}
