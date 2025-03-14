<?php 
    include "sidebar.php"; 
    $instansi = query("SELECT COUNT(*) AS total FROM tb_instansi WHERE status_active = 1")[0];
    $pendidikan = query("SELECT COUNT(*) AS total FROM tb_pendidikan WHERE status_active = 1")[0];
    $pengajuan = query("SELECT COUNT(*) AS total FROM tb_pengajuan WHERE status_active = 1")[0];
    $user = query("SELECT COUNT(*) AS total FROM tb_user WHERE status_active = 1")[0];
?>

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
                        <h5 class="card-title">Instansi Terdaftar</h5>
                        <h2 class="card-text text-success"><?= $instansi["total"] ?></h2>
                        <p class="text-muted">Lihat Dan Kelola Daftar Instansi</p>
                        <a href="instansi.php" class="btn btn-success mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Pengguna</h5>
                        <h2 class="card-text text-warning"><?= $user["total"] ?></h2>
                        <p class="text-muted">Lihat Dan Kelola Daftar Pengguna</p>
                        <a href="user.php" class="btn btn-warning mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Pendidikan</h5>
                        <h2 class="card-text text-primary"><?= $pendidikan["total"] ?></h2>
                        <p class="text-muted">lihat Dan Tambahkan Daftar Asal Sekolah Atau Universitas Pengguna</p>
                        <a href="pendidikan.php" class="btn btn-primary mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Pengajuan User</h5>
                        <h2 class="card-text text-danger"><?= $pengajuan["total"] ?></h2>
                        <p class="text-muted">Daftar Pengajuan Pengguna</p>
                        <a href="pengajuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>