<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Tambah Data Instansi</li>
        </ol>
    </div>

    <div class="container mt-5">
        <form action="instansi_view.php" class="form-instansi" method="POST" enctype="multipart/form-data">
            <!-- Nama Instansi -->
            <div class="mb-3">
                <label for="nama_instansi" class="form-label">Nama Instansi</label>
                <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" placeholder="Masukkan nama instansi" required>
            </div>
            <!-- Alamat Instansi -->
            <div class="mb-3">
                <label for="alamat_instansi" class="form-label">Alamat Instansi</label>
                <textarea class="form-control" id="alamat_instansi" name="alamat_instansi" rows="3" placeholder="Masukkan alamat instansi" required></textarea>
            </div>
            <!-- Deskripsi Instansi -->
            <div class="mb-3">
                <label for="deskripsi_instansi" class="form-label">Deskripsi Instansi</label>
                <textarea class="form-control" id="deskripsi_instansi" name="deskripsi_instansi" rows="3" placeholder="Masukkan deskripsi instansi"></textarea>
            </div>
            <!-- Telephone Instansi -->
            <div class="mb-3">
                <label for="telepon_instansi" class="form-label">Telepon Instansi</label>
                <input type="tel" class="form-control" id="telepon_instansi" name="telepon_instansi" placeholder="Masukkan nomor telepon instansi" required>
            </div>
            <!-- Image Instansi -->
            <div class="mb-3">
                <label for="image_instansi" class="form-label">Image Instansi</label>
                <div> <img src="../assets/img/login.jpeg" alt="upload foto" style="width: 100px; height: 100px" class="rounded-circle"></div>
                <input type="file" class="form-control" id="image_instansi" name="image_instansi" accept="image/*">
            </div>
            <!-- Submit Button -->
            <div class="text-center mt-3">
                <button type="submit" name="tambah_instansi" class="btn btn-success w-100">Tambah Instansi</button>
            </div>
        </form>
        <a href="instansi_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a>
    </div>
</main>