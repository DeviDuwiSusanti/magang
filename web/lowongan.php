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
    <link rel="icon" href="../assets/img/logo_kab_sidoarjo.png" type="image/png">
    <title>Home</title>
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
        
    <!--==================== Carieer ====================-->
            <h6 class="section__title" style="text-align: center">Temukan Kesempatan Magang Terbaikmu🚀</h4>
            <!-- Search Section -->
            <div class="search-container" style="text-align: center; margin-top: 10px">
                <div class="search-wrapper">
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari Instansi atau Jurusan..." />
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
                        <!-- Logo instansi (sementara pake gambar default) -->
                        <img src="../assets/img/instansi/logo_kab_sidoarjo.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                        <!-- Nama instansi -->
                        <p class="instansi"> <?= $row['nama_panjang'] ?> </p>
                        <div class="popular__data">
                            <!-- Nama bidang magang -->
                            <h3 class="popular__title">Internship - <?= $row['nama_bidang'] ?></h3>
                            <!-- Alamat instansi -->
                            <p class="popular__description"> <?= $row['alamat_instansi'] ?> </p>
                            <hr style="border: 1px solid #ddd; margin: 10px 0;">
                            <!-- Info jumlah pemagang aktif & tanggal dibuatnya lowongan -->
                            <p class="popular__details">
                                <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: 
                                <span class="total-pendaftar"><?= $pemagang_aktif ?></span><br>
                                <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: 
                                <span class="creation-date"> <?= formatTanggalIndonesia($row['bidang_create_date']) ?> </span>
                                <?php if ($row['bidang_change_date'] != NULL): ?>
                                    <br><span class="icon" style="margin-right: 5px;">&#128340;</span> Diupdate pada: 
                                    <span class="creation-date"> <?= formatTanggalIndonesia($row['bidang_change_date']) ?> </span>
                                <?php endif; ?>
                            </p>
                            <!-- Tombol buat liat detail lowongan -->
                            <a href="detaillow.php?id_bidang=<?= $row['id_bidang'] ?>">
                                <button class="details-button">Lihat Detail →</button>
                            </a>
                        </div>
                    </article>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
    </section>
    <?php include "../layout/footerUser.php" ?>
    </main>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Ambil input pencarian sama semua kotak lowongan
        const searchInput = document.getElementById("searchInput");
        const cards = document.querySelectorAll(".popular__card");

        // Fungsi buat nyari kotak yang sesuai sama teks yang diketik
        function filterCards() {
            const query = searchInput.value.toLowerCase(); // Ambil teks pencarian, terus ubah jadi huruf kecil

            cards.forEach((card) => {
                // Ambil teks dari judul, deskripsi, sama instansi di tiap kotak
                const title = card.querySelector(".popular__title").textContent.toLowerCase();
                const description = card.querySelector(".popular__description").textContent.toLowerCase();
                const instansi = card.querySelector(".instansi").textContent.toLowerCase();

                // Kalau inputnya kosong atau ada yang cocok, tampilin kotaknya
                if (query === "" || title.includes(query) || description.includes(query) || instansi.includes(query)) {
                    card.style.display = "block"; // Munculin kotak
                } else {
                    card.style.display = "none"; // Sembunyiin kalau nggak cocok
                }
            });
        }
        // Setiap kali user ngetik, langsung filter kotaknya
        searchInput.addEventListener("input", filterCards);

        // Biar pas pertama buka halaman, semua kotak langsung muncul
        filterCards();
    });
</script>

</body>
</html>
