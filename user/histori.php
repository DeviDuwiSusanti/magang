<?php include "../layout/sidebarUser.php" ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Daftar Kegiatan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Kegiatan Aktif</li>
        </ol>

        <!-- Tabel -->
        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Instansi</th>
                        <th>Bidang</th>
                        <th>Durasi</th>
                        <th>Periode Magang</th>
                        <th>Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data 1 -->
                    <tr>
                        <td>1</td>
                        <td>Hendra Hartono</td>
                        <td>Kominfo Sidoarjo</td>
                        <td>Cyber Security</td>
                        <td>3 Bulan</td>
                        <td>02 Januari - 02 Mei</td>
                        <td><a href="sertifikat_1.php">Masuk ke halaman sertifikat</a></td>
                    </tr>
                    <!-- Data 2 -->
                    <tr>
                        <td>2</td>
                        <td>Hendra Hartono</td>
                        <td>Kominfo Medan</td>
                        <td>Website Developer</td>
                        <td>6 Bulan</td>
                        <td>02 Januari - 02 Mei</td>
                        <td><a href="sertifikat_2.php">Masuk ke halaman sertifikat</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>