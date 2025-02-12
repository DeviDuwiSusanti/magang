<?php include "../layout/header.php"; ?>

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
        <form action="update_profile.php" class="form-profile" method="POST" enctype="multipart/form-data">
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

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
        <!-- <a href="bidang.php" class="btn btn-danger bi bi-arrow-left-circle"> Kembali</a> -->
    </div>
</div>

<?php include "footer.php"; ?>