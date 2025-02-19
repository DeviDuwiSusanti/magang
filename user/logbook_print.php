<?php
include '../koneksi.php';

if (ISSET($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
    $id_user = $_GET['id_user'];

    $sql = "SELECT * FROM tb_logbook 
    JOIN tb_pengajuan ON tb_logbook.id_pengajuan = tb_pengajuan.id_pengajuan 
    JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
    JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang 
    JOIN tb_profile_user ON tb_logbook.id_user = tb_profile_user.id_user 
    JOIN tb_pendidikan ON tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan 
    WHERE tb_logbook.id_pengajuan = '$id_pengajuan' AND tb_logbook.id_user = '$id_user'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Logbook Harian</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            margin: 20px;
            color: #333;
        }

        h2 {
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-info {
            margin-bottom: 20px;
        }

        .filter-info table {
            width: auto;
            margin: 0 auto;
        }

        .filter-info td {
            padding: 4px 8px;
        }

        tfoot th,
        tfoot td {
            padding: 8px;
            border: 1px solid #000;
            background-color: #e6e6e6;
        }

        .no-print {
            text-align: center;
            margin-top: 20px;
        }

        .no-print button {
            padding: 10px 20px;
            background-color: #007BFF;
            border: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Daftar Logbook Harian</h2>
    </div>

    <div class="filter-info">
        <table>
            <tr>
                <td><strong>NAMA</strong></td>
                <td>:</td>
                <td><?= $row['nama_user'] ?></td>
            </tr>
            <tr>
                <td><strong>ASAL STUDI</strong></td>
                <td>:</td>
                <td><?= $row['nama_pendidikan'] ?></td>
            </tr>
            <tr>
                <td><strong>INSTANSI MAGANG</strong></td>
                <td>:</td>
                <td><?= $row['nama_panjang'] ?> Sidoarjo</td>
            </tr>
            <tr>
                <td><strong>BIDANG</strong></td>
                <td>:</td>
                <td><?= $row['nama_bidang'] ?></td>
            </tr>
            <tr>
                <td><strong>DURASI</strong></td>
                <td>:</td>
                <td><?= $row['tanggal_mulai'] ?> Sampai <?= $row['tanggal_selesai'] ?></td>
            </tr>
        </table>
    </div>

    <table class="table">
    <thead>
        <tr>
            <th style="width: 2%;">No</th>
            <th>Tanggal</th>
            <th>Kegiatan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql2 = "SELECT * FROM tb_logbook WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user'";
        $query2 = mysqli_query($conn, $sql2);
        $no = 1;
        $total_logbook = 0; // Untuk menghitung total logbook

        while ($row2 = mysqli_fetch_assoc($query2)) { 
            $total_logbook++;
        ?>
        <tr>
            <td style="text-align: center;"><?= $no ?></td>
            <td style="text-align: left;"><?= $row2['tanggal_logbook'] ?></td>
            <td style="text-align: left;"><?= $row2['kegiatan_logbook'] ?></td>
            <td style="text-align: left;"><?= $row2['keterangan_logbook'] ?></td>
        </tr>
        <?php
        $no++;
        }
        ?>
    </tbody>
        <tfoot>
            <tr>
                <th>Total Logbook</th>
                <td colspan="3"><?= $total_logbook ?> Logbook</td>
            </tr>
        </tfoot>
    </table>


    <div class="no-print">
        <button onclick="window.print()">Cetak Logbook</button>
    </div>

    <!-- Tambahan: Tempat Tanda Tangan -->
    <div style="width: 100%; display: flex; justify-content: flex-end; margin-top: 50px;">
        <div style="text-align: center; width: 300px;">
            <p>Sidoarjo, <?= date("d F Y") ?></p>
            <p><strong>Pembimbing Magang</strong></p>
            <br><br><br><br> <!-- Jeda untuk tanda tangan -->
            <p><strong>(...................................)</strong></p>
        </div>
    </div>
</body>

</html>