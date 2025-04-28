<?php
include "../functions.php";

$id_user_ini = $_GET["id_user_ini"];
$id_pengajuan = $_GET["id_pengajuan"];

// Query untuk mengambil data peserta dan nilai
$sertifikat = query("SELECT pu.*, p.*, n.*, i.*, b.* 
                    FROM tb_profile_user pu
                    JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
                    JOIN tb_nilai n ON p.id_pengajuan = n.id_pengajuan AND n.id_user = pu.id_user
                    JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                    JOIN tb_bidang b ON p.id_bidang = b.id_bidang
                    WHERE pu.id_user = $id_user_ini")[0];

$id_pendidikan = $sertifikat["id_pendidikan"];
$pendidikan = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'")[0];

$id_instansi = query("SELECT id_instansi FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan' ")[0];
$id_instansi_ini = $id_instansi["id_instansi"];
$admin_instansi = query("SELECT * FROM tb_profile_user WHERE id_instansi = '$id_instansi_ini'")[0];

// Ambil background aktif dari instansi
$background = query("SELECT * FROM tb_sertifikat_background 
                    WHERE id_instansi = '$id_instansi_ini' AND background_active = '1' AND status_active = '1'")[0];

// CSS background yang akan digunakan
$backgroundCSS = "";
if (!empty($background)) {
  $backgroundCSS = "
    background-image: url('{$background['path_file']}');
    background-color: white;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  ";
} else {
  $backgroundCSS = "background-color: white;";
}

// CSS content tambahan
$contentStyle = "margin-top: 40px;";
if (!empty($background)) {
  $contentStyle .= "
    background-color: transparant;
    padding: 20px;
    border-radius: 10px;
  ";
}

// Fungsi untuk konversi tanggal
function formatTanggal($date)
{
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
      <?= $backgroundCSS ?>
    }

    @media print {
      body {
        margin: 0;
        padding: 0;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
      .content {
        background-color: rgba(255, 255, 255, 0.8) !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
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
      <?= $contentStyle ?>
    }
  </style>
</head>

<body>
  <div class="content">
    <h1>Sertifikat</h1>
    <h3>HASIL PRAKTIK MAGANG</h3>
    <p class="center">Nomor: 500.5.7.10/239/438.5.14/2025</p>

    <p>Diberikan kepada:</p>
    <h2><?= htmlspecialchars($sertifikat["nama_user"]) ?></h2>

    <table class="no-border">
      <tr>
        <td>Tempat, Tanggal Lahir</td>
        <td><?= htmlspecialchars($sertifikat["tempat_lahir"]) ?>, <?= $tanggal_lahir ?></td>
      </tr>
      <tr>
        <?php if (empty($pendidikan["fakultas"])) { ?>
          <td>Sekolah</td>
        <?php } else { ?>
          <td>Universitas</td>
        <?php } ?>
        <td><?= htmlspecialchars($pendidikan["nama_pendidikan"]) ?></td>
      </tr>
      <tr>
        <?php if (empty($pendidikan["fakultas"])) { ?>
          <td>Nomor Induk Sekolah Nasional</td>
          <td><?= htmlspecialchars($sertifikat["nisn"]) ?></td>
        <?php } else { ?>
          <td>Nomor Induk Mahasiswa</td>
          <td><?= htmlspecialchars($sertifikat["nim"]) ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td>Bidang Keahlian</td>
        <td><?= htmlspecialchars($sertifikat["nama_bidang"]) ?></td>
      </tr>
    </table>

    <p>Telah melaksanakan <?= htmlspecialchars($sertifikat["jenis_pengajuan"]) ?> pada <?= htmlspecialchars($sertifikat["nama_panjang"]) ?> di Bidang <?= $sertifikat["nama_bidang"] ?>
      selama 1 periode, dari tanggal <?= $tanggal_mulai ?> sampai <?= $tanggal_selesai ?>.</p>

    <?php
    if ($sertifikat["rata_rata"] >= 88) {
      $predikat = "SANGAT BAIK";
    } elseif ($sertifikat["rata_rata"] >= 74) {
      $predikat = "BAIK";
    } elseif ($sertifikat["rata_rata"] >= 60) {
      $predikat = "CUKUP";
    } else {
      $predikat = "KURANG";
    }
    ?>

    <p class="center"><strong>Dengan predikat:<br><?= $predikat ?></strong></p>

    <div class="signature">
      <p>Pembimbing Magang</p>
      <p><?= htmlspecialchars($sertifikat["nama_panjang"]) ?></p>
      <br>
      <?php if (!empty($sertifikat["tanda_tangan_admin"])) : ?>
        <img src="<?= htmlspecialchars($sertifikat['tanda_tangan_admin']) ?>" alt="TTD" style="width: 150px; height: 100px;">
      <?php endif; ?>
      <br>
      <strong><?= !empty($admin_instansi) ? htmlspecialchars($admin_instansi["nama_user"]) : '-' ?></strong><br>
      NIP. <?= !empty($admin_instansi) ? htmlspecialchars($admin_instansi["nip"]) : '-' ?>
    </div>
  </div>

  <script>
    window.onload = function() {
      if (window.location.href.indexOf('print') > -1) {
        window.print();
      }
    }
  </script>
</body>

</html>
