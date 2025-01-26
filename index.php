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
        .destinasi .destination {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
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
                    <!--========== ISLANDS ==========-->
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
                                        Gain valuable experience and develop your potential <br/>
                                        through an internship program in Sidoarjo.
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
                <h2 class="section__title" style="text-align: center">Destination Place</h2>
                <span class="section__subtitle" style="text-align: center">"Let's go to Bromo, where endless adventures
                    await to be explored!"</span><br>
                
                <!---========== Text and image layout=======-->
                <div class="custom-container">
                <!-- Center Text -->
                <div class="center-text">
                    <div class="text-block">
                        <p class="large-text">6</p>
                        <p class="small-text">Company</p>
                    </div>
                    <div class="text-block">
                        <p class="large-text">6</p>
                        <p class="small-text">Internship Vacancies</p>
                    </div>
                    <div class="text-block">
                        <p class="large-text">+950</p>
                        <p class="small-text">Registrant</p>
                    </div>
                </div>
                <div class="destinasi">
                    <div class="destination">
                        <article class="popular__card swiper-slide ">
                            <img src="assets/img/kawah.jpeg" alt="" class="popular__img"
                                style="width: 389px; height: 332px;" />
                            <div class="popular__data">
                                <h3 class="popular__title">Kawah Bromo</h3>
                                <p class="popular__description">Kawah Gunung Bromo bagi masyarakat Suku Tengger
                                    adalah tempat terakhir untuk melemparkan persembahan bagi dewa Brahma atau tuhan
                                    mereka yaitu Syah hyang widhi wasa.</p>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/lembah.jpeg" alt="" class="popular__img"
                                style="width: 389px; height: 332px;" />
                            <div class="popular__data">
                                <h3 class="popular__title">Lembah Widodaren</h3>
                                <p class="popular__description">Lembah Widodaren berada di Kawasan Wisata Bromo,
                                    terletak tepat di belakang Gunung Bromo dan sebelah Gunung Kursi serta Gunung
                                    Batok.</p>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/poten.jpeg" alt="" class="popular__img"
                                style="width: 389px; height: 332px;" />
                            <div class="popular__data">
                                <h3 class="popular__title">Pura Luhur Poten</h3>
                                <p class="popular__description">Berlokasi di bawah kaki Kawah Bromo, Pura Luhur
                                    Poten menjadi tempat ibadah nan sakral bagi Suku Tengger yang menghuni kawasan
                                    Taman Nasional Bromo di Jawa Timur. Pura tersebut juga erat kaitannya dengan
                                    Upacara Yadya Kasada yang rutin diselenggarakan setiap tahun</p>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/sun.png" alt="" class="popular__img"
                                style="width: 389px; height: 332px;" />
                            <div class="popular__data">
                                <h3 class="popular__title">Sunrise Point</h3>
                                <p class="popular__description">Pananjakan 1 termasuk spot yang paling terkenal dan
                                    populer di kalangan explorer dan pemburu sunrise Gunung Bromo, kebanyakan hasil
                                    dokumentasi pemandangan pagi Bromo dengan latar belakang gunung-gunung eksotis
                                    disekitarnya dan telah tersebar meluas diambil dari spot Pananjakan 1.</p>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/pasir1.png" alt="" class="popular__img"
                                style="width: 389px; height: 332px;" />
                            <div class="popular__data">
                                <h3 class="popular__title">Pasir Berbisik</h3>
                                <p class="popular__description">Kawasan ini sendiri berada di bagian timur dari
                                    kawah Bromo. Lautan pasir itu sendiri sebenarnya ialah kaldera raksasa, bagian
                                    dari kawasan pegunungan tengger yang diameternya sekitar 8-10 Km.</p>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="assets/img/teletubis.jpeg" alt="" class="popular__img"
                                style="width: 389px; height: 332px;" />
                            <div class="popular__data">
                                <h3 class="popular__title">Bukit Teletubbies</h3>
                                <p class="popular__description">Bukit Teletubbies Bromo merupakan sabana yang
                                    luasnya mencapai 382 hektar. Di tempat itu juga terdapat bukit-bukit yang
                                    dipenuhi warna hijau. Di sana ditumbuhi banyak tanaman, antara lain pakis,
                                    ilalang, lavender, dan berbagai jenis rumput.</p>
                            </div>
                            </a>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <?php include "assets/layout/footerUser.php" ?>
</body>

</html>