<?php

use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Data ditampilkan di halaman home
    public function index()
    {
        $tickets = session('tickets', []); // Ambil dari session sementara
        return view('student.Preference.ticketing', compact('tickets'));
    }

    // Simpan data dari form
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'description' => 'required|string',
        ]);

        // Simpan ke session sementara (karena kamu belum pakai database)
        $tickets = session('tickets', []);
        $tickets[] = $data;
        session(['tickets' => $tickets]);

        return redirect()->route('student.ticketing.index');
    }
    
}
