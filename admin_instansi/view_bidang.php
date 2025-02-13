<?php include "../layout/header.php"; ?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Bidang Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Bidang Instansi</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="tambah_bidang.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Bidang
            </a>
            <!-- <a href="bidang_print.php" class="btn btn-success">
                <i class="bi bi-printer me-1"></i>
                Cetak
            </a> -->
        </div>
        <div class="table-responsive-sm">
            <div class="bungkus">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bidang</th>
                            <th>Deskripsi</th>
                            <th>Kriteria</th>
                            <th>Kuota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Bidang Teknologi Informasi</td>
                            <td>Mengelola pengembangan sistem dan infrastruktur teknologi</td>
                            <td>Minimal 3 orang</td>
                            <td>3</td>
                            <td>
                                <a href="edit_bidang.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="view_bidang.php" class="btn btn-danger btn-sm" onclick="event.preventDefault(); showDeleteConfirmation(this.href);">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Bidang Pemasaran</td>
                            <td>Mengelola kegiatan pemasaran dan promosi instansi</td>
                            <td>Minimal 2 orang</td>
                            <td>2</td>
                            <td>
                                <a href="edit_bidang.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="view_bidang.php" class="btn btn-danger btn-sm" onclick="event.preventDefault(); showDeleteConfirmation(this.href);">
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