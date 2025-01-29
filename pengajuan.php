<?php include "header.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Pengajuan</li>
        </ol>

        <!-- Tabel -->
        <div class="bungkus-2">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nama Instansi</th>
                        <th>Nama Bidang</th>
                        <th>Asal Studi</th>
                        <th>Jurusan</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data 1 -->
                    <tr>
                        <td>1</td>
                        <td>Hendra Hartono</td>
                        <td>Diskominfo Sidoarjo</td>
                        <td>Informatika</td>
                        <td>Universitas Brawijaya</td>
                        <td>Teknik Informatika</td>
                        <td>01-02-2025</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm">Terima</a>
                            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    <!-- Data 2 -->
                    <tr>
                        <td>2</td>
                        <td>Nur Cahyani</td>
                        <td>Diskominfo Sidoarjo</td>
                        <td>Akuntansi</td>
                        <td>Universitas Negeri Surabaya</td>
                        <td>Akuntansi</td>
                        <td>01-02-2025</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm">Terima</a>
                            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>