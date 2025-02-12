<?php include "../layout/sidebarUser.php" ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Daftar Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Histori Pengajuan</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <!-- Tombol Tambah Pengajuan -->
        <div class="d-flex justify-content-end mb-4">
            <a href="pengajuan.php" class="btn btn-primary">Tambah Pengajuan</a>
        </div>

        <!-- Tabel -->
        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Perusahaan</th>
                        <th class="text-center">Bidang</th>
                        <th class="text-center">Status Lamaran</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Aksi</th>
                </thead>
                <tbody>
                    <!-- Data 1 -->
                    <tr>
                        <td class="text-center">1</td>
                        <td>Diskominfo Sidoarjo</td>
                        <td>Cyber Security</td>
                        <td>Diterima <span style="color: green; font-size: 20px;">&#10004;</span></td>
                        <td class="text-center">3 Bulan</td>
                        <td class="text-center">
                        <a href="detail_status.php" class="text-decoration-none" title="Lihat Detail">
                        <i class="bi bi-eye" style="font-size: 20px;"></i></a></td>
                    </tr>
                    <!-- Data 2 -->
                    <tr>
                        <td class="text-center">2</td>
                        <td>Diskominfo Medan</td>
                        <td>Website Developer</td>
                        <td>Diterima <span style="color: green; font-size: 20px;">&#10004;</span></td>
                        <td class="text-center">6 Bulan</td>
                        <td class="text-center">
                        <a href="detail_status.php" class="text-decoration-none" title="Lihat Detail">
                        <i class="bi bi-eye" style="font-size: 20px;"></i></a></td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Telkom Indonesia</td>
                        <td>UI/UX</td>
                        <td>Ditolak <span style="color: red; font-size: 20px;">&#10006;</span></td>
                        <td class="text-center">4 Bulan</td>
                        <td class="text-center">
                        <a href="detail_status.php" class="text-decoration-none" title="Lihat Detail">
                        <i class="bi bi-eye" style="font-size: 20px;"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>