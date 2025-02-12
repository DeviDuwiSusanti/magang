<?php include "../layout/sidebarUser.php" ?>
  
<div class="main-content p-4">
    <!-- Heading Dashboard -->
    <div class="container-fluid">
        <h1 class="mb-4">Histori</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Histori Kegiatan</li>
        </ol>

        <!-- Tombol Kembali -->
        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="histori.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>

        <div class="card mx-auto position-relative shadow-sm" style="max-width: 600px;">
            <div class="card-body text-center">
                <img src="../assets/img/login.jpeg" class="rounded-circle mb-3 shadow" alt="Profile Picture" style="width: 100px; height: 100px;">
                <h4 class="card-title mb-1">Hendra Hartono</h4>
                <p class="text-muted mb-3">hendra815@gmail.com</p>

                <hr>
                <table class="table table-borderless">
                    <tbody class="text-start">
                        <tr>
                            <td><i class="bi bi-person me-2"></i> <strong>Nama</strong></td>
                            <td>Hendra</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-mortarboard me-2"></i> <strong>Universitas</strong></td>
                            <td>Universitas Trunojoyo Madura</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-building me-2"></i> <strong>Perusahaan</strong></td>
                            <td>Dinas Komunikasi dan Informatika</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-shield-lock me-2"></i> <strong>Bidang</strong></td>
                            <td>Cyber Security</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-hourglass-split me-2"></i> <strong>Durasi</strong></td>
                            <td>3 Bulan</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-calendar-event me-2"></i> <strong>Periode</strong></td>
                            <td>02 Januari - 02 Mei</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="path/to/sertifikat.pdf" class="btn btn-outline-success btn-sm px-3" download>
                        <i class="bi bi-printer"></i> Sertifikat
                    </a>
                    <a href="path/to/nilai.pdf" class="btn btn-outline-primary btn-sm px-3" download>
                        <i class="bi bi-printer"></i> Nilai
                    </a>
                    <a href="logbook_daftar.php" class="btn btn-outline-info btn-sm px-3">
                        <i class="bi bi-book"></i> Logbook
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>