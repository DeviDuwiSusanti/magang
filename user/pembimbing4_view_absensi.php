<?php
include "../koneksi.php";
include "functions.php";
include "../functions.php";

if (isset($_GET['id_pengajuan']) && isset($_GET['id_user'])) {
    $id_pengajuan = $_GET['id_pengajuan'];
    $id_user = $_GET['id_user'];
    
    // Get user data
    $user_data = query("SELECT pu.nama_user, pu.gambar_user 
                        FROM tb_profile_user pu 
                        WHERE pu.id_user = '$id_user'");
    $nama_user = $user_data[0]['nama_user'] ?? 'Peserta Magang';
    $gambar_user = $user_data[0]['gambar_user'] ?? 'avatar.png';
    
    // Get absensi data
    $absensi_data = query("SELECT * FROM tb_absensi 
                           WHERE id_pengajuan = '$id_pengajuan' 
                           AND id_user = '$id_user'
                           AND status_active = '1'
                           ORDER BY tanggal_absensi DESC");
    
    if (!empty($absensi_data)) {
        echo '<div class="row mb-4">
                <div class="col-md-2 text-center">
                    <img src="../assets/img/user/'.$gambar_user.'" width="100" class="rounded-circle mb-2">
                </div>
                <div class="col-md-10">
                    <h4>'.$nama_user.'</h4>
                    <p>Total Absensi: '.count($absensi_data).' hari</p>
                </div>
              </div>';
        
        echo '<div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal</th>
                            <th>Datang</th>
                            <th>Foto Datang</th>
                            <th>Pulang</th>
                            <th>Foto Pulang</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($absensi_data as $absensi) {
            $tanggal = date('d F Y', strtotime($absensi['tanggal_absensi']));
            $jam_datang = $absensi['jam_datang'] ? date('H:i', strtotime($absensi['jam_datang'])) : '-';
            $jam_pulang = $absensi['jam_pulang'] ? date('H:i', strtotime($absensi['jam_pulang'])) : '-';
            
            echo '<tr>
                    <td>'.$tanggal.'</td>
                    <td>'.$jam_datang.'</td>
                    <td>';
            
            if ($absensi['foto_datang']) {
                echo '<a href="#" data-bs-toggle="modal" data-bs-target="#fotoModal" 
                     onclick="showFoto(\''.$absensi['foto_datang'].'\', \'Datang\')">
                        <img src="../'.$id_pengajuan.'/'.$absensi['foto_datang'].'" width="50" class="img-thumbnail">
                     </a>';
            } else {
                echo '-';
            }
            
            echo '</td>
                  <td>'.$jam_pulang.'</td>
                  <td>';
            
            if ($absensi['foto_pulang']) {
                echo '<a href="#" data-bs-toggle="modal" data-bs-target="#fotoModal" 
                     onclick="showFoto(\''.$absensi['foto_pulang'].'\', \'Pulang\')">
                        <img src="../'.$id_pengajuan.'/'.$absensi['foto_pulang'].'" width="50" class="img-thumbnail">
                     </a>';
            } else {
                echo '-';
            }
            
            echo '</td>
                </tr>';
        }
        
        echo '</tbody>
            </table>
        </div>';
        
        // Modal untuk foto besar
        echo '<div class="modal fade" id="fotoModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fotoModalLabel">Foto <span id="jenisAbsensi"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="fotoBesar" src="" class="img-fluid">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>';
        
        echo '<script>
                function showFoto(fotoPath, jenis) {
                    document.getElementById("jenisAbsensi").innerText = jenis;
                    document.getElementById("fotoBesar").src = "../'.$id_pengajuan.'/" + fotoPath;
                }
              </script>';
    } else {
        echo '<div class="alert alert-info text-center">Belum ada data absensi untuk peserta ini.</div>';
    }
} else {
    echo '<div class="alert alert-danger text-center">Parameter tidak valid.</div>';
}
?>