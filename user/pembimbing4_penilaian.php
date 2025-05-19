<?php
include '../koneksi.php';
include '../functions.php';

if (isset($_GET['id_nilai'])) {
    $id_nilai = $_GET['id_nilai'];
    $action = isset($_GET['action']) ? $_GET['action'] : 'view'; // Default action adalah view
    
    $nilai = query("SELECT n.*, pu.nama_user, pu.gambar_user, 
                    a.nama_user as nama_admin, a.gambar_user as gambar_admin
                    FROM tb_nilai n
                    JOIN tb_profile_user pu ON n.id_user = pu.id_user
                    LEFT JOIN tb_profile_user a ON n.id_admin_approve = a.id_user
                    WHERE n.id_nilai = '$id_nilai'")[0];
    
    function get_kategori_nilai($nilai) {
        if ($nilai >= 88) return 'Sangat Baik';
        if ($nilai >= 74) return 'Baik';
        if ($nilai >= 60) return 'Cukup';
        return 'Kurang';
    }
}
?>

<?php if (isset($_GET['id_nilai'])) : ?>
    <?php if ($nilai) : ?>
        <?php if ($action == 'view') : ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Aspek Penilaian</th>
                        <th width="20%">Nilai (0-100)</th>
                        <th width="20%">Kategori</th>
                    </tr>
                    <tr>
                        <td>Kehadiran/Absensi</td>
                        <td><?= $nilai['kehadiran'] ?></td>
                        <td><?= get_kategori_nilai($nilai['kehadiran']) ?></td>
                    </tr>
                    <tr>
                        <td>Ketepatan Waktu/Disiplin</td>
                        <td><?= $nilai['disiplin'] ?></td>
                        <td><?= get_kategori_nilai($nilai['disiplin']) ?></td>
                    </tr>
                    <tr>
                        <td>Tanggung Jawab Terhadap Tugas</td>
                        <td><?= $nilai['tanggung_jawab'] ?></td>
                        <td><?= get_kategori_nilai($nilai['tanggung_jawab']) ?></td>
                    </tr>
                    <tr>
                        <td>Kreativitas</td>
                        <td><?= $nilai['kreativitas'] ?></td>
                        <td><?= get_kategori_nilai($nilai['kreativitas']) ?></td>
                    </tr>
                    <tr>
                        <td>Kerjasama Tim</td>
                        <td><?= $nilai['kerjasama'] ?></td>
                        <td><?= get_kategori_nilai($nilai['kerjasama']) ?></td>
                    </tr>
                    <tr>
                        <td>Kemampuan Penggunaan TI</td>
                        <td><?= $nilai['teknologi_informasi'] ?></td>
                        <td><?= get_kategori_nilai($nilai['teknologi_informasi']) ?></td>
                    </tr>
                    <tr class="table-primary">
                        <td><strong>Rata-rata</strong></td>
                        <td><strong><?= number_format($nilai['rata_rata'], 2) ?></strong></td>
                        <td><strong><?= get_kategori_nilai($nilai['rata_rata']) ?></strong></td>
                    </tr>
                    <tr class="table-primary">
                        <td><strong>Bidang Keahlian</strong></td>
                        <td colspan="2" class="text-center"><strong><?= $nilai["bidang_keahlian"] ?></strong></td>
                    </tr>
                </table>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Catatan/Komentar:</strong></label>
                    <div class="border p-2 rounded"><?= nl2br($nilai['catatan']) ?></div>
                </div>

                <?php if ($nilai['status_approve'] == 1) : ?>
                    <div class="alert alert-success">
                        <strong>Disetujui oleh:</strong> <?= $nilai['nama_admin'] ?>
                        <br><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($nilai['tanggal_approve'])) ?>
                        <div class="mt-2">
                            <img src="<?= $nilai['tanda_tangan_admin'] ?>" alt="Tanda Tangan Admin" style="max-width: 200px;">
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($action == 'edit') : ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Kehadiran/Absensi (0-100)</label>
                    <input type="number" class="form-control" name="kehadiran" min="0" max="100" value="<?= $nilai['kehadiran'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ketepatan Waktu/Disiplin (0-100)</label>
                    <input type="number" class="form-control" name="disiplin" min="0" max="100" value="<?= $nilai['disiplin'] ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggung Jawab Terhadap Tugas (0-100)</label>
                    <input type="number" class="form-control" name="tanggung_jawab" min="0" max="100" value="<?= $nilai['tanggung_jawab'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kreativitas (0-100)</label>
                    <input type="number" class="form-control" name="kreativitas" min="0" max="100" value="<?= $nilai['kreativitas'] ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Kerjasama Tim (0-100)</label>
                    <input type="number" class="form-control" name="kerjasama" min="0" max="100" value="<?= $nilai['kerjasama'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kemampuan Penggunaan TI (0-100)</label>
                    <input type="number" class="form-control" name="teknologi_informasi" min="0" max="100" value="<?= $nilai['teknologi_informasi'] ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-3"><label class="form-label">Bidang Keahlian</label></div>
                <div class="col-7"><input type="text" name="bidang_keahlian" id="bidang_keahlian" class="form-control" required value="<?= $nilai["bidang_keahlian"] ?>"></div>
            </div><br><br>

            <div class="mb-3">
                <label class="form-label">Catatan/Komentar</label>
                <textarea class="form-control" name="catatan" rows="3"><?= $nilai['catatan'] ?></textarea>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="alert alert-danger">Data nilai tidak ditemukan</div>
    <?php endif; ?>
<?php endif; ?>