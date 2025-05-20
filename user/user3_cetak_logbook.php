<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
session_start();
include '../koneksi.php';
include 'functions.php';

// Set timezone ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

if (ISSET($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
}else{
    $id_pengajuan = $_SESSION['id_pengajuan'];
}
$id_user = $_SESSION['id_user'];

// Query untuk mengecek apakah ada logbook yang belum diverifikasi (status_active = 1)
$sql_check = "SELECT COUNT(*) as unverified_count FROM tb_logbook 
               WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user' AND status_active = '1'";
$query_check = mysqli_query($conn, $sql_check);
$row_check = mysqli_fetch_assoc($query_check);

if($row_check['unverified_count'] > 0) {
    showAlert('Peringatan!', 'Masih ada logbook yang belum diverifikasi oleh Pembimbing.', 'warning', "user3_logbook.php");
    exit();
}

// Query untuk mengambil data logbook dan informasi terkait
$sql = "SELECT * FROM tb_pengajuan p JOIN tb_instansi i ON p.id_instansi = i.id_instansi 
        JOIN tb_bidang b ON p.id_bidang = b.id_bidang JOIN tb_profile_user u ON u.id_user = '$id_user' JOIN tb_pendidikan d ON u.id_pendidikan = d.id_pendidikan
        WHERE p.id_pengajuan = '$id_pengajuan'";

$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);

// akses pembimbing
$sql_pembimbing = mysqli_query($conn, "SELECT nama_user, nip FROM tb_profile_user WHERE id_user = '$row[id_pembimbing]'");
$pembimbing = mysqli_fetch_assoc($sql_pembimbing);
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

        /* Pastikan gambar dalam tabel memiliki ukuran tetap */
        .table img {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            padding: 3px;
        }

        /* Aturan untuk cetak */
        @media print {
            .no-print {
                display: none;
            }
            .table img {
                width: 120px;
                height: 90px;
            }
            tr {
                page-break-inside: avoid;
            }
            .table {
                page-break-inside: avoid;
            }
            body {
                margin: 0;
                padding: 10px;
                font-size: 12px;
            }
            .table td, .table th {
                padding: 4px;
            }
            .ttd-section {
                page-break-inside: avoid;
                margin-top: 20px;
            }
        }

        .ttd-section {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }
        
        .ttd-container {
            text-align: center;
            width: 300px;
        }
    </style>
</head>

<script>
window.onload = function() {
    if (window === window.top) {
        document.querySelector('.no-print').style.display = 'block';
    } else {
        setTimeout(() => {
            window.print();
        }, 500);
    }
};
</script>
<body>
    <div class="header">
        <h2>Logbook <?= $row['jenis_pengajuan'] ?></h2>
    </div>

    <div class="filter-info">
        <table style="width: 100%; text-align: left;">
            <tr>
                <td style="width: 15%;"><strong>Nama</strong></td>
                <td style="width: 2%;">:</td>
                <td><?= $row['nama_user'] ?></td>
            </tr>
            <tr>
                <td><strong>Asal Studi</strong></td>
                <td>:</td>
                <td><?= $row['nama_pendidikan'] ?></td>
            </tr>
            <tr>
                <td><strong>Instansi</strong></td>
                <td>:</td>
                <td><?= $row['nama_panjang'] ?> Sidoarjo</td>
            </tr>
            <tr>
                <td><strong>Bidang</strong></td>
                <td>:</td>
                <td><?= $row['nama_bidang'] ?></td>
            </tr>
            <tr>
                <td><strong>Waktu Pelaksanaan</strong></td>
                <td>:</td>
                <td><?= formatPeriode($row['tanggal_mulai'], $row['tanggal_selesai']) ?></td>
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
                <th>Waktu</th>
                <th>Foto Kegiatan</th>
                <th>TTD</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM tb_logbook WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user' AND status_active = '2'";
            $query2 = mysqli_query($conn, $sql2);
            $no = 1;
            $total_logbook = 0;

            while ($row2 = mysqli_fetch_assoc($query2)) {
                $total_logbook++;
            ?>
                <tr>
                    <td style="text-align: center;"><?= $no ?></td>
                    <td style="text-align: left;"><?= date('d/m/Y', strtotime($row2['tanggal_logbook'])) ?></td>
                    <td style="text-align: left;"><?= $row2['kegiatan_logbook'] ?></td>
                    <td style="text-align: left;"><?= $row2['keterangan_logbook'] ?></td>
                    <td><?= date('H:i', strtotime($row2['jam_mulai'])) ?> - <?= date('H:i', strtotime($row2['jam_selesai'])) ?></td>
                    <td><img src="<?= $row2['foto_kegiatan'] ?>" alt="Gambar kegiatan"></td>
                    <td><img src="<?= $row2['tanda_tangan'] ?>" alt="TTD"></td>
                </tr>
            <?php
                $no++;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <td colspan="6"><?= $total_logbook ?> Logbook</td>
            </tr>
        </tfoot>
    </table>

    <div class="ttd-section">
        <div class="ttd-container">
            <p>Sidoarjo, <?= formatTanggalLengkapIndonesia(date('Y-m-d')) ?></p>
            <p><strong>Pembimbing Magang</strong></p>
            <br><br><br><br>
            <p><?= $pembimbing['nama_user'] ?></p>
            <p>(NIP. <?= $pembimbing['nip'] ?>)</p>
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()">Cetak Logbook</button>
    </div>
</body>
</html>