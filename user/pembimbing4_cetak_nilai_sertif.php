<?php 
include "../functions.php";

$id_user_ini = $_GET["id_user_ini"];
$sertifikat = query("SELECT pu.*, p.*, n.*, i.*, b.* 
                    FROM tb_profile_user pu
                    JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
                    JOIN tb_nilai n ON p.id_pengajuan = n.id_pengajuan
                    JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                    JOIN tb_bidang b ON p.id_bidang = b.id_bidang
                    
                    WHERE pu.id_user = $id_user_ini")[0];


?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Dokumen Magang</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
    }

    .page {
      page-break-after: always;
    }

    h1,
    h2,
    h3 {
      text-align: center;
      margin-bottom: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
    }

    .no-border {
      border: none;
    }

    .center {
      text-align: center;
    }

    .signature {
      margin-top: 40px;
      text-align: right;
    }
  </style>
</head>

<body>

  <!-- Halaman 1: Lembar Penilaian -->
  <div class="page">
    <h2>LEMBAR PENILAIAN PRAKTIK MAGANG</h2>
    <p class="center">Nomor: 500.5.7.10/239/438.5.14/2025</p>

    <table class="no-border">
      <tr>
        <td>Nama</td>
        <td>: <strong><?= $sertifikat["nama_user"] ?></strong></td>
      </tr>
      <tr>
        <td>NIM</td>
        <td>: <?= $sertifikat["nim"] ?></td>
      </tr>
      <tr>
        <td>Nama Instansi</td>
        <td>: <?= $sertifikat["nama_panjang"] ?></td>
      </tr>
      <tr>
        <td>Unit / Bagian / Bidang</td>
        <td>: <?= $sertifikat["nama_bidang"] ?></td>
      </tr>
      <tr>
        <td>Periode Magang</td>
        <td>: <?= $sertifikat["tanggal_mulai"] ?> - <?= $sertifikat["tanggal_selesai"] ?></td>
      </tr>
    </table>

    <table>
      <tr>
        <th>No.</th>
        <th>KOMPETENSI DASAR</th>
        <th>NILAI</th>
        <th>KETERANGAN</th>
      </tr>
      <tr>
        <td>1.</td>
        <td>Kehadiran/Absensi</td>
        <td><?= $sertifikat["kehadiran"] ?></td>
        <td></td>
      </tr>
      <tr>
        <td>2.</td>
        <td>Ketepatan Waktu/Disiplin</td>
        <td><?= $sertifikat["disiplin"] ?></td>
        <td></td>
      </tr>
      <tr>
        <td>3.</td>
        <td>Tanggung jawab Terhadap Tugas</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>4.</td>
        <td>Kreativitas</td>
        <td>90</td>
        <td></td>
      </tr>
      <tr>
        <td>5.</td>
        <td>Kerjasama Tim</td>
        <td>90</td>
        <td></td>
      </tr>
      <tr>
        <td>6.</td>
        <td>Penggunaan Teknologi Informasi</td>
        <td>90</td>
        <td></td>
      </tr>
      <tr>
        <th colspan="2">Rata-rata</th>
        <th>88</th>
        <td></td>
      </tr>
    </table>

    <div class="signature">
      <p>Kepala Bidang</p>
      <p>Pengelolaan Informasi dan Komunikasi Publik</p>
      <br><br>
      <strong>MUHAMMAD WILDAN, S.S</strong><br>
      NIP. 197110202005011008
    </div>
  </div>

  <!-- Halaman 2: Sertifikat -->
  <div class="page">
    <h1>Sertifikat</h1>
    <h3>HASIL PRAKTIK MAGANG</h3>
    <p class="center">Nomor: 500.5.7.10/239/438.5.14/2025</p>

    <p>Diberikan kepada:</p>
    <h2>AKHMAD FARDAN JONTANO</h2>

    <table class="no-border">
      <tr>
        <td>Tempat, Tanggal Lahir</td>
        <td>: Sidoarjo, 10 Januari 2004</td>
      </tr>
      <tr>
        <td>Universitas</td>
        <td>: Universitas Negeri Surabaya</td>
      </tr>
      <tr>
        <td>Nomor Induk Mahasiswa</td>
        <td>: 22020144097</td>
      </tr>
      <tr>
        <td>Kompetensi Keahlian</td>
        <td>: Kehumasan, Sosial Media Spesialis, Konten Kreator</td>
      </tr>
    </table>

    <p>Telah melaksanakan Praktik Kerja Lapangan pada Dinas Komunikasi dan Informatika Kabupaten Sidoarjo selama 4 bulan, dari tanggal 17 September 2024 sampai 31 Januari 2025.</p>

    <p class="center"><strong>Dengan predikat:<br>SANGAT BAIK</strong></p>

    <div class="signature">
      <p>Kepala Bidang</p>
      <p>Pengelolaan Informasi dan Komunikasi Publik</p>
      <br><br>
      <strong>MUHAMMAD WILDAN, S.S</strong><br>
      NIP. 197110202005011008
    </div>
  </div>

</body>

</html>