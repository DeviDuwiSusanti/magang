<?php 
include '../layout/sidebarUser.php';
include "functions.php";

// ===================== super admin ======================
$instansi_1 = query("SELECT COUNT(*) AS total FROM tb_instansi WHERE status_active = 1")[0];
$pendidikan_1 = query("SELECT COUNT(*) AS total FROM tb_pendidikan WHERE status_active = 1")[0];
$pengajuan_1 = query("SELECT COUNT(*) AS total FROM tb_pengajuan WHERE status_active = 1")[0];
$user_1 = query("SELECT COUNT(*) AS total FROM tb_user WHERE status_active = 1")[0];
// ============================== end of super admin =========================



// =============== admin instansi ==================================
include "update_status.php";
include "admin2_kirim_pengingat.php";

$id_instansi = $_SESSION["id_instansi"];

// data instansi
$instansi_admin_2 = query("SELECT COUNT(*) AS total 
    FROM tb_instansi
    JOIN tb_profile_user 
        ON tb_instansi.id_instansi = tb_profile_user.id_instansi
    WHERE tb_profile_user.id_user = '$id_user'")[0];

// data bidang
$bidang_admin_2 = query("SELECT COUNT(*) AS total 
    FROM tb_bidang
    JOIN tb_instansi 
        ON tb_bidang.id_instansi = tb_instansi.id_instansi
    WHERE tb_instansi.id_instansi = '$id_instansi'
    AND tb_bidang.status_active = '1'")[0];

// Query untuk menghitung total pengajuan
$total_pengajuan_2 = query("SELECT COUNT(*) AS total 
    FROM tb_pengajuan
    JOIN tb_instansi 
        ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
    WHERE tb_instansi.id_instansi = '$id_instansi'
    AND tb_pengajuan.status_active = '1'
    AND tb_pengajuan.status_pengajuan IN ('1', '2')")[0];

// Query untuk menghitung total pemagang
$pemagang_2 = query("SELECT SUM(
            CASE 
                WHEN jumlah_pelamar > 1 THEN jumlah_pelamar 
                ELSE 1 
            END
        ) AS total 
        FROM tb_pengajuan
        JOIN tb_instansi 
            ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        WHERE tb_instansi.id_instansi = '$id_instansi'
        AND tb_pengajuan.status_active = '1'
        AND tb_pengajuan.status_pengajuan IN ('4', '5')")[0];
// ========================== end of admin insatansi level 2 ===============================

// =========================== USER 3 =========================

// Query dapat jumlah pengajuan user
$sql2 = "SELECT COUNT(*) AS jumlah_pengajuan FROM tb_pengajuan WHERE id_user = '$id_user' AND status_pengajuan = '1' AND status_active = '1'";
$query2 = mysqli_query($conn, $sql2);
$total_pengajuan = mysqli_fetch_array($query2)['jumlah_pengajuan'];

// akses sertifikat/nilai
$sql2 = "SELECT COUNT(*) AS nilai FROM tb_nilai WHERE id_user = '$id_user' AND id_pengajuan = '$id_pengajuan' AND status_active = '1'";
$query2 = mysqli_query($conn, $sql2);
$total_nilai = mysqli_fetch_assoc($query2)['nilai'];

// akses histori
if ($ketua) {
    $sql3 = "SELECT COUNT(*) AS jumlah_histori FROM tb_pengajuan WHERE id_user = '$id_user' AND status_pengajuan = '5'";
    $query3 = mysqli_query($conn, $sql3);
    $total_histori = mysqli_fetch_array($query3)['jumlah_histori'];
} else if ($anggota) {
    $sql3 = "SELECT COUNT(*) AS jumlah_histori FROM tb_pengajuan p, tb_profile_user pu WHERE pu.id_user = '$id_user' AND p.status_pengajuan = '5' AND pu.id_pengajuan = p.id_pengajuan";
    $query3 = mysqli_query($conn, $sql3);
    $total_histori = mysqli_fetch_array($query3)['jumlah_histori'];
}

// akses logbook
$sql4 = "SELECT COUNT(*) AS jumlah_logbook FROM tb_logbook WHERE id_user = '$id_user' AND id_pengajuan = '$id_pengajuan' AND (status_active = 1 OR status_active = 2)";
$query4 = mysqli_query($conn, $sql4);
$total_logbook = mysqli_fetch_array($query4)['jumlah_logbook'];

// akses laporan akhir
$sql5 = "SELECT COUNT(*) jumlah_laprak FROM tb_dokumen WHERE id_user = '$id_user' AND jenis_dokumen = '3' AND id_pengajuan = '$id_pengajuan' AND (status_active = 1 OR status_active = 2)";
$query5 = mysqli_query($conn, $sql5);
$total_laprak = mysqli_fetch_assoc($query5)['jumlah_laprak'];

// ===================== pembimbing ======================
if ($level == 4) :
    $id_bidang = query("SELECT id_bidang FROM tb_profile_user WHERE id_user = '$id_user'")[0];
    $id_bidang_ini = $id_bidang["id_bidang"];
    $pengajuan_bidang = query("SELECT * FROM tb_pengajuan WHERE id_bidang = '$id_bidang_ini' AND status_pengajuan = '1' AND status_active = '1'");
    $persetujuan_pembimbing = count($pengajuan_bidang);

    $pengajuan = query("SELECT id_pengajuan FROM tb_pengajuan WHERE id_pembimbing = '$id_user' AND (status_pengajuan = '2' OR status_pengajuan = '4' OR status_pengajuan = '5') AND status_active = '1'");
    
    $daftar_anggota = []; // array untuk menampung semua peserta magang

    if (!empty($pengajuan)) {
        foreach ($pengajuan as $pj) {
            $id_pengajuan = $pj["id_pengajuan"];    
            $anggota = query("SELECT * FROM tb_profile_user 
                                JOIN tb_user ON tb_profile_user.id_user = tb_user.id_user 
                                WHERE tb_profile_user.id_pengajuan = '$id_pengajuan' 
                                AND tb_profile_user.status_active = '1'");
            if (!empty($anggota)) {
                $daftar_anggota = array_merge($daftar_anggota, $anggota);
            }
        }

        $daftar_peserta_magang = count($daftar_anggota);
    } else {
        $daftar_peserta_magang = 0;
    }


$total_absensi = 0;
$daftar_absensi = [];

if (!empty($daftar_anggota)) {
    foreach ($daftar_anggota as $anggota) {
        $id_peserta = $anggota["id_user"];
        
        $absensi_peserta = query("SELECT * FROM tb_absensi WHERE id_user = '$id_peserta'");
        $jumlah_absensi = count($absensi_peserta);

        $total_absensi += $jumlah_absensi;
        $daftar_absensi[$id_peserta] = $jumlah_absensi;
    }
}
endif;




?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>
        <div class="row">
            <!-- ===================== super admin ======================= -->
            <?php if ($level == "1") : ?>
                <!-- Card 1 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Instansi Terdaftar</h5>
                            <h2 class="card-text text-success"><?= $instansi_1["total"] ?></h2>
                            <!-- <p class="text-muted">Lihat Dan Kelola Daftar Instansi</p> -->
                            <a href="super1_instansi.php" class="btn btn-success mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Pengguna</h5>
                            <h2 class="card-text text-warning"><?= $user_1["total"] ?></h2>
                            <!-- <p class="text-muted">Lihat Dan Kelola Daftar Pengguna</p> -->
                            <a href="super1_user.php" class="btn btn-warning mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Pendidikan User</h5>
                            <h2 class="card-text text-primary"><?= $pendidikan_1["total"] ?></h2>
                            <!-- <p class="text-muted">lihat Dan Tambahkan Daftar Asal Sekolah Atau Universitas Pengguna</p> -->
                            <a href="pendidikan_user.php" class="btn btn-primary mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Pengajuan User</h5>
                            <h2 class="card-text text-danger"><?= $pengajuan_1["total"] ?></h2>
                            <!-- <p class="text-muted">Daftar Pengajuan Pengguna</p> -->
                            <a href="super1_pengajuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!-- ==================================== end of super admin level 1 =================================== -->


            <!-- ============================ admin instansi level 2========================================= -->
            <?php if ($level == "2") : ?>
                <?php if (empty($id_instansi)) : ?>
                    <div class="alert alert-info" role="alert">
                        <strong>Informasi:</strong> Anda telah memiliki akses sebagai Admin Instansi, namun instansi Anda belum ditentukan oleh Super Admin.
                        Silakan tunggu hingga penetapan instansi dilakukan.
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Kelola Instansi</h5>
                                <h2 class="card-text text-primary"><?= $instansi_admin_2["total"] ?></h2>
                                <p class="text-muted">Kelola data instansi</p>
                                <a href="admin2_instansi.php" class="btn btn-primary mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Kelola Bidang</h5>
                                <h2 class="card-text text-warning"><?= $bidang_admin_2["total"] ?></h2>
                                <p class="text-muted">Kelola data bidang</p>
                                <a href="admin2_bidang.php" class="btn btn-warning mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Pengajuan Baru</h5>
                                <h2 class="card-text text-danger"><?= $total_pengajuan_2["total"] ?></h2>
                                <p class="text-muted">Lihat pengajuan baru</p>
                                <a href="admin2_pengajuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card border-0">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Pemagang</h5>
                                <h2 class="card-text text-success"><?= $pemagang_2["total"] ?? 0 ?></h2>
                                <p class="text-muted">Lihat data pemagang</p>
                                <a href="admin2_user.php" class="btn btn-success mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <!-- ====================================== end of admin instansi level 2 ==================================== -->



            <!-- ====================================== USER DAN ANGGOTA (LEVEL 3) -->
            <!-- Card 1 -->
            <?php
            if ($ketua && $level == "3") { ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Pengajuan</h5>
                            <h2 class="card-text text-primary"><?= $total_pengajuan ?></h2>
                            <p class="text-muted">Permohonan Magang</p>
                            <a href="user3_statusPengajuan.php" class="btn btn-info mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if (isset($row2['status_pengajuan']) && $row2['status_pengajuan'] == '4') { ?>
                <!-- Card 1 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Isi Logbook</h5>
                            <h2 class="card-text text-primary"><?= $total_logbook ?></h2>
                            <p class="text-muted">Logbook Terisi</p>
                            <a href="user3_logbook.php" class="btn btn-primary mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            if (isset($row2['status_pengajuan']) && $row2['status_pengajuan'] == '5') { ?>
                <!-- Card 2 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Laporan Akhir</h5>
                            <h2 class="card-text text-success"><?= $total_laprak ?></h2>
                            <p class="text-muted">Laporan Terunggah</p>
                            <a href="user3_logbook.php" class="btn btn-success mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Sertifikat dan Nilai</h5>
                            <h2 class="card-text text-warning"><?= $total_nilai ?></h2>
                            <p class="text-muted">Tersedia</p>
                            <a href="user3_histori.php" class="btn btn-warning mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

                <!-- Card 4 -->
                <?php if (($ketua || $anggota) && $level == "3") : ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">Histori</h5>
                                <h2 class="card-text text-danger"><?= $total_histori ?: 0 ?></h2>
                                <p class="text-muted">Jumlah Kegiatan</p>
                                <a href="user3_histori.php" class="btn btn-danger mt-3 detail">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Card 5 /ABSENSI -->
                <?php
                if (isset($_POST['input_absen'])) {
                    // Validate that photo_data exists
                    if (!isset($_POST['photo_data']) || empty($_POST['photo_data'])) {
                        showAlert('Error!', 'Foto absensi tidak valid', 'error', "dashboard.php");
                        exit();
                    }
                    
                    // Call the function with the correct parameters
                    inputAbsensi($_POST, $id_pengajuan, $id_user);
                }
                ?>
                <?php 
                if (ISSET($status_pengajuan)):
                    if (($ketua || $anggota) && $level == "3" && $status_pengajuan == '4') :
                            $tanggal_sekarang = date('Y-m-d');  
                            $sqlAbsen = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_absensi WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user' AND tanggal_absensi = '$tanggal_sekarang'"));
                    ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">Absensi</h5><p></p>
                                <!-- Smaller date text -->
                                <p class="text-muted mb-1" style="font-size: 0.9rem;">
                                    <?= formatTanggalLengkapIndonesia(date('Y-m-d')) ?> <!-- Current date like "12 Mei 2025" -->
                                </p>
                                
                                <!-- Time display section -->
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Datang :</span>
                                    <span class="text-muted" style="display: inline-block; vertical-align: middle; height: 24px; line-height: 24px;"><?= !empty($sqlAbsen['jam_datang']) ? date('H:i', strtotime($sqlAbsen['jam_datang'])) : '-' ?></span>
                                    <span class="mx-2">|</span>
                                    <span class="text-muted">Pulang :</span>
                                    <span class="text-muted" style="display: inline-block; vertical-align: middle; height: 24px; line-height: 24px;"><?= !empty($sqlAbsen['jam_pulang']) ? date('H:i', strtotime($sqlAbsen['jam_pulang'])) : '-' ?></span>
                                </div>
                                <br>
                                <!-- Upload Photo Button -->
                                <?php 
                                if (!$sqlAbsen): ?>
                                    <button type="button" class="btn btn-primary mt-3 detail" data-bs-toggle="modal" data-bs-target="#uploadFotoModal">
                                        <i class="fas fa-camera me-2"></i>Lakukan Absensi
                                    </button>
                                <?php else:
                                    if  ($sqlAbsen['jam_pulang'] == NULL): ?>
                                        <button type="button" class="btn btn-primary mt-3 detail" data-bs-toggle="modal" data-bs-target="#uploadFotoModal">
                                            <i class="fas fa-camera me-2"></i>Lakukan Absensi
                                        </button>
                                    <?php else:?>
                                        <button type="button" class="btn btn-primary mt-3 detail">
                                            <i class="fas fa-camera me-2"></i>Absen Selesai
                                        </button>
                                    <?php endif;?>  
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                   <!-- MODAL ABSENSI  -->
                    <div class="modal fade" id="uploadFotoModal" tabindex="-1" aria-labelledby="uploadFotoModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="uploadFotoModalLabel">
                                        <i class="fas fa-camera me-2"></i>Ambil Foto Absensi
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="absensiForm" action="" method="post" enctype="multipart/form-data">
                                        <!-- Tampilan Hari, Tanggal, dan Jam -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Waktu Absensi:</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                                <input type="text" class="form-control fw-bold" id="waktuAbsensi" readonly>
                                            </div>
                                        </div>
                                        
                                        <!-- Camera Capture -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ambil Foto:</label>
                                            <div class="camera-container border rounded p-1 text-center">
                                                <video id="video" width="100%" autoplay playsinline style="display: none;"></video>
                                                <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                                                <div id="startCamera" class="d-grid gap-2">
                                                    <button type="button" class="btn btn-primary" onclick="startCamera()">
                                                        <i class="fas fa-camera me-2"></i>Buka Kamera
                                                    </button>
                                                </div>
                                                <div id="cameraControls" style="display: none;">
                                                    <button type="button" class="btn btn-success my-2" onclick="captureImage()">
                                                        <i class="fas fa-camera me-2"></i>Ambil Foto
                                                    </button>
                                                    <button type="button" class="btn btn-danger" onclick="stopCamera()">
                                                        <i class="fas fa-times me-2"></i>Tutup Kamera
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="photoData" name="photo_data">
                                        </div>

                                        <!-- Image Preview Container -->
                                        <div class="mb-3 text-center" id="imagePreviewContainer" style="display: none;">
                                            <img id="imagePreview" src="#" alt="Preview Gambar" class="img-thumbnail mt-2" style="max-height: 200px;">
                                            <button type="button" class="btn btn-warning btn-sm mt-2" onclick="retakePhoto()">
                                                <i class="fas fa-redo me-1"></i>Ambil Ulang
                                            </button>
                                        </div>  

                                        <div class="d-grid gap-2">
                                            <button type="submit" name="input_absen" class="btn btn-primary" id="submitBtn" disabled>
                                                <i class="fas fa-upload me-2"></i>Kirim
                                            </button>
                                        </div>  
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    let videoStream = null;

                    function startCamera() {
                        document.getElementById('startCamera').style.display = 'none';
                        document.getElementById('video').style.display = 'block';
                        document.getElementById('cameraControls').style.display = 'block';
                        
                        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false })
                            .then(function(stream) {
                                videoStream = stream;
                                const video = document.getElementById('video');
                                video.srcObject = stream;
                                video.play();
                            })
                            .catch(function(err) {
                                console.error("Error accessing camera: ", err);
                                alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.");
                                stopCamera();
                            });
                    }

                    function stopCamera() {
                        if (videoStream) {
                            videoStream.getTracks().forEach(track => track.stop());
                            videoStream = null;
                        }
                        document.getElementById('video').style.display = 'none';
                        document.getElementById('canvas').style.display = 'none';
                        document.getElementById('cameraControls').style.display = 'none';
                        document.getElementById('startCamera').style.display = 'block';
                    }

                    function captureImage() {
                        const video = document.getElementById('video');
                        const canvas = document.getElementById('canvas');
                        const context = canvas.getContext('2d');
                        
                        // Set canvas size to match video
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        
                        // Draw video frame to canvas
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);
                        
                        // Convert to data URL and show preview
                        const imageDataUrl = canvas.toDataURL('image/jpeg');
                        document.getElementById('photoData').value = imageDataUrl;
                        
                        // Show preview
                        document.getElementById('imagePreview').src = imageDataUrl;
                        document.getElementById('imagePreviewContainer').style.display = 'block';
                        document.getElementById('submitBtn').disabled = false;
                        
                        // Hide camera
                        document.getElementById('video').style.display = 'none';
                        document.getElementById('cameraControls').style.display = 'none';
                    }

                    function retakePhoto() {
                        document.getElementById('imagePreviewContainer').style.display = 'none';
                        document.getElementById('photoData').value = '';
                        document.getElementById('submitBtn').disabled = true;
                        startCamera();
                    }

                    // Update waktu absensi
                    document.addEventListener('DOMContentLoaded', function() {
                        const now = new Date();
                        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                        document.getElementById('waktuAbsensi').value = now.toLocaleDateString('id-ID', options);
                    });
                    </script>
                    <script>
                        // Fungsi untuk menampilkan waktu dalam format Indonesia
                        function updateWaktuAbsensi() {
                            const sekarang = new Date();
                            const options = {
                                weekday: 'long',
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: false
                            };
                            
                            document.getElementById('waktuAbsensi').value = sekarang.toLocaleDateString('id-ID', options);
                        }

                        // Update waktu saat modal dibuka
                        document.getElementById('uploadFotoModal').addEventListener('show.bs.modal', function() {
                            updateWaktuAbsensi();
                            // Update setiap detik
                            this.waktuInterval = setInterval(updateWaktuAbsensi, 1000);
                        });

                        // Hentikan interval saat modal ditutup
                        document.getElementById('uploadFotoModal').addEventListener('hidden.bs.modal', function() {
                            clearInterval(this.waktuInterval);
                        });
                    </script>

                   
                <?php endif; ?>
            <?php endif; ?>
  
            <!-- ============== pembimbing ========== -->
            <?php if ($level == 4) : ?>
                <!-- Card 1 -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title">Persetujuan Pembimbing</h6>
                            <h class="card-text text-danger"><?= $persetujuan_pembimbing ?></h>
                            <p class="text-muted"><?= $persetujuan_pembimbing ?> Kelompok Butuh Persetujuan</p>
                            <a href="pembimbing4_persetujuan.php" class="btn btn-danger mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Peserta Magang</h5>
                            <h2 class="card-text text-success"><?= $daftar_peserta_magang ?></h2>
                            <p class="text-muted"><?= $daftar_peserta_magang ?> Peserta Magang</p>
                            <a href="pembimbing4.php" class="btn btn-success mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Absensi Peserta Magang</h5>
                            <h2 class="card-text text-warning"><?= $total_absensi?></h2>
                            <p class="text-muted"><?= $total_absensi ?> Absesnsi Peserta Magang</p>
                            <a href="pembimbing4_absensi.php" class="btn btn-warning mt-3 detail">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>