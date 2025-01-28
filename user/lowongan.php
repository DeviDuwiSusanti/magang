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
    <link rel="stylesheet" href="../assets/libraries/swiper-bundle.min.css" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/lowongan.css" />
    <link rel="stylesheet" href="../assets/css/home.css"/>
    <style>
        .transparent-img {
            filter: grayscale(100%);
            opacity: 0.5;
        }

        .popular__card {
            position: relative;
        }

        .sold-out-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            font-style: italic;
            font-weight: bold;
            border-radius: 100px;
            z-index: 10;
        }
    </style>

    <title>Home</title>
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

    <!--==================== POPULAR ====================-->
    <section class="section" id="popular">
        <div class="container">
            <h2 class="section__title" style="text-align: center">
                With Our Experience </br> We Will Serve You
            </h2></br>

    <!---========== Text and image layout=======-->
    <div class="custom-container">
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
            <!-- Left Portrait Image -->
            <div class="left-column">
                <img src="../assets/img/pw2.jpg" alt="Left Portrait Image" class="custom-image">
            </div>
            <!-- Right Portrait Image -->
            <div class="right-column">
                <img src="../assets/img/pw1.jpg" alt="Right Portrait Image" class="custom-image">
                <img src="../assets/img/pw3.jpg" alt="Bottom Portrait Image" class="custom-image image-spacing">
            </div>
        </div>
    </div>

    <!--==================== Carieer ====================-->
    <h2 class="section__title" style="text-align: center">Explore Our Internship Opportunities</h2>
    <div class="popular__all">
        <section class="section" id="popular">
            <div class="container">
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
                </div>
            </div>
        </section>
        <?php include "../assets/layout/footerUser.php" ?>
    </main>
</body>

</html>