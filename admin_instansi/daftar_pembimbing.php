<?php include "../layout/header.php";

// Query pembimbing bidang
$bidang = "SELECT tb_pembimbing.id_pembimbing, tb_pembimbing.nama_pembimbing, 
    tb_pembimbing.nik_pembimbing, 
    tb_pembimbing.nip, tb_pembimbing.jabatan, 
    tb_pembimbing.telepone_pembimbing, tb_bidang.nama_bidang
    FROM tb_pembimbing
    JOIN tb_bidang 
        ON tb_pembimbing.id_bidang = tb_bidang.id_bidang
    JOIN tb_instansi 
        ON tb_bidang.id_instansi = tb_instansi.id_instansi
    JOIN tb_profile_user 
        ON tb_instansi.id_instansi = tb_profile_user.id_instansi
    WHERE tb_profile_user.id_user = '$id_user'
    AND tb_bidang.status_active = 'Y'
    ORDER BY tb_bidang.id_bidang DESC";

$query = mysqli_query($conn, $bidang);
$bidang_list = mysqli_fetch_all($query, MYSQLI_ASSOC);
$no = 1;

// var_dump($bidang_list);
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
                                        <a href="hapus_pembimbing.php?id=<?= $pembimbing['id_pembimbing'] ?>" class="btn btn-danger btn-sm">
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