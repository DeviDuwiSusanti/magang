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
    <?php include "../assets/layout/navbarUser.php" ?>

    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <section>
            <div class="swiper-container">
                <div>
                    <!--========== ISLANDS ==========-->
                    <section class="islands">
                        <img src="assets/img/bromo.jpg" alt="" class="islands__bg" />
                        <div class="bg__overlay">
                            <div class="islands__container container">
                                <div class="islands__data" style="z-index: 99; position: relative">
                                    <h2 class="islands__subtitle">
                                        Explore
                                    </h2>
                                    <h1 class="islands__title">
                                        Wonderful Bromo
                                    </h1>
                                    <p class="islands__description">
                                        This is a great time travel and
                                        enjoy the <br />
                                        beauty of Bromo.
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

        <!--==================== FOOTER ====================-->
        <footer class="footer section">
            <div class="footer__container container grid">
                <div>
                    <a href="#" class="footer__logo">
                        ACALA BR<i class="bx bxs-map"></i>MO
                    </a>
                    <p class="footer__description">
                    Our vision is to provide the best travel experiences <br>
                    in Bromo and unforgettable adventures.
                    </p>
                </div>

                <div class="footer__content">
                    <div>
                        <h3 class="footer__title">About</h3>

                        <ul class="footer__links">
                            <li>
                                <a href="#" class="footer__link">About Us</a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Features </a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">News & Blog</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="footer__title">Company</h3>

                        <ul class="footer__links">
                            <li>
                                <a href="#" class="footer__link">How We Work?
                                </a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Capital </a>
                            </li>
                            <li>
                                <a href="#" class="footer__link"> Security</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="footer__title">Support</h3>

                        <ul class="footer__links">
                            <li>
                                <a href="#" class="footer__link">FAQs </a>
                            </li>
                            <li>
                                <a href="#" class="footer__link">Support center
                                </a>
                            </li>
                            <li>
                                <a href="#" class="footer__link"> Contact Us</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="footer__title">Follow us</h3>

                        <ul class="footer__social">
                            <a href="#" class="footer__social-link">
                                <i class="bx bxl-facebook-circle"></i>
                            </a>
                            <a href="https://www.instagram.com/acala_bromo?igsh=MTB4dmFkcmFnNnht"
                                class="footer__social-link">
                                <i class="bx bxl-instagram-alt"></i>
                            </a>
                            <a href="#" class="footer__social-link">
                                <i class="bx bxl-pinterest"></i>
                            </a>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer__info container">
                <span class="footer__copy">
                    &#169; Acala Bromo. All rigths reserved
                </span>
                <div class="footer__privacy">
                    <a href="#">Terms & Agreements</a>
                    <a href="#">Privacy Policy</a>
                </div>
            </div>
        </footer>

        <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class="bx bx-chevrons-up"></i>
        </a>

        <script src="https://unpkg.com/scrollreveal"></script>

        <!--=============== SCROLLREVEAL ===============-->
        <script src="../assets/libraries/scrollreveal.min.js"></script>

        <!--=============== SWIPER JS ===============-->
        <script src="../assets/libraries/swiper-bundle.min.js"></script>

        <!--=============== MAIN JS ===============-->
        <script src="../assets/js/main.js"></script>
</body>

</html>