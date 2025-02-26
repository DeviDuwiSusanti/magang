<?php
include "../layout/header.php";

$id_instansi = $_SESSION['id_instansi'];
$no = 1;

// Query untuk data utama pengajuan
$sql = "SELECT
            tb_profile_user.nama_user,
            tb_bidang.nama_bidang,
            tb_pengajuan.jenis_pengajuan,
            tb_pengajuan.jumlah_pelamar,
            tb_pengajuan.tanggal_mulai,
            tb_pengajuan.tanggal_selesai,
            tb_pengajuan.id_pengajuan,
            tb_pengajuan.id_user,
            tb_pengajuan.status_pengajuan,
            tb_pengajuan.status_active
        FROM tb_pengajuan
        INNER JOIN tb_profile_user ON tb_pengajuan.id_user = tb_profile_user.id_user
        INNER JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.id_instansi = '$id_instansi'
        AND tb_pengajuan.status_active = '1'
        AND tb_pengajuan.status_pengajuan = '2'
        OR tb_pengajuan.status_pengajuan = '3'
        OR tb_pengajuan.status_pengajuan = '4'
        ORDER BY tb_pengajuan.id_pengajuan DESC";

$result = mysqli_query($conn, $sql);

// Query untuk mendapatkan daftar nama pengaju
$sql2 = "SELECT p.id_pengajuan, GROUP_CONCAT(pu.nama_user SEPARATOR ', ') AS daftar_nama
        FROM tb_pengajuan p
        JOIN tb_profile_user pu ON p.id_pengajuan = pu.id_pengajuan
        WHERE p.id_instansi = '$id_instansi'
        GROUP BY p.id_pengajuan
        ORDER BY p.id_pengajuan DESC";

$nama_pengaju = [];
$result2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_assoc($result2)) {
    $nama_pengaju[$row2['id_pengajuan']] = $row2['daftar_nama'];
}

$json_nama_pengaju = json_encode($nama_pengaju);
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Pemagang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Data Pemagang</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Kegiatan</th>
                            <th>Pemagang</th>
                            <th>Periode</th>
                            <th>Durasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row["nama_user"] ?></td>
                                <td><?= $row["nama_bidang"] ?></td>
                                <td><?= $row["jenis_pengajuan"] ?></td>
                                <td>
                                    <a href="#" class="show-detail" title="Lihat Detail"
                                        data-detail='<?= isset($nama_pengaju[$row['id_pengajuan']]) ? json_encode(explode(', ', $nama_pengaju[$row['id_pengajuan']])) : '[]' ?>'>
                                        <?= isset($nama_pengaju[$row['id_pengajuan']]) ? count(explode(', ', $nama_pengaju[$row['id_pengajuan']])) : 0 ?>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        // Konversi tanggal ke format yang diinginkan
                                        $start_date = new DateTime($row['tanggal_mulai']);
                                        $end_date = new DateTime($row['tanggal_selesai']);

                                        // Format tanggal dalam bahasa Indonesia
                                        $bulanIndo = [
                                            "Januari",
                                            "Februari",
                                            "Maret",
                                            "April",
                                            "Mei",
                                            "Juni",
                                            "Juli",
                                            "Agustus",
                                            "September",
                                            "Oktober",
                                            "November",
                                            "Desember"
                                        ];

                                        $tanggal_mulai = $start_date->format('d') . ' ' . $bulanIndo[$start_date->format('n') - 1] . ' ' . $start_date->format('Y');
                                        $tanggal_selesai = $end_date->format('d') . ' ' . $bulanIndo[$end_date->format('n') - 1] . ' ' . $end_date->format('Y');

                                        echo $tanggal_mulai . " - " . $tanggal_selesai;
                                    } else {
                                        echo "Periode Tidak Diketahui";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        $start_date = new DateTime($row['tanggal_mulai']);
                                        $end_date = new DateTime($row['tanggal_selesai']);
                                        $interval = $start_date->diff($end_date);

                                        $years = $interval->y;
                                        $months = $interval->m;
                                        $days = $interval->d;

                                        $hasil = "";

                                        if ($years > 0) {
                                            $hasil .= "$years Tahun ";
                                        }
                                        if ($months > 0) {
                                            $hasil .= "$months Bulan ";
                                        }
                                        if ($days > 0) {
                                            $hasil .= "$days Hari";
                                        }

                                        echo trim($hasil); // Hapus spasi berlebih di akhir
                                    } else {
                                        echo "Durasi Tidak Diketahui";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $status_pengajuan = $row['status_pengajuan'];
                                    $tanggal_mulai = $row['tanggal_mulai'];
                                    $tanggal_selesai = $row['tanggal_selesai'];

                                    date_default_timezone_set('Asia/Jakarta');
                                    $tanggal_sekarang = date("Y-m-d"); // Tanggal hari ini dalam format YYYY-MM-DD

                                    // **Cek apakah tanggal mulai sudah tiba & status masih "Diterima" (2)**
                                    if ($status_pengajuan == 2 && strtotime($tanggal_mulai) <= strtotime($tanggal_sekarang)) {
                                        // Update status menjadi "Berlangsung" (3) di database
                                        $sql_update = "UPDATE tb_pengajuan SET status_pengajuan = '3' WHERE id_pengajuan = '{$row['id_pengajuan']}'";
                                        mysqli_query($conn, $sql_update);

                                        // Set status_pengajuan ke 3 secara manual agar kondisi berikutnya mengenali perubahan
                                        $status_pengajuan = 3;
                                    }

                                    // **Cek apakah tanggal selesai sudah lewat & status masih "Berlangsung" (3)**
                                    if ($status_pengajuan == 3 && strtotime($tanggal_sekarang) > strtotime($tanggal_selesai)) {
                                        // Update status menjadi "Selesai" (4) di database
                                        $sql_update = "UPDATE tb_pengajuan SET status_pengajuan = '4' WHERE id_pengajuan = '{$row['id_pengajuan']}'";
                                        mysqli_query($conn, $sql_update);

                                        // Set status_pengajuan ke 4 secara manual agar kondisi berikutnya mengenali perubahan
                                        $status_pengajuan = 4;
                                    }

                                    // **Tampilkan status setelah update**
                                    if ($status_pengajuan == 4) {
                                        echo '<span class="badge bg-danger">Selesai</span>';
                                    } elseif ($status_pengajuan == 3) {
                                        echo '<span class="badge bg-primary">Berlangsung</span>';
                                    } elseif ($status_pengajuan == 2) {
                                        echo '<span class="badge bg-success">Diterima</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary">Menunggu</span>'; // Status default
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>