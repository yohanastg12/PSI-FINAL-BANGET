@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> BAA Dashboard</h2>
    <p>Welcome, {{ auth()->user()->name }}</p>

    <div class="row mt-4">
        <!-- Total Pengguna -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Pengguna</h5>
                            <h3>1,024</h3>
                        </div>
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <a href="#" class="text-white-50 small d-block mt-2">Lihat Detail →</a>
                </div>
            </div>
        </div>

        <!-- Total Kelas -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Kelas</h5>
                            <h3>48</h3>
                        </div>
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                    <a href="#" class="text-white-50 small d-block mt-2">Lihat Detail →</a>
                </div>
            </div>
        </div>

        <!-- Jadwal Aktif -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-purple shadow h-100 py-2" style="background-color: #6f42c1;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Jadwal Aktif</h5>
                            <h3>156</h3>
                        </div>
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <a href="#" class="text-white-50 small d-block mt-2">Lihat Detail →</a>
                </div>
            </div>
        </div>

        <!-- Gedung Tersedia -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Gedung Tersedia</h5>
                            <h3>12</h3>
                        </div>
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                    <a href="#" class="text-white-50 small d-block mt-2">Lihat Detail →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Tickets -->
    <div class="mt-4">
        <a href="{{ route('baa.tickets') }}" class="btn btn-info">Manage Tickets</a>
    </div>
</div>
@endsection
