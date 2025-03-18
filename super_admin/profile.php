<?php
include "sidebar.php";

// Query untuk mengambil data profile
$profile = query("SELECT * FROM tb_profile_user, tb_user WHERE tb_profile_user.id_user = '$id_user' AND tb_user.id_user = '$id_user'")[0];
$jenis_kelamin = ($profile["jenis_kelamin"] == 0 ? "Perempuan" : "Laki - Laki");

// Handle edit profile
if (isset($_POST["edit_profile"])) {
    if (edit_profile_super_admin($_POST) > 0) { 
        echo "<script>edit_profile_super_admin_success()</script>";
    } else { 
        echo "<script>edit_profile_super_admin_gagal()</script>";
    }
}
?>

<div class="container">
    <h1 class="mb-4 mt-4">My Profile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Halaman View Profile</li>
    </ol>
    <div class="container mt-5 mb-5">
        <div class="card mx-auto shadow" style="max-width: 500px;">
            <div class="card-body">
                <img src="../assets/img/user/<?= $profile["gambar_user"] ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                <h4 class="card-title"><?= $profile["nama_user"] ?></h4>
                <p class="text-muted"><?= $profile["email"] ?></p>
                
                <hr>
                <div class="card-body">
                    <table class="table">
                        <tbody class="text-start">
                            <tr>
                                <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                <td><?= $profile["nama_user"] ?></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-envelope"></i> <strong>Email</strong></td>
                                <td><?= $profile["email"] ?></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                                <td><?= $profile["telepone_user"] ?></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-gender-ambiguous"></i> <strong>Gender</strong></td>
                                <td><?= $jenis_kelamin ?></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                <td><?= $profile["alamat_user"] ?></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar"></i> <strong>TTL</strong></td>
                                <td><?= $profile["tempat_lahir"] ?> , <?= $profile["tanggal_lahir"] ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Tombol Edit Profile -->
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="bi bi-pencil"></i> Edit Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                    <input type="hidden" name="id_user" value="<?= $profile["id_user"] ?>">
                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama_user" value="<?= $profile["nama_user"] ?>">
                    </div>
                    <!-- Tempat Lahir -->
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $profile["tempat_lahir"] ?>">
                    </div>
                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $profile["tanggal_lahir"] ?>">
                    </div>
                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <div class="form-check">
                            <input type="radio" name="jenis_kelamin" id="gender_l" class="form-check-input" value="1" <?= ($profile["jenis_kelamin"] == 1) ? "checked" : "" ?>>
                            <label for="gender_l" class="form-check-label">Laki - Laki</label>
                        </div>
                        <div class="form-check">    
                            <input type="radio" name="jenis_kelamin" id="gender_p" class="form-check-input" value="0" <?= ($profile["jenis_kelamin"] == 0) ? "checked" : "" ?>>
                            <label for="gender_p" class="form-check-label">Perempuan</label>
                        </div>
                    </div>
                    <!-- Telepon -->
                    <div class="mb-3">
                        <label for="no_telepone" class="form-label">No. Telepon</label>
                        <input type="tel" pattern="[0-9]{8,15}" maxlength="15" inputmode="numeric" class="form-control" id="no_telepone" name="telepone" value="<?= $profile["telepone_user"] ?>">
                        <small id="telepon_error" class="text-danger"></small>
                    </div>
                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat_user" rows="3"><?= $profile["alamat_user"] ?></textarea>
                    </div>
                    <!-- Upload Foto Profil -->
                    <div class="input-field">
                        <label for="image">Edit Foto Profil (Max 1MB)</label><br><br>
                        <div class="image-preview" id="imagePreview">
                            <img src="../assets/img/user/<?= $profile["gambar_user"] ?>" id="previewImage" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                            <input type="hidden" name="gambar_lama" id="gambar_lama" value="<?= $profile["gambar_user"] ?>">
                        </div>
                        <input type="file" class="input" id="image" name="gambar" accept="image/*" onchange="validateFile()">
                    </div>
                    <!-- Submit Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="edit_profile" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<!-- JavaScript untuk Modal dan Validasi -->
<script>
    // Fungsi untuk validasi file
    function validateFile() {
        const fileInput = document.getElementById('image');
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const file = fileInput.files[0];

        if (file) {
            if (file.size > 1048576) { // 1MB = 1048576 bytes
                alert("Ukuran file terlalu besar! Maksimal 1MB.");
                fileInput.value = ""; // Reset file input
                previewImage.src = "../assets/img/user/<?= $profile["gambar_user"] ?>"; // Kembalikan ke gambar lama
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result; // Tampilkan pratinjau gambar baru
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    // Fungsi untuk validasi form edit
    function validateEditForm() {
        let telepon = document.getElementById('no_telepone').value;
        let isValid = true;

        // Validasi Telepon
        if (!/^\d+$/.test(telepon)) {
            document.getElementById('telepon_error').textContent = "Telepon hanya boleh berisi angka.";
            isValid = false;
        } else {
            document.getElementById('telepon_error').textContent = "";
        }

        return isValid;
    }

    // Event listener untuk input telepon
    document.getElementById("no_telepone").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    });
</script>