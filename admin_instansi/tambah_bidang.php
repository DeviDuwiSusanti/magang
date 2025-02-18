<?php 
include "../layout/header.php"; 

$status = "";
if (isset($_POST["tambah_bidang"])) {
    if(tambah_bidang($_POST) > 0) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Tambah Bidang</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Tambah Bidang Instansi</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        <div class="mb-4 text-end">
            <a href="view_bidang.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>
        
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
            <!-- Nama Bidang -->
            <div class="mb-3">
                <label for="nama_bidang" class="form-label">Nama Bidang</label>
                <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" placeholder="Masukkan nama bidang" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Bidang</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi bidang" required></textarea>
            </div>

            <!-- Kriteria -->
            <div class="mb-3">
                <label for="kriteria" class="form-label">Kriteria</label>
                <textarea class="form-control" id="kriteria" name="kriteria" rows="3" placeholder="Masukkan kriteria bidang" required></textarea>
            </div>

            <!-- Kuota -->
            <div class="mb-3">
                <label for="kuota" class="form-label">Kuota</label>
                <input type="number" class="form-control" id="kuota" name="kuota" placeholder="Masukkan kuota bidang" required>
            </div>

            <!-- Dokumen -->
            <div class="mb-3">
                <label for="dokumen" class="form-label">Dokumen Prasyarat</label>
                <textarea class="form-control" id="dokumen" name="dokumen" rows="3" placeholder="Masukkan dokumen prasyarat" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit" name="tambah_bidang"><i class="bi bi-plus-circle me-1"></i> Tambah Bidang</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    <?php if ($status === "success"): ?>
        alertSuccessEdit('Data bidang berhasil ditambahkan.', 'view_bidang.php');
    <?php elseif ($status === "error"): ?>
        alertErrorRegister('Registrasi gagal dilakukan.', 'register.php');
    <?php endif; ?>
</script>