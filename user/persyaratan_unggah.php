<?php 
include "../layout/sidebarUser.php"; 
include "functions.php"; 

// Inisialisasi variabel agar tidak undefined
if (isset($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
} else {
    echo "<script>alert('ID Pengajuan tidak ditemukan.'); window.history.back();</script>";
    exit();
}

// Proses upload file jika ada permintaan dari Dropzone
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    include "../koneksi.php"; // Pastikan koneksi database
    
    $id_pengajuan = $_POST['id_pengajuan'];
    $id_user = $_POST['id_user'];
    
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if ($file_extension !== "pdf") {
        echo json_encode(["status" => "error", "message" => "Hanya file PDF yang diperbolehkan!"]);
        exit();
    }
    
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_path = $upload_dir . uniqid() . "_" . basename($file_name);
    
    if (move_uploaded_file($file_tmp, $file_path)) {
        $id_dokumen = generateIdDokumen($conn, $id_user);
        $sql = "INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) 
                VALUES ('$id_dokumen', '$file_name', '2', '$file_path', '$id_pengajuan', '$id_user', '$id_user', '1', NOW(), NOW())";
        mysqli_query($conn, $sql);
        echo json_encode(["status" => "success", "message" => "File berhasil diunggah!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal mengunggah file!"]);
    }
    exit();
}

?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Unggah Persyaratan</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Persyaratan yang ditentukan Instansi</li>
            <a href="persyaratan_daftar.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>" class="btn btn-secondary">
                Lihat Daftar Dokumen Persyaratan
            </a>
        </ol>
        <div class="dropdown-divider"></div><br><br>

        <form action="" class="dropzone" id="myDropzone" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan ?>">
            <input type="hidden" name="id_user" value="<?= $id_user ?>">
        </form>
        <br>
        <button type="button" class="btn btn-primary" id="submit-all">Unggah Persyaratan</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script>
   Dropzone.autoDiscover = false;
let myDropzone = new Dropzone("#myDropzone", {
    url: window.location.href, // Kirim ke halaman yang sama
    acceptedFiles: ".pdf",
    maxFilesize: 5, // Maksimal ukuran file dalam MB
    paramName: "file",
    autoProcessQueue: false,
    parallelUploads: 10,
    addRemoveLinks: true,
    clickable: true, 
    init: function() {
        let dz = this;
        document.getElementById("submit-all").addEventListener("click", function() {
            if (dz.getQueuedFiles().length === 0) {
                alert("Tidak ada file yang diunggah!");
                return;
            }
            dz.processQueue();
        });

        dz.on("queuecomplete", function() {
            alert("Semua file berhasil diunggah!");
            window.location.href = "persyaratan_daftar.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>";
        });

        dz.on("error", function(file, message) {
            alert("Terjadi kesalahan saat mengunggah: " + message);
        });
    }
});

</script>

<?php include "../layout/footerDashboard.php"; ?>
