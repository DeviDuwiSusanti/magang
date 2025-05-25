<?php
include "../koneksi.php";
include "functions.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS digunakan untuk menambahkan ikon  ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--=============== SWIPER CSS untu membuat slider===============-->
    <link rel="stylesheet" href="../assets/libraries/swiper-bundle.min.css" />
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

    <!-- AOS JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/home.css" />
    <link rel="stylesheet" href="../assets/css/style3.css" />
    <link rel="icon" href="../assets/img/logo_kab_sidoarjo.png" type="image/png">
    <title>Home</title>
</head>

<body>
    <script src="../assets/js/animasi.js"></script>
    <?php include "../layout/navbarUser.php" ?>


    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <section class="swiper-wrapper" id="hero">
            <div class="container">
                <!-- Deskripsi di sebelah kiri -->
                <div class="hero-text" data-aos="fade-left">
                    <h1>Selamat Datang di Sidoarjo Internship</h1>
                    <p>
                        Temukan berbagai peluang magang terbaik di Sidoarjo yang sesuai dengan minat dan keahlianmu.
                        Kami menyediakan akses mudah bagi mahasiswa dan fresh graduate untuk mendapatkan pengalaman berharga.
                    </p>
                    <a href="tentang.php"><button class="details-button">Tentang Kami →</button></a>
                </div>
                
                <!-- Gambar di sebelah kanan -->
                <div class="hero-image" data-aos="fade-right">
                    <img src="../assets/img/bgHome.jpg" alt="Magang di Sidoarjo">
                </div>
            </div>
        </section>

        <!--==================== POPULAR ====================-->
        <section class="section" id="popular">
            <div class="container">
                <h2 class="section__title" style="text-align: center" data-aos="fade-up">Temukan Peluang Magang Terbaik di Sidoarjo</h2>
                <span class="section__subtitle" style="text-align: center" data-aos="fade-up">
                "Sidoarjo Internship menyediakan berbagai program magang yang sesuai dengan keterampilan dan minatmu. Daftar sekarang dan ambil langkah pertama menuju masa depan karirmu. Kesuksesan dimulai dari sini!"</span><br>
                <br><br>
                <div class="lowongan">
                    <div class="lowongans" data-aos="fade-down">
                        <?php
                        $query = getBidangInstansi($conn, 6);
                        while ($row = mysqli_fetch_assoc($query)){  
                            $pemagang_aktif = getPemagangAktif1($conn, $row['id_instansi'], $row['id_bidang']);
                            ?>
                            <article class="popular__card swiper-slide">
                                <img src="../assets/img/instansi/logo_kab_sidoarjo.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                <p><?= $row['nama_panjang'] ?></p>
                                <div class="popular__data">
                                    <h3 class="popular__title">Internship - <?= $row['nama_bidang'] ?></h3>
                                    <p class="popular__description"><?= $row['alamat_instansi'] ?></p>
                                    <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                    <p class="popular__details">
                                        <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar"><?= $pemagang_aktif ?></span><br>
                                        <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date"><?= formatTanggalIndonesia($row['bidang_create_date']) ?></span><br>
                                        <?php
                                        if ($row['bidang_change_date'] != NULL){?>
                                            <span class="icon" style="margin-right: 5px;">&#128340;</span> Diupdate pada: <span class="creation-date"><?= formatTanggalIndonesia($row['bidang_change_date']) ?></span><br>

                                        <?php
                                        }
                                        ?>
                                    </p>
                                    <a href="detaillow.php?id_bidang=<?= $row['id_bidang'] ?>"><button class="details-button">Lihat Detail →</button></a>
                                </div>
                            </article>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="view-all" style="text-align: center; margin-top: 20px;">
                        <a href="lowongan.php" style="text-decoration: none; font-weight: bold; color: #007BFF;">Lihat Selengkapnya →</a>
                    </div>
                </div>

                <!-- Tambahkan setelah section FAQ dan sebelum footer -->
                <section class="section" id="steps" style="padding: 60px 0;">
                    <div class="container">
                        <h2 class="section__title" style="text-align: center" data-aos="fade-up">Langkah-langkah Pendaftaran</h2>
                        <span class="section__subtitle" style="text-align: center" data-aos="fade-up">
                            "Ikuti langkah-langkah berikut untuk mendaftar program magang di Sidoarjo Internship"
                        </span><br><br>

                        <div class="row align-items-center" >
                            <!-- Kolom untuk step vertikal -->
                            <div class="col-md-6" data-aos="fade-right">
                                <div class="steps-vertical">
                                    <div class="step">
                                        <div class="step-number">1</div>
                                        <div class="step-content">
                                            <h4>Registrasi dan Login</h4>
                                            <p>Registrasi akun dan login untuk menambah data usulan magang</p>
                                        </div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">2</div>
                                        <div class="step-content">
                                            <h4>Lengkapi Profil</h4>
                                            <p>Lengkapi data diri</p>
                                        </div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">3</div>
                                        <div class="step-content">
                                            <h4>Pilih Lowongan</h4>
                                            <p>Telusuri lowongan magang yang tersedia dan pilih yang sesuai dengan minat Anda.</p>
                                        </div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">4</div>
                                        <div class="step-content">
                                            <h4>Buat Pengajuan</h4>
                                            <p>Ajukan lamaran untuk lowongan yang dipilih beserta unggah CV, KTP, dan Proposal sebagai dokumen prasyarat, lalu tunggu konfirmasi dari admin instansi.</p>
                                        </div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">5</div>
                                        <div class="step-content">
                                            <h4>Unggah berkas persyaratan Lainnya</h4>
                                            <p>Setelah diterima, Anda akan diarahkan untuk melengkapi dokumen persyaratan yang sebelumnya ditentukan oleh instansi</p>
                                        </div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">6</div>
                                        <div class="step-content">
                                            <h4>Mulai Magang</h4>
                                            <p>Setelah resmi diterima, Anda akan diarahkan untuk memulai program magang</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom untuk gambar -->
                            <div class="col-md-6" data-aos="fade-left">
                                <div class="text-center">
                                    <img src="../assets/img/step2.png" alt="Langkah Pendaftaran" class="img-fluid" style="max-height: 500px;">
                                    <img src="../assets/img/step3.png" alt="Langkah Pendaftaran" class="img-fluid" style="max-height: 500px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <br><br><br>
                <h2 class="section__title" style="text-align: center" data-aos="fade-up">Daftar Instansi</h2>
                <span class="section__subtitle" style="text-align: center" data-aos="fade-up">
                "Sidoarjo Internship telah membantu peserta dalam melaksanakan program magang berkualitas di Sidoarjo. Temukan peluang magang terbaik untuk karier masa depan Anda!"</span><br>

                <!-- Tambahkan search box di sini -->
                <div class="search-container" style="text-align: center; margin-top: 10px">
                    <div class="search-wrapper">
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari Instansi..." />
                        <i id="searchIcon" class="fas fa-search search-icon"></i>
                    </div>
                </div>

                <div class="popular__container swiper">
                    <div class="swiper-wrapper" id="instansiContainer">
                    <?php
                    $instansi = "SELECT nama_panjang, website_resmi_instansi FROM tb_instansi";
                    $query = mysqli_query($conn, $instansi);
                    while ($row = mysqli_fetch_assoc($query)){  
                    ?>
                        <article class="popular__card swiper-slide" style="text-align: center; cursor:pointer;" >
                            <div class="daftar_instansi">
                                <a href="<?= $row['website_resmi_instansi'] ?>" target="_blank">
                                    <img src="<?= !empty($row['gambar_instansi']) ? '../assets/img/instansi/'.$row['gambar_instansi'] : '../assets/img/instansi/logo_kab_sidoarjo.png' ?>"  alt="logo_instansi" class="popular__img" style="width: 50px; height: 50px;" /><br>
                                    <h4 class="popular__price"><?= $row['nama_panjang'] ?></h4>
                                </a>
                            </div>
                        </article>
                    <?php
                        }
                    ?>
                    </div>

                    <div class="swiper-button-next">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="bx bx-chevron-left"></i>
                    </div>
                </div>
                <br><br><br>
                <h2 class="section__title" style="text-align: center" data-aos="fade-up">Pertanyaan yang Sering Ditanyakan</h2><br><br>
                <?php include "../layout/faqs.php" ?>
            </div>
        </section>
    </main>
        <?php include "../layout/footerUser.php" ?>
</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const cards = document.querySelectorAll(".popular__card"); // Target seluruh card
    
    function filterInstansi() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        cards.forEach(card => {
            // Cari div daftar_instansi di dalam card
            const instansiDiv = card.querySelector('.daftar_instansi');
            const cardText = instansiDiv ? instansiDiv.textContent.toLowerCase() : '';
            
            // Toggle display seluruh card, bukan hanya bagian dalamnya
            if (cardText.includes(searchTerm)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }
    
    searchInput.addEventListener("input", filterInstansi);
    filterInstansi(); // Inisialisasi awal
});
</script>
