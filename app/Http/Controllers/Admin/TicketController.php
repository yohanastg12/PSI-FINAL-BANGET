<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Ticket;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index()
    {
        return view('student.Preference.ticketing');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Ticket::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('student.ticketing.index')->with('success', 'Ticket created successfully!');
    }
}
