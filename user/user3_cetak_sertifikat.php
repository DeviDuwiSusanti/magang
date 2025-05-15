<?php 
include "../functions.php";

$id_user_ini = $_GET["id_user_ini"];
$id_pengajuan = $_GET["id_pengajuan"];

// Ambil data user & pengajuan
$sertifikat = query("SELECT pu.*, p.*, n.*, i.*, b.* 
                    FROM tb_profile_user pu
                    JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
                    JOIN tb_nilai n ON p.id_pengajuan = n.id_pengajuan AND n.id_user = pu.id_user
                    JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                    JOIN tb_bidang b ON p.id_bidang = b.id_bidang
                    WHERE pu.id_user = $id_user_ini")[0];

// Validasi background
$id_instansi = query("SELECT id_instansi FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan' ")[0];
$id_instansi_ini = $id_instansi["id_instansi"];
$background = query("SELECT * FROM tb_sertifikat_background 
                    WHERE id_instansi = '$id_instansi_ini' AND background_active = '1' AND status_active = '1'")[0];

if (empty($background)) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "info",
                title: "Sertifikat Hampir Selesai",
                text: "Silahkan tunggu atau hubungi admin untuk penyelesaian sertifikat",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "user3_histori.php";
                }
            });
        });
    </script>';
    exit();
}

$id_pendidikan = $sertifikat["id_pendidikan"];
$pendidikan = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'")[0];
$admin_instansi = query("SELECT * FROM tb_profile_user WHERE id_instansi = '$id_instansi_ini'")[0];

function formatTanggal($date) {
    $bulan = array(
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    );
    $tanggal = date('j', strtotime($date));
    $bulan_num = date('n', strtotime($date));
    $tahun = date('Y', strtotime($date));
    return $tanggal . ' ' . $bulan[$bulan_num] . ' ' . $tahun;
}

function formatText($string) {
    return ucwords(strtolower($string));
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
      font-family: "Cambria", serif;
      margin: 0;
      padding: 0; /* Jangan gunakan padding di body */
      background-image: url('<?= $background['path_file'] ?>');
      background-color: white;
      background-size: cover;
      background-position: top center;
      background-repeat: no-repeat;
      background-attachment: fixed; /* Mencegah background bergeser saat print */
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
      min-height: 100vh;
    }

    @media print {
      body {
        margin: 0;
        padding: 0;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
      .no-print {
        display: none !important;
      }
      .content {
        background-color: transparent;
      }
    }

    h1, h2, h3 {
      text-align: center;
      margin: 10px 0;
    }

    h1 {
      font-size: 28px;
      margin-bottom: 5px;
    }

    h2 {
      font-size: 24px;
      margin-top: 5px;
      margin-bottom: 15px;
    }

    h3 {
      font-size: 20px;
      margin-top: 0;
    }

    p {
      margin: 8px 0;
      line-height: 1.4;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
    }

    table.no-border td {
      padding: 5px 0;
    }

    .center {
      text-align: center;
    }

    .signature {
      margin-top: 40px;
      text-align: right;
      padding-right: 50px;
    }

    .signature img {
      height: 80px;
      margin-bottom: 5px;
    }

    .signature p {
      margin: 5px 0;
    }

    .content {
      padding-top: 50px;
      margin-top: 20px;
      border-radius: 10px;
      max-width: 900px;
      margin-left: auto;
      margin-right: auto;
      /* background-color: rgba(255, 255, 255, 0.1);  */
      background-color: transparent;
    }

    .predikat {
      font-size: 18px;
      margin: 20px 0;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="content">
    <div class="no-print" style="background: #fff8c4; padding: 10px; border: 1px solid #ccc; margin-bottom: 10px;">
        <strong>⚠️ Penting:</strong> Saat mencetak, centang opsi <strong>"Background graphics"</strong> agar sertifikat tampil lengkap.
    </div>

    <h1>SERTIFIKAT</h1>
    <h3>HASIL PRAKTIK MAGANG</h3>
    <p class="center">Nomor: 500.5.7.10/239/438.5.14/2025</p>

    <p>Diberikan kepada:</p>
    <h2><?= formatText($sertifikat["nama_user"]) ?></h2>

    <table class="no-border">
      <tr>
        <td width="30%">Tempat, Tanggal Lahir</td>
        <td><?= formatText($sertifikat["tempat_lahir"]) ?>, <?= $tanggal_lahir ?></td>
      </tr>
      <tr>
        <td><?= empty($pendidikan["fakultas"]) ? "Sekolah" : "Universitas" ?></td>
        <td><?= formatText($pendidikan["nama_pendidikan"]) ?></td>
      </tr>
      <tr>
        <td><?= empty($pendidikan["fakultas"]) ? "Nomor Induk Sekolah Nasional" : "Nomor Induk Mahasiswa" ?></td>
        <td><?= empty($pendidikan["fakultas"]) ? $sertifikat["nisn"] : $sertifikat["nim"] ?></td>
      </tr>
      <tr>
        <td>Bidang Keahlian</td>
        <td><?= formatText($sertifikat["nama_bidang"]) ?></td>
      </tr>
    </table>

    <p>Telah melaksanakan <?= formatText($sertifikat["jenis_pengajuan"]) ?> pada <?= formatText($sertifikat["nama_panjang"]) ?> di Bidang <?= formatText($sertifikat["nama_bidang"]) ?> selama 1 periode, dari tanggal <?= $tanggal_mulai ?> hingga <?= $tanggal_selesai ?>
    <?php if($sertifikat["tanggal_extend"] != "") {  ?>
    , Dan Perpanjangan Waktu Hingga <?= formatTanggal($sertifikat["tanggal_extend"]) ?>
    <?php } else { ?>
    .
    <?php }?></p>

    <?php
    $rata = $sertifikat["rata_rata"];
    if ($rata >= 88) {
      $predikat = "SANGAT BAIK";
    } elseif ($rata >= 74) {
      $predikat = "BAIK";
    } elseif ($rata >= 60) {
      $predikat = "CUKUP";
    } else {
      $predikat = "KURANG";
    }
    ?>

    <div class="predikat">
      <strong>Dengan predikat:<br><?= $predikat ?></strong>
    </div>

    <div class="signature">
      <p>Pembimbing Magang</p>
      <p><?= formatText($sertifikat["nama_panjang"]) ?></p>
      <?php if (!empty($sertifikat["tanda_tangan_admin"])) : ?>
        <img src="<?= $sertifikat['tanda_tangan_admin'] ?>" alt="TTD">
      <?php endif; ?>
      <p><strong><?= !empty($admin_instansi) ? formatText($admin_instansi["nama_user"]) : '-' ?></strong></p>
      <p>NIP. <?= !empty($admin_instansi) ? $admin_instansi["nip"] : '-' ?></p>
    </div>
  </div>

  <script>
    window.onload = function() {
      window.print();
    };
  </script>

</body>
</html>
