<?php 
include "../layout/sidebarUser.php"; 
include "functions.php";  // Pastikan untuk meng-include file functions.php

// Inisialisasi variabel agar tidak undefined
if (isset($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
} else {
    echo "<script>alert('ID Pengajuan tidak ditemukan.'); window.history.back();</script>";
    exit();
}

if (isset($_POST['submit_persyaratan'])) {
    if (!isset($_FILES['persyaratan']) || empty($_FILES['persyaratan']['name'][0])) {
        echo "<script>alert('Pilih minimal satu file untuk diunggah!');</script>";
    } else {
        foreach ($_FILES['persyaratan']['name'] as $key => $name) {
            if ($_FILES['persyaratan']['error'][$key] == 0) {
                $file_extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if ($file_extension !== "pdf") {
                    echo "<script>alert('Hanya file PDF yang diperbolehkan!');</script>";
                    exit();
                }

                $uploaded_file = [
                    'name' => $_FILES['persyaratan']['name'][$key],
                    'tmp_name' => $_FILES['persyaratan']['tmp_name'][$key]
                ];
                
                $file_data = uploadFile($uploaded_file);
                $file_name = $file_data['name'];
                $file_path = $file_data['path'];
                
                // Generate ID dokumen
                $id_dokumen = generateIdDokumen($conn, $id_user); 
                
                // Simpan informasi dokumen ke database
                $sql = "INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) 
                        VALUES ('$id_dokumen', '$file_name', '2', '$file_path', '$id_pengajuan', '$id_user', '$id_user', '1', NOW(), NOW())";
                
                $query = mysqli_query($conn, $sql);
                if (!$query) {
                    die("<script>alert('Gagal menyimpan data ke database: " . mysqli_error($conn) . "'); window.history.back();</script>");
                }
            }
        }
        showAlert('Berhasil!', 'Persyaratan Berhasil Diunggah', 'success', "persyaratan_daftar.php?id_pengajuan=$id_pengajuan&id_user=$id_user");
        exit();
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Unggah Persyaratan</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Persyaratan yang ditentukan Instansi</li>
            <?php if (!is_null($id_pengajuan) && !is_null($id_user)) : ?>
                <a href="persyaratan_daftar.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>" class="btn btn-secondary">
                    Lihat Daftar Dokumen Persyaratan
                </a>
            <?php endif; ?>
        </ol>
        <div class="dropdown-divider"></div><br><br>

        <form action="" class="form-profile" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div id="file-container" class="mb-3">
                <div class="file-input-group d-flex align-items-center mb-2">
                <input type="file" class="form-control me-2" name="persyaratan[]" onchange="validateFile(this)">
                <input type="hidden" name="jenis_dokumen[]" value="persyaratan">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFileInput(this)">−</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="addFileInput()">Tambah</button><br>
            <button type="submit" class="btn btn-primary" name="submit_persyaratan">Unggah Persyaratan</button>
        </form>
    </div>
</div>

<script>
    function addFileInput() {
        let container = document.getElementById("file-container");
        let div = document.createElement("div");
        div.className = "file-input-group d-flex align-items-center mb-2";
        div.innerHTML = `
            <input type="file" class="form-control me-2" name="persyaratan[]" onchange="validateFile(this)">
            <input type="hidden" name="jenis_dokumen[]" value="persyaratan">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeFileInput(this)">−</button>
        `;
        container.appendChild(div);
    }

    function removeFileInput(button) {
        let container = document.getElementById("file-container");
        if (container.children.length > 1) {
            button.parentElement.remove();
        }
    }

    function validateFile(input) {
        let file = input.files[0];
        if (file) {
            let allowedExtensions = /(\.pdf)$/i;
            if (!allowedExtensions.exec(file.name)) {
                alert("Hanya file PDF yang diperbolehkan!");
                input.value = ""; // Mengosongkan input file
            }
        }
    }

    function validateForm() {
        let files = document.querySelectorAll('input[type="file"]');
        for (let file of files) {
            if (file.files.length === 0) {
                alert("Pilih minimal satu file untuk diunggah!");
                return false;
            }
        }
        return true;
    }
</script>

<?php include "../layout/footerDashboard.php"; ?>