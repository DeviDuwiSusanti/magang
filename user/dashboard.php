<?php include '../layout/sidebarUser.php' ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">User</li>
        </ol>
        <div class="row">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Pengajuan</h5>
                        <h2 class="card-text text-primary">2</h2>
                        <p class="text-muted">Permohonan Magang</p>
                        <a href="status_pengajuan.php" class="btn btn-info mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Unggah Logbook</h5>
                        <h2 class="card-text text-primary">15</h2>
                        <p class="text-muted">Logbook Terunggah</p>
                        <a href="kegiatan_aktif.php" class="btn btn-primary mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Akhir</h5>
                        <h2 class="card-text text-success">0</h2>
                        <p class="text-muted">Laporan Terunggah</p>
                        <a href="kegiatan_aktif.php" class="btn btn-success mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Cek Sertifikat dan Nilai</h5>
                        <h2 class="card-text text-warning">1</h2>
                        <p class="text-muted">Tersedia</p>
                        <a href="histori.php" class="btn btn-warning mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Histori</h5>
                        <h2 class="card-text text-danger">4</h2>
                        <p class="text-muted">Jumlah Kegiatan</p>
                        <a href="histori.php" class="btn btn-danger mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>