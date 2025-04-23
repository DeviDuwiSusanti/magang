<?php
include '../koneksi.php';
include '../functions.php';

if (isset($_GET['id_nilai'])) {
    $id_nilai = $_GET['id_nilai'];
    $nilai = query("SELECT * FROM tb_nilai WHERE id_nilai = '$id_nilai'")[0];
    
    if ($nilai) {
        echo '
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Aspek Penilaian</th>
                    <th width="20%">Nilai (0-100)</th>
                    <th width="20%">Kategori</th>
                </tr>
                <tr>
                    <td>Kehadiran/Absensi</td>
                    <td>'.$nilai['kehadiran'].'</td>
                    <td>'.get_kategori_nilai($nilai['kehadiran']).'</td>
                </tr>
                <tr>
                    <td>Ketepatan Waktu/Disiplin</td>
                    <td>'.$nilai['disiplin'].'</td>
                    <td>'.get_kategori_nilai($nilai['disiplin']).'</td>
                </tr>
                <tr>
                    <td>Tanggung Jawab Terhadap Tugas</td>
                    <td>'.$nilai['tanggung_jawab'].'</td>
                    <td>'.get_kategori_nilai($nilai['tanggung_jawab']).'</td>
                </tr>
                <tr>
                    <td>Kreativitas</td>
                    <td>'.$nilai['kreativitas'].'</td>
                    <td>'.get_kategori_nilai($nilai['kreativitas']).'</td>
                </tr>
                <tr>
                    <td>Kerjasama Tim</td>
                    <td>'.$nilai['kerjasama'].'</td>
                    <td>'.get_kategori_nilai($nilai['kerjasama']).'</td>
                </tr>
                <tr>
                    <td>Kemampuan Penggunaan TI</td>
                    <td>'.$nilai['teknologi_informasi'].'</td>
                    <td>'.get_kategori_nilai($nilai['teknologi_informasi']).'</td>
                </tr>
                <tr class="table-primary">
                    <td><strong>Rata-rata</strong></td>
                    <td><strong>'.number_format($nilai['rata_rata'], 2).'</strong></td>
                    <td><strong>'.get_kategori_nilai($nilai['rata_rata']).'</strong></td>
                </tr>
            </table>
            
            <div class="mb-3">
                <label class="form-label"><strong>Catatan/Komentar:</strong></label>
                <div class="border p-2 rounded">'.nl2br($nilai['catatan']).'</div>
            </div>
        </div>';
    } else {
        echo '<div class="alert alert-danger">Data nilai tidak ditemukan</div>';
    }
}

function get_kategori_nilai($nilai) {
    if ($nilai >= 88) return 'Sangat Baik';
    if ($nilai >= 74) return 'Baik';
    if ($nilai >= 60) return 'Cukup';
    return 'Kurang';
}
?>