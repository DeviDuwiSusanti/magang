<?php 
include "../layout/header.php"; 

$id_bidang = $_GET["id_bidang"];
$edit_bidang = query("SELECT * FROM tb_bidang WHERE id_bidang = $id_bidang")[0];

$status = "";
if(isset($_POST["edit_bidang"])) {
    if(edit_bidang($_POST) > 0) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Bidang</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Edit Bidang Instansi</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="mb-4 mt-3 text-end">
            <a href="view_bidang.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
        </div>
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
            <input type="hidden" name="id_bidang" id="id_bidang" value="<?= $id_bidang ?>">
            <!-- Nama Bidang -->
            <div class="mb-3">
                <label for="nama_bidang" class="form-label fw-bold">Nama Bidang</label>
                <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" placeholder="Masukkan nama bidang" required value="<?= $edit_bidang["nama_bidang"] ?>">
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi Bidang</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi bidang" required><?= $edit_bidang["deskripsi_bidang"] ?></textarea>
            </div>

            <!-- Kriteria -->
            <div class="mb-3">
                <label for="kriteria" class="form-label fw-bold">Kriteria</label>
                <textarea class="form-control" id="kriteria" name="kriteria" rows="3" placeholder="Masukkan kriteria bidang" required><?= $edit_bidang["kriteria_bidang"] ?></textarea>
                <small class="text-muted">*Pisahkan dengan koma</small>
            </div>

            <!-- Kuota -->
            <div class="mb-3">
                <label for="kuota" class="form-label fw-bold">Kuota</label>
                <input type="number" class="form-control" id="kuota" name="kuota" placeholder="Masukkan kuota bidang" required value="<?= $edit_bidang["kuota_bidang"] ?>">
            </div>

            <!-- Dokumen -->
            <div class="mb-3">
                <label for="dokumen" class="form-label fw-bold">Dokumen Prasyarat</label>
                <textarea class="form-control" id="dokumen" name="dokumen" rows="3" placeholder="Masukkan dokumen prasyarat" required><?= $edit_bidang["dokumen_prasyarat"] ?></textarea>
                <small class="text-muted">*Pisahkan dengan koma</small>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="edit_bidang" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    <?php if ($status === "success"): ?>
        alertSuccessEdit('Data bidang berhasil diperbarui.', 'view_bidang.php');
    <?php elseif ($status === "error"): ?>
        alertSuccessEdit('Tidak ada perubahan. Data bidang disimpan.', 'view_bidang.php');
    <?php endif; ?>
</script>