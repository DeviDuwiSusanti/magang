<?php include "../layout/header.php"; ?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Pembimbing</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Data Daftar Pembimbing</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="tambah_pembimbing.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Pembimbing
            </a>
        </div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pembimbing</th>
                            <th>Nama Bidang</th>
                            <th>Gender</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mishbahus Surur</td>
                            <td>Teknologi Informasi</td>
                            <td>Laki-Laki</td>
                            <td>087968743321</td>
                            <td>Bangkalan</td>
                            <td>
                                <a href="edit_pembimbing.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="daftar_pembimbing.php" class="btn btn-danger btn-sm" onclick="event.preventDefault(); showDeleteConfirmation(this.href);">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Syaiful Hidayat</td>
                            <td>Teknologi Informasi</td>
                            <td>Laki-Laki</td>
                            <td>085743213344</td>
                            <td>Surabaya</td>
                            <td>
                                <a href="edit_pembimbing.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="daftar_pembimbing.php" class="btn btn-danger btn-sm" onclick="event.preventDefault(); showDeleteConfirmation(this.href);">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>