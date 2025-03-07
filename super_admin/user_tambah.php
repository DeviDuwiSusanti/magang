<?php 
    include "sidebar.php"; 

    if(isset($_POST["tambah_admin_instansi"])) {
        if(tambah_admin_instansi($_POST)) { ?>
        <script>tambah_user_super_admin_success()</script>
<?php } else { ?>
        <script>tambah_user_super_admin_gagal()</script>
    <?php }
}

?>


<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Calon Admin Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Tambah Calon Admin Instansi</li>
        </ol>
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
            <!-- Nama -->
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_user" placeholder="Masukkan Nama Lengkap Calon Admin Instansi" required>
            </div>

            <!-- NIK -->
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" inputmode="numeric" class="form-control"  id="nik" name="nik" placeholder="Masukkan NIK Calon Admin Instansi (16)" required maxlength="16">
                <span id="nik_error" class="text-danger"></span>
            </div>

            <!-- NIP -->
            <div class="mb-3">
                <label for="nik" class="form-label">NIP</label>
                <input type="text" inputmode="numeric" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP Calon Admin Instansi (18)" required maxlength="18">
                <span id="nip_error" class="text-danger"></span>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email_admin_instansi" class="form-label">Email</label>
                <input type="text" class="form-control" id="email_admin_instansi" name="email" placeholder="Masukkan Email Calon Admin Instansi" required maxlength="255">
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
                    <input type="radio" name="jenis_kelamin" id="gender_l" value="1" class="form-check-input" required>
                    <label for="gender_l" class="form-check-label">Laki - Laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="gender_p" value="0" class="form-check-input" required>
                    <label for="gender_p" class="form-check-label">Perempuan</label>
                </div>
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No. Telepon</label>
                <input type="tel" pattern="[0-9]{8,15}" class="form-control" id="telepone_user" maxlength="15" name="telepone_user" placeholder="Masukkan Nomor telepone Calon Admin Instansi">
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
            <button type="submit" name="tambah_admin_instansi" class="btn btn-primary edit">Tambah Data</button>
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

    document.getElementById("nik").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    });
    document.getElementById("nip").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    });
    document.getElementById("telepone_user").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    });


    $(document).ready(function() {
            // Validasi real-time untuk NIK
            $('#nik').on('input', function() {
                let nik = $(this).val().trim(); // Ambil nilai dan hilangkan spasi
                let nikError = $('#nik_error');

                if (nik.length === 0) {
                    nikError.text('NIK tidak boleh kosong!').show();
                } else if (nik.length < 16) {
                    nikError.text('NIK harus 16 digit!').show();
                } else {
                    nikError.hide();
                }
            });

            
            $('#nip').on('input', function() {
                let nisn = $(this).val().trim(); 
                let nisnError = $('#nip_error');

                if (nisn.length === 0) {
                    nisnError.text('NIP tidak boleh kosong!').show();
                } else if (nisn.length < 18) {
                    nisnError.text('NIP harus 18 digit!').show();
                } else {
                    nisnError.hide();
                }
            });
        });
</script>