<?php
include "../koneksi.php"; 
include "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="../assets/libraries/swiper-bundle.min.css" />
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <!-- AOS JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/style2.css" />
    <link rel="stylesheet" href="../assets/css/low.css" />
    <link rel="stylesheet" href="../assets/css/detail.css" />
    <link rel="icon" href="../assets/img/logo_kab_sidoarjo.png" type="image/png">
    <title>Lowongan Magang</title>
</head>

<body>
    <script src="../assets/js/animasi.js"></script>
    <?php include "../layout/navbarUser.php" ?>

    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <div class="wrapper">
            <div class="container main">
                <div class="row">
                    <div class="col-md-6 side-image">
                        <div class="text">
                            <h1 class="hero-title">Temukan Karir Impianmu</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--==================== POPULAR ====================-->
        <section class="section" id="popular">
            <div class="container" data-aos="fade-up">
                <h2 class="section__title" style="text-align: center">
                    Dengan Pengalaman Kami </br> Kami Hadir untuk Melayani Anda
                </h2></br>
                
                <!---========== Text and image layout=======-->
                <div class="custom-container" data-aos="fade-up">
                    <!-- Center Text -->
                    <div class="center-text">
                        <div class="text-block">
                            <p class="large-text">44</p>
                            <p class="small-text">Instansi</p>
                        </div>
                        <div class="text-block">
                            <p class="large-text">+100</p>
                            <p class="small-text">Lowongan</p>
                        </div>
                        <div class="text-block">
                            <p class="large-text">+100</p>
                            <p class="small-text">Selesai</p>
                        </div>
                    </div>
                    
                    <!-- Image Row -->
                    <div class="image-row">
                        <!-- Kiri Gambar -->
                        <div class="left-column" data-aos="fade-left">
                            <img src="../assets/img/pw2.jpg" alt="Left Portrait Image" class="custom-image">
                        </div>
                        <!-- Kanan Gambar-->
                        <div class="right-column" data-aos="fade-right">
                            <img src="../assets/img/pw1.jpg" alt="Right Portrait Image" class="custom-image">
                            <img src="../assets/img/pw3.jpg" alt="Bottom Portrait Image" class="custom-image image-spacing">
                        </div>
                    </div>
                </div>
                
                <!--==================== Career ====================-->
                <h6 class="section__title" style="text-align: center">Temukan Kesempatan Magang Terbaikmu🚀</h6>
                <!-- Search Section -->
                <div class="search-container" style="text-align: center; margin-top: 10px">
                    <div class="search-wrapper">
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari Instansi atau Bidang..." />
                        <i id="searchIcon" class="fas fa-search search-icon"></i>
                    </div>
                </div>

                <div class="lowongan">
                    <div class="lowongans" data-aos="fade-down">
                    <?php
                    $query = getBidangInstansi($conn);
                    while ($row = mysqli_fetch_assoc($query)){  
                        $pemagang_aktif = getPemagangAktif1($conn, $row['id_instansi'], $row['id_bidang']);
                        ?>
                        <!-- Buat satu kartu lowongan -->
                        <article class="popular__card swiper-slide">
                            <!-- Logo instansi -->
                            <img src="../assets/img/instansi/logo_kab_sidoarjo.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <!-- Nama instansi -->
                            <p class="instansi"><?= $row['nama_panjang'] ?></p>
                            <div class="popular__data">
                                <!-- Nama bidang magang -->
                                <h3 class="popular__title">Internship - <?= $row['nama_bidang'] ?></h3>
                                <!-- Alamat instansi -->
                                <p class="popular__description"><?= $row['alamat_instansi'] ?></p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <!-- Info jumlah pemagang aktif & tanggal dibuatnya lowongan -->
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: 
                                    <span class="total-pendaftar"><?= $pemagang_aktif ?></span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: 
                                    <span class="creation-date"><?= $row['create_date'] ?></span>
                                </p>
                                <!-- Tombol buat liat detail lowongan -->
                                <button class="details-button" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id_bidang'] ?>">
                                    Lihat Detail →
                                </button>
                            </div>
                        </article>

                        <!-- Modal Detail Lowongan -->
                        <div class="modal fade" id="detailModal<?= $row['id_bidang'] ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $row['id_bidang'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Lowongan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="blog__detail">
          <h3>Internship - <?= $row['nama_bidang'] ?></h3>
          <table class="detail-table">
            <tr><td><b>Instansi</b></td><td>:</td><td><?= $row['nama_panjang'] ?></td></tr>
            <tr><td><b>Alamat</b></td><td>:</td><td><?= $row['alamat_instansi'] ?></td></tr>
            <tr><td><b>Pemagang Aktif</b></td><td>:</td><td><?= $pemagang_aktif ?></td></tr>
            <tr><td><b>Kuota Lowongan</b></td><td>:</td><td><?= $row['kuota_bidang'] ?></td></tr>
            <tr><td><b>Dibuat pada</b></td><td>:</td><td><?= $row['bidang_change_date'] ?></td></tr>
          </table>

          <h3>Deskripsi Lowongan</h3>
          <p><?= $row['deskripsi_bidang'] ?></p>

          <h3>Kriteria</h3>
          <ul class="list">
            <?php foreach (explode(',', $row['kriteria_bidang']) as $item): ?>
              <li><?= $item ?></li>
            <?php endforeach; ?>
          </ul>

          <h3>Persyaratan Dokumen</h3>
          <ul class="list">
            <?php foreach (explode(',', $row['dokumen_prasyarat']) as $item): ?>
              <li><?= $item ?></li>
            <?php endforeach; ?>
          </ul>

          <h3>Lokasi Instansi</h3>
          <div class="maps-container">
            <?= $row['lokasi_instansi'] ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="../user/user3_statusPengajuan.php" class="btn btn-primary">Daftar Sekarang</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
</div>
                </div>
            </div>
<?php } ?> <!-- tutup while di sini -->
        </section>
    </main>


    <?php include "../layout/footerUser.php" ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Inisialisasi AOS
            AOS.init();
            
            // Fungsi pencarian
            const searchInput = document.getElementById("searchInput");
            const cards = document.querySelectorAll(".popular__card");

            function filterCards() {
                const query = searchInput.value.toLowerCase();

                cards.forEach((card) => {
                    const title = card.querySelector(".popular__title").textContent.toLowerCase();
                    const description = card.querySelector(".popular__description").textContent.toLowerCase();
                    const instansi = card.querySelector(".instansi").textContent.toLowerCase();

                    if (query === "" || title.includes(query) || description.includes(query) || instansi.includes(query)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            }
            
            searchInput.addEventListener("input", filterCards);
            filterCards();
        });
    </script>


</body>
</html>