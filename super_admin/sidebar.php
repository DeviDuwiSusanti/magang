<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/style_super_admin.css">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- DataTables CSS + Bootstrap Theme -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button id="toggle-btn" type="button">
                    <i class="bi bi-grid"></i>
                </button>
                <div class="sidebar-logo">
                    <a class="text-decoration-none" href="index.php">Super Admin</a>
                </div>
            </div>

            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="index.php" class="sidebar-link text-decoration-none">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="profile_view.php" class="sidebar-link text-decoration-none">
                        <i class="bi bi-person-circle"></i>
                        <span>My Profile</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="instansi_view.php" class="sidebar-link text-decoration-none">
                        <i class="bi bi-buildings"></i>
                        <span>Instansi</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="admin_instansi_view.php" class="sidebar-link text-decoration-none">
                        <i class="bi bi-building-fill-add"></i>
                        <span>Admin Instansi</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="user_view.php" class="sidebar-link text-decoration-none">
                        <i class="bi bi-people"></i>
                        <span>User</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="study_view.php" class="sidebar-link text-decoration-none">
                        <i class="bi bi-mortarboard"></i>
                        <span>Sekolah / Universitas</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="pengajuan_view.php" class="sidebar-link text-decoration-none">
                        <i class="bi bi-journals"></i>
                        <span>Pengajuan</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="settings.php" class="sidebar-link text-decoration-none">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <a href="logout.php" class="sidebar-link text-decoration-none">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>


        <div class="main">
            <nav class="navbar navbar-expand px-4 py-3">
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item d-flex align-items-center me-5">
                            <button id="mode-toggle" class="mode-toggle">
                                <i id="mode-icon" class="bi bi-moon-fill"></i>
                            </button>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="../assets/img/login.jpeg" alt="avatar" class="avatar rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                                <a href="profile_view.php" class="dropdown-item">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>My Profile</span>
                                </a>
                                <a href="admin_instansi_view.php" class="dropdown-item">
                                    <i class="bi bi-person-check"></i>
                                    <span>Admin Instansi</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="settings.php" class="dropdown-item">
                                    <i class="bi bi-gear"></i>
                                    <span>Pengaturan</span>
                                </a>
                                <a href="help.php" class="dropdown-item">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Pusat Bantuan</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    


        <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

    <!-- JSZip (Required for Export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- pdfMake (Required for PDF Export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- DataTables Buttons Export to PDF -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

</body>

</html>