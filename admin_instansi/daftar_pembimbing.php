<?php include "../layout/header.php";

// Ambil id_instansi admin yang sedang login
$get_instansi = "SELECT id_instansi FROM tb_profile_user WHERE id_user = '$id_user'";
$query_instansi = mysqli_query($conn, $get_instansi);
$instansi = mysqli_fetch_assoc($query_instansi);
$id_instansi_admin = $instansi["id_instansi"];

// Query untuk mendapatkan daftar bidang
$bidang = "SELECT 
            pu.id_user AS id_pembimbing, 
            pu.nama_user AS nama_pembimbing, 
            pu.nik AS nik_pembimbing, 
            pu.nip, 
            pu.jabatan, 
            pu.telepone_user AS telepone_pembimbing, 
            b.nama_bidang
        FROM tb_profile_user AS pu
        JOIN tb_bidang AS b
            ON pu.id_bidang = b.id_bidang
        JOIN tb_instansi AS i
            ON b.id_instansi = i.id_instansi
        JOIN tb_user AS u
            ON pu.id_user = u.id_user
        WHERE pu.status_active = '1'
        AND u.status_active = '1'
        AND i.id_instansi = '$id_instansi_admin'
        ORDER BY b.id_bidang ASC";

$query = mysqli_query($conn, $bidang);
$bidang_list = mysqli_fetch_all($query, MYSQLI_ASSOC);
$no = 1;
?>

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
                            <th>Bidang</th>
                            <th>Jabatan</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bidang_list)): ?>
                            <?php foreach ($bidang_list as $pembimbing): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= ($pembimbing['nama_pembimbing']) ?></td>
                                    <td><?= ($pembimbing['nama_bidang']) ?></td>
                                    <td><?= ($pembimbing['jabatan']) ?></td>
                                    <td><?= ($pembimbing['telepone_pembimbing']) ?></td>
                                    <td>
                                        <a href="edit_pembimbing.php?id=<?= $pembimbing['id_pembimbing'] ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="hapus.php?id=<?= $pembimbing['id_pembimbing'] ?>&type=pembimbing" class="btn btn-danger btn-sm" onclick="confirmDelete(event)">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
            text: "Data pembimbing akan dihapus!",
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