<?php
include "../functions.php";
include "functions.php";

$id_user_ini = $_GET["id_user_ini"];
$id_pengajuan = $_GET["id_pengajuan"];

// Query untuk mengambil data peserta dan nilai
$sertifikat = query("SELECT pu.*, p.*, n.*, i.*, b.* 
                    FROM tb_profile_user pu
                    JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
                    JOIN tb_nilai n ON p.id_pengajuan = n.id_pengajuan AND n.id_user = pu.id_user
                    JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                    JOIN tb_bidang b ON n.id_bidang = b.id_bidang
                    WHERE pu.id_user = $id_user_ini")[0];

// Validasi kelengkapan data diri
$data_diri_kosong = [];
$kolom_wajib = [
  'nama_user',
  'tanggal_lahir',
  'nama_panjang',
  'nama_bidang',
  'tanggal_mulai',
  'tanggal_selesai'
];

// Validasi NIM/NISN (minimal salah satu harus ada)
if (empty($sertifikat["nim"]) && empty($sertifikat["nisn"])) {
  $data_diri_kosong[] = "NIM atau NISN";
}

foreach ($kolom_wajib as $kolom) {
  if (empty($sertifikat[$kolom])) {
    $data_diri_kosong[] = str_replace('_', ' ', $kolom);
  }
}

// Jika ada data diri yang kosong, tampilkan sweetalert dan hentikan proses
if (!empty($data_diri_kosong)) {
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
  echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Gagal !!",
                text: "Silahkan lengkapi data diri terlebih dahulu",
                showConfirmButton: true,
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "profil.php";
                }
            });
        });
    </script>';
  exit(); // Hentikan eksekusi script
}

// Lanjutkan dengan kode berikutnya jika data lengkap
$id_instansi = query("SELECT id_instansi FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan' ")[0];
$id_instansi_ini = $id_instansi["id_instansi"];
$admin_instansi = query("SELECT * FROM tb_profile_user WHERE id_instansi = '$id_instansi_ini'")[0];


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

$nomor_sertifikat = $sertifikat["nomor_nilai"];
$kode_surat = generateKodeSurat($nomor_sertifikat, $id_instansi_ini);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Lembar Penilaian Magang</title>
  <style>
    @page {
      size: A4 portrait;
      margin: 0;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      position: relative;
    }

    .logo-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo-header img {
      height: 100px;
    }

    .background {
      position: absolute;
      top: 45%;
      left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.1;
      z-index: -1;
      max-width: 100%;
      max-height: 100%;
    }

    .background-text {
      margin-top: 50px;
      position: absolute;
      top: 65%;
      left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.1;
      z-index: -1;
      font-size: 60px;
      font-weight: bold;
      color: #000;
      text-align: center;
      width: 100%;
      text-transform: capitalize;
    }

    h1,
    h2,
    h3 {
      text-align: center;
      margin-bottom: 0;
      text-transform: uppercase;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      padding: 5px;
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
      float: right;
      text-align: left;
      width: 300px;
    }

    .signature img {
      height: 80px;
      margin-bottom: 5px;
    }

    .signature p {
      margin: 5px 0;
    }

    .signature-wrapper {
      display: flex;
      align-items: flex-start;
      margin-top: 20px;
      gap: 10px;
    }

    .qr-code {
      flex-shrink: 0;
    }

    .signature-info {
      text-align: left;
      font-size: 14px;
      line-height: 1.4;
    }

    .signature-info p {
      margin: 2px 0;
    }

    .signature-info .nama {
      font-size: 15px;
      text-transform: uppercase;
      margin-top: 5px;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .capitalize {
      text-transform: capitalize;
    }
  </style>
</head>

<body>
  <!-- Logo Header -->
  <div class="logo-header">
    <img src="../assets/img/logo_kab_sidoarjo.png" alt="Logo Kabupaten Sidoarjo">
  </div>

  <!-- Background Transparan -->
  <img src="../assets/img/instansi/logo_kab_sidoarjo.png" class="background" alt="Background">
  <div class="background-text"><?= ($sertifikat["nama_panjang"]) ?></div>

  <h2>LEMBAR PENILAIAN <?=
                        ($sertifikat["jenis_pengajuan"] == 'Praktik Kerja Lapangan')
                          ? $sertifikat["jenis_pengajuan"]
                          : 'PRAKTIK ' . $sertifikat["jenis_pengajuan"];
                        ?>
  </h2>

  <p class="center uppercase">Nomor: <?= $kode_surat ?></p>

  <table>
    <tr>
      <td class="uppercase">Nama</td>
      <td>: <strong><?= ($sertifikat["nama_user"]) ?></strong></td>
    </tr>
    <tr>
      <?php if ($sertifikat["nim"] == "") { ?>
        <td class="uppercase">Nisn</td>
        <td>: <?= $sertifikat["nisn"] ?></td>
      <?php } else { ?>
        <td class="uppercase">Nim</td>
        <td>: <?= $sertifikat["nim"] ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td class="uppercase">Nama Instansi</td>
      <td>: <?= ($sertifikat["nama_panjang"]) ?></td>
    </tr>
    <tr>
      <td class="uppercase">Unit / Bagian / Bidang</td>
      <td>: <?= ($sertifikat["nama_bidang"]) ?></td>
    </tr>
    <tr>
      <td class="uppercase">Bidang Keahlian</td>
      <td>: <?= ($sertifikat["bidang_keahlian"]) ?></td>
    </tr>
    <tr>
      <?php if ($sertifikat["tanggal_extend"] != "") { ?>
        <td class="uppercase">Periode Magang</td>
        <td>: <?= $tanggal_mulai ?> - <?= formatTanggal($sertifikat["tanggal_extend"]) ?></td>
      <?php } else { ?>
        <td class="uppercase">Periode Magang</td>
        <td>: <?= $tanggal_mulai ?> - <?= $tanggal_selesai ?></td>
      <?php } ?>
    </tr>
  </table>

  <table border="1">
    <tr>
      <th class="uppercase">No.</th>
      <th class="uppercase">Kompetensi Dasar</th>
      <th class="uppercase">Nilai</th>
      <th class="uppercase">Keterangan</th>
    </tr>
    <tr>
      <td>1.</td>
      <td class="capitalize">Kehadiran/Absensi</td>
      <td><?= $sertifikat["kehadiran"] ?></td>
      <td></td>
    </tr>
    <tr>
      <td>2.</td>
      <td class="capitalize">Ketepatan Waktu/Disiplin</td>
      <td><?= $sertifikat["disiplin"] ?></td>
      <td></td>
    </tr>
    <tr>
      <td>3.</td>
      <td class="capitalize">Tanggung Jawab Terhadap Tugas</td>
      <td><?= $sertifikat["tanggung_jawab"] ?></td>
      <td></td>
    </tr>
    <tr>
      <td>4.</td>
      <td class="capitalize">Kreativitas</td>
      <td><?= $sertifikat["kreativitas"] ?></td>
      <td></td>
    </tr>
    <tr>
      <td>5.</td>
      <td class="capitalize">Kerjasama Tim</td>
      <td><?= $sertifikat["kerjasama"] ?></td>
      <td></td>
    </tr>
    <tr>
      <td>6.</td>
      <td class="capitalize">Penggunaan Teknologi Informasi</td>
      <td><?= $sertifikat["teknologi_informasi"] ?></td>
      <td></td>
    </tr>
    <tr>
      <th colspan="2" class="capitalize">Rata-rata</th>
      <th><?= $sertifikat["rata_rata"] ?></th>
      <td></td>
    </tr>
  </table>

  <div class="signature">
    <p>Kepala <?= $sertifikat["nama_bidang"] ?></p>
    <p><?= $sertifikat["nama_panjang"] ?></p>

    <div class="signature-wrapper">
      <!-- QR Code -->
      <div class="qr-code">
        <?php if (!empty($sertifikat["url_qr"])) : ?>
          <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($sertifikat['url_qr']) ?>&size=100x100" alt="QR Code">
        <?php endif; ?>
      </div>

      <!-- Info Pejabat -->
      <div class="signature-info">
        <p>Ditandatangani Secara Elektronik </p>
        <p class="nama"><?= htmlspecialchars($sertifikat["nama_pejabat"]) ?></p>
        <p><?= htmlspecialchars($sertifikat["pangkat_pejabat"]) ?></p>
      </div>
    </div>

    <p><strong><?= $sertifikat["nama_pejabat"] ?></strong></p>
    <p>NIP. <?= $sertifikat["nip_pejabat"] ?></p>
  </div>
  </div>
</body>

</html>

<script src="../assets//js/alert.js"></script>
<script>
  window.onload = function() {
    window.print();
  };
</script>