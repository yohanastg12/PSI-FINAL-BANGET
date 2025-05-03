<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;




class TicketController extends Controller
{
    public function index()
    {
        $tickets = session('tickets', []); 
        return view('student.Preference.ticketing', compact('tickets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'role' => 'required|string|max:100'
        ]);

        Ticket::create($data);

        return redirect()->route('baa.dashboard')->with('success', 'Ticket berhasil disimpan.');
    }

    
    
    
}
