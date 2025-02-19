<?php 
include "../layout/header.php";

$id_instansi = $_SESSION['id_instansi'];
$no = 1;

// Query untuk data utama pengajuan
$sql = "SELECT
            tb_profile_user.nama_user,
            tb_bidang.nama_bidang,
            tb_pengajuan.jenis_pengajuan,
            tb_pengajuan.jumlah_pelamar,
            tb_pengajuan.tanggal_mulai,
            tb_pengajuan.tanggal_selesai,
            tb_pengajuan.id_pengajuan,
            tb_pengajuan.status_pengajuan,
            tb_pengajuan.status_active
        FROM tb_pengajuan
        INNER JOIN tb_profile_user ON tb_pengajuan.id_user = tb_profile_user.id_user
        INNER JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.id_instansi = '$id_instansi'
        AND tb_pengajuan.status_active = 'Y'
        ORDER BY tb_pengajuan.id_pengajuan DESC";

$result = mysqli_query($conn, $sql);

// Query untuk mendapatkan daftar nama pengaju
$sql2 = "SELECT p.id_pengajuan, GROUP_CONCAT(pu.nama_user SEPARATOR ', ') AS daftar_nama
        FROM tb_pengajuan p
        JOIN tb_profile_user pu ON p.id_pengajuan = pu.id_pengajuan
        WHERE p.id_instansi = '$id_instansi'
        GROUP BY p.id_pengajuan
        ORDER BY p.id_pengajuan DESC";

$nama_pengaju = [];
$result2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_assoc($result2)) {
    $nama_pengaju[$row2['id_pengajuan']] = $row2['daftar_nama'];
}

$json_nama_pengaju = json_encode($nama_pengaju);
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Daftar Pengajuan User</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Pengajuan</th>
                            <th>Calon Pelamar</th>
                            <th>Dokumen</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <!-- <th>Status Pengajuan</th>
                            <th>Update Status</th> -->
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_user'] ?></td>
                            <td><?= $row['nama_bidang'] ?></td>
                            <td><?= $row['jenis_pengajuan'] ?></td>
                            <td>
                                <a href="#" class="show-detail" title="Lihat Detail"
                                    data-detail='<?= isset($nama_pengaju[$row['id_pengajuan']]) ? json_encode(explode(', ', $nama_pengaju[$row['id_pengajuan']])) : '[]' ?>'>
                                    <?= isset($nama_pengaju[$row['id_pengajuan']]) ? count(explode(', ', $nama_pengaju[$row['id_pengajuan']])) : 0 ?>
                                </a>
                            </td>
                            <td>
                                <!-- Data dokumen diubah menjadi array of object dengan nama dan URL -->
                                <a href="#" class="show-doc" title="Lihat Dokumen"
                                    data-doc='[
                                     {"name": "KTP", "url": "dokumen/ktp.pdf"},
                                     {"name": "Kartu Keluarga", "url": "dokumen/kk.pdf"},
                                     {"name": "Ijazah", "url": "dokumen/ijazah.pdf"}
                                   ]'>
                                    Lihat Dokumen
                                </a>
                            </td>
                            <!-- <td></td>
                            <td></td> -->
                            <td><?= $row['tanggal_mulai'] ?></td>
                            <td><?= $row['tanggal_selesai'] ?></td>
                            <td>
                                <a href="terima.php" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle"></i> Terima
                                </a>
                                <a href="hapus_bidang.php" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan dokumen (opsional jika ingin menggunakan modal) -->
<div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dokumenModalLabel">Dokumen yang dilengkapi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <ul id="dokumenList"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

