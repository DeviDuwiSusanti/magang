<?php 
include "../layout/sidebarUser.php";
include '../koneksi.php';
include "functions.php"; 

if (isset($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
};

// Ambil data pengajuan
$sql_pengajuan = "SELECT * FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$query_pengajuan = mysqli_query($conn, $sql_pengajuan);
$row = mysqli_fetch_assoc($query_pengajuan);

// Cek level user
$sql_user = "SELECT level FROM tb_user WHERE id_user = '$id_user'";
$query_user = mysqli_query($conn, $sql_user);
$user_data = mysqli_fetch_assoc($query_user);
$level_user = $user_data['level'];

// Ambil daftar laporan akhir berdasarkan id_pengajuan, dan jika level 4 hanya ambil miliknya sendiri
if ($level_user == 4) {
    $sql = "SELECT d.*, p.nama_user FROM tb_dokumen d 
            JOIN tb_profile_user p ON d.id_user = p.id_user
            WHERE d.jenis_dokumen = '3' AND d.id_pengajuan = '$id_pengajuan' AND d.id_user = '$id_user'";
} else {
    $sql = "SELECT d.*, p.nama_user FROM tb_dokumen d 
            JOIN tb_profile_user p ON d.id_user = p.id_user
            WHERE d.jenis_dokumen = '3' AND d.id_pengajuan = '$id_pengajuan'";
}

$result = mysqli_query($conn, $sql);

// Cek apakah pengguna sudah mengunggah laporan akhir sendiri
$sql_cek_laporan = "SELECT * FROM tb_dokumen WHERE id_user = '$id_user' AND id_pengajuan = '$id_pengajuan'";
$result_cek_laporan = mysqli_query($conn, $sql_cek_laporan);
$laporan_terunggah = mysqli_num_rows($result_cek_laporan) > 0;
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Laporan Akhir</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Laporan Akhir Kegiatan Anda</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <!-- Tombol tambah laporan aktif jika user level 3 atau 4 dan belum mengunggah laporan -->
            <?php if (($level_user == 3 || $level_user == 4) && !$laporan_terunggah): ?>
                <a href="laprak_unggah.php?id_user=<?= $id_user ?>&id_pengajuan=<?= $id_pengajuan ?>" 
                   class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Laporan Akhir
                </a>
            <?php endif; ?>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Nama Dokumen</th>
                        <th class="text-center">Pemilik Laporan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): 
                        $no = 1;
                        while ($row2 = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= isset($row2['create_date']) ? date('d/m/Y', strtotime($row2['create_date'])) : '-' ?></td>
                                <td>
                                    <a href="<?= $row2['file_path'] ?? '#' ?>" target="_blank">
                                        <?= htmlspecialchars($row2['nama_dokumen'] ?? 'Tidak diketahui') ?>
                                    </a>
                                </td>
                                <td class="text-center"><?= htmlspecialchars($row2['nama_user'] ?? 'Tidak diketahui') ?></td>
                                <td class="text-center">
                                    <?php 
                                    // Level 3 dan 4 hanya bisa menghapus laporannya sendiri
                                    if (($level_user == 3 || $level_user == 4) && $row2['id_user'] == $id_user): ?>
                                        <a href="laprak_daftar.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>&id_dokumen=<?= $row2['id_dokumen'] ?>" 
                                           onclick="return confirm('Anda yakin akan menghapus laporan ini?')" 
                                           class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    <?php else: ?>
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
