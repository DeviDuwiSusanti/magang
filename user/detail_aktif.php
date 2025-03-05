<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 
include "functions.php";  

// Ambil id_user dari session atau parameter URL
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : (isset($_GET['id_user']) ? $_GET['id_user'] : null);

// Query untuk mengambil data pengajuan magang yang masih aktif dan sesuai dengan id_user yang login
$sql = "SELECT tb_pengajuan.*, tb_profile_user.*, tb_pendidikan.nama_pendidikan, tb_user.email AS email_login, tb_instansi.*, tb_bidang.*
        FROM tb_pengajuan 
        LEFT JOIN tb_profile_user ON tb_pengajuan.id_pengajuan = tb_profile_user.id_pengajuan LEFT JOIN tb_pendidikan ON tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan 
        LEFT JOIN tb_user ON tb_profile_user.id_user = tb_user.id_user  LEFT JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi LEFT JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang 
        WHERE tb_pengajuan.status_pengajuan = '4' AND tb_profile_user.id_user = '$id_user'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
?>


<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Kegiatan Aktif</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Kegiatan Aktif</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="kegiatan_aktif.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>

        <!-- Menampilkan informasi user -->
        <div class="container mt-5 mb-5">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body top text-center">
                    <!-- Foto profil -->
                    <img src="../assets/img/user/<?= !empty($row['gambar_user']) ? $row['gambar_user'] : 'avatar.png' ?>" class="rounded-circle mb-3" alt="Profile Picture"style="width: 100px; height: 100px;">
                    <h4 class="card-title"><?= $row['nama_user'] ?? 'Tidak Diketahui' ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($row['email_login'] ?? 'Tidak Ada Email'); ?></p>

                    <hr>
                    <div class="card-body">
                        <!-- Tabel informasi pengguna -->
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td><?= $row['nama_user'] ?? 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-mortarboard"></i> <strong>Universitas</strong></td>
                                    <td><?= $row['nama_pendidikan'] ?? 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> <strong>Perusahaan</strong></td>
                                    <td><?= $row['nama_panjang'] ?? 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-shield-lock"></i> <strong>Bidang</strong></td>
                                    <td><?= $row['nama_bidang'] ?? 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-hourglass-split"></i> <strong>Durasi</strong></td>
                                    <td>
                                    <?= hitungDurasi($row['tanggal_mulai'], $row['tanggal_selesai']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-event"></i> <strong>Periode Magang</strong></td>
                                    <td>
                                        <?= formatPeriode($row['tanggal_mulai'], $row['tanggal_selesai']) ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php";?>