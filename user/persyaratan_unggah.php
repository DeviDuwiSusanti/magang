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
    $deskripsi = $_POST['deskripsi'] ?? 'Tidak ada deskripsi';

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
        $id_dokumen = generateIdDokumen($conn, $id_pengajuan);
        $sql = "INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) 
                VALUES ('$id_dokumen', '$deskripsi', '2', '$file_path', '$id_pengajuan', '$id_user', '$id_user', '1', NOW(), NOW())";
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<style>
   .dropzone {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: flex-start;
    border: 2px dashed #007bff;
    padding: 20px;
    border-radius: 10px;
    background: #f9f9f9;
    transition: 0.3s;
}

.dropzone:hover {
    border-color: #0056b3;
    background: #eef4ff;
}

.dz-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 140px !important;
        height: 190px !important;
        position: relative;
        border-radius: 12px;
        background: #ffffff;
        padding: 12px;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #ddd;
    }

    .dz-preview:hover {
        transform: translateY(-3px);
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
    }

    .pdf-icon {
        width: 45px;
        height: 45px;
        margin-bottom: 10px;
    }

    .deskripsi-input {
        width: 100%;
        font-size: 12px;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        margin-top: 5px;
    }

    .action-container {
        position: absolute;
        top: 6px;
        right: 6px;
        z-index: 10;
    }

    .remove-button {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        z-index: 10;
    }

    .remove-button:hover {
        background: darkred;
        transform: scale(1.1);
    }
</style>

<script>
    Dropzone.autoDiscover = false;
let myDropzone = new Dropzone("#myDropzone", {
    url: window.location.href,
    acceptedFiles: ".pdf",
    maxFilesize: 5,
    paramName: "file",
    autoProcessQueue: false,
    parallelUploads: 10,
    addRemoveLinks: false,
    clickable: true,
    thumbnailWidth: 50,
    thumbnailHeight: 50,
    init: function () {
        let dz = this;

        document.getElementById("submit-all").addEventListener("click", function () {
            if (dz.getQueuedFiles().length === 0) {
                alert("Tidak ada file yang diunggah!");
                return;
            }
            dz.processQueue();
        });

        dz.on("addedfile", function (file) {
            let filePreview = file.previewElement;
            filePreview.classList.add("custom-preview");

            // Tambahkan ikon PDF
            let pdfIcon = document.createElement("img");
            pdfIcon.src = "https://cdn-icons-png.flaticon.com/512/337/337946.png";
            pdfIcon.className = "pdf-icon";

            let dzImage = filePreview.querySelector(".dz-image");
            dzImage.innerHTML = "";
            dzImage.appendChild(pdfIcon);

            // Input deskripsi
            let descriptionInput = document.createElement("input");
            descriptionInput.setAttribute("type", "text");
            descriptionInput.setAttribute("name", "descriptions[]");
            descriptionInput.setAttribute("placeholder", "Deskripsi...");
            descriptionInput.className = "form-control deskripsi-input";

            // Tombol hapus
            let removeButton = document.createElement("button");
            removeButton.className = "remove-button";
            removeButton.innerHTML = "<i class='fas fa-trash-alt'></i>";

            // Event listener agar bisa menghapus file dari Dropzone
            removeButton.addEventListener("click", function (event) {
                event.preventDefault();
                event.stopPropagation();
                dz.removeFile(file); // Pastikan ini bekerja
                console.log("File dihapus:", file.name); // Debugging
            });

            // Bungkus dalam div agar tombol hapus selalu di atas
            let actionContainer = document.createElement("div");
            actionContainer.className = "action-container";
            actionContainer.appendChild(removeButton);

            // Tambahkan ke tampilan
            filePreview.appendChild(actionContainer);
            filePreview.appendChild(descriptionInput);
        });

        dz.on("sending", function (file, xhr, formData) {
            let descriptionInput = file.previewElement.querySelector("input[name='descriptions[]']");
            formData.append("deskripsi", descriptionInput ? descriptionInput.value : "Tidak ada deskripsi");
        });

        dz.on("queuecomplete", function () {
            alert("Semua file berhasil diunggah!");
            window.location.href = "persyaratan_daftar.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>";
        });

        dz.on("error", function (file, message) {
            alert("Terjadi kesalahan saat mengunggah: " + message);
        });
    }
});

    </script>


<?php include "../layout/footerDashboard.php"; ?>
