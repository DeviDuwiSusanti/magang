<?php include "../layout/sidebarUser.php";

$sql2 = "SELECT * FROM tb_profile_user, tb_user, tb_pendidikan WHERE tb_profile_user.id_user = '$id_user' AND tb_user.id_user  = '$id_user' AND tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan";
$query2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($query2);

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
                    <img src="../assets/img/user/<?= $row2['gambar'] ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                    <h4 class="card-title"><?= $row2['nama_user'] ?></h4>
                    <p class="text-muted"><?= $row2['email'] ?></p>

                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td><?= $row2['nama_user'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-envelope"></i> <strong>Email</strong></td>
                                    <td><?= $row['email'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar"></i> <strong>TTL</strong></td>
                                    <td><?php echo $row['tempat_lahir'] . ', ' . $row['tanggal_lahir']; ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-gender-ambiguous"></i> <strong>Jenis Kelamin</strong></td>
                                    <td><?= $row2['jenis_kelamin'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-credit-card"></i> <strong>NIK</strong></td>
                                    <td><?= $row2['nik'] ?></td>
                                </tr>
                                <tr>
                                <tr>
                                    <td><i class="bi bi-mortarboard"></i> <strong> <?= !empty($row['nim']) ? 'NIM' : (!empty($row['nisn']) ? 'NISN' : 'NIM/NISN') ?></strong></td>
                                    <td><?= !empty($row['nim']) ? $row['nim'] : $row['nisn'] ?></td>
                                </tr>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> <strong>Asal Studi</strong></td>
                                    <td><?= $row2['nama_pendidikan'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                                    <td><?= $row2['telepone'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                    <td><?= $row2['alamat_user'] ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-grid">
                            <a href="profil_edit.php?id_user=<?= $id_user ?>" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php" ?>