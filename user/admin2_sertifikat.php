<?php
include "../layout/sidebarUser.php";

$id_instansi_ini = $_SESSION["id_instansi"];

// Handle upload background sertifikat
if(isset($_FILES['background_file']) && is_array($_FILES['background_file']['name'])) {
    $uploadDir = '../assets/img/instansi/'.$id_instansi_ini.'/';
    
    // Buat folder jika belum ada
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $successCount = 0;
    $errorMessages = [];
    
    // Loop melalui semua file yang diupload
    for($i = 0; $i < count($_FILES['background_file']['name']); $i++) {
        if($_FILES['background_file']['error'][$i] == UPLOAD_ERR_OK) {
            $fileName = basename($_FILES['background_file']['name'][$i]);
            $fileTmpName = $_FILES['background_file']['tmp_name'][$i];
            $targetFilePath = $uploadDir . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            
            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg');
            
            if(in_array($fileType, $allowTypes)) {
                // Generate unique filename to prevent overwrite
                $uniqueName = uniqid() . '_' . $fileName;
                $targetFilePath = $uploadDir . $uniqueName;
                
                if(move_uploaded_file($fileTmpName, $targetFilePath)) {
                    // Simpan ke database dengan background_active = 0 dan status_active = 1
                    $id_background = generateIdBackground($id_instansi_ini);
                    $query = "INSERT INTO tb_sertifikat_background 
                             (id_background, id_instansi, nama_file, path_file, background_active, status_active, create_by) 
                              VALUES 
                             ('$id_background', '$id_instansi_ini', '$fileName', '$targetFilePath', '0', '1', '$id_user')";
                    
                    if(!mysqli_query($conn, $query)) {
                        $errorMessages[] = "Gagal menyimpan file $fileName ke database";
                        // Hapus file yang sudah diupload jika gagal simpan ke database
                        if(file_exists($targetFilePath)) {
                            unlink($targetFilePath);
                        }
                    } else {
                        $successCount++;
                    }
                } else {
                    $errorMessages[] = "Gagal upload file $fileName";
                }
            } else {
                $errorMessages[] = "File $fileName: Format tidak didukung (hanya JPG, PNG, JPEG)";
            }
        }
    }
    
    // Tampilkan pesan hasil upload
    if($successCount > 0 || !empty($errorMessages)) {
        $successMsg = $successCount > 0 ? "Berhasil upload $successCount file" : "";
        $errorMsg = !empty($errorMessages) ? implode("<br>", $errorMessages) : "";
        ?>
        <script>
            alert_berhasil_gagal_super_admin("<?= $successCount > 0 ? 'success' : 'error' ?>", 
                "Upload File", 
                "<?= $successMsg ?><?= ($successMsg && $errorMsg) ? '<br>' : '' ?><?= $errorMsg ?>", 
                "admin2_sertifikat.php");
        </script>
        <?php
    }
}

// Handle update nama file
if(isset($_POST['update_nama_file'])) {
    $id_background = $_POST['id_background'];
    $nama_file = mysqli_real_escape_string($conn, $_POST['nama_file']);
    
    $query = "UPDATE tb_sertifikat_background SET nama_file = '$nama_file', change_by = '$id_user', change_date = NOW() WHERE id_background = '$id_background'";
    if(mysqli_query($conn, $query)) { ?>
        <script>
            alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Nama file berhasil diupdate", "admin2_sertifikat.php");
        </script>
    <?php } else { ?>
        <script>
            alert_berhasil_gagal_super_admin("error", "Gagal !!", "Gagal mengupdate nama file", "admin2_sertifikat.php");
        </script>
    <?php }
}

// Handle aktifkan background (set background_active = 1)
if(isset($_POST['aktifkan_background'])) {
    $id_background = $_POST['id_background'];
    
    // Nonaktifkan semua background untuk instansi ini
    $query = "UPDATE tb_sertifikat_background SET background_active = '0' WHERE id_instansi = '$id_instansi_ini'";
    mysqli_query($conn, $query);
    
    // Aktifkan background yang dipilih
    $query = "UPDATE tb_sertifikat_background SET background_active = '1', change_by = '$id_user', change_date = NOW() WHERE id_background = '$id_background'";
    if(mysqli_query($conn, $query)) { ?>
        <script>
            alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Background sertifikat berhasil diaktifkan", "admin2_sertifikat.php");
        </script>
    <?php } else { ?>
        <script>
            alert_berhasil_gagal_super_admin("error", "Gagal !!", "Gagal mengaktifkan background", "admin2_sertifikat.php");
        </script>
    <?php }
}

// Handle hapus background (soft delete - set status_active = 0)
if(isset($_POST['hapus_background'])) {
    $id_background = $_POST['id_background'];
    
    // Update status di database (soft delete)
    $query = "UPDATE tb_sertifikat_background SET status_active = '0', change_by = '$id_user', change_date = NOW() WHERE id_background = '$id_background'";
    if(mysqli_query($conn, $query)) { ?>
        <script>
            alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Background sertifikat berhasil dihapus", "admin2_sertifikat.php");
        </script>
    <?php } else { ?>
        <script>
            alert_berhasil_gagal_super_admin("error", "Gagal !!", "Gagal menghapus data dari database", "admin2_sertifikat.php");
        </script>
    <?php }
}

// Get all background sertifikat untuk instansi ini yang status_active = 1
$backgrounds = query("SELECT * FROM tb_sertifikat_background WHERE id_instansi = '$id_instansi_ini' AND status_active = '1'");
?>

<style>
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
        position: relative;
    }
    
    .dropzone .dz-message {
        font-size: 1.2em;
        color: #666;
        pointer-events: none;
    }
    
    .dropzone .dz-preview .dz-image {
        width: 100px;
        height: 100px;
    }
    
    #uploadButton {
        margin-top: 15px;
    }
    
    .file-input-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .file-input-wrapper input {
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .edit-nama-file {
        display: none;
    }
    
    .edit-nama-file.active {
        display: block;
    }
    
    .nama-file-display {
        cursor: pointer;
    }
    
    .nama-file-display:hover {
        text-decoration: underline;
    }
    
    .badge-background-active {
        background-color: #28a745;
    }
    
    .badge-background-inactive {
        background-color: #6c757d;
    }
    
    /* Style untuk daftar file yang akan diupload */
    .file-list {
        margin-top: 15px;
        padding: 10px;
        border: 1px solid #eee;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    
    .file-list-item {
        padding: 5px 0;
        border-bottom: 1px solid #eee;
    }
    
    .file-list-item:last-child {
        border-bottom: none;
    }
    
    /* Memastikan tombol aktifkan selalu terlihat */
    .btn-aktifkan {
        opacity: 1 !important;
        visibility: visible !important;
    }
</style>

<div class="main-content p-3">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Kelola Background Sertifikat</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Upload Dan Aktifkan Background Sertifikat</li>
            <li class="breadcrumb-item active">Tombol Aktifkan Berada Di Sebelah Kiri Tombol Hapus</li>
        </ol>
        
        <!-- Link back to Signature Page -->
        <div class="mb-4">
            <a href="admin2_tanda_tangan.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Persetujuan Nilai
            </a>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5>Tambah Background Baru</h5>
                <p class="small text-muted">Nb. Ukuran File Max 1Mb, Bisa Upload Multiple File</p>
                <form id="uploadForm" method="POST" enctype="multipart/form-data">
                    <div class="dropzone" id="myDropzone">
                        <div class="dz-message">
                            <i class="bi bi-cloud-arrow-up" style="font-size: 2rem;"></i><br>
                            Seret file ke sini atau klik untuk mengupload<br>
                            <span class="text-muted">(Format: JPG, PNG, JPEG)</span>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" name="background_file[]" id="background_file" multiple accept="image/jpg, image/jpeg, image/png">
                        </div>
                    </div>
                    
                    <!-- Daftar file yang akan diupload -->
                    <div id="selectedFiles" class="file-list" style="display: none;">
                        <h6>File yang akan diupload:</h6>
                        <div id="fileListContent"></div>
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
                                        <span class="badge <?= $bg['background_active'] == '1' ? 'badge-background-active' : 'badge-background-inactive' ?>">
                                            <?= $bg['background_active'] == '1' ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                        <div class="nama-file-display ms-2" data-id="<?= $bg['id_background'] ?>">
                                            <?= $bg['nama_file'] ?>
                                        </div>
                                        <form method="POST" class="edit-nama-file" id="edit-nama-<?= $bg['id_background'] ?>">
                                            <input type="hidden" name="id_background" value="<?= $bg['id_background'] ?>">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="nama_file" value="<?= $bg['nama_file'] ?>">
                                                <button type="submit" name="update_nama_file" class="btn btn-success">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-secondary cancel-edit" data-id="<?= $bg['id_background'] ?>">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="id_background" value="<?= $bg['id_background'] ?>">
                                            <?php if($bg['background_active'] == '0'): ?>
                                                <button type="submit" name="aktifkan_background" class="btn btn-sm btn-outline-success btn-aktifkan">
                                                    <i class="bi bi-check-circle"></i> Aktifkan
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-success" disabled>
                                                    <i class="bi bi-check-circle"></i> Aktif
                                                </button>
                                            <?php endif; ?>
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
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<!-- Dropzone JS -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
    $(document).ready(function() {
        // Fungsi untuk edit nama file
        $('.nama-file-display').click(function() {
            const id = $(this).data('id');
            $(this).hide();
            $('#edit-nama-' + id).addClass('active');
        });
        
        $('.cancel-edit').click(function() {
            const id = $(this).data('id');
            $('#edit-nama-' + id).removeClass('active');
            $('.nama-file-display[data-id="' + id + '"]').show();
        });

        // Tampilkan daftar file yang dipilih
        $('#background_file').change(function() {
            const files = this.files;
            const fileList = $('#fileListContent');
            const selectedFilesContainer = $('#selectedFiles');
            
            fileList.empty();
            
            if (files.length > 0) {
                selectedFilesContainer.show();
                
                for (let i = 0; i < files.length; i++) {
                    fileList.append('<div class="file-list-item">' + (i+1) + '. ' + files[i].name + '</div>');
                }
                
                $('#myDropzone .dz-message').html(
                    `Dipilih ${files.length} file<br>
                     <span class="text-muted">Klik Upload untuk mengunggah</span>`
                );
            } else {
                selectedFilesContainer.hide();
                $('#myDropzone .dz-message').html(
                    `<i class='bi bi-cloud-arrow-up' style='font-size: 2rem;'></i><br>
                     Seret file ke sini atau klik untuk mengupload<br>
                     <span class='text-muted'>(Format: JPG, PNG, JPEG)</span>`
                );
            }
        });
        
        // Inisialisasi Dropzone
        Dropzone.autoDiscover = false;
        
        // Konfigurasi Dropzone
        $("#myDropzone").dropzone({
            url: "admin2_sertifikat.php", // URL untuk upload
            paramName: "background_file", // Parameter name
            maxFilesize: 1, // MB
            acceptedFiles: "image/jpg,image/jpeg,image/png",
            addRemoveLinks: true,
            autoProcessQueue: false, // Tidak otomatis upload
            parallelUploads: 5, // Bisa upload multiple file
            uploadMultiple: true, // Enable multiple file upload
            dictDefaultMessage: "<i class='bi bi-cloud-arrow-up' style='font-size: 2rem;'></i><br>Seret file ke sini atau klik untuk mengupload<br><span class='text-muted'>(Format: JPG, PNG, JPEG)</span>",
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
                
                // Ketika file ditambahkan
                this.on("addedfile", function(file) {
                    // Update tampilan daftar file
                    const files = $('#background_file')[0].files;
                    const fileList = $('#fileListContent');
                    
                    fileList.empty();
                    
                    if (files.length > 0) {
                        $('#selectedFiles').show();
                        
                        for (let i = 0; i < files.length; i++) {
                            fileList.append('<div class="file-list-item">' + (i+1) + '. ' + files[i].name + '</div>');
                        }
                    }
                });
            }
        });
        
        // Handle klik pada seluruh area dropzone untuk memunculkan file dialog
        $('#myDropzone').click(function(e) {
            // Hanya trigger jika yang diklik bukan elemen dropzone internal
            if ($(e.target).hasClass('dropzone') || $(e.target).hasClass('dz-message')) {
                $('#background_file').click();
            }
        });
    });
</script>