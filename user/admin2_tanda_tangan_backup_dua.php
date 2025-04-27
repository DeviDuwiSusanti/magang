<?php
include "../layout/sidebarUser.php";

$id_instansi_ini = $_SESSION["id_instansi"];


if(isset($_POST["submit_approve"])) {
    $result = approve_nilai($_POST);
    if($result === 404) { ?>
        <script>alert_berhasil_gagal_super_admin("error", "Gagal !!", "Tanda Tangan Tidak Boleh Kosong", "admin2_tanda_tangan.php")</script>
    <?php } else if ($result > 0) { ?>
        <script>alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Admin Berhasil Menyetujui Penilian", "admin2_tanda_tangan.php")</script>
    <?php } else { ?>
        <script>alert_berhasil_gagal_super_admin("error", "Gagal !!", "Admin Gagal Menyetujui Penilaian", "admin2_tanda_tangan.php")</script>
    <?php }
}

// Handle upload background sertifikat
if(isset($_FILES['background_file']) && $_FILES['background_file']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../assets/img/instansi/'.$id_instansi_ini.'/';
    
    // Buat folder jika belum ada
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Upload file
    $fileName = basename($_FILES['background_file']['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    
    if(in_array($fileType, $allowTypes)) {
        // Generate unique filename to prevent overwrite
        $uniqueName = uniqid() . '_' . $fileName;
        $targetFilePath = $uploadDir . $uniqueName;
        
        if(move_uploaded_file($_FILES['background_file']['tmp_name'], $targetFilePath)) {
            // Simpan ke database
            $id_background = generateIdBackground($id_instansi_ini);
            $query = "INSERT INTO tb_sertifikat_background 
                     (id_background, id_instansi, nama_file, path_file, status_active, create_by) 
                      VALUES 
                     ('$id_background', '$id_instansi_ini', '$fileName', '$targetFilePath', '1', '$id_user')";
            
            if(mysqli_query($conn, $query)) { ?>
                <script>
                    alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Background sertifikat berhasil diupload", "admin2_tanda_tangan.php");
                </script>
            <?php } else { ?>
                <script>
                    alert_berhasil_gagal_super_admin("error", "Gagal !!", "Gagal menyimpan data ke database: <?= mysqli_error($conn) ?>", "admin2_tanda_tangan.php");
                </script>
            <?php }
        } else { ?>
            <script>
                alert_berhasil_gagal_super_admin("error", "Gagal !!", "Maaf, terjadi error saat upload file", "admin2_tanda_tangan.php");
            </script>
        <?php }
    } else { ?>
        <script>
            alert_berhasil_gagal_super_admin("error", "Gagal !!", "Hanya file JPG, JPEG, PNG, & GIF yang diperbolehkan", "admin2_tanda_tangan.php");
        </script>
    <?php }
}

// Handle set active background
if(isset($_POST['set_active'])) {
    $id_background = $_POST['id_background'];
    
    // Nonaktifkan semua background untuk instansi ini
    $query = "UPDATE tb_sertifikat_background SET status_active = '0' WHERE id_instansi = '$id_instansi_ini'";
    mysqli_query($conn, $query);
    
    // Aktifkan background yang dipilih
    $query = "UPDATE tb_sertifikat_background SET status_active = '1' WHERE id_background = '$id_background'";
    if(mysqli_query($conn, $query)) { ?>
        <script>
            alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Background sertifikat berhasil diaktifkan", "admin2_tanda_tangan.php");
        </script>
    <?php } else { ?>
        <script>
            alert_berhasil_gagal_super_admin("error", "Gagal !!", "Gagal mengaktifkan background", "admin2_tanda_tangan.php");
        </script>
    <?php }
}

// Handle hapus background
if(isset($_POST['hapus_background'])) {
    $id_background = $_POST['id_background'];
    
    // Ambil path file dari database
    $fileData = query("SELECT path_file FROM tb_sertifikat_background WHERE id_background = '$id_background' AND id_instansi = '$id_instansi_ini'");
    
    if(!empty($fileData)) {
        $filePath = $fileData[0]['path_file'];
        
        // Hapus file dari server
        if(file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Hapus dari database
        $query = "DELETE FROM tb_sertifikat_background WHERE id_background = '$id_background' AND id_instansi = '$id_instansi_ini'";
        if(mysqli_query($conn, $query)) { ?>
            <script>
                alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Background sertifikat berhasil dihapus", "admin2_tanda_tangan.php");
            </script>
        <?php } else { ?>
            <script>
                alert_berhasil_gagal_super_admin("error", "Gagal !!", "Gagal menghapus data dari database", "admin2_tanda_tangan.php");
            </script>
        <?php }
    }
}

// Get all nilai that need approval (where tanda_tangan_admin is null)
$id_instansi = query("SELECT id_instansi FROM tb_profile_user WHERE id_user = '$id_user'")[0];
$id_instansi_ini = $id_instansi["id_instansi"];
$nilai_need_approval = query("SELECT n.*, p.id_instansi, pu.nama_user, pu.gambar_user
                            FROM tb_nilai n
                            JOIN tb_profile_user pu ON n.id_user = pu.id_user
                            JOIN tb_pengajuan p ON n.id_pengajuan = p.id_pengajuan
                            WHERE n.tanda_tangan_admin IS NULL AND p.id_instansi = '$id_instansi_ini'");

// Get all background sertifikat untuk instansi ini
$backgrounds = query("SELECT * FROM tb_sertifikat_background WHERE id_instansi = '$id_instansi_ini'");

$no = 1;
?>

<style>
    .signature-pad {
        background-color: #f8f9fa;
        width: 100%;
    }
    
    .signature-pad canvas {
        width: 100%;
        height: 200px;
        touch-action: none;
    }
    
    /* Style untuk preview background */
    .background-preview {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    
    .background-item {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 5px;
    }
    
    /* Dropzone style */
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: white;
        min-height: 150px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
    }
    
    .dropzone .dz-message {
        font-size: 1.2em;
        color: #666;
    }
    
    .dropzone .dz-preview .dz-image {
        width: 100px;
        height: 100px;
    }
    
    #uploadButton {
        margin-top: 15px;
    }
</style>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Persetujuan Nilai Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Berikut daftar nilai yang perlu persetujuan</li>
        </ol>
        
        <!-- Tombol untuk manajemen background sertifikat -->
        <div class="mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backgroundModal">
                <i class="bi bi-image"></i> Kelola Background Sertifikat
            </button>
        </div>
    </div>

    <?php if (!empty($nilai_need_approval)) : ?>
        <div class="container mt-5">
            <div class="card shadow-lg">
                <div class="card-body">
                    <table id="table_nilai" class="table table-striped table-bordered align-middle text-center">
                        <thead class="table-light small">
                            <tr>
                                <th>No.</th>
                                <th>Peserta</th>
                                <th>Rata-rata Nilai</th>
                                <th>Detail Nilai</th>
                                <th>Tanda Tangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($nilai_need_approval as $nilai) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-center">
                                        <div>
                                        <?php $gambar = !empty($nilai["gambar_user"]) ? $nilai["gambar_user"] : 'avatar.png'; ?>
                                            <img src="../assets/img/user/<?= $gambar ?>" alt="Foto" class="rounded-circle mb-2" style="object-fit: cover; width: 100px; height: 100px">
                                            <div style="font-size: 14px;"><?= $nilai["nama_user"] ?></div>
                                        </div>
                                    </td>

                                    <td><?= number_format($nilai['rata_rata'], 2) ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm viewNilai"
                                            data-id_nilai="<?= $nilai['id_nilai'] ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewNilaiModal">
                                            <i class="bi bi-eye"></i> Lihat
                                        </button>
                                    </td>
                                    <td>
                                        <div id="signature-pad-<?= $nilai['id_nilai'] ?>" class="signature-pad border rounded">
                                            <canvas width="100%" height="100"></canvas>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-danger clearSignature" data-id="<?= $nilai['id_nilai'] ?>">
                                                Hapus Tanda Tangan
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                    <form method="POST">
                                        <input type="hidden" name="id_admin_approve" value="<?= $id_user ?>">
                                        <input type="hidden" name="id_nilai" value="<?= $nilai['id_nilai'] ?>">
                                        <input type="hidden" name="tanda_tangan_admin" id="signature-data-<?= $nilai['id_nilai'] ?>">
                                        <button type="submit" name="submit_approve" class="btn btn-success btn-sm" onclick="return handleSubmit(<?= $nilai['id_nilai'] ?>)">
                                            <i class="bi bi-check-circle"></i> Setujui
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container mt-5">
            <div class="alert alert-success text-center">
                Tidak ada nilai yang perlu disetujui saat ini.
            </div>
        </div>
    <?php endif; ?>
</main>

<!-- Modal untuk View Nilai -->
<div class="modal fade" id="viewNilaiModal" tabindex="-1" aria-labelledby="viewNilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNilaiModalLabel">Detail Nilai Peserta Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewNilaiContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Background Sertifikat -->
<div class="modal fade" id="backgroundModal" tabindex="-1" aria-labelledby="backgroundModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backgroundModalLabel">Kelola Background Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Tambah Background Baru</h5>
                <form id="uploadForm" method="POST" enctype="multipart/form-data">
                    <div class="dropzone" id="myDropzone">
                        <div class="dz-message">
                            <i class="bi bi-cloud-arrow-up" style="font-size: 2rem;"></i><br>
                            Seret file ke sini atau klik untuk mengupload<br>
                            <span class="text-muted">(Format: JPG, PNG, JPEG, GIF)</span>
                        </div>
                        <div class="fallback">
                            <input name="background_file" type="file" />
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" name="upload_background" class="btn btn-primary" id="uploadButton">
                            <i class="bi bi-upload"></i> Upload Background
                        </button>
                    </div>
                </form>
                
                <hr>
                
                <h5>Daftar Background Tersedia</h5>
                <div class="row" id="backgroundList">
                    <?php if(!empty($backgrounds)): ?>
                        <?php foreach($backgrounds as $bg): ?>
                            <div class="col-md-6 background-item" id="bg-<?= $bg['id_background'] ?>">
                                <img src="<?= $bg['path_file'] ?>" class="background-preview" alt="Background Sertifikat">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <span class="badge bg-<?= $bg['background_active'] == '1' ? 'success' : 'secondary' ?>">
                                            <?= $bg['background_active'] == '1' ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                        <span class="ms-2"><?= $bg['nama_file'] ?></span>
                                    </div>
                                    <div>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="id_background" value="<?= $bg['id_background'] ?>">
                                            <button type="submit" name="set_active" class="btn btn-sm btn-<?= $bg['background_active'] == '1' ? 'info' : 'outline-info' ?>" <?= $bg['background_active'] == '1' ? 'disabled' : '' ?>>
                                                <i class="bi bi-check-circle"></i> Set Aktif
                                            </button>
                                            <button type="submit" name="hapus_background" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus background ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                Belum ada background sertifikat yang diupload.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<!-- Script untuk Signature Pad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<!-- Dropzone JS -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_nilai').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [5, 10],
            language: {
                search: "Cari : ",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        // Initialize signature pads for each row
        let signaturePads = {};
        $('.signature-pad').each(function() {
            const id = $(this).attr('id').split('-')[2];
            const canvas = this.querySelector('canvas');
            signaturePads[id] = new SignaturePad(canvas, {
                backgroundColor: 'rgb(248, 249, 250)',
                penColor: 'rgb(0, 0, 0)'
            });
            
            // Handle resize
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePads[id].clear();
            }
            
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
        });

        // Clear signature buttons
        $('.clearSignature').click(function() {
            const id = $(this).data('id');
            signaturePads[id].clear();
        });

        // View Nilai Modal
        $('.viewNilai').click(function() {
            const idNilai = $(this).data('id_nilai');
            $.ajax({
                url: 'pembimbing4_penilaian.php',
                type: 'GET',
                data: {id_nilai: idNilai},
                success: function(response) {
                    $('#viewNilaiContent').html(response);
                }
            });
        });

        window.handleSubmit = function(id) {
            const pad = signaturePads[id];
            if (pad.isEmpty()) {
                alert("Tanda tangan tidak boleh kosong!");
                return false;
            }
            document.getElementById("signature-data-" + id).value = pad.toDataURL();
            return true;
        }

        // Inisialisasi Dropzone
        Dropzone.autoDiscover = false;
        
        // Konfigurasi Dropzone yang lebih sederhana
        $("#myDropzone").dropzone({
            url: "admin2_tanda_tangan.php", // URL untuk upload
            paramName: "background_file", // Parameter name
            maxFilesize: 5, // MB
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            autoProcessQueue: false, // Tidak otomatis upload
            parallelUploads: 1, // Hanya 1 file sekaligus
            dictDefaultMessage: "<i class='bi bi-cloud-arrow-up' style='font-size: 2rem;'></i><br>Seret file ke sini atau klik untuk mengupload<br><span class='text-muted'>(Format: JPG, PNG, JPEG, GIF)</span>",
            dictFileTooBig: "File terlalu besar ({{filesize}}MB). Maksimal {{maxFilesize}}MB.",
            dictInvalidFileType: "Format file tidak didukung.",
            dictResponseError: "Server merespon dengan kode {{statusCode}}.",
            dictCancelUpload: "Batalkan upload",
            dictRemoveFile: "Hapus file",
            init: function() {
                var myDropzone = this;
                
                // Ketika form di-submit, proses upload
                $("#uploadForm").submit(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (myDropzone.files.length === 0) {
                        alert("Silakan pilih file terlebih dahulu");
                        return false;
                    }
                    
                    // Proses upload file
                    myDropzone.processQueue();
                });
                
                // Ketika upload selesai, reload halaman
                this.on("complete", function(file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                });
                
                // Ketika ada error
                this.on("error", function(file, message) {
                    alert("Error: " + message);
                    this.removeFile(file);
                });
            }
        });
    });
</script>