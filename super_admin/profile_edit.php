<?php
    include "sidebar.php"; 
    $profile_edit = query("SELECT * FROM tb_profile_user, tb_user WHERE tb_profile_user.id_user = '$id_user' AND tb_user.id_user = '$id_user'")[0];



    if (isset($_POST["edit_profile"])) {
        if (edit_profile_1($_POST) > 0) {
            ECHO "<script>
                    alert('berhasil di edit');
                    document.location.href = 'profile_view.php' ;
                </script>";
        } else {
            ECHO "<script>alert('gagal di edit'); document.location.href = profile_edit.php</script>";
        }
    }
?>



<div class="main-content">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Edit Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Edit Profile</li>
        </ol>
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $profile_edit["id_user"] ?>">
            <!-- Nama -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap : </label>
                <input type="text" class="form-control" id="nama" name="nama_user" value="<?= $profile_edit["nama_user"] ?>">
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir: </label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $profile_edit["tempat_lahir"] ?>">
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $profile_edit["tanggal_lahir"] ?>">
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="gender_l" class="form-check-input" value="<?= $profile_edit["jenis_kelamin"] ?>" checked>
                    <label for="gender_l" class="form-check-label">Laki - Laki</label>
                </div>
                <div class="form-check">    
                    <input type="radio" name="jenis_kelamin" id="gender_p" class="form-check-input" value="<?= $profile_edit["jenis_kelamin"] ?>" checked>
                    <label for="gender_p" class="form-check-label">Perempuan</label>
                </div>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="no_telepone" class="form-label">No. Telepone</label>
                <input type="text" class="form-control" id="no_telepone" name="telepone" value="<?= $profile_edit["telepone_user"] ?>">
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat_user" rows="3" required><?= $profile_edit["alamat_user"] ?></textarea>
            </div>

            <!-- Upload Foto Profil -->
            <div class="input-field ">
                <label for="image">Edit Foto Profil (Max 1MB)</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/user/<?= $profile_edit["gambar_user"] ?>" id="previewImage" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <input type="hidden" name="gambar_lama" id="gambar_lama" value="<?= $profile_edit["gambar_user"] ?>">
                </div>
                <input type="file" class="input" id="image" name="gambar" accept="image/*" onchange="validateFile()">
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit" name="edit_profile">Simpan Perubahan</button>
        </form>
        <a href="profile_view" class="btn btn-danger bi bi-arrow-left-circle"> Kembali</a>
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
</script>