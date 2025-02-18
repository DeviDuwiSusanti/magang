<?php 
    include "sidebar.php";
    $id_instansi = $_GET["id_instansi"];
    $instansi = query("SELECT * FROM tb_instansi WHERE id_instansi = $id_instansi")[0];


    if(isset($_POST["edit_instansi"])) {
        if(edit_instansi($_POST)) {
            echo "<script>
                alert ('Berhasil Edit Data Instansi');
                document.location.href = 'instansi_view.php';
            </script>";
        } else {
            echo "<script>
                alert ('Gagal Edit Data Instansi');
                document.location.href = 'instansi_view.php';
            </script>";
        }
    }
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Edit Data Instansi</li>
        </ol>
    </div>

    <div class="container mt-5">
        <form action="" class="form-instansi" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
            <div class="mb-3">
                <label for="nama_instansi" class="form-label">ID Instansi</label>
                <input type="text" class="form-control" id="id_instansi" name="id_instansi" value="<?= $instansi["id_instansi"] ?>">
            </div>

            <div class="mb-3">
                <label for="nama_instansi" class="form-label">Nama Pendek Instansi</label>
                <input type="text" class="form-control" id="nama_pendek" name="nama_pendek" value="<?= $instansi["nama_pendek"] ?>">
            </div>

            <div class="mb-3">
                <label for="nama_instansi" class="form-label">Nama Panjang Instansi</label>
                <input type="text" class="form-control" id="nama_panjang" name="nama_panjang" value="<?= $instansi["nama_panjang"] ?>">
            </div>

            <div class="mb-3">
                <label for="nama_instansi" class="form-label">Gruop Instansi</label>
                <input type="text" class="form-control" id="group_instansi" name="group_instansi" value="<?= $instansi["group_instansi"] ?>">
            </div>
    
            <div class="mb-3">
                <label for="alamat_instansi" class="form-label">Alamat Instansi</label>
                <textarea class="form-control" id="alamat_instansi" name="alamat_instansi" rows="3"><?= $instansi["alamat_instansi"] ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi_instansi" class="form-label">Deskripsi Instansi</label>
                <textarea class="form-control" id="deskripsi_instansi" name="deskripsi_instansi" rows="3"><?= $instansi["deskripsi_instansi"] ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi_instansi" class="form-label">Lokasi Instansi</label>
                <textarea class="form-control" id="lokasi_instansi" name="lokasi_instansi" rows="3"><?= $instansi["lokasi_instansi"] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="telepon_instansi" class="form-label">Telepon Instansi</label>
                <input type="tel" class="form-control" id="telepone_instansi" name="telepone_instansi" value="<?= $instansi["telepone_instansi"] ?>">
            </div>

            <!-- Upload Foto Profil -->
            <div class="input-field ">
                <label for="image">Upload Logo / Gambar Instansi (Max 1MB)</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="../assets/img/instansi/<?= $instansi["gambar_instansi"] ?>" id="previewImage" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <input type="hidden" name="gambar_instansi" id="gambar_instansi" value="<?= $instansi["gambar_instansi"] ?>">
                </div>
                <input type="file" class="input" id="image" name="gambar_instansi" accept="image/*" onchange="validateFile()">
            </div>
            
            <div class="text-center mt-3">
                <button type="submit" name="edit_instansi" class="btn btn-success w-100">Edit Data Instansi</button>
            </div>
        </form>
        <a href="instansi_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a>
    </div>
</main>
<?php include "footer.php" ?>

