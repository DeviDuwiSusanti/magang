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
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/low.css" />
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
                With Our Experience </br> We Will Serve You
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
        <h2 class="section__title" style="text-align: center" data-aos="fade-up">Explore Our Internship Opportunities</h2>
        <div class="search-container" style="text-align: center; margin-bottom: 20px;">
            <div class="search-wrapper">
                <input type="text" id="searchInput" class="search-input" placeholder="Cari Instansi atau Bidang..." />
                <i id="searchIcon" class="fas fa-search search-icon"></i>
            </div>
        </div>
            <section class="section" id="popular" data-aos="fade-up">
                <div class="container">
                    <div class="lowongan">
                        <div class="lowongans">
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Komunikasi dan Informatika</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
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
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
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
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
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
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
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
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Pendidikan</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang TIK</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <!-- Lowongan tambahan -->
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Tenaga Kerja</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61213</p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                            </a>
                        </article>
                        <article class="popular__card">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p>Dinas Tenaga Kerja</p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - Bidang Komunikasi Informatika</h3>
                                <p class="popular__description">Jl. Diponegoro No.139, Lemah Putro, Lemahputro, Kec. Sidoarjo...</p>
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Total Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date">25 Januari 2025</span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                        </article>
                    </div>

                    <div class="view-all">
                        <i id="viewMore" class="details-button fa fa-arrow-down"></i>
                    </div>
                </div>
            </div>
        </section>
        <?php include "../layout/footerUser.php" ?>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cards = document.querySelectorAll(".popular__card");
            const viewMoreButton = document.getElementById("viewMore");

            // Tampilkan 4 lowongan pertama
            cards.forEach((card, index) => {
                if (index < 4) {
                    card.classList.add("visible");
                }
            });

            viewMoreButton.addEventListener("click", () => {
                cards.forEach(card => card.classList.add("visible"));
                viewMoreButton.style.display = "none"; // Sembunyikan tombol setelah klik
            });
        });
    </script>
</body>
</html>