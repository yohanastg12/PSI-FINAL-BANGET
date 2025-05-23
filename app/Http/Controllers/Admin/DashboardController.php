<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Room;
use App\Lesson;
use App\SchoolClass;  // Import model SchoolClass

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count(); // Mengambil jumlah total pengguna
        $totalRooms = Room::count(); // Mengambil jumlah total ruangan
        $totalLessons = Lesson::count(); // Mengambil jumlah total pelajaran
        $totalClasses = SchoolClass::count(); // Mengambil jumlah total kelas

        return view('home', compact('totalUsers', 'totalRooms', 'totalLessons', 'totalClasses')); // Kirim totalClasses ke view
    }
}
