<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Data Sekolah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Tambah Data Sekolah</li>
        </ol>
    </div>

    <div class="container mt-5">
        <form action="study_view.php" class="form-instansi" method="POST" enctype="multipart/form-data">
            <!-- Nama Sekolah -->
            <div class="mb-3">
                <label for="nama_study" class="form-label">Nama Sekolah</label>
                <input type="text" class="form-control" id="nama_study" name="nama_study" placeholder="Masukkan nama Sekolah" required>
            </div>
            <!-- Nama Jurusan -->
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" rows="3" placeholder="Masukkan Jurusan Sekolah">
            </div>
            <!-- Alamat Sekolah -->
            <div class="mb-3">
                <label for="alamat_study" class="form-label">Alamat Sekolah</label>
                <textarea class="form-control" name="alamat_study" id="almaat_study" placeholder="Masukkan Alamat Sekolah"></textarea>
            </div>
            <!-- Submit Button -->
            <div class="text-center mt-3">
                <button type="submit" name="tambah_study" class="btn btn-success w-100">Tambah Data Sekolah</button>
            </div>
        </form>
        <a href="study_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a><br>
    </div>
</main>

<?php include "footer.php" ?>