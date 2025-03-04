<?php include "../layout/header.php"; 

$id_instansi = $_SESSION["id_instansi"];

// data instansi
$instansi_admin = query("SELECT COUNT(*) AS total 
    FROM tb_instansi
    JOIN tb_profile_user 
        ON tb_instansi.id_instansi = tb_profile_user.id_instansi
    WHERE tb_profile_user.id_user = '$id_user'")[0];

// data bidang
$bidang_admin = query("SELECT COUNT(*) AS total 
    FROM tb_bidang
    JOIN tb_instansi 
        ON tb_bidang.id_instansi = tb_instansi.id_instansi
    WHERE tb_instansi.id_instansi = '$id_instansi'
    AND tb_bidang.status_active = '1'")[0];

// Query untuk menghitung total pengajuan
$total_pengajuan = query("SELECT COUNT(*) AS total 
    FROM tb_pengajuan
    JOIN tb_instansi 
        ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
    WHERE tb_instansi.id_instansi = '$id_instansi'
    AND tb_pengajuan.status_pengajuan = '1'")[0];

// Query untuk menghitung total pemagang
$pemagang = query("SELECT SUM(
            CASE 
                WHEN jumlah_pelamar > 1 THEN jumlah_pelamar 
                ELSE 1 
            END
        ) AS total 
        FROM tb_pengajuan
        JOIN tb_instansi 
            ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        WHERE tb_instansi.id_instansi = '$id_instansi'
        AND tb_pengajuan.status_pengajuan NOT IN ('0', '1')
    ")[0];
?>


<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Admin Instansi</li>
        </ol>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Instansi</h5>
                        <h2 class="card-text text-primary"><?= $instansi_admin["total"] ?></h2>
                        <p class="text-muted">Kelola data instansi</p>
                        <a href="view_instansi.php" class="btn btn-primary mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Bidang</h5>
                        <h2 class="card-text text-warning"><?= $bidang_admin["total"] ?></h2>
                        <p class="text-muted">Kelola data bidang</p>
                        <a href="view_bidang.php" class="btn btn-warning mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Pengajuan Baru</h5>
                        <h2 class="card-text text-danger"><?= $total_pengajuan["total"] ?></h2>
                        <p class="text-muted">Lihat pengajuan baru</p>
                        <a href="pengajuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Pemagang</h5>
                        <h2 class="card-text text-success"><?= $pemagang["total"] ?? 0 ?></h2>
                        <p class="text-muted">Lihat data pemagang</p>
                        <a href="view_user.php" class="btn btn-success mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>