<?php 
  include "../functions.php";

 $id_nilai = $_GET["id"];

// Ambil semua informasi dari tb_nilai dan tb_bidang
$info = query("SELECT * FROM tb_nilai n 
                JOIN tb_bidang b ON n.id_bidang = b.id_bidang 
                WHERE id_nilai = '$id_nilai'")[0];

// Ambil ID pengajuan
$id_pengajuan = $info["id_pengajuan"];

// Ambil ID instansi dari pengajuan
$data_instansi = query("SELECT p.id_instansi 
                        FROM tb_pengajuan p 
                        JOIN tb_nilai n ON p.id_pengajuan = n.id_pengajuan 
                        WHERE p.id_pengajuan = '$id_pengajuan'")[0];

$id_instansi = $data_instansi["id_instansi"];

// Ambil data instansi
$instansi = query("SELECT * FROM tb_instansi 
                   WHERE id_instansi = '$id_instansi'")[0];

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Surat Keluar</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f9f9f9;
    }
    .container {
      max-width: 600px;
      background-color: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #005b8f;
    }
    .info p {
      margin: 8px 0;
    }
    .buttons {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
    }
    .buttons a {
      padding: 10px 20px;
      background-color: #0099ff;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
    }
    .buttons a:hover {
      background-color: #007acc;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>E-Buddy Kab. Sidoarjo</h2>
  <div class="info">
    <p><strong>Jenis:</strong> Surat Keluar</p>
    <p><strong>No. Surat:</strong> 900/1046/438.5.14/2025</p>
    <p><strong>Tanggal Surat:</strong> <?= $info["tanggal_approve"] ?></p>
    <p><strong>Pembuat:</strong> <?= $instansi["nama_panjang"] ?> - <?= $info["nama_bidang"] ?></p>
    <p><strong>Dibuat Pada:</strong> <?= $info["created_date"] ?></p>
    <p><strong>Disetujui:</strong> <?= $info["nama_pejabat"] ?>, <?= $info["pangkat_pejabat"] ?></p>
    <p><strong>Disetujui Pada:</strong> <?= $info["tanggal_approve"] ?></p>
  </div>
  <div class="buttons">
    <a href="user3_cetak_sertifikat.php" target="_blank">Lihat Sertifikat</a>
    <a href="user3_cetak_nilai.php" target="_blank">Lihat Nilai</a>
  </div>
</div>

</body>
</html>
