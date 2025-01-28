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
    <link rel="stylesheet" href="../assets/css/home.css" />
    <style>
        #profile-table td {
            padding: 8px;
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
                    <section class="islands">
                        <img src="../assets/img/bgHome.jpg" alt="" class="islands__bg" />
                        <div class="bg__overlay">
                            <div class="islands__container container">
                                <div class="islands__data" style="z-index: 99; position: relative">
                                    <h2 class="islands__subtitle">
                                        Explore
                                    </h2>
                                    <h1 class="islands__title">
                                        Your Profile
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
        <section class="section" id="profile">
            <div class="container">
                <div class="row">
                    <!-- Article Kiri -->
                    <div class="col-md-4">
                        <article class="profile__card text-center p-3">
                            <img src="../assets/img/avatar1.png" alt="Foto Profil" class="rounded-circle mb-3" style="width: 100px; height: 100px;" />
                            <h3 class="profile__name">Heviaa</h3>
                            <hr style="border: 1px solid #ddd; margin: 10px 0;">
                            <div class="profile__menu">
                                <a href="#home" class="btn btn-outline-primary btn-sm mb-2 w-100">
                                    <i class="bx bx-send"></i> Pengajuan
                                </a>
                                <a href="#lowongan" class="btn btn-outline-secondary btn-sm mb-2 w-100">
                                    <i class="bx bx-loader-circle"></i> Status Pengajuan
                                </a>
                                <a href="#pengajuan" class="btn btn-outline-success btn-sm mb-2 w-100">
                                    <i class="bx bx-task"></i> Kegiatan Aktif
                                </a>
                                <a href="#about" class="btn btn-outline-info btn-sm w-100">
                                    <i class="bx bx-history"></i> Histori
                                </a>
                            </div>
                        </article>
                    </div>

                    <!-- Article Kanan -->
                    <div class="col-md-8">
                        <article class="profile__data p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2>Data Profil Pengguna</h2>
                                <!-- Tombol Edit Profil -->
                                <a href="edit_profil.php" class="btn btn-outline-secondary btn-sm">
                                    <i class="bx bx-edit"></i> Edit Profil
                                </a>
                            </div>
                            <hr style="border: 1px solid #ddd; margin: 10px 0;">
                            <table id="profile-table">
                                <tbody>
                                    <tr>
                                        <td><strong>Nama Lengkap </strong></td>
                                        <td>: Heviaa</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>: heviaa@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIK</strong></td>
                                        <td>: 35227247635247</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tempat Lahir</strong></td>
                                        <td>: Bojonegoro</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Lahir</strong></td>
                                        <td>: 17 Agustus 2005</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Telepon</strong></td>
                                        <td>: 0865327432</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat</strong></td>
                                        <td>: Jl. Diponegoro No.139, Lemah Putro, Sidoarjo, Jawa Timur</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Asal Studi</strong></td>
                                        <td>: Universitas Trunojoyo Madura</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr style="border: 1px solid #ddd; margin: 10px 0;">
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <?php include "../assets/layout/footerUser.php" ?>
</body>

</html>


