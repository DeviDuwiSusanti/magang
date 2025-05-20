<?php 
include "../functions.php";
include "functions.php";

$id_user_ini = $_GET["id_user_ini"];
$id_pengajuan = $_GET["id_pengajuan"];

// Validasi kelengkapan profil user
$profile_check = query("SELECT pu.*, p.nama_pendidikan
                       FROM tb_profile_user pu
                       LEFT JOIN tb_pendidikan p ON pu.id_pendidikan = p.id_pendidikan
                       WHERE pu.id_user = $id_user_ini")[0];

// Cek field yang wajib diisi
if (empty($profile_check['nama_user']) || 
    empty($profile_check['tempat_lahir']) || 
    empty($profile_check['tanggal_lahir']) || 
    (empty($profile_check['nim']) && empty($profile_check['nisn'])) || 
    empty($profile_check['nama_pendidikan'])) {
    
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "warning",
                title: "Profil Belum Lengkap",
                text: "Silahkan lengkapi profil terlebih dahulu sebelum mencetak sertifikat",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "profil.php";
                }
            });
        });
    </script>';
    exit();
}

// Ambil data user & pengajuan
$sertifikat = query("SELECT pu.*, p.*, n.*, i.*, b.* 
                    FROM tb_profile_user pu
                    JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
                    JOIN tb_nilai n ON p.id_pengajuan = n.id_pengajuan AND n.id_user = pu.id_user
                    JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                    JOIN tb_bidang b ON n.id_bidang = b.id_bidang
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

$tanggal_mulai = formatTanggal($sertifikat["tanggal_mulai"]);
$tanggal_selesai = formatTanggal($sertifikat["tanggal_selesai"]);
$tanggal_lahir = formatTanggal($sertifikat["tanggal_lahir"]);

$nomor_sertifikat = $sertifikat["nomor_nilai"];
$kode_surat = generateKodeSurat($nomor_sertifikat, $id_instansi_ini);



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
      margin-top: 25px;
      float: right; /* Geser elemen ke kanan */
      text-align: left; /* Isi teks tetap rata kiri */
      width: 200px; /* Atur lebar agar tidak terlalu panjang */
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
    <p class="center">Nomor: <?= $kode_surat ?></p>

    <p>Diberikan kepada:</p>
    <h2><?= ($sertifikat["nama_user"]) ?></h2>

    <table class="no-border">
      <tr>
        <td width="30%">Tempat, Tanggal Lahir</td>
        <td><?= ($sertifikat["tempat_lahir"]) ?>, <?= $tanggal_lahir ?></td>
      </tr>
      <tr>
        <td><?= empty($pendidikan["fakultas"]) ? "Sekolah" : "Perguruan Tinggi" ?></td>
        <td><?= ($pendidikan["nama_pendidikan"]) ?></td>
      </tr>
      <tr>
        <td><?= empty($pendidikan["fakultas"]) ? "Nomor Induk Sekolah Nasional" : "Nomor Induk Mahasiswa" ?></td>
        <td><?= empty($pendidikan["fakultas"]) ? $sertifikat["nisn"] : $sertifikat["nim"] ?></td>
      </tr>
      <tr>
        <td>Bidang Keahlian</td>
        <td><?= ($sertifikat["nama_bidang"]) ?></td>
      </tr>
    </table>

    <p>Telah melaksanakan <?= ($sertifikat["jenis_pengajuan"]) ?> pada <?= ($sertifikat["nama_panjang"]) ?> di Bidang <?= ($sertifikat["nama_bidang"]) ?> selama 1 periode, dari tanggal <?= $tanggal_mulai ?> hingga <?= $tanggal_selesai ?>
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
      <p>Kepala <?= $sertifikat["nama_bidang"] ?></p>
      <p><?= $sertifikat["nama_panjang"] ?></p>
      <?php if (!empty($sertifikat["url_qr"])) : ?>
  <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($sertifikat['url_qr']) ?>&size=150x150" alt="QR Code">
<?php endif; ?>

      <p><strong><?= $sertifikat["nama_pejabat"] ?></strong></p>
      <p>NIP. <?= $sertifikat["nip_pejabat"] ?></p>
    </div>
  </div>

  <script>
    window.onload = function() {
      window.print();
    };
  </script>

</body>
</html>