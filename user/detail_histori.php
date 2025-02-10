<?php include "../layout/sidebarUser.php" ?>
  
<div class="main-content p-4">
     <!-- Heading Dashboard -->
    <div class="container-fluid">
    <h1 class="mb-4">Histori</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">histori Kegiatan</li>
        </ol>

         <!-- Tombol Kembali -->
        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="histori.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>

            <div class="card mx-auto position-relative" style="max-width: 600px;">
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

                        <!-- Tombol Cetak Sertifikat di pojok kiri bawah -->
                        <!-- Tombol Cetak Sertifikat (Kiri) -->
                        <a href="path/to/sertifikat.pdf" class="btn btn-sm btn-success" download>
                            <i class="bi bi-printer"></i> Cetak Sertifikat
                        </a>

                        <!-- Tombol Cetak Logbook (Kanan) -->
                        <a href="logbook_daftar.php" class="btn btn-sm btn-info">
                            <i class="bi bi-book"></i> Lihat Logbook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>