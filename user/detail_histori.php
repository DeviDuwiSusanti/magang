<?php
include "../koneksi.php";
include "../layout/sidebarUser.php"; 

// Query untuk mengambil data pengajuan yang statusnya selesai berdasarkan ID user
$sql = "SELECT * FROM tb_pengajuan, tb_profile_user, tb_pendidikan, tb_user, tb_instansi, tb_bidang 
        WHERE tb_pengajuan.id_pengajuan = tb_profile_user.id_pengajuan 
        AND tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan 
        AND tb_pengajuan.id_instansi = tb_instansi.id_instansi 
        AND tb_pengajuan.id_bidang = tb_bidang.id_bidang 
        AND tb_pengajuan.status_pengajuan = 'Selesai' 
        AND tb_profile_user.id_user = '$id_user'
        AND tb_user.id_user = '$id_user'";  // Menambahkan filter berdasarkan id_user


$query = mysqli_query($conn, $sql); 
$row = mysqli_fetch_assoc($query); 
?>

<div class="main-content p-4">
    <div class="container-fluid">
    <h1 class="mb-4">Histori</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Histori Kegiatan</li>
        </ol>

        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="histori.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>
        
        <!-- Menampilkan informasi user dalam bentuk kartu -->
        <div class="container mt-5 mb-5">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body top text-center">
                    <!-- Foto profil -->
                    <img src="../assets/img/user/<?= isset($row['gambar_user']) ? $row['gambar_user'] : 'default.png' ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                    <h4 class="card-title"><?= isset($row['nama_user']) ? $row['nama_user'] : 'Tidak Diketahui' ?></h4>
                    <p class="text-muted"><?= isset($row['email']) ? $row['email'] : 'Tidak Ada Email' ?></p>

                    <hr>
                    <div class="card-body">
                        <!-- Tabel informasi pengguna -->
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td><?= isset($row['nama_user']) ? $row['nama_user'] : 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-mortarboard"></i> <strong>Universitas</strong></td>
                                    <td><?= isset($row['nama_pendidikan']) ? $row['nama_pendidikan'] : 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> <strong>Perusahaan</strong></td>
                                    <td><?= isset($row['nama_panjang']) ? $row['nama_panjang'] : 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-shield-lock"></i> <strong>Bidang</strong></td>
                                    <td><?= isset($row['nama_bidang']) ? $row['nama_bidang'] : 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-hourglass-split"></i> <strong>Durasi</strong></td>
                                    <td class="text-start">
                                        <?php 
                                            // Hitung durasi magang
                                            if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                                $start_date = new DateTime($row['tanggal_mulai']);
                                                $end_date = new DateTime($row['tanggal_selesai']);
                                                $interval = $start_date->diff($end_date);
                                                echo $interval->m + ($interval->y * 12) . " Bulan";
                                            } else {
                                                echo "Durasi Tidak Diketahui";
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-event"></i> <strong>Periode</strong></td>
                                    <td>
                                        <?php 
                                            // Format tanggal mulai dan selesai
                                            if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                                echo date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai']));
                                            } else {
                                                echo "Periode Tidak Diketahui";
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol untuk unggah logbook dan laporan akhir -->
                    <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="path/to/sertifikat.pdf" class="btn btn-outline-primary btn-sm px-3" download>
                        <i class="bi bi-printer"></i> Sertifikat & Nilai
                    </a>
                    <a href="laprak_daftar.php?id_pengajuan=<?= $row['id_pengajuan'] ?>&id_user=<?= $id_user ?>" class="btn btn-outline-info btn-sm px-3">
                        <i class="bi bi-book"></i> Laporan
                    </a>
                    <a href="logbook_daftar.php?id_pengajuan=<?= $row['id_pengajuan'] ?>&id_user=<?= $id_user ?>" class="btn btn-outline-info btn-sm px-3">
                        <i class="bi bi-book"></i> Logbook
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php";?>