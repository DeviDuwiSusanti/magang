<?php include "sidebar.php"; ?>


<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Super Admin</li>
        </ol>
        <div class="row">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">My Profile</h5>
                        <h2 class="card-text text-primary">1</h2>
                        <p class="text-muted">Lihat Atau Edit Profile Saya</p>
                        <a href="profile_view.php" class="btn btn-primary mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Instansi Terdaftar</h5>
                        <h2 class="card-text text-success">50</h2>
                        <p class="text-muted">Lihat Dan Kelola Daftar Instansi</p>
                        <a href="instansi_view.php" class="btn btn-success mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Pengguna</h5>
                        <h2 class="card-text text-warning">100</h2>
                        <p class="text-muted">Lihat Dan Kelola Daftar Pengguna</p>
                        <a href="user_view.php" class="btn btn-warning mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Pengajuan</h5>
                        <h2 class="card-text text-danger">13</h2>
                        <p class="text-muted">Daftar Pengajuan Pengguna</p>
                        <a href="pengajuan_view.php" class="btn btn-danger mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>