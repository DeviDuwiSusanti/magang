<?php include "../layout/header.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Instansi</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Edit Profile Instansi</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end mt-3">
            <a href="view_instansi.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i>  Kembali</a>
        </div>
        <form action="update_profile.php" class="form-instansi" method="POST" enctype="multipart/form-data">
            <!-- Nama Instansi -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Instansi</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama instansi" required value="Dinas Komunikasi dan Informatika Kabupaten Sidoarjo">
            </div>
        
            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Instansi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi instansi" required>Dinas Kominfo Sidoarjo adalah lembaga yang berada di Kabupaten Sidoarjo</textarea>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required>Jl. Diponegoro No. 139, Lemahputro, Sidoarjo</textarea>
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label for="telephone" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Masukkan nomor telepon" required value="085876453211">
            </div>

            <!-- Upload Foto Profil -->
            <div class="mb-3">
                <label for="image">Foto Profil</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/login.jpeg" id="previewImage" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; object-position: top;" >
                </div>
                <input type="file" class="input form-control" id="image" name="image" accept="image/*" onchange="previewFile()" required>
                <small class="text-muted">Kosong Jika tidak ingin di ganti</small>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit" onclick="event.preventDefault(); alertEdit(this.href);"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
  function previewFile() {
    const fileInput = document.getElementById('image');
    const previewImage = document.getElementById('previewImage');
    const file = fileInput.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImage.src = e.target.result;
      }
      reader.readAsDataURL(file);
    } else {
      previewImage.src = '../assets/img/login.jpeg';
    }
  }
</script>