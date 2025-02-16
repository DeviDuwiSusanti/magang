<?php 
    include "sidebar.php";

    $profile = query("SELECT * FROM tb_profile_user, tb_user WHERE tb_profile_user.id_user = '$id_user' AND tb_user.id_user = '$id_user'")[0];
    $jenis_kelamin = ($profile["jenis_kelamin"] == 'P' ? "Perempuan" : "Laki - Laki")
?>

<div class="container">
    <h1 class="mb-4 mt-4">My Profile</h1>
    <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman View Profile</li>
        </ol>
    <div class="container mt-5 mb-5">
        <div class="card mx-auto shadow" style="max-width: 500px;">
            <div class="card-body">
                <img src="../assets/img/user/<?= $profile["gambar"] ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
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
                                <td><?= $profile["telepone"] ?></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-gender-ambiguous"></i> <strong>Gender</strong></td>
                                <td><?= $jenis_kelamin ?></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                <td><?= $profile["alamat_user"] ?></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar"></i> <strong>TTL</strong></td>
                                <td><?= $profile["tempat_lahir"] ?> , <?= $profile["tanggal_lahir"] ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-grid">
                        <a href="profile_edit.php" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>