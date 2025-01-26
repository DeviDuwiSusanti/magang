<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="./assets/libraries/swiper-bundle.min.css" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/home.css" />
    <style>
        
        .lowongan .lowongans {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .slide-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .carousel img {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
        }

        .details-button {
            display: inline-block; 
            background: linear-gradient(90deg, #4CAF50, #2D9CDB); 
            color: #fff; 
            text-decoration: none; 
            font-weight: bold; 
            padding: 10px 20px; 
            border-radius: 25px; 
            text-align: center
        }
    </style>

    <title>Home</title>
</head>

<body>
    <?php include "assets/layout/navbarUser.php" ?>

    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <section>
            <div class="swiper-container">
                <div>
                    <section class="islands">
                        <img src="assets/img/bgHome.jpg" alt="" class="islands__bg" />
                        <div class="bg__overlay">
                            <div class="islands__container container">
                                <div class="islands__data" style="z-index: 99; position: relative">
                                    <h2 class="islands__subtitle">
                                        Explore
                                    </h2>
                                    <h1 class="islands__title">
                                        Sidoarjo Internship
                                    </h1>
                                    <p class="islands__description">
                                    Dapatkan pengalaman berharga <br>dan kembangkan potensi Anda
                                    melalui program magang di Sidoarjo.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>

        <!--==================== POPULAR ====================-->
        <section class="section" id="popular">
            <div class="container">
                <h2 class="section__title" style="text-align: center">Manfaat</h2>
                <span class="section__subtitle" style="text-align: center">
                "Ikutlah magang kami di Sidoarjo, di mana banyak sekali peluang menanti untuk membentuk masa depan Anda!"</span><br>
                    
                <div class="slide-container">
                    <!-- Carousel -->
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">

                        <!-- Indicators/dots -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
                        </div>

                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="assets/img/home1.jpg" alt="Los Angeles" class="d-block">
                                <div class="carousel-caption">
                                    <h3>Pengalaman Berharga</h3>
                                    <p>Pembelajaran langsung untuk meningkatkan keterampilan Anda</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="assets/img/home2.jpg" alt="Chicago" class="d-block">
                                <div class="carousel-caption">
                                    <h3>Peluang Karir</h3>
                                    <p>Membuka pintu untuk prospek pekerjaan di masa depan</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="assets/img/home3.jpg" alt="New York" class="d-block">
                                <div class="carousel-caption">
                                    <h3>Jaringan Profesional</h3>
                                    <p>CTerhubung dengan perusahaan terkemuka di Sidoarjo</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="assets/img/home4.jpg" alt="New York" class="d-block">
                                <div class="carousel-caption">
                                    <h3>Pertumbuhan Pribadi</h3>
                                    <p>Tingkatkan kepercayaan diri dan kemampuan beradaptasi Anda</p>
                                </div>
                            </div>
                        </div>

                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>

                <br><br><br>
                <h2 class="section__title" style="text-align: center">Temukan Peluang Magang Terbaik di Sidoarjo</h2>
                <span class="section__subtitle" style="text-align: center">
                "Sidoarjo Internship menyediakan berbagai program magang yang sesuai dengan keterampilan dan minatmu. Daftar sekarang dan ambil langkah pertama menuju masa depan karirmu. Kesuksesan dimulai dari sini!"</span><br>
                <br><br>
                <div class="lowongan">
                    <div class="lowongans">
                    <article class="popular__card swiper-slide">
                        <img src="assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                        <p>Dinas Komunikasi dan Informatika</p>
                        <div class="popular__data">
                            <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                            <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                            <hr style="border: 1px solid #ddd; margin: 10px 0;">
                            <p class="popular__details">
                                <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pendaftar: <span class="total-pendaftar">120</span><br>
                                <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                            </p>
                            <a href="user/lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                        </div>
                    </article>

                        <article class="popular__card swiper-slide">
                            <img src="assets/img/instansi/dinas.png" alt="" class="popular__img"
                                style="width: 50px; height: 50px;" />
                            <p>Dinas Kesehatan</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pendaftar: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="user/lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/instansi/dinas.png" alt="" class="popular__img"
                                style="width: 50px; height: 50px;" />
                            <p>Dinas Perikanan</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pendaftar: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="user/lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Sosial</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pendaftar: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="user/lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Pendidikan</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pendaftar: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="user/lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Tenaga Kerja</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pendaftar: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="user/lowongan.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                    </div>

                    <div class="view-all" style="text-align: center; margin-top: 20px;">
                        <a href="user/lowongan.php" style="text-decoration: none; font-weight: bold; color: #007BFF;">Lihat Selengkapnya →</a>
                    </div>
                </div>


                <br><br><br>
                <h2 class="section__title" style="text-align: center">Gabung Bersama Kami</h2>
                <span class="section__subtitle" style="text-align: center">
                "S-Match telah membantu peserta dalam melaksanakan program magang berkualitas di Sidoarjo. Temukan peluang magang terbaik untuk karier masa depan Anda!"</span><br>
                <div class="popular__container swiper">
                    <div class="swiper-wrapper">
                        <article class="popular__card swiper-slide" style="text-align: center;">
                            <a href="user/lowongan.php">
                                <img src="assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                <div class="popular__data">
                                    <h2 class="popular__price"><span>Dinas </span>Komunikasi dan Informatika</h2>
                                    <!-- <h3 class="popular__title">Lemah Putro</h3> --><br>
                                    <p class="popular__description">
                                        <i class="bx bx-briefcase"></i> 3 Lowongan <br />
                                        <i class="bx bxs-group"></i> 50 Pendaftar
                                    </p>
                                </div>
                            </a>
                        </article>

                        <article class="popular__card swiper-slide" style="text-align: center;">
                            <a href="user/lowongan.php">
                                <img src="assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                <div class="popular__data">
                                    <h2 class="popular__price"><span>Dinas </span>Kesehatan</h2>
                                    <!-- <h3 class="popular__title">Lemah Putro</h3> --><br>
                                    <p class="popular__description">
                                        <i class="bx bx-briefcase"></i> 3 Lowongan <br />
                                        <i class="bx bxs-group"></i> 50 Pendaftar
                                    </p>
                                </div>
                            </a>
                        </article>

                        <article class="popular__card swiper-slide" style="text-align: center;">
                            <a href="user/lowongan.php">
                                <img src="assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                <div class="popular__data">
                                    <h2 class="popular__price"><span>Dinas </span>Perikanan</h2>
                                    <!-- <h3 class="popular__title">Lemah Putro</h3> --><br>
                                    <p class="popular__description">
                                        <i class="bx bx-briefcase"></i> 3 Lowongan <br />
                                        <i class="bx bxs-group"></i> 50 Pendaftar
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
            </div>
        </section>

        <?php include "assets/layout/footerUser.php" ?>
</body>

</html>
