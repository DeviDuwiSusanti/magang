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

    <title>About</title>
</head>

<body>
    <?php include "../assets/layout/navbarUser.php" ?>
    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <section>
            <div class="swiper-container gallery-top">
                <div class="swiper-wrapper">
                    <!--========== ISLANDS 1 ==========-->
                    <section class="islands swiper-slide">
                        <img src="../assets/img/home2.jpg" alt="" class="islands__bg" />
                        <div class="bg__overlay">
                            <div class="islands__container container">
                                <div class="islands__data">
                                    <h2 class="islands__subtitle">
                                        Need Intership
                                    </h2>
                                    <h1 class="islands__title">
                                        About Us
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>

        <!--==================== About ====================-->
        <section class="contact section" id="contact">
            <div class="contact__container container grid">
                <div class="contact__images">
                    <div class="contact__orbe"></div>
                        <div class="contact__img">
                            <img src="../assets/img/home4.jpg" alt="" />
                        </div>
                    </div>

                    <div class="contact__content">
                        <div class="contact__data">
                            <span class="section__subtitle">Butuh Bantuan?</span>
                            <h2 class="section__title">
                                Jangan khawatir!
                            </h2>
                            <p class="contact__description">
                            Jika Anda menghadapi kendala dalam mencari program magang atau memerlukan panduan lebih lanjut, kami menyediakan informasi lengkap di platform ini untuk membantu Anda. Eksplor semua fitur dan temukan solusi terbaik untuk kebutuhan magang Anda! 
                            </p>
                        </div>
                        <!-- MENU TUTORIAL -->
                        <div class="contact__card">
                            <!-- Cara Daftar -->
                            <div class="contact__card-box">
                                <div class="contact__card-info">
                                    <i class="bx bx-user-plus"></i> <!-- Ikon untuk "Cara Daftar" -->
                                    <div>
                                        <h3 class="contact__card-title">Cara Daftar</h3>
                                    </div>
                                </div>
                                <a href="about_daftar.php" target="_blank">
                                    <button class="button contact__card-button">Lihat</button>
                                </a>
                            </div>

                            <!-- Cek Status -->
                            <div class="contact__card-box">
                                <div class="contact__card-info">
                                    <i class="bx bx-search-alt"></i> <!-- Ikon untuk "Cek Status" -->
                                    <div>
                                        <h3 class="contact__card-title">Cek Status</h3>
                                    </div>
                                </div>
                                <a href="about_status.php" target="_blank">
                                    <button class="button contact__card-button">Lihat</button>
                                </a>
                            </div>

                            <!-- Unggah Logbook -->
                            <div class="contact__card-box">
                                <div class="contact__card-info">
                                    <i class="bx bx-upload"></i> <!-- Ikon untuk "Unggah Logbook" -->
                                    <div>
                                        <h3 class="contact__card-title">Unggah Logbook</h3>
                                    </div>
                                </div>
                                <a href="about_logbook.php" target="_blank">
                                    <button class="button contact__card-button">Lihat</button>
                                </a>
                            </div>

                            <!-- Cek Sertifikat -->
                            <div class="contact__card-box">
                                <div class="contact__card-info">
                                    <i class="bx bx-certificate"></i> <!-- Ikon untuk "Cek Sertifikat" -->
                                    <div>
                                        <h3 class="contact__card-title">Cek Sertifikat</h3>
                                    </div>
                                </div>
                                <a href="about_sertifikat.php" target="_blank">
                                    <button class="button contact__card-button">Lihat</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

   <?php include "../assets/layout/footerUser.php" ?>
</body>

</html>