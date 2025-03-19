<?php
session_set_cookie_params(25200); // 25200 detik = 7 jam
session_start();
include "../functions.php";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM tb_user u, tb_profile_user pu WHERE u.email = '$email' AND u.id_user = pu.id_user";

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
        if ($row2['id_pengajuan']){
            $_SESSION['id_pengajuan'] = $row2['id_pengajuan'];
            $id_pengajuan = $_SESSION['id_pengajuan'];
            $_SESSION['status_pengajuan'] = $row2['status_pengajuan']; // Simpan status pengajuan ke session
            $status_pengajuan = $_SESSION['status_pengajuan']; // Ambil status pengajuan dari session
        }if (!empty($row2['status_pengajuan'])) {
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
} else{
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
                <?php if($level == '1') : ?>
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
                        <a href="super1_pendidikan.php" class="sidebar-link text-decoration-none">
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
                <?php if($level == "2") : ?>
                    <li class="sidebar-item">
                        <a href="admin2_instansi.php" class="sidebar-link">
                            <i class="bi bi-buildings"></i>
                            <span>Kelola Instansi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="admin2_bidang.php" class="sidebar-link">
                            <i class="bi bi-building-fill-add"></i>
                            <span>Kelola Bidang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="admin2_pembimbing.php" class="sidebar-link">
                            <i class="bi bi-person-workspace"></i>
                            <span>Pembimbing Bidang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="admin2_pengajuan.php" class="sidebar-link">
                            <i class="bi bi-journals"></i>
                            <span>Kelola Pengajuan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="admin2_user.php" class="sidebar-link">
                            <i class="bi bi-people"></i>
                            <span>Daftar Pemagang</span>
                        </a>
                    </li>
                <?php endif; ?>


                <!-- ========== USER ========== -->
                <?php 
                    if ($ketua && $level == '3'){?>
                        <li class="sidebar-item">
                            <a href="status_pengajuan.php" class="sidebar-link">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Pengajuan</span>
                            </a>
                        </li>
                <?php
                    }
                ?>

                <?php if(($ketua || $anggota) && $level == '3') : ?>
                <li class="sidebar-item">
                    <a href="kegiatan_aktif.php" class="sidebar-link">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Kegiatan Aktif</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php
                if (isset($status_pengajuan) && $status_pengajuan == '4') { ?>
                    <li class="sidebar-item">
                        <a href="logbook_daftar.php" class="sidebar-link">
                            <i class="bi bi-journal-check"></i>
                            <span>Logbook Harian</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="laprak_daftar.php" class="sidebar-link">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            <span>Laporan Akhir</span>
                        </a>
                    </li>
                <?php
                }
                ?>

                <?php if(($ketua || $anggota) && $level == '3') : ?>
                <li class="sidebar-item">
                    <a href="histori.php" class="sidebar-link">
                        <i class="bi bi-clock-history"></i>
                        <span>Histori</span>
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
                                alt="<?= $row['nama_user'] ?>" class="avatar img-fluid rounded-circle">
                            </a>
                                <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                                    <a href="profil.php?id_user=<?= $id_user ?>" class="dropdown-item">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Profile Saya</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="setting.php" class="dropdown-item">
                                        <i class="bi bi-gear"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                    <a href="bantuan.php" class="dropdown-item">
                                        <i class="bi bi-question-circle"></i>
                                        <span>Pusat Bantuan</span>
                                    </a>
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
            
    <script src="../assets/js/alert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Sertakan JS: jQuery, Bootstrap, dan DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>