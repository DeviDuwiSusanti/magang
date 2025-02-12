<?php include "../layout/sidebarUser.php" ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Daftar Histori Kegiatan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Histori Kegiatan</li>
        </ol>

        <!-- Tabel -->
        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Instansi</th>
                        <th class="text-center">Bidang</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Periode Magang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data 1 -->
                    <tr>
                        <td class="text-center">1</td>
                        <td>Hendra Hartono</td>
                        <td>Kominfo Sidoarjo</td>
                        <td>Cyber Security</td>
                        <td class="text-center">3 Bulan</td>
                        <td>02 Januari - 02 Mei</td>
                        <td class="text-center">
                        <a href="detail_histori.php" class="text-decoration-none" title="Lihat Detail">
                        <i class="bi bi-eye" style="font-size: 20px;"></i></a></td>
                        </td>
                    </tr>
                    <!-- Data 2 -->
                    <tr>
                        <td class="text-center">2</td>
                        <td>Hendra Hartono</td>
                        <td>Kominfo Medan</td>
                        <td>Website Developer</td>
                        <td class="text-center">6 Bulan</td>
                        <td>02 Januari - 02 Mei</td>
                        <td class="text-center">
                        <a href="detail_histori.php" class="text-decoration-none" title="Lihat Detail">
                        <i class="bi bi-eye" style="font-size: 20px;"></i></a></td>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>