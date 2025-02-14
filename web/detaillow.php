<?php
include "koneksi.php"; 

// Mengambil data lowongan dari database
$sql = "SELECT * FROM tb_bidang WHERE status_active = '1'";
$query = mysqli_query($conn, $sql);
$bidang = mysqli_fetch_assoc($query);
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
    <title>Detail Lowongan</title>
</head>
<body>

<!-- Navbar -->
<?php include "../layout/navbarUser.php" ?>

<!--==================== MAIN ====================-->
<main class="main">
    <section class="blog section" id="blog">
        <div class="container">
            <h1 class="blog__title">Detail Lowongan</h1>
            
            <!-- Detail Lowongan -->
            <div class="blog__detail">
                <h3>Internship - <?php echo $bidang['nama']; ?></h3>
                <table class="detail-table">
                    <tr><td><b>Perusahaan</b></td><td>:</td><td><?php echo $bidang['id_instansi']; ?></td></tr>
                    <tr><td><b>Lokasi</b></td><td>:</td><td>Kab. Sidoarjo</td></tr>
                    <tr><td><b>Total Pemagang Aktif</b></td><td>:</td><td><?php echo $bidang['kuota']; ?></td></tr>
                    <tr><td><b>Kuota Lowongan</b></td><td>:</td><td>4</td></tr>
                    <tr><td><b>Dibuat pada</b></td><td>:</td><td><?php echo date("d F Y", strtotime($bidang['create_date'])); ?></td></tr>
                </table>
                
                <h3>Deskripsi Lowongan</h3>
                <p><?php echo $bidang['deskripsi']; ?></p>
                
                <h3>Kriteria</h3>
                <ul class="list">
                    <li>Jenjang pendidikan: <?php echo $bidang['kriteria']; ?></li>
                </ul>

                <h3>Persyaratan Dokumen</h3>
                <ul class="list">
                    <li>CV</li>
                    <li>Surat Badan Kesatuan Bangsa dan Politik Provinsi Jawa Timur</li>
                    <li>Surat Badan Kesatuan Bangsa dan Politik Kabupaten Sidoarjo</li>
                    <li>Proposal</li>
                </ul>

                <h3>Lokasi Instansi</h3>
                <div class="maps-container">
                    <iframe src="https://www.google.com/maps/embed?..." allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                
                <div class="d-flex justify-content-left mt-4">
                    <a href="../login.php" class="btn btn-primary">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include "../layout/footerUser.php" ?>

</body>
</html>