<?php
include '../koneksi.php';
include '../functions.php';

if (isset($_GET['id_nilai'])) {
    $id_nilai = $_GET['id_nilai'];
    $nilai = query("SELECT * FROM tb_nilai WHERE id_nilai = '$id_nilai'")[0];
    
    if ($nilai) {
        echo '
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Kehadiran/Absensi (0-100)</label>
                <input type="number" class="form-control" name="kehadiran" min="0" max="100" value="'.$nilai['kehadiran'].'" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ketepatan Waktu/Disiplin (0-100)</label>
                <input type="number" class="form-control" name="disiplin" min="0" max="100" value="'.$nilai['disiplin'].'" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tanggung Jawab Terhadap Tugas (0-100)</label>
                <input type="number" class="form-control" name="tanggung_jawab" min="0" max="100" value="'.$nilai['tanggung_jawab'].'" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Kreativitas (0-100)</label>
                <input type="number" class="form-control" name="kreativitas" min="0" max="100" value="'.$nilai['kreativitas'].'" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Kerjasama Tim (0-100)</label>
                <input type="number" class="form-control" name="kerjasama" min="0" max="100" value="'.$nilai['kerjasama'].'" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Kemampuan Penggunaan TI (0-100)</label>
                <input type="number" class="form-control" name="teknologi_informasi" min="0" max="100" value="'.$nilai['teknologi_informasi'].'" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan/Komentar</label>
            <textarea class="form-control" name="catatan" rows="3">'.$nilai['catatan'].'</textarea>
        </div>';
    } else {
        echo '<div class="alert alert-danger">Data nilai tidak ditemukan</div>';
    }
}
?>