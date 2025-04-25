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

// Fungsi untuk konversi tanggal
function formatTanggal($date) {
    $bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );
    
    $tanggal = date('j', strtotime($date));
    $bulan_num = date('n', strtotime($date));
    $tahun = date('Y', strtotime($date));
    
    return $tanggal . ' ' . $bulan[$bulan_num] . ' ' . $tahun;
}

$tanggal_mulai = formatTanggal($sertifikat["tanggal_mulai"]);
$tanggal_selesai = formatTanggal($sertifikat["tanggal_selesai"]);
$tanggal_lahir = formatTanggal($sertifikat["tanggal_lahir"]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Sertifikat Magang</title>
  <style>
    @page {
      size: A4 landscape;
      margin: 0;
    }
    body {
      font-family: Arial, sans-serif;
      margin: 50px;
    }
    h1, h2, h3 {
      text-align: center;
      margin-bottom: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .no-border {
      border: none;
    }
    .center {
      text-align: center;
    }
    .signature {
      margin-top: 80px;
      text-align: right;
    }
    .content {
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <h1>Sertifikat</h1>
  <h3>HASIL PRAKTIK MAGANG</h3>
  <p class="center">Nomor: 500.5.7.10/239/438.5.14/2025</p>

  <div class="content">
    <p>Diberikan kepada:</p>
    <h2><?= $sertifikat["nama_user"] ?></h2>

    <table class="no-border">
      <tr>
        <td>Tempat, Tanggal Lahir</td>
        <td><?= $sertifikat["tempat_lahir"] ?>, <?= $tanggal_lahir ?></td>
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

    <p>Telah melaksanakan <?= $sertifikat["jenis_pengajuan"] ?> pada <?= $sertifikat["nama_panjang"] ?> 
    Selama 1 Periode, dari tanggal <?= $tanggal_mulai ?> sampai <?= $tanggal_selesai ?>.</p>

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
      <br>
      <?php if($sertifikat["tanda_tangan_admin"] != "") : ?>
        <img src="<?= $sertifikat['tanda_tangan_admin'] ?>" alt="TTD" style="width: 150px; height: 100px;">
      <?php endif; ?>
      <br>
      <strong><?= $admin_instansi["nama_user"] ?></strong><br>
      NIP. <?= $admin_instansi["nip"] ?>
    </div>
  </div>
</body>
</html>