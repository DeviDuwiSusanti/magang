<?php include "../layout/sidebarUser.php"; ?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Logbook</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Logbook Harian Anda</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="logbook_unggah.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Logbook
            </a>
            <a href="logbook_print.php" class="btn btn-success">
                <i class="bi bi-printer me-1"></i>
                Cetak
            </a>
        </div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2025-02-07</td>
                            <td>Diskusi Tim</td>
                            <td>Diskusi Proyek Magang</td>
                            <td>
                                <a href="logbook_edit.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="hapus_logbook.php" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2025-02-08</td>
                            <td>Pengerjaan Tugas</td>
                            <td>Mengerjakan Flowchart Sistem Magang</td>
                            <td>
                                <a href="logbook_edit.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="hapus_logbook.php" class="btn btn-danger btn-sm">
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
