<?php
include "../layout/header.php";

$bidang = "SELECT b.id_bidang, b.nama_bidang, b.status_active, b.deskripsi_bidang, b.kuota_bidang, b.kriteria_bidang, b.dokumen_prasyarat,
                  i.id_instansi, i.nama_panjang, 
                  pu.id_user 
            FROM tb_bidang AS b
            JOIN tb_instansi AS i ON b.id_instansi = i.id_instansi
            JOIN tb_profile_user AS pu ON i.id_instansi = pu.id_instansi
            WHERE pu.id_user = '$id_user'
            AND b.status_active = '1'
            ORDER BY b.id_bidang ASC";

$query = mysqli_query($conn, $bidang);
$bidang = mysqli_fetch_all($query, MYSQLI_ASSOC);
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
                                <td><?= $bd["kriteria_bidang"] ?></td>
                                <td><?= $bd["kuota_bidang"] ?></td>
                                <td><?= $bd["dokumen_prasyarat"] ?></td>
                                <td style="width: 150px;">
                                    <a href="edit_bidang.php?id_bidang=<?= $bd["id_bidang"] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="hapus.php?id=<?= $bd["id_bidang"] ?>&type=bidang" onclick="confirmDelete(event)" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- <?php if (empty($bidang)) : ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data bidang</td>
                            </tr>
                        <?php endif; ?> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    function confirmDelete(event) {
        // Mencegah aksi default link
        event.preventDefault();

        // Mendapatkan URL yang akan dihapus
        const url = event.currentTarget.href;

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