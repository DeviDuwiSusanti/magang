<?php 
include "../functions.php";

$id_user_ini = $_GET["id_user_ini"];
$id_pengajuan = $_GET["id_pengajuan"];
$sertifikat = query("SELECT pu.*, p.*, n.*, i.*, b.* 
                    FROM tb_profile_user pu
                    JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
                    JOIN tb_nilai n ON p.id_pengajuan = n.id_pengajuan
                    JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                    JOIN tb_bidang b ON p.id_bidang = b.id_bidang
                    
                    WHERE pu.id_user = $id_user_ini")[0];

$id_pendidikan = $sertifikat["id_pendidikan"];
$pendidikan = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'")[0];

$id_instansi = query("SELECT id_instansi FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan' ")[0];
$id_instansi_ini = $id_instansi["id_instansi"];
$admin_instansi = query("SELECT * FROM tb_profile_user WHERE id_instansi = '$id_instansi_ini'")[0];

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
        <td><?= $sertifikat["tanggung_jawab"] ?></td>
        <td></td>
      </tr>
      <tr>
        <td>4.</td>
        <td>Kreativitas</td>
        <td><?= $sertifikat["kreativitas"] ?></td>
        <td></td>
      </tr>
      <tr>
        <td>5.</td>
        <td>Kerjasama Tim</td>
        <td><?= $sertifikat["kerjasama"] ?></td>
        <td></td>
      </tr>
      <tr>
        <td>6.</td>
        <td>Penggunaan Teknologi Informasi</td>
        <td><?= $sertifikat["teknologi_informasi"] ?></td>
        <td></td>
      </tr>
      <tr>
        <th colspan="2">Rata-rata</th>
        <th><?= $sertifikat["rata_rata"] ?></th>
        <td></td>
      </tr>
    </table>

    <div class="signature">
      <p>Kepala Bidang</p>
      <p><?= $sertifikat["nama_panjang"] ?></p>
      <br><br>
      <strong><?= $admin_instansi["nama_user"] ?></strong><br>
      NIP. <?= $admin_instansi["nip"] ?>
    </div>
  </div>

  <!-- Halaman 2: Sertifikat -->
  <div class="page">
    <h1>Sertifikat</h1>
    <h3>HASIL PRAKTIK MAGANG</h3>
    <p class="center">Nomor: 500.5.7.10/239/438.5.14/2025</p>

    <p>Diberikan kepada:</p>
    <h2><?= $sertifikat["nama_user"] ?></h2>

    <table class="no-border">
      <tr>
        <td>Tempat, Tanggal Lahir</td>
        <td><?= $sertifikat["tempat_lahir"] ?>, <?= $sertifikat["tanggal_lahir"] ?></td>
      </tr>
      <tr>
        <?php if($pendidikan["fakultas"] == "") { ?>
          <td>Sekolah</td>
        <?php } else { ?>
          <td>Universitas</td>
        <?php } ?>
        <td><?= $pendidikan["nama_pendidikan"] ?></td>
      </tr>
      <tr>
      <?php if($pendidikan["fakultas"] == "") { ?>
          <td>Nomor Induk Sekolah Nasional</td>
          <td><?= $sertifikat["nisn"] ?></td>
        <?php } else { ?>
          <td>Nomor Induk Mahasiswa</td>
          <td><?= $sertifikat["nim"] ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td>Bidang Keahlian</td>
        <td><?= $sertifikat["nama_bidang"] ?></td>
      </tr>
    </table>

    <p>Telah melaksanakan <?= $sertifikat["jenis_pengajuan"] ?> pada <?= $sertifikat["nama_panjang"] ?> Selama 1 Periode, dari tanggal <?= $sertifikat["tanggal_mulai"] ?> sampai <?= $sertifikat["tanggal_selesai"] ?>.</p>

    <?php 
      if($sertifikat["rata_rata"] >= 88) {
        $prefikat = "SANGAT BAIK";
      } else if($sertifikat["rata_rata"] >= 74) {
        $predikat = "BAIK";
      } else if ($sertifikat["rata_rata"] >= 60 ) {
        $predikat = "CUKUP";
      } else {
        $predikat = "KURANG";
      }
    ?>
    <p class="center"><strong>Dengan predikat:<br><?= $predikat ?></strong></p>

    <div class="signature">
      <p>Kepala Bidang</p>
      <p><?= $sertifikat["nama_panjang"] ?></p>
      <br><br>
      <strong><?= $admin_instansi["nama_user"] ?></strong><br>
      NIP. <?= $admin_instansi["nip"] ?>
    </div>
  </div>

</body>

</html>