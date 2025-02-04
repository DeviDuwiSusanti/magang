<?php 
    include "sidebar.php";
?>

<div class="container">
    <h1 class="mb-4 mt-4">My Profile</h1>
    <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman View Profile</li>
        </ol>
    <div class="container mt-5 mb-5">
        <div class="card mx-auto shadow" style="max-width: 500px;">
            <div class="card-body">
                <img src="img/login.jpeg" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                <h4 class="card-title">Mishbahus Surur</h4>
                <p class="text-muted">mishbahus30@gmail.com</p>
                
                <hr>
                <div class="card-body">
                    <table class="table">
                        <tbody class="text-start">
                            <tr>
                                <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                <td>Mishbahus Surur</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-envelope"></i> <strong>Email</strong></td>
                                <td>mishbahus30@gmail.com</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                                <td>0895803255502</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-gender-ambiguous"></i> <strong>Gender</strong></td>
                                <td>Laki-laki</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                <td>Jl. Sakera Sepulu No 52, Bangkalan</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar"></i> <strong>TTL</strong></td>
                                <td>Bangkalan, 30 Mei 2004</td>
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