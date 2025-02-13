<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Data Perguruan Tinggi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Tambah Data Perguruan Tinggi</li>
        </ol>
    </div>

    <div class="container mt-5">
        <form action="study_view.php" class="form-instansi" method="POST" enctype="multipart/form-data">
            <!-- Nama Univ -->
            <div class="mb-3">
                <label for="nama_study" class="form-label">Nama Perguruan Tinggi</label>
                <input type="text" class="form-control" id="nama_study" name="nama_study" placeholder="Masukkan nama Perguruan Tinggi" required>
            </div>
            <!-- nama Fak -->
            <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas </label>
                <input class="form-control" type="text" name="fakultas" id="fakultas" placeholder="Masukkan Nama Fakultas">
            </div>
            <!-- Nama Prod -->
            <div class="mb-3">
                <label for="jurusan_prodi" class="form-label">Program studi</label>
                <input type="text"  class="form-control" id="jurusan_prodi" name="jurusan_prodi" rows="3" placeholder="Masukkan Nama Program Studi">
            </div>
            <!-- Alamat Perguruan Tinggi -->
            <div class="mb-3">
                <label for="alamat_study" class="form-label">Alamat Perguruan tinggi</label>
                <textarea class="form-control" name="alamat_study" id="alamat_study" placeholder="Masukkan Alamat Perguruan Tinggi"></textarea>
            </div>
            <!-- Submit Button -->
            <div class="text-center mt-3">
                <button type="submit" name="tambah_study" class="btn btn-success w-100">Tambah Data Perguruan Tinggi</button>
            </div>
        </form>
        <a href="study_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a>
    </div>
</main>
<?php include "footer.php" ?>