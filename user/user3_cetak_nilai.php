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
    .background {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.1;
      z-index: -1;
      max-width: 100%;
      max-height: 100%;
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
    th, td {
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
      text-align: right;
    }
  </style>
</head>
<body>
  <!-- Background Transparan -->
  <img src="../assets/img/instansi/logo_kab_sidoarjo.png" class="background" alt="Background">

  <h2>LEMBAR PENILAIAN PRAKTIK MAGANG</h2>
  <p class="center">Nomor: 500.5.7.10/239/438.5.14/2025</p>

  <table>
    <tr>
      <td>Nama</td>
      <td>: <strong><?= $sertifikat["nama_user"] ?></strong></td>
    </tr>
    <tr>
      <?php if($sertifikat["nim"] == "") {?>
        <td>NISN</td>
        <td>: <?= $sertifikat["nisn"] ?></td>
      <?php } else { ?>
          <td>NIM</td>
          <td>: <?= $sertifikat["nim"] ?></td>
      <?php } ?>
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
      <td>: <?= $tanggal_mulai ?> - <?= $tanggal_selesai ?></td>
    </tr>
  </table>

  <table border="1">
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
    <p>Pembimbing Magang</p>
    <p><?= $sertifikat["nama_panjang"] ?></p>
    <br> 
    <?php if(!empty($sertifikat) && $sertifikat["tanda_tangan_admin"] != "") : ?>
      <img src="<?= $sertifikat['tanda_tangan_admin'] ?>" alt="TTD" style="width: 150px; height: 100px;">
    <?php endif; ?>
    <br>
    <strong><?= !empty($admin_instansi) ? $admin_instansi["nama_user"] : '-' ?></strong><br>
    NIP. <?= !empty($admin_instansi) ? $admin_instansi["nip"] : '-' ?>
  </div>
</body>
</html>