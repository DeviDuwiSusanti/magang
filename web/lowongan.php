<?php
include "koneksi.php";
$sql = "SELECT * FROM tb_bidang  WHERE status_active = '1'" ;
$query = mysqli_query($conn, $sql);

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

        <!-- Search Section -->
        <div class="search-container" style="text-align: center; margin-top: 10px">
            <div class="search-wrapper">
                <input type="text" id="searchInput" class="search-input" placeholder="Cari Instansi atau Bidang..." />
                <i id="searchIcon" class="fas fa-search search-icon"></i>
            </div>
        </div>

        <section class="section" id="popular">
            <div class="container">
            <h2 class="section__title" style="text-align: center" data-aos="fade-up">
            Temukan Peluang Magang Terbaik di Sidoarjo</h2>
            <span class="section__subtitle" style="text-align: center" data-aos="fade-up">
                    "Sidoarjo Internship menyediakan berbagai program magang yang sesuai dengan keterampilan dan minatmu. Daftar sekarang dan ambil langkah pertama menuju masa depan karirmu. Kesuksesan dimulai dari sini!"
                </span>
            <br><br><br>
            <div class="lowongan">
                <div class="lowongans" data-aos="fade-down">
                    <?php
                    // Menampilkan lowongan
                    while ($row = mysqli_fetch_assoc($query)) {
                        // Ambil data instansi berdasarkan id_instansi
                        $sql2 = "SELECT * FROM tb_instansi WHERE id_instansi = '$row[id_instansi]'";
                        $query2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($query2);
                    ?>
                        <article class="popular__card swiper-slide">
                            <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                            <p><?= $row2['nama_panjang'] ?></p>
                            <div class="popular__data">
                                <h3 class="popular__title">Internship - <?= $row['nama'] ?></h3>
                                <p class="popular__description"><?= $row2['alamat'] ?></p>
                                <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                <p class="popular__details">
                                    <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar">120</span><br>
                                    <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date"><?= $row['create_date'] ?></span>
                                </p>
                                <a href="detaillow.php"><button class="details-button">Lihat Detail →</button></a>
                            </div>
                        </article>
                    <?php
                    }
                    ?>
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
        const searchInput = document.getElementById("searchInput");
        const cards = document.querySelectorAll(".popular__card");
        const viewMoreButton = document.getElementById("viewMore");

        // Menambahkan event listener untuk pencarian
        searchInput.addEventListener("input", function () {
            const query = searchInput.value.toLowerCase(); // Ambil nilai input dan ubah jadi huruf kecil

            cards.forEach((card) => {
                const title = card.querySelector(".popular__title").textContent.toLowerCase(); // Ambil nama bidang
                const description = card.querySelector(".popular__description").textContent.toLowerCase(); // Ambil deskripsi

                // Filter card berdasarkan nama atau deskripsi yang sesuai dengan input
                if (title.includes(query) || description.includes(query)) {
                    card.style.display = "block"; // Tampilkan card jika cocok
                } else {
                    card.style.display = "none"; // Sembunyikan card jika tidak cocok
                }
            });
        });

        // Tampilkan 4 lowongan pertama
        cards.forEach((card, index) => {
            if (index < 4) {
                card.classList.add("visible");
            }
        });

        // Event listener untuk tombol 'Lihat Lebih Banyak'
        viewMoreButton.addEventListener("click", () => {
            cards.forEach(card => card.classList.add("visible"));
            viewMoreButton.style.display = "none"; // Sembunyikan tombol setelah klik
        });
    });
</script>

</body>
</html>