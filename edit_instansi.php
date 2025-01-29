<?php include "header.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Edit Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Edit Profile Instansi</li>
        </ol>

        <!-- Tombol Kembali -->
        <div class="mb-4">
            <a href="daftar_instansi.php" class="btn btn-danger">Kembali</a>
        </div>
        <form action="update_profile.php" class="form-instansi" method="POST" enctype="multipart/form-data">
            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Instansi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi instansi" required></textarea>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label for="telephone" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Masukkan nomor telepon" required>
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Logo Instansi</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit">Simpan Perubahan</button>
        </form>
    </div>
</div>