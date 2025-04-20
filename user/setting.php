<?php 
    include '../layout/sidebarUser.php';
    $email = query("SELECT email FROM tb_user WHERE id_user = '$id_user'")[0];
    $admin_instansi = query("SELECT * FROM tb_profile_user , tb_user  WHERE tb_profile_user.id_user = tb_user.id_user AND tb_user.level = '2'");

    if (isset($_POST["edit_email"])) {
        $result = edit_email_user($_POST);
        if ($result === 404) { ?>
            <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Email Sudah Terdaftar Silahkan Periksa Atau Guanakan Email Yang Lain", "setting.php"); </script>
        <?php } else if ($result > 0) { ?>
            <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Edit Email Berhasil Silahkan Login Ulang", "../logout.php"); </script>
        <?php } else { ?>
            <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Edit Email Gagal", "setting.php"); </script>
        <?php }
    }

    if(isset($_POST["generate_super_admin"])) {
        if(generate_super_admin($_POST) > 0 ) { ?>
            <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Menjadikan Super Admin Berhasil", "setting.php"); </script>
        <?php } else { ?>
            <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Menjadikan Super Admin Gagal", "setting.php"); </script>
        <?php }
    }
    
    // Handle tambah data
if (isset($_POST["tambah_super_admin"])) {
    $result = tambah_user_by_super_admin($_POST);
    if ($result === 404) { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Email Sudah Terdaftar Didalam Database, Silahkan Periksa Atau gunakan email Yang Lain", "setting.php"); </script>
    <?php } else if ($result === 405) { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "NIK Sudah Terdaftar Didialam Database, Silahkan Periksa Atau Gunakan NIK Yang Lain", "setting.php"); </script>
    <?php } else if ($result === 406) { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "NIP Sudah Terdaftar Didialam Database, Silahkan Periksa Atau Gunakan NIP Yang Lain", "setting.php"); </script>
    <?php } else if ($result > 0) { ?>
        <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Tambah Data User Berhasil", "setting.php"); </script>
    <?php } else { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Tambah Data User Gagal", "setting.php"); </script>
    <?php  }
}
?>

<!-- Modal Preview Gambar -->
<div id="imageModalPreview" class="image-modal" onclick="closeImageModal()">
    <span class="image-modal-close">&times;</span>
    <img class="image-modal-content" id="modalPreviewImage">
</div>

<style>
    /* style for preview image */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999; /* Lebih tinggi dari modal Bootstrap */
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.85);
        justify-content: center;
        align-items: center;
    }

    .image-modal-content {
        max-width: 90%;
        max-height: 90vh;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .image-modal-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10000;
    }

    .image-modal-close:hover {
        color: #ccc;
    }
</style>

<div class="container mt-4">
<h1 class="text-center"><i class="bi bi-gear"></i> Pengaturan</h1>
    <p class="text-center text-muted">Kelola akun dan sistem aplikasi.</p>

    <!-- Menu Navigasi -->
    <nav class="nav nav-pills justify-content-center mb-4">
        <a class="nav-link" href="#email"><i class="bi bi-envelope"></i> Email</a>
        <a class="nav-link" href="#sistem"><i class="bi bi-sliders"></i> Sistem</a>
        <a class="nav-link" href="#logout"><i class="bi bi-box-arrow-right"></i> logout</a>
    </nav>

    <div class="row">
        <div id="email" class="col-md-12">
            <div class="card mb-4 p-4">
                <h4><i class="bi bi-envelope"></i> Edit Email</h4>
                <p>Email Saat Ini: <strong><?= $email["email"] ?></strong></p>
                
                <form action="" method="POST" id="edit-email-form">
                    <div class="mb-3">
                        <label for="email_baru" class="form-label">Email Baru</label>
                        <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                        <input type="email" name="email_baru" class="form-control" id="email_baru" placeholder="email baru" required>
                    </div>
                    <input type="hidden" name="edit_email" value="1">
                    <button type="button" onclick="confirm_edit_email_user()" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>

                </form>

            </div>
        </div>

        <?php if($level == '1') : ?>
        <div class="col-md-12">
            <!-- Jadikan User sebagai Super Admin -->
            <div class="card p-4">
                <h4><i class="bi bi-person-gear"></i> Jadikan Super Admin</h4>
                <p>Pilih pengguna untuk dijadikan Super Admin.</p>
                <form action="" method="POST" id="jadikan-super-admin-form">
                    <div class="mb-3">
                        <label for="user" class="form-label">Pilih User</label>
                        <input type="hidden" name="change_by" id="change_by" value="<?= $id_user ?>">

                        <select class="form-select select2" id="calon" name="calon" required>
                            <option value="" selected disabled hidden>Pilih User</option>
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
            
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?> ">
            <input type="hidden" name="level" id="level" value="1">

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Nama Lengkap Calon Super Admin" required>
            </div>
            
            <div class="mb-3">
                <label for="email_admin_instansi" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email Calon Super Admin" required>
            </div>
            
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nik_admin_instansi" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK Calon Super Admin" required maxlength="16">
                    <small id="nik_error" class="text-danger"></small>
                </div>

                <div class="mb-3 col-6">
                    <label for="nik_admin_instansi" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP Calon Super Admin" required maxlength="18">
                    <small id="nip_error" class="text-danger"></small>
                </div>

                <div class="mb-3 col-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir Calon Super Admin">
                </div>

                <div class="mb-3 col-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir Calon Super Admin">
                </div>

                <div class="mb-3 col-6">
                    <label for="gender" class="form-label"> Jenis Kelamin </label>
                    <div class="form-check">
                        <input type="radio" name="jenis_kelamin" id="gender_l" value="1" class="form-check-input" required>
                        <label for="gender_l" class="form-check-label">Laki - Laki</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="jenis_kelamin" id="gender_p" value="0" class="form-check-input" required>
                        <label for="gender_p" class="form-check-label">Perempuan</label>
                    </div>
                </div>

                <div class="mb-3 col-6">
                    <label for="no_telepon" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="telepone_user" pattern="[0-9]{8,15}" maxlength="15" name="telepone_user" placeholder="Nomor telepone Calon Super Admin">
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat_user" rows="3" placeholder="Alamat Calon Super Admin"></textarea>
            </div>

            <div class="input-field ">
                <label for="image">Upload Foto (Max 1MB)</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/user/avatar.png" id="previewImage" class="rounded-circle mb-3" style="width: 100px; height: 100px; cursor: pointer;" onclick="openImageModal(this)">
                </div>
                <input type="file" class="input" id="image" name="gambar_user" accept="image/*" onchange="validateFile()">
            </div>

            <button type="submit" class="btn btn-primary edit" name="tambah_super_admin" >Tambah Data Super Admin</button>
        </form>
    </div>
    <?php endif; ?>
</div>

<div class="container mt-4">

    <!-- Pengaturan Sistem -->
    <div id="sistem" class="card p-4 mb-4">
        <h4><i class="bi bi-sliders"></i> Pengaturan Sistem</h4>
        <div class="mt-3">
            <label for="tema" class="form-label">Tema Dashboard</label>
            <select class="form-select" id="tema">
                <option value="light">Mode Terang</option>
                <option value="dark">Mode Gelap</option>
            </select>
        </div>
    </div>

    <!-- Pengaturan Keamanan -->
    <div id="keamanan" class="card p-4">
        <h4><i class="bi bi-box-arrow-right"></i> Logout</h4>
        <div class="mt-3">
            <!-- Form Logout -->
            <form id="logout" action="../logout.php" method="POST">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout dari Perangkat
                </button>
            </form>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php" ?>


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

        document.getElementById("nik").addEventListener("input", function (e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });
        document.getElementById("nip").addEventListener("input", function (e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });
        document.getElementById("telepone_user").addEventListener("input", function (e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });

</script>

<script>
    function openImageModal(img) {
        const modal = document.getElementById("imageModalPreview");
        const modalImg = document.getElementById("modalPreviewImage");

        modal.style.display = "flex"; // make it center using flex
        modalImg.src = img.src;
    }

    function closeImageModal() {
        document.getElementById("imageModalPreview").style.display = "none";
    }
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("tambah-super-admin-form");

    const nikInput = document.getElementById("nik");
    const nipInput = document.getElementById("nip");
    const nikError = document.getElementById("nik_error");
    const nipError = document.getElementById("nip_error");

    function validateNik() {
        if (nikInput.value.length < 16) {
            nikError.textContent = "NIK harus terdiri dari 16 digit.";
            nikInput.classList.add("is-invalid");
            return false;
        } else {
            nikError.textContent = "";
            nikInput.classList.remove("is-invalid");
            return true;
        }
    }

    function validateNip() {
        if (nipInput.value.length < 18) {
            nipError.textContent = "NIP harus terdiri dari 18 digit.";
            nipInput.classList.add("is-invalid");
            return false;
        } else {
            nipError.textContent = "";
            nipInput.classList.remove("is-invalid");
            return true;
        }
    }

    // Event listener realtime (saat ngetik)
    nikInput.addEventListener("input", validateNik);
    nipInput.addEventListener("input", validateNip);

    // Validasi akhir saat submit form
    form.addEventListener("submit", function (e) {
        const isNikValid = validateNik();
        const isNipValid = validateNip();

        if (!isNikValid || !isNipValid) {
            e.preventDefault(); // Blokir submit
        }
    });
});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("mode-toggle");
        const modeIcon = document.getElementById("mode-icon");
        const selectTema = document.getElementById("tema");

        // Ambil tema dari localStorage atau default ke "light"
        const savedTheme = localStorage.getItem("theme") || "light";
        applyTheme(savedTheme);
        selectTema.value = savedTheme; // <-- Ini dia yang penting!

        // Event dari tombol navbar
        toggleBtn?.addEventListener("click", function () {
            const newTheme = document.body.classList.contains("dark-mode") ? "light" : "dark";
            applyTheme(newTheme);
            selectTema.value = newTheme; // Sync dropdown
        });

        // Event dari dropdown
        selectTema?.addEventListener("change", function () {
            applyTheme(this.value);
        });

        function applyTheme(theme) {
            if (theme === "dark") {
                document.body.classList.add("dark-mode");
                modeIcon.classList.remove("bi-moon-fill");
                modeIcon.classList.add("bi-sun-fill");
            } else {
                document.body.classList.remove("dark-mode");
                modeIcon.classList.remove("bi-sun-fill");
                modeIcon.classList.add("bi-moon-fill");
            }
            localStorage.setItem("theme", theme);
        }
    });

</script>
