<?php
session_start();
include "../koneksi.php";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM tb_user 
            JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user 
            WHERE tb_user.email = '$email'";
    $hasil = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($hasil);
    $id_user = $row['id_user']; // Ambil id_user dari sesi login
    $level = $row['level'];
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
                <?php 
                    if ($level == 3){?>
                        <li class="sidebar-item">
                            <a href="profil.php" class="sidebar-link">
                                <i class="bi bi-person-lines-fill"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                <?php        
                    }
                ?>
                
                <li class="sidebar-item">
                    <a href="kegiatan_aktif.php" class="sidebar-link">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Kegiatan Aktif</span>
                    </a>
                </li>
                <?php 
                    if ($level == 3){?>
                        <li class="sidebar-item">
                            <a href="status_pengajuan.php" class="sidebar-link">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Status Pengajuan</span>
                            </a>
                        </li>
                <?php
                    }
                ?>
                <li class="sidebar-item">
                    <a href="histori.php" class="sidebar-link">
                        <i class="bi bi-clock-history"></i>
                        <span>Histori</span>
                    </a>
                </li>
                <?php 
                    if ($level == 3){?>
                        <li class="sidebar-item">
                            <a href="setting.php" class="sidebar-link">
                                <i class="bi bi-gear"></i>
                                <span>Setting</span>
                            </a>
                        </li>
                <?php
                    }
                ?>
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
                <!-- <form action="#" class="d-none d-sm-inline-block">
                    <div class="input-group input-group-navbar">
                        <input type="text" class="form-control border-0 rounded-0 pe-0" placeholder="Search..." aria-label="Search">
                        <button class="btn rounded-0 border-0">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form> -->
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
                            <?php 
                            if ($level == 3){?>
                                <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                                    <a href="profil_edit.php?id_user=<?= $id_user ?>" class="dropdown-item">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit Profil</span>
                                    </a>
                                    <a href="setting.php" class="dropdown-item">
                                        <i class="bi bi-gear"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="bantuan.php" class="dropdown-item">
                                        <i class="bi bi-question-circle"></i>
                                        <span>Pusat Bantuan</span>
                                    </a>
                                    <a href="../logout.php" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            <?php
                                }
                            ?>
                        </li>
                    </ul>
                </div>
            </nav>
        <!-- </div>
    </div> -->
    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Sertakan JS: jQuery, Bootstrap, dan DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>