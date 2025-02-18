<?php
include "../layout/header.php";

$instansi = "SELECT * 
    FROM tb_instansi
    JOIN tb_profile_user 
        ON tb_instansi.id_instansi = tb_profile_user.id_instansi
    WHERE tb_profile_user.id_user = '$id_user'";

$query = mysqli_query($conn, $instansi);
$instansi = mysqli_fetch_assoc($query);
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Profile Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Data Profile Instansi</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="container mt-5 mb-5">
            <!-- shadow -->
            <div class="card mx-auto" style="max-width: 950px;">
                <div class="card-body top-2">
                    <img src="../assets/img/instansi/<?= $instansi["gambar_instansi"] ?: 'logo_kab_sidoarjo.png' ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                    <h4 class="card-title judul"><?= $instansi["nama_panjang"] ?></h4>

                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-buildings"></i> <strong>Nama Instansi</strong></td>
                                    <td><?= $instansi["nama_panjang"] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-card-text"></i> <strong>Deskripsi</strong></td>
                                    <td><?= $instansi["deskripsi_instansi"] ?: 'Deskripsi belum diatur' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                    <td><?= $instansi["alamat_instansi"] ?: 'Alamat belum diatur' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar"></i> <strong>Telepon</strong></td>
                                    <td><?= $instansi["telepone_instansi"] ?: 'Telepon belum diatur' ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-grid">
                            <a href="edit_instansi.php" class="btn btn-primary">
                                <i class="bi bi-pencil me-1"></i> Edit Profile Instansi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>