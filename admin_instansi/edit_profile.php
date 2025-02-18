<?php
include "../layout/header.php";
$edit_profile = query("SELECT * FROM tb_profile_user, tb_user WHERE tb_profile_user.id_user = '$id_user' AND tb_user.id_user = '$id_user'")[0];

$status = "";
if (isset($_POST["edit_profile"])) {
    if (edit_profile_1($_POST) > 0) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Profile</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Edit Profile Admin Instansi</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        <div class="mb-4 text-end">
            <a href="view_profile.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>
        <form action="" id="editForm" class="form-profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $edit_profile["id_user"] ?>">
            <!-- Nama -->
            <div class="mb-3">
                <label for="nama_user" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Masukkan tempat lahir" value="<?= $edit_profile["nama_user"] ?>">
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir" value="<?= $edit_profile["tempat_lahir"] ?>">
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $edit_profile["tanggal_lahir"] ?>">
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender_l" value="L" <?= $edit_profile["jenis_kelamin"] == "L" ? "checked" : "" ?>>
                        <label class="form-check-label" for="gender_l">Laki-Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender_p" value="P" <?= $edit_profile["jenis_kelamin"] == "P" ? "checked" : "" ?>>
                        <label class="form-check-label" for="gender_p">Perempuan</label>
                    </div>
                </div>
            </div>

            <!-- Telepone -->
            <div class="mb-3">
                <label for="no_telepone" class="form-label">No. Telepone</label>
                <input type="text" class="form-control" id="no_telepone" name="telepone" value="<?= $edit_profile["telepone_user"] ?>">
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat_user" rows="3" placeholder="Masukkan alamat lengkap"><?= $edit_profile["alamat_user"] ?></textarea>
            </div>

            <!-- Upload Foto Profil -->
            <div class="mb-3">
                <label for="image">Foto Profil</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/user/<?= $edit_profile["gambar_user"] ?: 'avatar.png' ?>" id="previewImage" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; object-position: top;">
                    <input type="hidden" name="gambar_lama" id="gambar_lama" value="<?= $edit_profile["gambar_user"] ?>">
                </div>
                <input type="file" class="input form-control" id="image" name="gambar" accept="image/*" onchange="previewFile()">
                <small class="text-muted">Kosong Jika tidak ingin di ganti</small>
            </div>

            <!-- Tombol Submit -->
            <button id="kirimBtn" type="submit" class="btn btn-primary edit" name="edit_profile"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    <?php if ($status === "success"): ?>
        alertSuccessEdit('Data profile berhasil diperbarui.', 'view_profile.php');
    <?php elseif ($status === "error"): ?>
        alertSuccessEdit('Tidak ada perubahan. Data profile disimpan.', 'view_profile.php');
    <?php endif; ?>


    function previewFile() {
        const fileInput = document.getElementById('image');
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const file = fileInput.files[0];

        if (file) {
            if (file.size > 1048576) { // 1MB = 1048576 bytes
                // alert("Ukuran file terlalu besar! Maksimal 1MB.");
                alertErrorRegister('Ukuran file terlalu besar! Maksimal 1MB.', 'edit_profile.php');
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