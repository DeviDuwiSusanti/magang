<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Sekolah / Universitas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Tambah Data Sekolah / Universitas</li>
        </ol>
    </div>

    <div class="container mt-5">
        <form action="study_view.php" class="form-instansi" method="POST" enctype="multipart/form-data">
            <!-- Nama Instansi -->
            <div class="mb-3">
                <label for="nama_study" class="form-label">Nama Sekolah / Universitas</label>
                <input type="text" class="form-control" id="nama_study" name="nama_study" placeholder="Masukkan nama instansi" required>
            </div>
            <!-- Alamat Instansi -->
            <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas </label>
                <textarea class="form-control" id="fakultas" name="fakultas" rows="3" placeholder="Masukkan alamat instansi" required></textarea>
            </div>
            <!-- Deskripsi Instansi -->
            <div class="mb-3">
                <label for="jurusan_prodi" class="form-label">Jurusan / Prodi</label>
                <textarea class="form-control" id="jurusan_prodi" name="jurusan_prodi" rows="3" placeholder="Masukkan deskripsi instansi"></textarea>
            </div>
            <!-- Telephone Instansi -->
            <div class="mb-3">
                <label for="alamat_study" class="form-label">Alamat</label>
                <input type="tel" class="form-control" id="alamat_study" name="alamat_study" placeholder="Masukkan nomor telepon instansi" required>
            </div>
            <!-- Submit Button -->
            <div class="text-center mt-3">
                <button type="submit" name="tambah_study" class="btn btn-info w-100">Tambah Sekolah / Universitas</button>
            </div>
        </form>
        <a href="study_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a>
    </div>
</main>