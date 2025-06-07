<?php
session_set_cookie_params(25200); // 25200 detik = 7 jam
session_start();
include "../functions.php";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM tb_user u, tb_profile_user pu WHERE u.email = '$email' AND u.id_user = pu.id_user AND u.status_active = '1'";

    $hasil = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($hasil);
    $_SESSION['id_user'] = $row['id_user']; // Ambil id_user dari sesi login
    $_SESSION['level'] = $row['level'];

    $id_user = $_SESSION['id_user'];
    $level = $_SESSION['level'];

    $id_pengajuan = null; // Inisialisasi default

    if ($row && !empty($row['id_pengajuan'])) {
        $sql2 = "SELECT * FROM tb_pengajuan WHERE id_pengajuan = '$row[id_pengajuan]' AND status_active = '1'";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        if ($row2['id_pengajuan']) {
            $_SESSION['id_pengajuan'] = $row2['id_pengajuan'];
            $id_pengajuan = $_SESSION['id_pengajuan'];
            $_SESSION['status_pengajuan'] = $row2['status_pengajuan']; // Simpan status pengajuan ke session
            $status_pengajuan = $_SESSION['status_pengajuan']; // Ambil status pengajuan dari session
        }
        if (!empty($row2['status_pengajuan'])) {
            $_SESSION['status_pengajuan'] = $row2['status_pengajuan'];
        } else {
            echo "status_pengajuan kosong!";
        }
    }
    // inisialisasi apakah anggota atau ketua kelompok
    $lastTwoDigits = substr($id_user, -2); // 2 digit terakhir dari id_user

    $ketua = ($lastTwoDigits === '00') ? true : false;
    $anggota = !$ketua;

    // Simpan ke session
    $_SESSION['ketua'] = $ketua;
    $_SESSION['anggota'] = $anggota;
} else {
    echo "<script> window.location.href='../login.php' </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/admin_instansi.css">
    <link rel="stylesheet" href="../assets/css/style_super_admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
    <link rel="icon" href="../assets/img/logo_kab_sidoarjo.png" type="image/png">
    <!-- aku ubah disini -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-grid"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="../web/beranda.php">Sistem Magang</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="bi bi-speedometer"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="profil.php" class="sidebar-link">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Profile</span>
                    </a>
                </li>


                <!-- ================================= super admin ================================== -->
                <?php if ($level == '1') : ?>
                    <li class="sidebar-item">
                        <a href="super1_instansi.php" class="sidebar-link text-decoration-none">
                            <i class="bi bi-buildings"></i>
                            <span>Instansi</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="super1_admin_instansi.php" class="sidebar-link text-decoration-none">
                            <i class="bi bi-building-fill-add"></i>
                            <span>Admin Instansi</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="super1_user.php" class="sidebar-link text-decoration-none">
                            <i class="bi bi-people"></i>
                            <span>User</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="pendidikan_user.php" class="sidebar-link text-decoration-none">
                            <i class="bi bi-mortarboard"></i>
                            <span>Pendidikan</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="super1_pengajuan.php" class="sidebar-link text-decoration-none">
                            <i class="bi bi-journals"></i>
                            <span>Pengajuan</span>
                        </a>
                    </li>

                <?php endif; ?>
                <!-- end of super admin =================================== -->




                <!-- ======================== level 2 admin instansi ========================= -->
                <?php if ($level == "2" && !empty($row['id_instansi'])) : ?>
                    <li class="sidebar-item">
                        <a href="admin2_instansi.php" class="sidebar-link">
                            <i class="bi bi-buildings"></i>
                            <span>Kelola Instansi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi"
                            aria-expanded="false" aria-controls="multi">
                            <i class="bi bi-building"></i>
                            <span>Bidang Instansi</span>
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="admin2_bidang.php" class="sidebar-link submenu-link">
                                    <i class="bi bi-building-fill-add"></i> <!-- Icon bulat kecil -->
                                    Kelola Bidang
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="admin2_pembimbing.php" class="sidebar-link submenu-link">
                                    <i class="bi bi-person-badge-fill"></i>
                                    Pembimbing Bidang
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi2"
                            aria-expanded="false" aria-controls="multi2">
                            <i class="bi bi-list-stars"></i>
                            <span>Pengajuan</span>
                        </a>
                        <ul id="multi2" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="jenis_pengajuan.php" class="sidebar-link submenu-link">
                                    <i class="bi bi-journal-bookmark-fill"></i> <!-- Icon bulat kecil -->
                                    Kelola Jenis Pengajuan
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="admin2_pengajuan.php" class="sidebar-link submenu-link">
                                    <i class="bi bi-send-check-fill"></i>
                                    Proses Pengajuan User
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="admin2_user.php" class="sidebar-link">
                            <i class="bi bi-people"></i>
                            <span>Daftar Pemagang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="pendidikan_user.php" class="sidebar-link text-decoration-none">
                            <i class="bi bi-mortarboard"></i>
                            <span>Pendidikan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi3"
                            aria-expanded="false" aria-controls="multi3">
                            <i class="bi bi-check-circle"></i>
                            <span>TTD & Sertifkat</span>
                        </a>
                        <ul id="multi3" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="admin2_tanda_tangan.php" class="sidebar-link submenu-link">
                                    <i class="bi bi-check"></i> <!-- Icon bulat kecil -->
                                    Tanda Tangan
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="admin2_sertifikat.php" class="sidebar-link submenu-link">
                                    <i class="bi bi-award"></i>
                                    Sertifikat
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>


                <!-- ========== USER ========== -->
                <?php
                if ($ketua && $level == '3') { ?>
                    <li class="sidebar-item">
                        <a href="user3_statusPengajuan.php" class="sidebar-link">
                            <i class="bi bi-file-earmark-text"></i>
                            <span>Pengajuan</span>
                        </a>
                    </li>
                <?php
                }
                ?>

                <?php if (($ketua || $anggota) && $level == '3') : ?>
                    <li class="sidebar-item">
                        <a href="user3_kegiatan_aktif.php" class="sidebar-link">
                            <i class="bi bi-clipboard-check"></i>
                            <span>Kegiatan Aktif</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php
                if (isset($status_pengajuan) && $status_pengajuan == '4') { ?>
                    <li class="sidebar-item">
                        <a href="user3_logbook.php" class="sidebar-link">
                            <i class="bi bi-journal-check"></i>
                            <span>Logbook Harian</span>
                        </a>
                    </li>
                <?php
                }
                ?>

                <?php if (isset($status_pengajuan) && $status_pengajuan == '5' && $level == '3'): ?>
                    <li class="sidebar-item">
                        <a href="user3_logbook.php" class="sidebar-link">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            <span>Laporan Akhir</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (($ketua || $anggota) && $level == '3') : ?>
                    <li class="sidebar-item">
                        <a href="user3_histori.php" class="sidebar-link">
                            <i class="bi bi-clock-history"></i>
                            <span>Histori</span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if ($level == 4): ?>
                    <!-- Daftar Peserta Magang -->
                    <li class="sidebar-item">
                        <a href="pembimbing4_persetujuan.php" class="sidebar-link">
                            <i class="bi bi-clipboard-check"></i>
                            <span>Peserta Magang</span>
                        </a>
                    </li>
                    <!-- Daftar Peserta Magang -->
                    <li class="sidebar-item">
                        <a href="pembimbing4.php" class="sidebar-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Peserta Magang</span>
                        </a>
                    </li>
                    <!-- Daftar Absesnsi Peserta Magang -->
                    <li class="sidebar-item">
                        <a href="pembimbing4_absensi.php" class="sidebar-link">
                            <i class="bi bi-emoji-frown"></i>
                            <span>Absesnsi Peserta</span>
                        </a>
                    </li>
                <?php endif; ?>



                <li class="sidebar-item">
                    <a href="setting.php" class="sidebar-link">
                        <i class="bi bi-gear"></i>
                        <span>Setting</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <a href="../logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-4 py-3">
                <button class="d-lg-none me-3" id="hamburger-btn">
                    <i class="bi bi-list"></i>
                </button>
                <div class="navbar-greeting d-flex flex-column justify-content-center me-auto">
                    <div id="greeting" class="fw-semibold greeting-text"></div>
                    <div id="clock" class="clock-text"></div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <!-- Tombol Toggle Dark Mode -->
                        <li class="nav-item d-flex align-items-center me-5">
                            <button id="mode-toggle" class="mode-toggle">
                                <i id="mode-icon" class="bi bi-moon-fill"></i>
                            </button>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="../assets/img/user/<?= !empty($row['gambar_user']) ? $row['gambar_user'] : 'avatar.png' ?>"
                                    alt="<?= $row['nama_user'] ?>" class="avatar img-fluid rounded-circle" style="object-fit: cover; object-position: top; border: 2px solid #ccc;">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                                <a href="profil.php?id_user=<?= $id_user ?>" class="dropdown-item">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Profile Saya</span>
                                </a>
                                <a href="../web/beranda.php" class="dropdown-item">
                                    <i class="bi bi-house-door"></i>
                                    <span>Beranda</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="setting.php" class="dropdown-item">
                                    <i class="bi bi-gear"></i>
                                    <span>Pengaturan</span>
                                </a>
                                <?php if ($level == 3) : ?>
                                    <a href="bantuan.php" class="dropdown-item">
                                        <i class="bi bi-question-circle"></i>
                                        <span>Pusat Bantuan</span>
                                    </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a href="../logout.php" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="loader hidden">
                <div class="spinner"></div>
                <p>Mohon tunggu sebentar...</p>
            </div>

            <script src="../assets/js/alert.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="../assets/js/script.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

            <!-- Sertakan JS: jQuery, Bootstrap, dan DataTables -->
            <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

            <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <!-- Inisialisasi DataTables -->
            <!-- <script>
                $(document).ready(function() {
                    $('#myTable').DataTable();
                });
            </script> -->

            <!-- Inisialisasi DataTables -->
            <script>
                // Toggle sidebar tampilan mobile
                const hamburgerBtn = document.getElementById('hamburger-btn');
                const sidebar = document.getElementById('sidebar');

                hamburgerBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('show-sidebar');
                });

                // Optional: klik di luar sidebar untuk nutup
                document.addEventListener('click', (e) => {
                    if (!sidebar.contains(e.target) && !hamburgerBtn.contains(e.target)) {
                        sidebar.classList.remove('show-sidebar');
                    }
                });

                function updateGreetingAndClock() {
                    const greetingElement = document.getElementById("greeting");
                    const clockElement = document.getElementById("clock");

                    // Cek apakah layar besar
                    const isDesktop = window.innerWidth >= 768;

                    if (!isDesktop) {
                        greetingElement.style.display = "none";
                        clockElement.style.display = "none";
                        return;
                    }

                    const now = new Date();
                    const hours = now.getHours();
                    const minutes = now.getMinutes().toString().padStart(2, '0');
                    const seconds = now.getSeconds().toString().padStart(2, '0');

                    const namaUser = "<?= $row['nama_user'] ?>";

                    let greeting;
                    if (hours >= 4 && hours < 11) {
                        greeting = "Selamat Pagi";
                    } else if (hours >= 11 && hours < 15) {
                        greeting = "Selamat Siang";
                    } else if (hours >= 15 && hours < 18) {
                        greeting = "Selamat Sore";
                    } else {
                        greeting = "Selamat Malam";
                    }

                    greetingElement.textContent = `${greeting}, ${namaUser}`;
                    clockElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes}:${seconds}`;

                    greetingElement.style.display = "inline";
                    clockElement.style.display = "inline";
                }

                // Update setiap detik
                setInterval(updateGreetingAndClock, 1000);
                updateGreetingAndClock();

                // Update saat ukuran layar berubah
                window.addEventListener('resize', updateGreetingAndClock);

                // Ambil semua link di sidebar
                const sidebarLinks = document.querySelectorAll('sidebar-link');

                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault(); // Cegah navigasi langsung

                        let loader = document.querySelector('.loader');

                        // Kalau loader sudah dihapus, buat ulang dari awal
                        if (!loader) {
                            loader = document.createElement('div');
                            loader.className = 'loader';
                            loader.innerHTML = `
                <div class="spinner"></div>
                <p>Mohon tunggu sebentar...</p>
            `;
                            document.body.appendChild(loader);
                        } else {
                            loader.classList.remove("hidden");
                        }

                        // Delay 2 detik sebelum navigasi ke link tujuan
                        setTimeout(() => {
                            window.location.href = link.href; // Navigasi ke link setelah delay
                        }, 2000); // 2000 ms = 2 detik
                    });
                });
            </script>
</body>

</html>