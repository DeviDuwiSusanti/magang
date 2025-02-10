<?php include "../layout/sidebarUser.php" ?>

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
                    <img src="../assets/img/login.jpeg" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                    <h4 class="card-title">Hendra Hartono</h4>
                    <p class="text-muted">hendra815@gmail.com</p>

                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td>Hendra</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-envelope"></i> <strong>Email</strong></td>
                                    <td>hendra815@gmail.com</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar"></i> <strong>TTL</strong></td>
                                    <td>Bojonegoro, 03 April 2004</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-gender-ambiguous"></i> <strong>Gender</strong></td>
                                    <td>Laki-laki</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-credit-card"></i> <strong>NIK</strong></td>
                                    <td>3522674523647</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-mortarboard"></i> <strong>NIM</strong></td>
                                    <td>226487264</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> <strong>Asal Studi</strong></td>
                                    <td>Universitas Trunojoyo Madura</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                                    <td>085760786535</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                    <td>Dusun Pencol Desa Setren, Bojonegoro</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-grid">
                            <a href="profil_edit.php" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>