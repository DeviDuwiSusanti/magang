<?php
include "../koneksi.php";

function getBidangInstansi($conn) {
    $sql = "SELECT tb_bidang.*, tb_instansi.*, tb_bidang.change_date AS bidang_change_date, tb_instansi.change_date AS instansi_change_date FROM tb_bidang, tb_instansi 
            WHERE tb_bidang.status_active = 'Y' 
            AND tb_bidang.id_instansi = tb_instansi.id_instansi";
    return mysqli_query($conn, $sql);
}

// Pemagang aktif dari 1 instansi tiap bidang
function getPemagangAktif1($conn, $id_instansi, $id_bidang) {
    $sql = "SELECT COUNT(*) FROM tb_pengajuan WHERE status_active = 'Y' AND id_instansi = '$id_instansi' 
            AND id_bidang = '$id_bidang'";

    $result = mysqli_query($conn, $sql);
    $count1 = mysqli_fetch_array($result)[0]; // Ambil hasil COUNT(*)

    return $count1;
}

// Jumlah total pemagang aktif dari 1 instansi
function getPemagangAktif2($conn, $id_instansi) {
    $sql = "SELECT COUNT(*) FROM tb_pengajuan WHERE status_active = 'Y' AND id_instansi = '$id_instansi'";

    $result = mysqli_query($conn, $sql);
    $count2 = mysqli_fetch_array($result)[0]; // Ambil hasil COUNT(*)

    return $count2;
}


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
    <link rel="stylesheet" href="../assets/css/web.css" />
    <link rel="stylesheet" href="../assets/css/style2.css" />
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
                        $query = getBidangInstansi($conn);
                        while ($row = mysqli_fetch_assoc($query)){  
                            $pemagang_aktif = getPemagangAktif1($conn, $row['id_instansi'], $row['id_bidang']);
                            ?>
                            <article class="popular__card swiper-slide">
                                <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                <p><?= $row['nama_panjang'] ?></p>
                                <div class="popular__data">
                                    <h3 class="popular__title">Internship - <?= $row['nama_bidang'] ?></h3>
                                    <p class="popular__description"><?= $row['alamat_instansi'] ?></p>
                                    <hr style="border: 1px solid #ddd; margin: 10px 0;">
                                    <p class="popular__details">
                                        <span class="icon" style="margin-right: 5px;">&#128101;</span> Pemagang Aktif: <span class="total-pendaftar"><?= $pemagang_aktif ?></span><br>
                                        <span class="icon" style="margin-right: 5px;">&#128197;</span> Dibuat pada: <span class="creation-date"><?= $row['bidang_change_date'] ?></span>
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


                <br><br><br>
                <h2 class="section__title" style="text-align: center" data-aos="fade-up">Gabung Bersama Kami</h2>
                <span class="section__subtitle" style="text-align: center" data-aos="fade-up">
                "S-Match telah membantu peserta dalam melaksanakan program magang berkualitas di Sidoarjo. Temukan peluang magang terbaik untuk karier masa depan Anda!"</span><br>
                <div class="popular__container swiper">
                    <div class="swiper-wrapper">
                    <?php
                        $query = getBidangInstansi($conn);
                        while ($row = mysqli_fetch_assoc($query)){
                            $pemagang_aktif = getPemagangAktif2($conn, $row['id_instansi']);
                            $nama_instansi = $row['nama_panjang'];
                            $kata_pertama = explode(' ', $nama_instansi)[0]; // Pecah string dan ambil kata pertama

                            $sql2 = "SELECT COUNT(*) AS jumlah_lowongan FROM tb_bidang WHERE id_instansi = '$row[id_instansi]'";
                            $query2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($query2);
                            $jumlah_lowongan = $row2['jumlah_lowongan'] ?? 0; // Jika tidak ada lowongan, default 0
                            ?>
                            <article class="popular__card swiper-slide" style="text-align: center;">
                                <a href="<?= $row['deskripsi_instansi'] ?>" target="_blank">
                                    <img src="../assets/img/instansi/dinas.png" alt="" class="popular__img" style="width: 50px; height: 50px;" />
                                    <div class="popular__data">
                                        <h2 class="popular__price"><span><?php echo $kata_pertama; ?> </span> 
                                        <?php echo str_replace($kata_pertama, '', $nama_instansi); ?></h2>
                                        <br>
                                        <p class="popular__description">
                                            <i class="bx bx-briefcase"></i> <?= $row2['jumlah_lowongan'] ?> Lowongan <br />
                                            <i class="bx bxs-group"></i> <?= $pemagang_aktif ?> Pemagang Aktif
                                        </p>
                                    </div>
                                </a>
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