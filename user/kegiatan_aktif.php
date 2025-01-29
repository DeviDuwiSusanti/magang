<?php include "../layout/sidebarUser.php" ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Kelola Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Instansi</li>
        </ol>

        <!-- Tabel -->
        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Alamat</th>
                        <th>Gambar</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data 1 -->
                    <tr>
                        <td>1</td>
                        <td>Instansi A adalah instansi yang bergerak di bidang pendidikan dan pelatihan.</td>
                        <td>Jl. Merdeka No. 123, Jakarta</td>
                        <td><img src="./img/login.jpeg" alt="Gambar Instansi A" class="rounded"></td>
                        <td>08123456789</td>
                        <td>
                            <a href="edit_instansi.php" class="btn btn-primary btn-sm manage">Edit</a>
                        </td>
                    </tr>
                    <!-- Data 2 -->
                    <tr>
                        <td>2</td>
                        <td>Instansi B adalah instansi yang menyediakan layanan konsultasi bisnis.</td>
                        <td>Jl. Sudirman No. 45, Bandung</td>
                        <td><img src="./img/login.jpeg" alt="Gambar Instansi B" class="rounded"></td>
                        <td>08234567890</td>
                        <td>
                            <a href="edit_instansi.php" class="btn btn-primary btn-sm manage">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>