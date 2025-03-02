<?php include "sidebar.php";
    $id_user_ini = $_GET["id_user"];
    $pengguna = query("SELECT * FROM tb_profile_user WHERE id_user = '$id_user_ini'")[0];

    if(isset($_POST["edit_data_user"])) {
        if(super_admin_edit($_POST)) { ?>
        <script>edit_user_super_admin_success()</script>
        <?php } else { ?>
        <script>edit_user_super_admin_gagal()</script>
        <?php }
    }
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Edit User </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Edit User</li>
        </ol>
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user_ini ?>">
            <!-- Nama -->
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_user" value="<?= $pengguna["nama_user"] ?>">
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $pengguna["tempat_lahir"] ?>">
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $pengguna["tanggal_lahir"] ?>">
            </div>

            <!-- gender -->
            <div class="mb-3">
            <label for="gender" class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="gender_l" class="form-check-input" value="L" 
                        <?= ($pengguna["jenis_kelamin"] == 1) ? "checked" : "" ?>>
                    <label for="gender_l" class="form-check-label">Laki - Laki</label>
                </div>

                <div class="form-check">    
                    <input type="radio" name="jenis_kelamin" id="gender_p" class="form-check-input" value="P" 
                        <?= ($pengguna["jenis_kelamin"] == 0) ? "checked" : "" ?>>
                    <label for="gender_p" class="form-check-label">Perempuan</label>
                </div>
            </div>


            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="no_telepone" class="form-label">No. Telepone</label>
                <input type="tel" pattern="[0-9]{8,15}" inputmode="numeric" maxlength="15" class="form-control" id="no_telepone" name="telepone_user" value="<?= $pengguna["telepone_user"] ?>">
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat_user" rows="3"><?= $pengguna["alamat_user"] ?></textarea>
            </div>

            <!-- Upload Foto Profil -->
            <div class="input-field ">
                <label for="image">Edit Foto Profil (Max 1MB)</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/user/<?= $pengguna["gambar_user"] ?>" id="previewImage" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <input type="hidden" name="gambar_lama" id="gambar_lama" value="<?= $pengguna["gambar_user"] ?>">
                </div>
                <input type="file" class="input" id="image" name="gambar_user" accept="image/*" onchange="validateFile()">
            </div>

            <!-- Submit Button -->
            <button type="submit" name="edit_data_user" class="btn btn-primary edit">Simpan Perubahan</button>
        </form>
        <a href="user_view.php" class="btn btn-danger bi bi-arrow-left-circle"> Kembali</a>
    </div>
</div>
<?php include "footer.php" ?>


<script>
function validateFile() {
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
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    document.getElementById("no_telepone").addEventListener("input", function (e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });

</script>