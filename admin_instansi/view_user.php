<?php include "header.php"; ?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Pemagang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Data Pemagang</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Pengajuan</th>
                            <th>Pemagang Aktif</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mishbahus Surur</td>
                            <td>Teknologi Informasi</td>
                            <td>Magang</td>
                            <td>4</td>
                            <td>02-01-2025</td>
                            <td>02-05-2025</td>
                            <td class="text-success">Aktif</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Syaiful Hidayat</td>
                            <td>Teknologi Informasi</td>
                            <td>Magang</td>
                            <td>4</td>
                            <td>02-01-2025</td>
                            <td>02-05-2025</td>
                            <td class="text-danger">Selesai</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>