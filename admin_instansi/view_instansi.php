<?php include "header.php"; ?>

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
                    <img src="../assets/img/login.jpeg" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                    <h4 class="card-title judul">Dinas Komunikasi dan Informatika Kabupaten Sidoarjo</h4>

                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-buildings"></i> <strong>Nama Instansi</strong></td>
                                    <td>Dinas Komunikasi dan Informatika Kabupaten Sidoarjo</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-card-text"></i> <strong>Deskripsi</strong></td>
                                    <td>Dinas Kominfo Sidoarjo adalah lembaga yang berada di Kabupaten Sidoarjo</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                    <td>Jl. Diponegoro No.139, Lemah Putro, Sidoarjo</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar"></i> <strong>Telepon</strong></td>
                                    <td>085876453211</td>
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