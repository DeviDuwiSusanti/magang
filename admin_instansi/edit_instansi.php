<?php include "../layout/header.php";

$edit_instansi = "SELECT * 
    FROM tb_instansi
    JOIN tb_profile_user 
        ON tb_instansi.id_instansi = tb_profile_user.id_instansi
    WHERE tb_profile_user.id_user = '$id_user'";

$query = mysqli_query($conn, $edit_instansi);
$edit_instansi = mysqli_fetch_assoc($query);

$status = "";
if (isset($_POST["edit_instansi"])) {
    if (edit_instansi_1($_POST) > 0) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Instansi</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Edit Profile Instansi</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end mt-3">
            <a href="view_instansi.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle me-1"></i>Kembali</a>
        </div>
        <form action="" class="form-instansi" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
            <input type="hidden" name="id_instansi" value="<?= $edit_instansi["id_instansi"] ?>">
            <input type="hidden" id="group_instansi" name="group_instansi" value="<?= $edit_instansi["group_instansi"] ?>">
            <!-- <input type="hidden" id="lokasi_instansi" name="lokasi_instansi" rows="3"><?= $edit_instansi["lokasi_instansi"] ?></input> -->
            <!-- Nama Instansi Panjang-->
            <div class="mb-3">
                <label for="nama_panjang" class="form-label">Nama Lengkap Instansi</label>
                <input type="text" class="form-control" id="nama_panjang" name="nama_panjang" placeholder="Masukkan nama instansi" value="<?= $edit_instansi["nama_panjang"] ?>">
            </div>

            <!-- Nama Instansi Pendek-->
            <div class="mb-3">
                <label for="nama_pendek" class="form-label">Nama Singkat Instansi</label>
                <input type="text" class="form-control" id="nama_pendek" name="nama_pendek" placeholder="Masukkan nama instansi" value="<?= $edit_instansi["nama_pendek"] ?>">
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi_instansi" class="form-label">Deskripsi Instansi</label>
                <textarea class="form-control" id="deskripsi_instansi" name="deskripsi_instansi" rows="3" placeholder="Masukkan deskripsi instansi"><?= $edit_instansi["deskripsi_instansi"] ?></textarea>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat_instansi" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat_instansi" name="alamat_instansi" rows="3" placeholder="Masukkan alamat lengkap"><?= $edit_instansi["alamat_instansi"] ?></textarea>
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label for="telepone_instansi" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepone_instansi" name="telepone_instansi" placeholder="Masukkan nomor telepon" value="<?= $edit_instansi["telepone_instansi"] ?>">
            </div>

            <!-- Lokasi Instansi -->
            <div class="mb-3">
                <label for="lokasi_instansi" class="form-label">Link Lokasi</label>
                <textarea class="form-control" id="lokasi_instansi" name="lokasi_instansi" rows="3" placeholder="Masukkan link lokasi"><?= $edit_instansi["lokasi_instansi"] ?></textarea>
            </div>

            <!-- Upload Foto Profil -->
            <div class="mb-3">
                <label for="gambar_instansi" class="form-label">Foto Profil</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/instansi/<?= $edit_instansi["gambar_instansi"] ?: 'logo_kab_sidoarjo.png' ?>" id="previewImage" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; object-position: top;">
                    <input type="hidden" name="gambar_instansi" id="gambar_instansi" value="<?= $edit_instansi["gambar_instansi"] ?>">
                </div>
                <input type="file" class="input form-control" id="image" name="gambar_instansi" accept="image/*" onchange="previewFile()">
                <small class="text-muted">Kosong Jika tidak ingin di ganti</small>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit" name="edit_instansi"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    <?php if ($status === "success"): ?>
        alertSuccessEdit('Data instansi berhasil diperbarui.', 'view_instansi.php');
    <?php elseif ($status === "error"): ?>
        alertSuccessEdit('Tidak ada perubahan. Data instansi disimpan.', 'view_instansi.php');
    <?php endif; ?>

    function previewFile() {
        const fileInput = document.getElementById('image');
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const file = fileInput.files[0];

        if (file) {
            if (file.size > 1048576) { // 1MB = 1048576 bytes
                alert("Ukuran file terlalu besar! Maksimal 1MB.");
                fileInput.value = ""; // Reset file input
                previewImage.src = ""; // Hapus pratinjau
                previewContainer.style.display = "none";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }
</script>