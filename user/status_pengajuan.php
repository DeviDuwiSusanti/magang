<?php include "../layout/sidebarUser.php" ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Daftar Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Histori Pengajuan</li>
        </ol>

        <!-- Tabel -->
        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Perusahaan</th>
                        <th>Bidang</th>
                        <th>Status Lamaran</th>
                        <th>Durasi</th>
                        <th>Aksi</th>
                </thead>
                <tbody>
                    <!-- Data 1 -->
                    <tr>
                        <td>1</td>
                        <td>Diskominfo Sidoarjo</td>
                        <td>Cyber Security</td>
                        <td>Diterima <span style="color: green; font-size: 20px;">&#10004;</span></td>
                        <td>3 Bulan</td>
                        <td><a href="halamandetail.php" class="text-decoration-none" title="Lihat Detail">
                        <i class="bi bi-eye"></i></a>
                        <a href="logbook.php" class="text-decoration-none border p-2" title="Lengkapi Dokumen">
                         Lengkapi Dokumen</a></td>
                    </tr>
                    <!-- Data 2 -->
                    <tr>
                        <td>1</td>
                        <td>Diskominfo Medan</td>
                        <td>Website Developer</td>
                        <td>Diterima <span style="color: green; font-size: 20px;">&#10004;</span></td>
                        <td>6 Bulan</td>
                        <td><a href="halamandetail.php" class="text-decoration-none" title="Lihat Detail">
                        <i class="bi bi-eye"></i></a>
                        <a href="logbook.php" class="text-decoration-none border p-2" title="Lengkapi Dokumen">
                        Lengkapi Dokumen</a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Telkom Indonesia</td>
                        <td>UI/UX</td>
                        <td>Ditolak <span style="color: red; font-size: 20px;">&#10006;</span></td>
                        <td>4 Bulan</td>
                        <td><a href="halamandetail.php" class="text-decoration-none" title="Lihat Detail">
                        <i class="bi bi-eye"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>