<?php
include "../koneksi.php"; 

// Query untuk mengambil data pengajuan magang yang masih aktif
$sql = "SELECT * 
        FROM tb_pengajuan, tb_profile_user, tb_pendidikan, tb_instansi, tb_bidang 
        WHERE tb_pengajuan.id_user = tb_profile_user.id_user
        AND tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
        AND tb_pengajuan.id_instansi = tb_instansi.id_instansi
        AND tb_pengajuan.id_bidang = tb_bidang.id_bidang
        AND tb_pengajuan.status_pengajuan = 'Diterima'";
$query = mysqli_query($conn, $sql);
$no = 1; 
?>

<!DOCTYPE html>
<html lang="en">
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
</head>
<body>

<!-- Menampilkan navbar-->
<?php include "../layout/navbarUser.php" ?>

<main class="main">
    <div class="container mt-5"><br><br>
        <h1 class="text-center mb-4">Tabel Kegiatan Aktif</h1>
        
        <!-- Tabel buat menampilkan data -->
        <table id="myTable">
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
                <?php while($row = mysqli_fetch_assoc($query)): ?> 
                    <tr>
                        <td class="text-center"><?= $no++; ?></td> 
                        <td><?= $row['nama_user'] ?></td> 
                        <td><?= $row['nama_pendidikan'] ?></td> 
                        <td><?= $row['nama_panjang'] ?></td> 
                        <td><?= $row['nama_bidang'] ?></td> 
                        <td class="text-center">
                            <?php 
                                // Cek apakah tanggal mulai dan selesai ada atau tidak
                                if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                    $start_date = new DateTime($row['tanggal_mulai']);
                                    $end_date = new DateTime($row['tanggal_selesai']);
                                    $interval = $start_date->diff($end_date);
                                    // Hitung durasi dalam bulan (tahun dikonversi ke bulan)
                                    echo $interval->m + ($interval->y * 12) . " Bulan";
                                } else {
                                    echo "Durasi Tidak Diketahui"; // Kalau tanggalnya kosong
                                }
                            ?>
                        </td>
                        <td>
                            <!-- Format tanggal biar lebih gampang dibaca -->
                            <?= date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai'])) ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
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