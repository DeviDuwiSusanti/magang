<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pengajuan Aktif</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/lowongan.css" />
    <link rel="stylesheet" href="../assets/css/home.css"/>
</head>
<body>
<?php include "../assets/layout/navbarUser.php" ?>

<!--==================== MAIN ====================-->
<main class="main">

    <!--==================== HOME ====================-->
    <section>
        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
            <section class="islands swiper-slide">
                <img src="../assets/img/pw3.jpg" alt="" class="islands__bg" />
                <div class="islands__container container">
                <div class="islands__data">
                    <h1 class="islands__title">Internship Portal</h1>
                </div>
                </div>
            </section>
            </div>
        </div>
    </section>

    <?php include "../assets/layout/navbarpengajuan.php" ?>
    
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tabel Pengajuan Aktif</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Instansi</th>
                    <th>Status Lamaran</th>
                    <th>Durasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Pelatihan Digital Marketing</td>
                    <td>Dinas Kominfo Sidoarjo</td>
                    <td>Diterima</td>
                    <td>3 Bulan</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Workshop UI/UX</td>
                    <td>Universitas Trunojoyo Madura</td>
                    <td>Ditolak</td>
                    <td>1 Minggu</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Sosialisasi Keamanan Jaringan</td>
                    <td>Dinas Kominfo Surabaya</td>
                    <td>
                        Progres  <a href="dokumen.php" class="btn btn-sm btn-primary">Lengkapi Dokumen</a>
                    </td>
                    <td>2 Hari</td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php include "../assets/layout/footerUser.php" ?>
</body>
</html>