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
    <link rel="stylesheet" href="../assets/css/style2.css" />
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

        $sql = "SELECT tb_bidang.*, tb_instansi.*, tb_bidang.change_date AS bidang_change_date FROM tb_bidang, tb_instansi WHERE tb_bidang.id_bidang = '$id_bidang' AND tb_instansi.id_instansi = tb_bidang.id_instansi";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $pemagang_aktif = getPemagangAktif1($conn, $row['id_instansi'], $row['id_bidang']);
    } ?>

    <!--==================== MAIN ====================-->
    <main class="main">
        <section class="blog section" id="blog">
            <div class="container">
                <h1 class="blog__title">Detail Lowongan</h1>

                <!-- Detail Lowongan -->
                <div class="blog__detail">
                    <h3>Internship - <?= $row['nama_bidang'] ?></h3>
                    <table class="detail-table">
                        <tr>
                            <td><b>Instansi</b></td>
                            <td>:</td>
                            <td><?= $row['nama_panjang'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Alamat</b></td>
                            <td>:</td>
                            <td><?= $row['alamat_instansi'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Pemagang Aktif</b></td>
                            <td>:</td>
                            <td><?= $pemagang_aktif ?></td>
                        </tr>
                        <tr>
                            <td><b>Kuota Lowongan</b></td>
                            <td>:</td>
                            <td><?= $row['kuota_bidang'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Dibuat pada</b></td>
                            <td>:</td>
                            <td><?= $row['bidang_change_date'] ?></td>
                        </tr>
                    </table>

                    <h3>Deskripsi Lowongan</h3>
                    <p><?= $row['deskripsi_bidang'] ?></p>

                    <h3>Kriteria</h3>
                    <ul class="list">
                        <?php
                        // perulangan untuk data list di database 
                        $kriteria = isset($row['kriteria_bidang']) ? explode(',', $row['kriteria_bidang']) : [];
                        foreach ($kriteria as $item) : ?>
                            <li><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h3>Persyaratan Dokumen</h3>
                    <ul class="list">
                        <?php
                        $doc_prasyarat = isset($row['dokumen_prasyarat']) ? explode(',', $row['dokumen_prasyarat']) : [];
                        foreach ($doc_prasyarat as $item) : ?>
                            <li><?= $item ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h3>Lokasi Instansi</h3>
                    <div class="maps-container">
                        <?php echo $row['lokasi_instansi']; ?>
                        <!-- <?php
                                if (!empty($row['lokasi_instansi'])) {
                                    $embed_url = $row['lokasi_instansi'];

                                    echo "<iframe 
                                     src='$embed_url' 
                                     width='600' 
                                     height='450' 
                                     style='border:0;' 
                                     allowfullscreen='' 
                                     loading='lazy' 
                                     referrerpolicy='no-referrer-when-downgrade'>
                                 </iframe>";
                                } else {
                                    echo "<p>Lokasi instansi tidak tersedia.</p>";
                                }
                                ?> -->
                    </div>

                    <div class="d-flex justify-content-left mt-4">
                        <a href="../user/pengajuan.php" class="btn btn-primary">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include "../layout/footerUser.php" ?>

</body>

</html>