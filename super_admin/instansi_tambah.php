<?php 
    include "sidebar.php";

    if(isset($_POST["tambah_instansi"])) {
        if(tambah_instansi_super_admin($_POST) > 0) { ?>
            <script>tambah_instansi_super_admin_success()</script>
        <?php } else { ?>
            <script>tambah_instansi_super_admin_gagal()</script>
        <?php }
    }

?>



<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Tambah Data Instansi</li>
        </ol>
    </div>

    <div class="container mt-5">
        <form action="" class="form-instansi" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
            <div class="mb-3">
                <label for="nama_instansi" class="form-label">ID Instansi</label>
                <input type="text" inputmode="numeric" maxlength="10" class="form-control" id="id_instansi" name="id_instansi" placeholder="Masukkan ID instansi" required>
            </div>

            <div class="mb-3">
                <label for="nama_instansi" class="form-label">Nama Pendek Instansi</label>
                <input type="text" maxlength="100" class="form-control" id="nama_pendek" name="nama_pendek" placeholder="Masukkan nama Pendek instansi" required>
            </div>

            <div class="mb-3">
                <label for="nama_instansi" class="form-label">Nama Panjang Instansi</label>
                <input type="text" maxlength="255" class="form-control" id="nama_panjang" name="nama_panjang" placeholder="Masukkan nama Panjang instansi" required>
            </div>

            <div class="mb-3">
                <label for="nama_instansi" class="form-label">Gruop Instansi</label>
                <input type="text" maxlength="100" class="form-control" id="group_instansi" name="group_instansi" placeholder="Masukkan Group instansi">
            </div>
    
            <div class="mb-3">
                <label for="alamat_instansi" class="form-label">Alamat Instansi</label>
                <textarea class="form-control" id="alamat_instansi" name="alamat_instansi" rows="3" placeholder="Masukkan alamat instansi"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi_instansi" class="form-label">Deskripsi Instansi</label>
                <textarea class="form-control" id="deskripsi_instansi" name="deskripsi_instansi" rows="3" placeholder="Masukkan deskripsi instansi"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi_instansi" class="form-label">Lokasi Instansi</label>
                <textarea class="form-control" id="lokasi_instansi" name="lokasi_instansi" rows="3" placeholder="Masukkan Lokasi Instansi"></textarea>
            </div>

            <div class="mb-3">
                <label for="telepon_instansi" class="form-label">Telepon Instansi</label>
                <input type="tel" pattern="[0-9]{8,15}" inputmode="numeric" maxlength="15" class="form-control" id="telepone_instansi" name="telepone_instansi" placeholder="Masukkan nomor telepon instansi">
            </div>

            <!-- Upload Foto Profil -->
            <div class="input-field ">
                <label for="image">Upload Logo / Gambar Instansi (Max 1MB)</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/instansi/logo_kab_sidoarjo.png" id="previewImage" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                </div>
                <input type="file" class="input" id="image" name="gambar_instansi" accept="image/*" onchange="validateFile()">
            </div>
            
            <div class="text-center mt-3">
                <button type="submit" name="tambah_instansi" class="btn btn-success w-100">Tambah Instansi</button>
            </div>
        </form>
        <a href="instansi_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a>
    </div>
</main>
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

    document.getElementById("id_instansi").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, "");
        });

    document.getElementById("telepone_instansi").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, "");
    });
</script>