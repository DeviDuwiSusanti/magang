<?php include '../layout/sidebarUser.php';


// ===================== super admin ======================
$instansi_1 = query("SELECT COUNT(*) AS total FROM tb_instansi WHERE status_active = 1")[0];
$pendidikan_1 = query("SELECT COUNT(*) AS total FROM tb_pendidikan WHERE status_active = 1")[0];
$pengajuan_1 = query("SELECT COUNT(*) AS total FROM tb_pengajuan WHERE status_active = 1")[0];
$user_1 = query("SELECT COUNT(*) AS total FROM tb_user WHERE status_active = 1")[0];
// ============================== end of super admin =========================



// =============== admin instansi ==================================
include "update_status.php";
include "admin2_kirim_pengingat.php";

$id_instansi = $_SESSION["id_instansi"];

// data instansi
$instansi_admin_2 = query("SELECT COUNT(*) AS total 
    FROM tb_instansi
    JOIN tb_profile_user 
        ON tb_instansi.id_instansi = tb_profile_user.id_instansi
    WHERE tb_profile_user.id_user = '$id_user'")[0];

// data bidang
$bidang_admin_2 = query("SELECT COUNT(*) AS total 
    FROM tb_bidang
    JOIN tb_instansi 
        ON tb_bidang.id_instansi = tb_instansi.id_instansi
    WHERE tb_instansi.id_instansi = '$id_instansi'
    AND tb_bidang.status_active = '1'")[0];

// Query untuk menghitung total pengajuan
$total_pengajuan_2 = query("SELECT COUNT(*) AS total 
    FROM tb_pengajuan
    JOIN tb_instansi 
        ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
    WHERE tb_instansi.id_instansi = '$id_instansi'
    AND tb_pengajuan.status_active = '1'
    AND tb_pengajuan.status_pengajuan IN ('1', '2')")[0];

// Query untuk menghitung total pemagang
$pemagang_2 = query("SELECT SUM(
            CASE 
                WHEN jumlah_pelamar > 1 THEN jumlah_pelamar 
                ELSE 1 
            END
        ) AS total 
        FROM tb_pengajuan
        JOIN tb_instansi 
            ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        WHERE tb_instansi.id_instansi = '$id_instansi'
        AND tb_pengajuan.status_active = '1'
        AND tb_pengajuan.status_pengajuan IN ('2', '4', '5')")[0];
// ========================== end of admin insatansi level 2 ===============================

// =========================== USER 3 =========================

// Query dapat jumlah pengajuan user
$sql2 = "SELECT COUNT(*) AS jumlah_pengajuan FROM tb_pengajuan WHERE id_user = '$id_user' AND status_pengajuan = '1' AND status_active = '1'";
$query2 = mysqli_query($conn, $sql2);
$total_pengajuan = mysqli_fetch_array($query2)['jumlah_pengajuan'];

// akses sertifikat/nilai
$sql2 = "SELECT COUNT(*) AS nilai FROM tb_nilai WHERE id_user = '$id_user' AND id_pengajuan = '$id_pengajuan' AND status_active = '1'";
$query2 = mysqli_query($conn, $sql2);
$total_nilai = mysqli_fetch_assoc($query2)['nilai'];

// akses histori
if ($ketua){
    $sql3 = "SELECT COUNT(*) AS jumlah_histori FROM tb_pengajuan WHERE id_user = '$id_user' AND status_pengajuan = '5'";
    $query3 = mysqli_query($conn, $sql3);
    $total_histori = mysqli_fetch_array($query3)['jumlah_histori'];
}else if ($anggota){
    $sql3 = "SELECT COUNT(*) AS jumlah_histori FROM tb_pengajuan p, tb_profile_user pu WHERE pu.id_user = '$id_user' AND p.status_pengajuan = '5' AND pu.id_pengajuan = p.id_pengajuan";
    $query3 = mysqli_query($conn, $sql3);
    $total_histori = mysqli_fetch_array($query3)['jumlah_histori'];
}

// akses logbook
$sql4 = "SELECT COUNT(*) AS jumlah_logbook FROM tb_logbook WHERE id_user = '$id_user' AND id_pengajuan = '$id_pengajuan' AND (status_active = 1 OR status_active = 2)";
$query4 = mysqli_query($conn, $sql4);
$total_logbook = mysqli_fetch_array($query4)['jumlah_logbook'];

// akses laporan akhir
$sql5 = "SELECT COUNT(*) jumlah_laprak FROM tb_dokumen WHERE id_user = '$id_user' AND jenis_dokumen = '3' AND id_pengajuan = '$id_pengajuan' AND (status_active = 1 OR status_active = 2)";
$query5 = mysqli_query($conn, $sql5);
$total_laprak = mysqli_fetch_assoc($query5)['jumlah_laprak'];

// ===================== pembimbing ======================
if ($level == 4) :
    $id_bidang = query("SELECT id_bidang FROM tb_profile_user WHERE id_user = '$id_user'")[0];
    $id_bidang_ini = $id_bidang["id_bidang"];
    $pengajuan_bidang = query("SELECT * FROM tb_pengajuan WHERE id_bidang = '$id_bidang_ini'");
    $persetujuan_pembimbing = count($pengajuan_bidang);
    
    $pengajuan = query("SELECT id_pengajuan FROM tb_pengajuan WHERE id_pembimbing = '$id_user' AND (status_pengajuan = '2' OR status_pengajuan = '4' OR status_pengajuan = '5')");
    if (!empty($pengajuan)) {
        $pengajuan_user = $pengajuan[0]["id_pengajuan"];

        // Pindahkan ini ke dalam if agar tidak error saat kosong
        $daftar_anggota = query("SELECT * FROM tb_profile_user, tb_user WHERE tb_profile_user.id_user = tb_user.id_user AND tb_profile_user.id_pengajuan = '$pengajuan_user' AND tb_profile_user.status_active = '1'");
        $daftar_peserta_magang = count($daftar_anggota);
    } else {
        // Bisa di-set ke 0 jika ingin tetap aman
        $daftar_peserta_magang = 0;
    }
endif;

?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>
        <div class="row">
            <!-- ===================== super admin ======================= -->
            <?php if($level == "1") : ?>
                <!-- Card 1 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Instansi Terdaftar</h5>
                            <h2 class="card-text text-success"><?= $instansi_1["total"] ?></h2>
                            <!-- <p class="text-muted">Lihat Dan Kelola Daftar Instansi</p> -->
                            <a href="super1_instansi.php" class="btn btn-success mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Pengguna</h5>
                            <h2 class="card-text text-warning"><?= $user_1["total"] ?></h2>
                            <!-- <p class="text-muted">Lihat Dan Kelola Daftar Pengguna</p> -->
                            <a href="super1_user.php" class="btn btn-warning mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Pendidikan</h5>
                            <h2 class="card-text text-primary"><?= $pendidikan_1["total"] ?></h2>
                            <!-- <p class="text-muted">lihat Dan Tambahkan Daftar Asal Sekolah Atau Universitas Pengguna</p> -->
                            <a href="super1_pendidikan.php" class="btn btn-primary mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Pengajuan User</h5>
                            <h2 class="card-text text-danger"><?= $pengajuan_1["total"] ?></h2>
                            <!-- <p class="text-muted">Daftar Pengajuan Pengguna</p> -->
                            <a href="super1_pengajuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!-- ==================================== end of super admin level 1 =================================== -->


            <!-- ============================ admin instansi level 2========================================= -->
            <?php if($level == "2") : ?>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Kelola Instansi</h5>
                                <h2 class="card-text text-primary"><?= $instansi_admin_2["total"] ?></h2>
                                <p class="text-muted">Kelola data instansi</p>
                                <a href="admin2_instansi.php" class="btn btn-primary mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Kelola Bidang</h5>
                                <h2 class="card-text text-warning"><?= $bidang_admin_2["total"] ?></h2>
                                <p class="text-muted">Kelola data bidang</p>
                                <a href="admin2_bidang.php" class="btn btn-warning mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Pengajuan Baru</h5>
                                <h2 class="card-text text-danger"><?= $total_pengajuan_2["total"] ?></h2>
                                <p class="text-muted">Lihat pengajuan baru</p>
                                <a href="admin2_pengajuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Pemagang</h5>
                                <h2 class="card-text text-success"><?= $pemagang_2["total"] ?? 0 ?></h2>
                                <p class="text-muted">Lihat data pemagang</p>
                                <a href="admin2_user.php" class="btn btn-success mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <!-- ====================================== end of admin instansi level 2 ==================================== -->



            <!-- ====================================== USER DAN ANGGOTA (LEVEL 3) -->
            <!-- Card 1 -->
            <?php 
            if ($ketua && $level == "3"){?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Pengajuan</h5>
                            <h2 class="card-text text-primary"><?= $total_pengajuan?></h2>
                            <p class="text-muted">Permohonan Magang</p>
                            <a href="user3_statusPengajuan.php" class="btn btn-info mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if (isset($row2['status_pengajuan']) && $row2['status_pengajuan'] == '4') { ?>
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Isi Logbook</h5>
                        <h2 class="card-text text-primary"><?= $total_logbook ?></h2>
                        <p class="text-muted">Logbook Terisi</p>
                        <a href="user3_logbook.php" class="btn btn-primary mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <?php
            } if (isset($row2['status_pengajuan']) && $row2['status_pengajuan'] == '5') { ?>
            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Akhir</h5>
                        <h2 class="card-text text-success"><?= $total_laprak ?></h2>
                        <p class="text-muted">Laporan Terunggah</p>
                        <a href="user3_logbook.php" class="btn btn-success mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Cek Sertifikat dan Nilai</h5>
                        <h2 class="card-text text-warning"><?= $total_nilai ?></h2>
                        <p class="text-muted">Tersedia</p>
                        <a href="user3_histori.php" class="btn btn-warning mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>

            <!-- Card 4 -->
            <?php if(($ketua || $anggota) && $level == "3") : ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Histori</h5>
                        <h2 class="card-text text-danger"><?= $total_histori ?: 0 ?></h2>
                        <p class="text-muted">Jumlah Kegiatan</p>
                        <a href="user3_histori.php" class="btn btn-danger mt-3 detail">View Details</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>


            
            <!-- ============== pembimbing ========== -->
            <?php if($level == 4) : ?>
                <!-- Card 1 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Persetujuan Pembimbing</h5>
                            <h2 class="card-text text-danger"><?= $persetujuan_pembimbing ?></h2>
                            <p class="text-muted">Persetujuan Pembimbing Terkait Peserta Magang</p>
                            <a href="pembimbing4_persetujuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Peserta Magang</h5>
                            <h2 class="card-text text-success"><?= $daftar_peserta_magang ?></h2>
                            <p class="text-muted">Daftar Peserta Magang Yang Akan Saya Bimbing</p>
                            <a href="pembimbing4.php" class="btn btn-success mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>