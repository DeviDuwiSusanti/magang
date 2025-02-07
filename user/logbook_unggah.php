<?php include "../layout/sidebarUser.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Logbook</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Logbook Harian</li>
            <a href="logbook_daftar.php" class="btn btn-secondary">Lihat Daftar Logbook</a>
        </ol>
        
        <form action="" class="form-logbook" method="POST" enctype="multipart/form-data">
            <!-- Input Tanggal Otomatis -->
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>
            
            <!-- Input Kegiatan -->
            <div class="mb-3">
                <label for="kegiatan" class="form-label">Kegiatan</label>
                <input type="text" class="form-control" id="kegiatan" name="kegiatan" required>
            </div>
            
            <!-- Input Keterangan -->
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Unggah Logbook</button>
        </form>
    </div>
</div>
