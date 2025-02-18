<?php
include "../layout/header.php";

$bidang = query("SELECT * FROM tb_bidang WHERE status_active = 'Y'");
$no = 1;
?>

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
                            <th>Dokumen Prasyarat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bidang as $bd) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $bd["nama_bidang"] ?></td>
                                <td><?= $bd["deskripsi_bidang"] ?></td>
                                <td><?= $bd["kriteria"] ?></td>
                                <td><?= $bd["kuota"] ?></td>
                                <td><?= $bd["dokumen_prasyarat"] ?></td>
                                <td style="width: 150px;">
                                    <a href="edit_bidang.php?id_bidang=<?= $bd["id_bidang"] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="hapus_bidang.php?id_bidang=<?= $bd["id_bidang"] ?>" onclick="confirmDelete(event)" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    function confirmDelete(event) {
        event.preventDefault(); // Mencegah aksi default link

        const url = event.currentTarget.href; // Ambil URL dari atribut href

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data bidang akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, alihkan ke URL hapus
                window.location.href = url;
            }
        });
    }
</script>