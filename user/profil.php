<?php include "../layout/sidebarUser.php";

$sql2 = "SELECT pu.*, u.*, p.* FROM tb_profile_user pu JOIN tb_user u ON pu.id_user = u.id_user LEFT JOIN tb_pendidikan p ON pu.id_pendidikan = p.id_pendidikan WHERE pu.id_user = '$id_user'";
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
                    <img src="../assets/img/user/<?= $row2['gambar_user'] ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
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
                                    <td>
                                        <?= ($row2['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>
                                    </td>
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
                                <?php
                                if ($row2['fakultas'] != NULL){?>
                                <tr>
                                    <td><i class="bi bi-building-check"></i> <strong>Fakultas</strong></td>
                                    <td><?= $row2['fakultas'] ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td><i class="bi bi-diagram-3"></i> <strong>Jurusan</strong></td>
                                    <td><?= $row2['jurusan'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                                    <td><?= $row2['telepone_user'] ?></td>
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