<?php
include '../koneksi.php';
include '../functions.php';

if (isset($_GET['id_pengajuan']) && isset($_GET['id_user']) && isset($_GET['id_pembimbing'])) {
    $id_pengajuan = $_GET['id_pengajuan'];
    $id_user = $_GET['id_user'];
    $id_pembimbing = $_GET['id_pembimbing'];
    
    // Update semua logbook sebagai sudah dilihat
    $query_update = "UPDATE tb_logbook SET status_active = '2' 
                    WHERE id_pengajuan = '$id_pengajuan' 
                    AND id_user = '$id_user'
                    AND status_active = '1'";
    mysqli_query($conn, $query_update);
    
    // Ambil data logbook
    $logbooks = query("SELECT * FROM tb_logbook 
                        WHERE id_pengajuan = '$id_pengajuan' 
                        AND id_user = '$id_user'
                        ORDER BY tanggal_logbook DESC");
    
    if (!empty($logbooks)) {
        echo '
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Keterangan</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';
        
        $no = 1;
        foreach ($logbooks as $logbook) {
            $status = $logbook['status_active'] == 2 ? 
                        '<span class="badge bg-success">Sudah Dilihat</span>' : 
                        '<span class="badge bg-warning">Belum Dilihat</span>';
            
            echo '
            <tr>
                <td>'.$no++.'</td>
                <td>'.date('d-m-Y', strtotime($logbook['tanggal_logbook'])).'</td>
                <td>'.$logbook['kegiatan_logbook'].'</td>
                <td>'.$logbook['keterangan_logbook'].'</td>
                <td>'.$logbook['jam_mulai'].'</td>
                <td>'.$logbook['jam_selesai'].'</td>
                <td>'.$status.'</td>
            </tr>';
        }
        
        echo '
                </tbody>
            </table>
        </div>';
    } else {
        echo '<div class="alert alert-info">Belum ada logbook untuk peserta ini</div>';
    }
}
?>