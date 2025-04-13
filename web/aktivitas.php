<?php
include "../koneksi.php"; 

// Query untuk mengambil data pengajuan magang yang masih aktif
$sql = "SELECT * 
        FROM tb_profile_user 
        JOIN tb_pengajuan ON tb_profile_user.id_pengajuan = tb_pengajuan.id_pengajuan
        JOIN tb_pendidikan ON tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
        JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.status_pengajuan = '4'";

$query = mysqli_query($conn, $sql); 
$no = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pengajuan Aktif</title>
    
    <!-- Import ikon dari Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    
    <!-- Import Bootstrap CSS biar tampilan lebih rapih -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Import CSS tambahan buat tampilan halaman -->
    <link rel="stylesheet" href="../assets/css/style2.css" />
    <link rel="stylesheet" href="../assets/css/aktif.css" />
    <link rel="stylesheet" href="../assets/css/low.css" />
    
    <!-- Import DataTables CSS biar tabel bisa interaktif -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <link rel="icon" href="../assets/img/logo_kab_sidoarjo.png" type="image/png">
</head>
<body>

<!-- Menampilkan navbar-->
<?php include "../layout/navbarUser.php" ?>

<main class="main">
    <div class="container mt-5"><br><br>
        <h1 class="text-center mb-4">Tabel Kegiatan Aktif</h1>
        
        <!-- Tabel buat menampilkan data -->
        <table id="myTable" class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Pendidikan</th>
                    <th class="text-center">Perusahaan</th>
                    <th class="text-center">Posisi</th>
                    <th class="text-center">Durasi</th>
                    <th class="text-center">Periode Magang</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($query) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?> 
                        <tr>
                            <td class="text-center"><?= $no++; ?></td> 
                            <td class="text-center"><?= $row['nama_user'] ?></td> 
                            <td class="text-center"><?= $row['nama_pendidikan'] ?></td> 
                            <td class="text-center"><?= $row['nama_panjang'] ?></td> 
                            <td class="text-center"><?= $row['nama_bidang'] ?></td> 
                            <td class="text-center">
                                <?php 
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        $start_date = new DateTime($row['tanggal_mulai']);
                                        $end_date = new DateTime($row['tanggal_selesai']);
                                        $interval = $start_date->diff($end_date);
                                        
                                        $months = $interval->m + ($interval->y * 12);
                                        $days = $interval->d;
                                        
                                        echo "$months Bulan" . ($days > 0 ? " $days Hari" : "");
                                    } else {
                                        echo "Durasi Tidak Diketahui";
                                    } 
                                ?>
                            </td>
                            <td class="text-center">
                                <?= date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai'])) ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data pengajuan aktif</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Menampilkan footer-->
<?php include "../layout/footerUser.php" ?>

<!-- Import jQuery buat fungsi interaktif -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Import DataTables buat bikin tabel lebih interaktif -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Aktifkan DataTables setelah halaman dimuat
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
</body>
</html>