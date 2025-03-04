<?php 
    include "sidebar.php";
    $id_pendidikan = $_GET["id_pendidikan"];
    $pendidikan = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'")[0];
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

            <div class="mb-3">
                <label for="nama_pendidikan" class="form-label">Nama Studi</label>
                <input type="text" class="form-control" id="nama_pendidikan" name="nama_pendidikan" value="<?= $pendidikan["nama_pendidikan"] ?>">
            </div>
            
            <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas</label>
                <input type="tel" class="form-control" id="fakultas" name="fakultas"  value="<?= $pendidikan["fakultas"] ?>">
            </div>

            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan / Prodi</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= $pendidikan["jurusan"] ?>">
            </div>

            <div class="mb-3">
                <label for="alamat_pendidikan" class="form-label">Alamat Pendidikan</label>
                <textarea class="form-control" id="alamat_pendidikan" name="alamat_pendidikan" rows="3"><?= $pendidikan["alamat_pendidikan"] ?></textarea>
            </div>
            <div class="text-center mt-3">
                <button type="submit" name="edit_study" class="btn btn-success w-100">Edit Sekolah / Universitas</button>
            </div>
        </form>
        <a href="study_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a>
    </div>
</main>
<?php include "footer.php" ?>