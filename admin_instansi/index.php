<?php include "header.php"; ?>


<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Admin Instansi</li>
        </ol>
        <div class="row">
            <!-- Kartu 1 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <!-- shadow sm -->
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Instansi</h5>
                        <h2 class="card-text text-primary">1</h2>
                        <p class="text-muted">Kelola data instansi</p>
                        <a href="view_instansi.php" class="btn btn-primary mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Kartu 2 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Pemagang</h5>
                        <h2 class="card-text text-success">55</h2>
                        <p class="text-muted">Lihat data pemagang</p>
                        <a href="view_user.php" class="btn btn-success mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Kartu 3 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Bidang</h5>
                        <h2 class="card-text text-warning">8</h2>
                        <p class="text-muted">Kelola data bidang</p>
                        <a href="view_bidang.php" class="btn btn-warning mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Kartu 4 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Pengajuan Baru</h5>
                        <h2 class="card-text text-danger">3</h2>
                        <p class="text-muted">Lihat pengajuan baru</p>
                        <a href="pengajuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>