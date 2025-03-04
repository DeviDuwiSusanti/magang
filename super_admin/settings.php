<?php 
    include "sidebar.php";
    $super_admin = query("SELECT * FROM tb_user WHERE id_user = '$id_user'")[0];
    $admin_instansi = query("SELECT * FROM tb_profile_user , tb_user  WHERE tb_profile_user.id_user = tb_user.id_user AND tb_user.level = '2'");

    if (isset($_POST["edit_email"])) {
        if (edit_email_super_admin($_POST) > 0) {
            echo "<script>edit_email_super_admin_success();</script>";
        } else {
            echo "<script>edit_email_super_admin_gagal();</script>";
        }
    }
?>

<div class="container mt-4">
    <h2 class="text-center"><i class="bi bi-gear"></i> Pengaturan Super Admin</h2>
    <p class="text-center text-muted">Kelola akun dan pengguna di sistem.</p>

    <div class="row">
        <div class="col-md-6">
            <!-- Edit Email Super Admin -->
            <div class="card mb-4 p-4">
                <h4><i class="bi bi-envelope"></i> Edit Email</h4>
                <p>Email Saat Ini: <strong><?= $super_admin["email"] ?></strong></p>
                <!-- Form Edit Email Super Admin -->
                <form action="" method="POST" id="edit-email-form">
                    <div class="mb-3">
                        <label for="email_baru" class="form-label">Email Baru</label>
                        <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                        <input type="email" name="email_baru" class="form-control" id="email_baru" placeholder="Masukkan email baru" required>
                    </div>
                    <button type="button" name="edit_email" onclick="confirm_edit_email_super_admin()" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Jadikan User sebagai Super Admin -->
            <div class="card p-4">
                <h4><i class="bi bi-person-gear"></i> Jadikan Super Admin</h4>
                <p>Pilih pengguna untuk dijadikan Super Admin.</p>
                <form action="" method="POST" id="jadikan-super-admin-form">
                    <div class="mb-3">
                        <label for="user" class="form-label">Pilih User</label>
                        <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                        <select class="form-select select2" id="user">
                            <option selected disabled>Pilih User</option>
                            <?php foreach($admin_instansi as $calon) : ?>
                            <option value="<?= $calon["id_user"] ?>"><?= $calon["nama_user"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="generate_super_admin" class="btn btn-warning"><i class="bi bi-person-badge"></i> Jadikan Super Admin</button>
                </form>
            </div>
        </div>

        <!-- Tambah Super Admin Baru -->
        <div class="col-md-12"></div>
            <h4 class="mt-5"><i class="bi bi-person-plus"></i> Tambah Super Admin Baru</h4>
            <form action="" class="form-profile" method="POST" enctype="multipart/form-data" id="tambah-super-admin-form">
            
            <input type="hidden" name="id_super_admin" id="id_super_admin" value="<?= $super_admin["id_user"] ?>">
            <!-- Nama -->
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_user" placeholder="Masukkan Nama Lengkap Calon Admin Instansi" required>
            </div>

            <!-- NIK -->
            <div class="mb-3">
                <label for="nik_admin_instansi" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik_user" inputmode="numeric" name="nik_user" placeholder="Masukkan NIK Calon Admin Instansi (16)" required maxlength="16">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email_admin_instansi" class="form-label">Email</label>
                <input type="text" class="form-control" id="email_admin_instansi" name="email" placeholder="Masukkan Email Calon Admin Instansi" required>
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir Calon Admin Instansi">
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir Calon Admin Instansi">
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label"> Jenis Kelamin </label>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="gender_l" value="L" class="form-check-input" required>
                    <label for="gender_l" class="form-check-label">Laki - Laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="gender_p" value="P" class="form-check-input" required>
                    <label for="gender_p" class="form-check-label">Perempuan</label>
                </div>
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="telepon_user" inputmode="numeric" maxlength="15" name="telepone_user" placeholder="Masukkan Nomor telepone Calon Admin Instansi">
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat_user" rows="3" placeholder="Masukkan Alamat Calon Admin Instansi"></textarea>
            </div>

            <!-- Upload Foto Profil -->
            <div class="input-field ">
                <label for="image">Upload Foto (Max 1MB)</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/user/avatar.png" id="previewImage" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                </div>
                <input type="file" class="input" id="image" name="gambar_instansi" accept="image/*" onchange="validateFile()">
            </div>


            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit">Tambah Data Super Admin</button>
        </form>
    </div>
</div>
<?php include "footer.php" ?>


<script>
    $(document).ready(function() {
        // Inisialisasi Select2 pada elemen <select>
        $('.select2').select2({
            placeholder: "Cari User...", // Placeholder untuk input pencarian
            allowClear: true, // Memungkinkan user menghapus pilihan
            width: '100%', // Lebar dropdown
            minimumResultsForSearch: 1 // Menampilkan fitur pencarian bahkan jika hanya ada 1 opsi
        });

        // Menambahkan pesan jika tidak ada hasil pencarian
        $('.select2').on('select2:open', function() {
            const searchInput = document.querySelector('.select2-search__field');
            searchInput.setAttribute('placeholder', 'Ketik untuk mencari...');
        });

        $('.select2').on('select2:close', function() {
            const noResults = document.querySelector('.select2-results__message');
            if (noResults) {
                noResults.textContent = 'Tidak ditemukan';
            }
        });
    });

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

        document.getElementById("nik_user").addEventListener("input", function (e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });
        document.getElementById("telepone_user").addEventListener("input", function (e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });

</script>
