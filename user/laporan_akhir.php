<?php include "../layout/sidebarUser.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Laporan</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Laporan Akhir Kegiatan</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="kegiatan_aktif.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>
        
        <!-- Form Upload Laporan Akhir -->
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="laporan_akhir" class="form-label">Unggah Laporan Akhir</label>
                <input type="file" class="form-control" id="laporan_akhir" name="laporan_akhir" accept=".pdf" required>
                <small class="text-muted">Pilih file laporan akhir (PDF)</small>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-upload me-1"></i>Kirim</button>
        </form>
    </div>
</div>
