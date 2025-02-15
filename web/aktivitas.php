<?php
include "../koneksi.php"; 

$sql = "SELECT * FROM tb_pengajuan 
        JOIN tb_profile_user ON tb_pengajuan.id_user = tb_profile_user.id_user
        JOIN tb_pendidikan ON tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
        JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.status_active = 'Y'";

$query = mysqli_query($conn, $sql);
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pengajuan Aktif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style2.css" />
    <link rel="stylesheet" href="../assets/css/aktiv.css" />
    <link rel="stylesheet" href="../assets/css/low.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body>

<?php include "../layout/navbarUser.php" ?>

<main class="main">
    <div class="container mt-5"><br><br>
        <h1 class="text-center mb-4">Tabel Kegiatan Aktif</h1>
        <table id="myTable" class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Universitas</th>
                    <th>Perusahaan</th>
                    <th>Posisi</th>
                    <th>Durasi</th>
                    <th>Periode Magang</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_user'] ?></td>
                        <td><?= $row['nama_pendidikan'] ?></td>
                        <td><?= $row['nama_panjang'] ?></td>
                        <td><?= $row['nama_bidang'] ?></td>
                        <td>
                            <?php 
                                if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                    $start_date = new DateTime($row['tanggal_mulai']);
                                    $end_date = new DateTime($row['tanggal_selesai']);
                                    $interval = $start_date->diff($end_date);
                                    echo $interval->m + ($interval->y * 12) . " Bulan";
                                } else {
                                    echo "Durasi Tidak Diketahui";
                                }
                            ?>
                        </td>
                        <td>
                            <?= date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai'])) ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include "../layout/footerUser.php" ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

</body>
</html>