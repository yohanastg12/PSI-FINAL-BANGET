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
            'description' => 'required|string',
            // Hapus validasi 'role' karena akan kita isi sendiri
        ]);
    
        // Tambahkan role dari user yang login
        $data['role'] = auth()->user()->role;
    
        // Simpan ke session sementara
        $tickets = session('tickets', []);
        $tickets[] = $data;
        session(['tickets' => $tickets]);
    
        return redirect()->route('student.ticketing.index')->with('success', 'Ticket berhasil disimpan.');
    }
    
}
