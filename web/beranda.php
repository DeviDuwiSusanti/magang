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
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/home.css" />
    <link rel="stylesheet" href="../assets/css/beranda.css" />
    <title>Home</title>
    <style>
        .lowongan .lowongans {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
    </style>
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
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Komunikasi dan Informatika</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                        </article>

                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img"
                                style="width: 50px; height: 50px;" />
                            <p>Dinas Kesehatan</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img"
                                style="width: 50px; height: 50px;" />
                            <p>Dinas Perikanan</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Sosial</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Pendidikan</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Tenaga Kerja</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                    </div>

                    <div class="view-all" style="text-align: center; margin-top: 20px;">
                        <a href="lowongan.php" style="text-decoration: none; font-weight: bold; color: #007BFF;">Lihat Selengkapnya →</a>
                    </div>
                </div>


                <br><br><br>
                <h2 class="section__title" style="text-align: center" data-aos="fade-up">Gabung Bersama Kami</h2>
                <span class="section__subtitle" style="text-align: center" data-aos="fade-up">
                "S-Match telah membantu peserta dalam melaksanakan program magang berkualitas di Sidoarjo. Temukan peluang magang terbaik untuk karier masa depan Anda!"</span><br>
                <div class="popular__container swiper">
                    <div class="swiper-wrapper">
                        <article class="popular__card swiper-slide" style="text-align: center;">
                            <a href="lowongan.php">
                                <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                <div class="popular__data">
                                    <h2 class="popular__price"><span>Dinas </span>Komunikasi dan Informatika</h2>
                                    <!-- <h3 class="popular__title">Lemah Putro</h3> --><br>
                                    <p class="popular__description">
                                        <i class="bx bx-briefcase"></i> 3 Lowongan <br />
                                        <i class="bx bxs-group"></i> 5 Pemagang Aktif
                                    </p>
                                </div>
                            </a>
                        </article>

                        <article class="popular__card swiper-slide" style="text-align: center;">
                            <a href="lowongan.php">
                                <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                <div class="popular__data">
                                    <h2 class="popular__price"><span>Dinas </span>Kesehatan</h2>
                                    <!-- <h3 class="popular__title">Lemah Putro</h3> --><br>
                                    <p class="popular__description">
                                        <i class="bx bx-briefcase"></i> 3 Lowongan <br />
                                        <i class="bx bxs-group"></i> 5 Pemagang Aktif
                                    </p>
                                </div>
                            </a>
                        </article>

                        <article class="popular__card swiper-slide" style="text-align: center;">
                            <a href="lowongan.php">
                                <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                <div class="popular__data">
                                    <h2 class="popular__price"><span>Dinas </span>Perikanan</h2>
                                    <!-- <h3 class="popular__title">Lemah Putro</h3> --><br>
                                    <p class="popular__description">
                                        <i class="bx bx-briefcase"></i> 3 Lowongan <br />
                                        <i class="bx bxs-group"></i> 5 Pemagang Aktif
                                    </p>
                                </div>
                            </a>
                        </article>
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
