<?php
include "../layout/header.php";

$profile = query("SELECT * FROM tb_profile_user AS pu, tb_user AS u
                WHERE pu.id_user = '$id_user' 
                AND u.id_user = '$id_user'")[0]
;

$gender = ($profile["jenis_kelamin"] == '0' ? "Perempuan" : "Laki - Laki");
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Profile Saya</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman View Profile</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="container mt-5 mb-5">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body top">
                    <img src="../assets/img/user/<?= $profile["gambar_user"] ?: 'avatar_admin.jpg' ?>" 
                        class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border: 2px solid #ccc;">
                    <h4 class="card-title"><?= $profile["nama_user"] ?></h4>
                    <p class="text-muted"><?= $profile["email"] ?></p>
                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td><?= $profile["nama_user"] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-envelope"></i> <strong>Email</strong></td>
                                    <td><?= $profile["email"] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                                    <td><?= $profile["telepone_user"] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-gender-ambiguous"></i> <strong>Gender</strong></td>
                                    <td><?= $gender ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                    <td><?= $profile["alamat_user"] ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="bi bi-calendar"></i> <strong>TTL</strong>
                                    </td>
                                    <td>
                                        <?= $profile["tempat_lahir"] ?>,
                                        <?php
                                        if (!empty($profile['tanggal_lahir'])) {
                                            echo date('d F Y', strtotime($profile['tanggal_lahir']));
                                        } else {
                                            echo "Tanggal Lahir Tidak Diketahui";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-grid">
                            <a href="edit_profile.php" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>