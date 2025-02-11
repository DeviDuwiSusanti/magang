<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
                    <a href="index.php">Sistem Magang</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="index.php" class="sidebar-link">
                        <i class="bi bi-speedometer"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="view_profile.php" class="sidebar-link">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Profile Saya</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="view_instansi.php" class="sidebar-link">
                        <i class="bi bi-buildings"></i>
                        <span>Kelola Instansi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="view_bidang.php" class="sidebar-link">
                        <i class="bi bi-building-fill-add"></i>
                        <span>Bidang</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="daftar_pembimbing.php" class="sidebar-link">
                        <i class="bi bi-person-workspace"></i>
                        <span>Pembimbing Bidang</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="pengajuan.php" class="sidebar-link">
                        <i class="bi bi-journals"></i>
                        <span>Kelola Pengajuan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="view_user.php" class="sidebar-link">
                        <i class="bi bi-people"></i>
                        <span>Daftar Pemagang</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="nilai.php" class="sidebar-link">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Penilaian</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="sertifikat.php" class="sidebar-link">
                        <i class="bi bi-award"></i>
                        <span>Sertifikat</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="setting.php" class="sidebar-link">
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
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item d-flex align-items-center me-5">
                            <button id="mode-toggle" class="mode-toggle">
                                <i id="mode-icon" class="bi bi-moon-fill"></i>
                            </button>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="../assets/img/login.jpeg" alt="avatar" class="avatar img-fluid rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                                <a href="view_profile.php" class="dropdown-item">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Edit Profile</span>
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
                                <a href="#" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
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

    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable();

            $('#myTable tbody').on('click', 'a.show-detail', function(e) {
                e.preventDefault();

                var detailData = $(this).data('detail');
                var detailHtml = '<ul>';
                $.each(detailData, function(index, name) {
                    detailHtml += '<li>' + (index + 1) + '. ' + name + '</li>';
                });
                detailHtml += '</ul>';

                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (!row.child.isShown()) {
                    $('#myTable tbody tr.shown').not(tr).each(function() {
                        table.row(this).child.hide();
                        $(this).removeClass('shown');
                    });
                }

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(detailHtml).show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
</body>

</html>