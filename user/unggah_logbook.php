<?php include "../layout/sidebarUser.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Logbook</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Logbook Harian</li>
            <a href="daftar_logbook.php" class="btn btn-secondary">Lihat Daftar Logbook</a>
        </ol>
        
        <form action="" class="form-logbook" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="file" class="form-control" id="lampiran" name="lampiran" accept=".pdf,.doc,.docx,.jpg,.png" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Unggah Logbook</button>
        </form>
    </div>
</div>
