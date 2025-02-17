<?php 
include "../layout/sidebarUser.php"; 
include '../koneksi.php';  // Pastikan koneksi ke database sudah benar

// Cek apakah id_user ada dalam query string atau sesi
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
} elseif (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
} else {
    echo "id_user tidak ditemukan.";
    exit;  // Jika id_user tidak ada, hentikan proses
}

// Proses unggah file
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['laporan_akhir'])) {
    $file = $_FILES['laporan_akhir'];  // Ambil file yang diunggah
    $file_name = basename($file['name']);
    $file_tmp = $file['tmp_name'];
    $file_error = $file['error'];
    $file_size = $file['size'];

    // Tentukan direktori tujuan penyimpanan file
    $upload_dir = 'uploads/';
    $file_path = $upload_dir . $file_name;

    // Validasi file
    if ($file_error === 0) {
        if ($file_size < 5000000) {  // Batas ukuran file 5MB
            // Pastikan folder upload ada
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);  // Membuat folder jika belum ada
            }

            // Pindahkan file ke direktori tujuan
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Menyimpan data ke database dengan ID User
                $jenis_dokumen = 'Laporan Akhir';  // Jenis dokumen

                $stmt = $conn->prepare("INSERT INTO tb_dokumen (nama_dokumen, jenis_dokumen, file_path, id_user, create_date) 
                                       VALUES (?, ?, ?, ?, NOW())");
                $stmt->bind_param("sssi", $file_name, $jenis_dokumen, $file_path, $id_user);

                if ($stmt->execute()) {
                    // Jika berhasil, tampilkan alert
                    echo "<script>alert('Laporan berhasil diunggah!'); window.location.href='laprak_daftar.php?id_user=$id_user';</script>";
                }
            } else {
                echo "<script>alert('Gagal mengunggah file.');</script>";
            }
        }
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengunggah file.');</script>";
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Laporan Akhir</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Laporan Akhir Kegiatan</li>
            <a href="laprak_daftar.php?id_user=<?= $id_user ?>" class="btn btn-secondary">Lihat Daftar Laporan Akhir</a>
        </ol>
        <div class="dropdown-divider"></div><br><br>

        <!-- Form Unggah Laporan -->
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="laporan_akhir" class="form-label">Unggah Laporan Akhir (PDF)</label>
                <input type="file" class="form-control" id="laporan_akhir" name="laporan_akhir" accept=".pdf" required>
                <small class="text-muted">Pilih file laporan akhir (PDF)</small>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Unggah Laporan</button>
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
            <input type="file" class="form-control me-2" name="laporan_akhir[]" accept=".pdf" required>
            <!-- Input tersembunyi untuk mengirimkan jenis dokumen ke server -->
            <input type="hidden" name="jenis_dokumen[]" value="laporan akhir">
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