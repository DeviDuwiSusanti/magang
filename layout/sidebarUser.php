<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-grid"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Sistem Magang</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'index.php' : '../index.php'; ?>" class="sidebar-link">
                        <i class="bi bi-speedometer"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'edit_profil.php' ? 'edit_profil.php' : 'user/edit_profil.php'; ?>" class="sidebar-link">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Edit Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'kegiatan_aktif.php' ? 'kegiatan_aktif.php' : 'user/kegiatan_aktif.php'; ?>" class="sidebar-link">
                        <i class="bi bi-pencil-square"></i>
                        <span>Kegiatan Aktif</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'status_pengajuan.php' ? 'status_pengajuan.php' : 'user/status_pengajuan.php'; ?>" class="sidebar-link">
                        <i class="bi bi-building-fill-add"></i>
                        <span>Status Pengajuan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'histori.php' ? 'histori.php' : 'user/histori.php'; ?>" class="sidebar-link">
                        <i class="bi bi-journals"></i>
                        <span>Histori</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-gear"></i>
                        <span>Setting</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
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
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="./img/login.jpeg" alt="avatar" class="avatar img-fluid rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                                <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'profil.php' ? 'profil.php' : 'user/profil.php'; ?>" class="dropdown-item">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Lihat Profil</span>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="bi bi-bar-chart-line-fill"></i>
                                    <span>Kembali ke Beranda</span>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="bi bi-gear"></i>
                                    <span>Pengaturan</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Pusat Bantuan</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        <!-- </div>
    </div> -->
    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>