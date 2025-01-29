<?php include "header.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Bidang Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Bidang Instansi</li>
        </ol>

        <!-- Tombol Tambah Bidang -->
        <div class="mb-4">
            <a href="tambah_bidang.php" class="btn btn-primary">Tambah Bidang</a>
        </div>

        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bidang</th>
                        <th>Deskripsi</th>
                        <th>Kriteria</th>
                        <th>Kuota</th>
                        <!-- <th>Status</th> -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh data bidang -->
                    <tr>
                        <td>1</td>
                        <td>Bidang Teknologi Informasi</td>
                        <td>Mengelola pengembangan sistem dan infrastruktur teknologi</td>
                        <td>Minimal 3 orang</td>
                        <td>3</td>
                        <!-- <td>Aktif</td> -->
                        <td>
                            <a href="edit_bidang.php?" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_bidang.php?" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Bidang Pemasaran</td>
                        <td>Mengelola kegiatan pemasaran dan promosi instansi</td>
                        <td>Minimal 2 orang</td>
                        <td>2</td>
                        <!-- <td>Non-Aktif</td> -->
                        <td>
                            <a href="edit_bidang.php?" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_bidang.php?" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
