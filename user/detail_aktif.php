<?php include "../layout/sidebarUser.php" ?>

<div class="main-content p-4">
    <!-- Heading Dashboard -->
    <div class="container-fluid">
        <h1 class="mb-4">Kegiatan Aktif</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Kegiatan Aktif</li>
        </ol>
        <div class="dropdown-divider"></div>
         <!-- Tombol Kembali -->
        <div class="mb-4 text-end">
            <a href="kegiatan_aktif.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>
        <div class="container mt-5 mb-5">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body top text-center">
                    <img src="../assets/img/login.jpeg" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                    <h4 class="card-title">Hendra Hartono</h4>
                    <p class="text-muted">hendra815@gmail.com</p>

                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td>Hendra</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-mortarboard"></i> <strong>Universitas</strong></td>
                                    <td>Universitas Trunojoyo Madura</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> <strong>Perusahaan</strong></td>
                                    <td>Dinas Komunikasi dan Informatika</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-shield-lock"></i> <strong>Bidang</strong></td>
                                    <td>Cyber Security</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-hourglass-split"></i> <strong>Durasi</strong></td>
                                    <td>3 Bulan</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-event"></i> <strong>Periode</strong></td>
                                    <td>02 Januari - 02 Mei</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Tombol Unggah Logbook dan Laporan Akhir -->
                    <div class="mb-3">
                        <a href="logbook_unggah.php" class="btn btn-primary btn-sm me-2">
                            <i class="bi bi-file-earmark-text me-1"></i> Unggah Logbook
                        </a>
                        <a href="laporan_akhir.php" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-check me-1"></i> Unggah Laporan Akhir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
