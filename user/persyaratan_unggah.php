<?php 
include "../layout/sidebarUser.php"; 

// Periksa apakah id_pengajuan dan id_user ada dalam query string
if (isset($_GET['id_pengajuan']) && isset($_GET['id_user'])) {
    $id_pengajuan = $_GET['id_pengajuan'];
    $id_user = $_GET['id_user'];  // Ambil id_user dari query string
} else {
    // Jika id_pengajuan atau id_user tidak ditemukan, arahkan ke halaman lain atau tampilkan pesan error
    echo "<script>alert('ID Pengajuan atau ID User tidak ditemukan!'); window.location.href='persyaratan_daftar.php';</script>";
    exit();
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Persyaratan</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Persyaratan yang ditentukan Instansi</li>
            <a href="persyaratan_daftar.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>" class="btn btn-secondary">Lihat Daftar Dokumen Persyaratan</a>
        </ol>
        <div class="dropdown-divider"></div><br><br>

        <form action="upload_process.php" class="form-profile" method="POST" enctype="multipart/form-data">
            <div id="file-container" class="mb-3">
                <div class="file-input-group d-flex align-items-center mb-2">
                    <!-- Input type file untuk mengunggah dokumen -->
                    <input type="file" class="form-control me-2" name="persyaratan[]" accept=".pdf,.doc,.docx,.jpg,.png" required>
                    <!-- Input tersembunyi untuk mengirimkan jenis dokumen ke server -->
                    <input type="hidden" name="jenis_dokumen[]" value="persyaratan">
                    <!-- Tombol untuk menghapus input -->
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFileInput(this)">−</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="addFileInput()">Tambah</button><br>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Unggah Persyaratan</button>
        </form>
    </div>
</div>

<script>
    let fileCount = 1;
    function addFileInput() {
        fileCount++;
        let container = document.getElementById("file-container");
        let div = document.createElement("div");
        div.className = "file-input-group d-flex align-items-center mb-2";
        div.innerHTML = `
            <!-- Input type file untuk mengunggah dokumen -->
            <input type="file" class="form-control me-2" name="persyaratan[]" accept=".pdf" required>
            <!-- Input tersembunyi untuk mengirimkan jenis dokumen ke server -->
            <input type="hidden" name="jenis_dokumen[]" value="persyaratan">
            <!-- Tombol untuk menghapus input -->
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
</script>

<?php include "../layout/footerDashboard.php"; ?>
