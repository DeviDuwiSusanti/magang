<?php
include '../koneksi.php';
include '../functions.php';

$id_nilai = $_GET['id'] ?? '';

if (!empty($id_nilai)) {
    $nilai = query("SELECT n.*, pu.nama_user, b.nama_bidang 
                   FROM tb_nilai n
                   JOIN tb_profile_user pu ON n.id_user = pu.id_user
                   JOIN tb_bidang b ON n.id_bidang = b.id_bidang
                   WHERE n.id_nilai = '$id_nilai' AND n.status_active = '1'");
    
    if (!empty($nilai)) {
        $nilai = $nilai[0];
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center">Verifikasi Nilai Magang</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($nilai)) : ?>
                        <div class="text-center mb-4">
                            <img src="../assets/img/logo.png" alt="Logo" width="150">
                            <h4 class="mt-3">Sertifikat Nilai Magang</h4>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Nama Peserta:</strong> <?= $nilai['nama_user'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Bidang Magang:</strong> <?= $nilai['nama_bidang'] ?></p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Keahlian:</strong> <?= $nilai['bidang_keahlian'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>ID Nilai:</strong> <?= $nilai['id_nilai'] ?></p>
                            </div>
                        </div>
                        
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Komponen Penilaian</th>
                                    <th>Nilai (0-100)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kehadiran/Absensi</td>
                                    <td><?= $nilai['kehadiran'] ?></td>
                                </tr>
                                <tr>
                                    <td>Ketepatan Waktu/Disiplin</td>
                                    <td><?= $nilai['disiplin'] ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggung Jawab</td>
                                    <td><?= $nilai['tanggung_jawab'] ?></td>
                                </tr>
                                <tr>
                                    <td>Kreativitas</td>
                                    <td><?= $nilai['kreativitas'] ?></td>
                                </tr>
                                <tr>
                                    <td>Kerjasama Tim</td>
                                    <td><?= $nilai['kerjasama'] ?></td>
                                </tr>
                                <tr>
                                    <td>Penggunaan TI</td>
                                    <td><?= $nilai['teknologi_informasi'] ?></td>
                                </tr>
                                <tr class="table-success">
                                    <td><strong>Nilai Rata-rata</strong></td>
                                    <td><strong><?= number_format($nilai['rata_rata'], 2) ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="mt-3">
                            <h5>Catatan Pembimbing:</h5>
                            <p><?= nl2br($nilai['catatan']) ?></p>
                        </div>
                        
                        <div class="text-center mt-4">
                            <small class="text-muted">Dokumen ini divalidasi dengan QR Code</small>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">Data Tidak Ditemukan!</h4>
                            <p>ID nilai tidak valid atau dokumen telah dihapus.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>