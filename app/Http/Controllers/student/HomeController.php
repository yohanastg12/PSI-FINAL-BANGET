<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('student.home');
    }
}
