<?php
include '../koneksi.php';
include '../functions.php';

if (isset($_GET['id_pengajuan']) && isset($_GET['id_user']) && isset($_GET['id_pembimbing'])) {
    $id_pengajuan = $_GET['id_pengajuan'];
    $id_user = $_GET['id_user'];
    $id_pembimbing = $_GET['id_pembimbing'];
    
    // Ambil data logbook
    $logbooks = query("SELECT * FROM tb_logbook 
                      WHERE id_pengajuan = '$id_pengajuan' 
                      AND id_user = '$id_user' AND (status_active = '1' OR status_active = '2')
                      ORDER BY tanggal_logbook DESC");
    
    if (!empty($logbooks)) {
        echo '
        <div class="table-responsive">
            <div class="mb-3">
                <input type="checkbox" id="selectAllLogbooks" class="form-check-input">
                <label for="selectAllLogbooks" class="form-check-label">Pilih Semua Logbook Belum Diverifikasi</label>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Keterangan</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status & Aksi</th>
                    </tr>
                </thead>
                <tbody>';
        
        $no = 1;
        foreach ($logbooks as $logbook) {
            $status = $logbook['status_active'] == 2 ? 
                        '<span class="badge bg-success">Sudah Diverifikasi</span>' : 
                        '<div class="form-check">
                            <input type="checkbox" name="selected_logbooks[]" value="'.$logbook['id_logbook'].'" class="form-check-input logbook-checkbox">
                            <label class="form-check-label">Belum Diverifikasi</label>
                        </div>';
            
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
        </div>
        <script>
        $(document).ready(function() {
            // Select All checkbox
            $("#selectAllLogbooks").change(function() {
                $(".logbook-checkbox").prop("checked", $(this).prop("checked"));
            });
            
            // Jika ada checkbox logbook yang tidak dicentang, uncheck selectAll
            $(".logbook-checkbox").change(function() {
                if (!$(this).prop("checked")) {
                    $("#selectAllLogbooks").prop("checked", false);
                }
                
                // Cek apakah semua checkbox logbook sudah dicentang
                let allChecked = $(".logbook-checkbox:not(:checked)").length === 0;
                $("#selectAllLogbooks").prop("checked", allChecked);
            });
        });
        </script>';
    } else {
        echo '<div class="alert alert-info">Belum ada logbook untuk peserta ini</div>';
    }
}
?>