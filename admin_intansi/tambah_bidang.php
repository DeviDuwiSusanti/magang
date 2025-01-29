<?php include "header.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Tambah Bidang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tambah Bidang Instansi</li>
        </ol>

        <!-- Tombol Kembali -->
        <div class="mb-4">
            <a href="bidang.php" class="btn btn-danger">Kembali</a>
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
                <input type="text" class="form-control" id="kuota" name="kuota" placeholder="Masukkan kuota bidang" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit">Simpan Perubahan</button>
        </form>
    </div>
</div>