@extends('layouts.admin')
@section('content')
<div class="dashboard-container">
    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <h1><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h1>
        <p class="text-muted">Ringkasan aktivitas sistem terbaru</p>
    </div>

    <!-- Statistik Utama -->
    <div class="stats-grid">
        <!-- Card Pengguna -->
        <div class="stat-card bg-gradient-blue">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>1,024</h3>
                <p>Total Pengguna</p>
            </div>
            <a href="#" class="stat-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
        </div>

        <!-- Card Kelas -->
        <div class="stat-card bg-gradient-green">
            <div class="stat-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <h3>48</h3>
                <p>Total Kelas</p>
            </div>
            <a href="#" class="stat-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
        </div>

        <!-- Card Jadwal -->
        <div class="stat-card bg-gradient-purple">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <h3>156</h3>
                <p>Jadwal Aktif</p>
            </div>
            <a href="#" class="stat-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
        </div>

        <!-- Card Ruangan -->
        <div class="stat-card bg-gradient-orange">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-info">
                <h3>12</h3>
                <p>Gedung Tersedia</p>
            </div>
            <a href="#" class="stat-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <!-- Dua Kolom Bawah -->
    <div class="dashboard-content">
        <!-- Grafik Aktivitas -->
        <div class="dashboard-chart">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-chart-line"></i> Aktivitas Sistem (7 Hari Terakhir)</h3>
                </div>
                <div class="card-body">
                    <div class="chart-placeholder">
                        <img src="https://via.placeholder.com/800x300?text=Grafik+Aktivitas" alt="Grafik Aktivitas" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengguna Online -->
        <div class="dashboard-sidebar">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-user-clock"></i> Pengguna Online</h3>
                </div>
                <div class="card-body">
                    <ul class="user-list">
                        <li class="user-item">
                            <img src="https://i.pravatar.cc/40?img=1" alt="User" class="user-avatar">
                            <div class="user-info">
                                <strong>Admin Sistem</strong>
                                <span>Baru saja</span>
                            </div>
                            <span class="online-dot"></span>
                        </li>
                        <li class="user-item">
                            <img src="https://i.pravatar.cc/40?img=2" alt="User" class="user-avatar">
                            <div class="user-info">
                                <strong>Dosen A</strong>
                                <span>5 menit lalu</span>
                            </div>
                            <span class="online-dot"></span>
                        </li>
                        <li class="user-item">
                            <img src="https://i.pravatar.cc/40?img=3" alt="User" class="user-avatar">
                            <div class="user-info">
                                <strong>Dosen B</strong>
                                <span>15 menit lalu</span>
                            </div>
                            <span class="online-dot"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="dashboard-table">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-calendar-day"></i> Jadwal Hari Ini (Senin, 12 Juni 2023)</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Kelas</th>
                                <th>Mata Kuliah</th>
                                <th>Pengajar</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>08:00 - 09:30</td>
                                <td>SI-01</td>
                                <td>Pemrograman Web</td>
                                <td>Dr. Ahmad</td>
                                <td>Gedung A/301</td>
                            </tr>
                            <tr>
                                <td>10:00 - 11:30</td>
                                <td>TI-02</td>
                                <td>Basis Data</td>
                                <td>Dr. Siti</td>
                                <td>Gedung B/105</td>
                            </tr>
                            <tr>
                                <td>13:00 - 14:30</td>
                                <td>MI-03</td>
                                <td>Jaringan Komputer</td>
                                <td>Prof. Bambang</td>
                                <td>Gedung C/202</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Dashboard Styles */
    .dashboard-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .dashboard-header {
        margin-bottom: 30px;
    }
    
    .dashboard-header h1 {
        color: #2c3e50;
        font-weight: 700;
    }
    
    /* Stat Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        border-radius: 10px;
        padding: 20px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.2;
        position: absolute;
        right: 20px;
        top: 20px;
    }
    
    .stat-info h3 {
        font-size: 2rem;
        margin-bottom: 5px;
    }
    
    .stat-link {
        color: white;
        text-decoration: none;
        font-size: 0.9rem;
        display: inline-block;
        margin-top: 10px;
        opacity: 0.8;
    }
    
    .stat-link:hover {
        opacity: 1;
        text-decoration: underline;
    }
    
    /* Gradient Backgrounds */
    .bg-gradient-blue {
        background: linear-gradient(135deg, #3498db, #2c3e50);
    }
    
    .bg-gradient-green {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
    }
    
    .bg-gradient-purple {
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
    }
    
    .bg-gradient-orange {
        background: linear-gradient(135deg, #e67e22, #d35400);
    }
    
    /* Dashboard Content */
    .dashboard-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    @media (max-width: 768px) {
        .dashboard-content {
            grid-template-columns: 1fr;
        }
    }
    
    /* User List */
    .user-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .user-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .user-avatar {
        border-radius: 50%;
        margin-right: 15px;
    }
    
    .user-info {
        flex-grow: 1;
    }
    
    .user-info strong {
        display: block;
        margin-bottom: 3px;
    }
    
    .user-info span {
        font-size: 0.8rem;
        color: #7f8c8d;
    }
    
    .online-dot {
        display: block;
        width: 10px;
        height: 10px;
        background-color: #2ecc71;
        border-radius: 50%;
    }
    
    /* Schedule Table */
    .schedule-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .schedule-table th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
    }
    
    .schedule-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .schedule-table tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Chart Placeholder */
    .chart-placeholder {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
    }
</style>
@endsection