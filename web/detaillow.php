<?php
include "../koneksi.php";
include "functions.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/style3.css" />
    <link rel="stylesheet" href="../assets/css/detail.css" />
    <link rel="icon" href="../assets/img/logo_kab_sidoarjo.png" type="image/png">
    <title>Detail Lowongan</title>
</head>

<body>

    <!-- Navbar -->
    <?php include "../layout/navbarUser.php";
    // MENGAMBIL DATA DARI BIDANG/LOWONGAN SESUAI DENGAN ID
    if (isset($_GET['id_bidang'])) {
        $id_bidang = $_GET['id_bidang'];

        $sql = "SELECT tb_bidang.*, tb_instansi.*, tb_bidang.create_date AS bidang_create_date, tb_bidang.change_date AS bidang_change_date FROM tb_bidang, tb_instansi WHERE tb_bidang.id_bidang = '$id_bidang' AND tb_instansi.id_instansi = tb_bidang.id_instansi";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $pemagang_aktif = getPemagangAktif1($conn, $row['id_instansi'], $row['id_bidang']);
    } ?>

    <!--==================== MAIN ====================-->
    <main class="main">
        <section class="blog section" id="blog">
            <div class="container">
                <div class="breadcrumb mb-4">
                    <a href="lowongan.php" class="breadcrumb-link">Lowongan</a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current">Detail Lowongan</span>
                </div>

                <div class="job-header">
                    <div class="job-header-content">
                        <h1 class="blog__title"><?= $row['nama_bidang'] ?></h1>
                        <div class="job-company">
                            <i class="bx bx-buildings"></i>
                            <span><?= $row['nama_panjang'] ?></span>
                        </div>
                        <div class="job-location">
                            <i class="bx bx-map"></i>
                            <span><?= $row['alamat_instansi'] ?></span>
                        </div>
                    </div>
                    <div class="job-header-badge">
                        <span class="badge">Internship</span>
                    </div>
                </div>

                <!-- Detail Lowongan -->
                <div class="blog__detail">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="job-section">
                                <h3 class="section-title">
                                    <i class="bx bx-detail"></i>
                                    <span>Deskripsi Lowongan</span>
                                </h3>
                                <div class="job-content">
                                    <?= $row['deskripsi_bidang'] ?>
                                </div>
                            </div>

                            <div class="job-section">
                                <h3 class="section-title">
                                    <i class="bx bx-list-check"></i>
                                    <span>Kriteria</span>
                                </h3>
                                <div class="job-content summernote-output">
                                    <?= $row['kriteria_bidang'] ?>
                                </div>
                            </div>

                            <div class="job-section">
                                <h3 class="section-title">
                                    <i class="bx bx-file"></i>
                                    <span>Persyaratan Dokumen</span>
                                </h3>
                                <div class="job-content summernote-output">
                                    <?= $row['dokumen_persyaratan'] ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="job-sidebar">
                                <div class="sidebar-card">
                                    <h4 class="sidebar-title">Ringkasan Lowongan</h4>
                                    <div class="sidebar-item">
                                        <i class="bx bx-user"></i>
                                        <div>
                                            <span class="sidebar-item-label">Pemagang Aktif</span>
                                            <span class="sidebar-item-value"><?= $pemagang_aktif ?></span>
                                        </div>
                                    </div>
                                    <div class="sidebar-item">
                                        <i class="bx bx-group"></i>
                                        <div>
                                            <span class="sidebar-item-label">Kuota Lowongan</span>
                                            <span class="sidebar-item-value"><?= $row['kuota_bidang'] ?></span>
                                        </div>
                                    </div>
                                    <div class="sidebar-item">
                                        <i class="bx bx-calendar"></i>
                                        <div>
                                            <span class="sidebar-item-label">Dibuat pada</span>
                                            <span class="sidebar-item-value"><?= formatTanggalIndonesia($row['bidang_create_date']) ?></span>
                                        </div>
                                    </div>
                                     <?php
                                        if ($row['bidang_change_date'] != NULL):?>
                                        <div class="sidebar-item">
                                            <i class="bx bx-time"></i>
                                            <div>
                                                <span class="sidebar-item-label">Diupdate pada</span>
                                                <span class="sidebar-item-value"><?= formatTanggalIndonesia($row['bidang_change_date']) ?></span>
                                            </div>
                                        </div>
                                     <?php endif; ?>
                                </div>

                                <div class="sidebar-card">
                                    <h4 class="sidebar-title">Lokasi Instansi</h4>
                                    <div class="sidebar-item">
                                        <i class="bx bx-map"></i>
                                        <div>
                                            <?php if (!empty($row['lokasi_instansi'])): ?>
                                                <a href="<?= $row['lokasi_instansi'] ?>" target="_blank" rel="noopener noreferrer" class="maps-link">
                                                    Lihat di Google Maps
                                                </a>
                                            <?php else: ?>
                                                <span class="sidebar-item-value">Lokasi tidak tersedia</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="sidebar-card">
                                    <div class="alert alert-info">
                                        <i class="bx bx-info-circle"></i>
                                        <div>
                                            <strong>Ketentuan Upload Dokumen:</strong> Saat pendaftaran pengajuan hanya perlu mengunggah KTP, CV, dan Proposal. Dokumen lainnya dapat diunggah setelah pengajuan diterima.
                                        </div>
                                    </div>
                                </div>

                                <div class="apply-now">
                                    <a href="../user/user3_statusPengajuan.php" class="btn btn-primary btn-apply">
                                        <i class="bx bx-send"></i>
                                        Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include "../layout/footerUser.php" ?>

</body>

</html>
