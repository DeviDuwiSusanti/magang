<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Sekolah / Universitas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Edit Data Sekolah / Universitas</li>
        </ol>
    </div>

    <div class="container mt-5">
        <form action="instansi_view.php" class="form-instansi" method="POST" enctype="multipart/form-data">
            <!-- Nama Instansi -->
            <div class="mb-3">
                <label for="nama_study" class="form-label">Nama Sekolah / Universitas</label>
                <input type="text" class="form-control" id="nama_study" name="nama_study" value="Universitas Trunojoyo Madura" required>
            </div>
            
            <!-- Telephone Instansi -->
            <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas</label>
                <input type="tel" class="form-control" id="fakultas" name="fakultas"  value="Fakultas Teknik" required>
            </div>
            <!-- Image Instansi -->
            <div class="mb-3">
                <label for="jurusan_prodi" class="form-label">Jurusan / Prodi</label>
                <input type="text" class="form-control" id="jurusan_prodi" name="jurusan_prodi" value="Teknik Informatika">
            </div>

            <!-- Alamat Instansi -->
            <div class="mb-3">
                <label for="alamat_instansi" class="form-label">Alamat Instansi</label>
                <textarea class="form-control" id="alamat_instansi" name="alamat_instansi" rows="3" required>JL. pahlawan kec sidoarjo kabupaten sidoarjo</textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-3">
                <button type="submit" name="edit_study" class="btn btn-info w-100">Edit Sekolah / Universitas</button>
            </div>
        </form>
        <a href="study_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a>
    </div>
</main>