<?php 
include "../layout/sidebarUser.php";
include '../koneksi.php';
include "functions.php"; 

$id_pengajuan = $_GET['id_pengajuan'];
$id_user = $_GET['id_user'];

// Mengambil id_pengajuan dan status_pengajuan jika ada
$sql_pengajuan = "SELECT * FROM tb_pengajuan WHERE id_user = '$id_user' AND id_pengajuan = '$id_pengajuan'";
$query_pengajuan = mysqli_query($conn, $sql_pengajuan);
$row = mysqli_fetch_assoc($query_pengajuan);

// Mengambil daftar dokumen laporan akhir
$sql = "SELECT * FROM tb_dokumen WHERE id_user = '$id_user' AND jenis_dokumen = '3' AND id_pengajuan = '$id_pengajuan'";
$result = mysqli_query($conn, $sql);

// Cek apakah pengguna sudah mengunggah laporan akhir
$laporan_terunggah = mysqli_num_rows($result) > 0;
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Laporan Akhir</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Laporan Akhir Kegiatan Anda</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <!-- Tombol tambah laporan hanya aktif jika belum ada laporan yang diunggah -->
            <a href="laprak_unggah.php?id_user=<?= $id_user ?>&id_pengajuan=<?= $id_pengajuan ?? '' ?>" 
               class="btn btn-primary <?= $laporan_terunggah ? 'disabled' : '' ?>">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Laporan Akhir
            </a>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Dokumen</th>
                        <th>Jenis Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): 
                        $no = 1;
                        while ($row2 = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= isset($row2['create_date']) ? date('d/m/Y', strtotime($row2['create_date'])) : '-' ?></td>
                                <td>
                                    <a href="<?= $row2['file_path'] ?? '#' ?>" target="_blank">
                                        <?= htmlspecialchars($row2['nama_dokumen'] ?? 'Tidak diketahui') ?>
                                    </a>
                                </td>
                                <td><?= getKategoriText($row2['jenis_dokumen'] ?? ''); ?></td>
                                <td class="text-center">
                                    <?php if (isset($row['status_pengajuan']) && $row['status_pengajuan'] != 5): ?>
                                        <a href="laprak_edit.php?id_dokumen=<?= $row2['id_dokumen'] ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="laprak_hapus.php?id_dokumen=<?= $row2['id_dokumen'] ?>" onclick="return confirm('Anda yakin akan menghapus laporan ini?')" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; 
                    else: ?>
                        <tr><td colspan="5" class="text-center">Tidak ada laporan akhir.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>
