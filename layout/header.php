<?php
session_start();
include "../functions.php";

if (!isset($_SESSION['email']) || !isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM tb_user WHERE email = '$email'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

if ($user['level'] != 2) {
    header("Location: ../login.php");
    exit();
}

$id_user = $user["id_user"];
$pengguna = query("SELECT * FROM tb_profile_user WHERE id_user = '$id_user'")[0];
?>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/alert.js"></script>
    <!-- Select2 CSS -->
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
                    <a href="index.php">Sistem Magang</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="index.php" class="sidebar-link active">
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
                        <span>Kelola Bidang</span>
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
                <a href="../admin_instansi/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-4 py-3">
                <button id="hamburger-menu" class="btn btn-outline-secondary d-lg-none me-3">
                    <i class="bi bi-list"></i>
                </button>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item d-flex align-items-center me-5">
                            <button id="mode-toggle" class="mode-toggle">
                                <i id="mode-icon" class="bi bi-moon-fill"></i>
                            </button>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="../assets/img/user/<?= $pengguna["gambar_user"] ?: 'avatar.png' ?>" alt="avatar" class="avatar img-fluid rounded-circle" style="object-fit: cover; object-position: top;">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3">
                                <a href="edit_profile.php" class="dropdown-item">
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
                                <a href="../admin_instansi/logout.php" class="dropdown-item">
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

            <!-- Select2 JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
                    $('#bidang').select2({
                        placeholder: "Pilih Bidang",
                        allowClear: true
                    });
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