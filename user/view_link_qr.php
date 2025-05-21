<?php
include "../functions.php";
include "functions.php";

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


$nomor_nilai = $info["nomor_nilai"];
$kode_surat = generateKodeSurat($nomor_nilai, $id_instansi);

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
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      width: 100%;
      max-width: 600px;
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin: 20px;
    }

    h2 {
      text-align: center;
      color: #005b8f;
      margin-top: 0;
    }

    .info p {
      margin: 12px 0;
      line-height: 1.5;
    }

    .buttons {
      margin-top: 25px;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .buttons a {
      padding: 12px 20px;
      background-color: #0099ff;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      text-align: center;
      flex: 1;
      min-width: 120px;
      transition: background-color 0.3s;
    }

    .buttons a:hover {
      background-color: #007acc;
    }

    @media (max-width: 480px) {
      .container {
        padding: 20px;
      }
      
      .buttons {
        flex-direction: column;
      }
      
      .buttons a {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>E-Buddy Kab. Sidoarjo</h2>
    <div class="info">
      <p><strong>Jenis:</strong> Surat Keluar</p>
      <p><strong>No. Surat:</strong> <?= $kode_surat ?></p>
      <p><strong>Tanggal Surat:</strong> <?= $info["tanggal_approve"] ?></p>
      <p><strong>Pembuat:</strong> <?= $instansi["nama_panjang"] ?> - <?= $info["nama_bidang"] ?></p>
      <p><strong>Dibuat Pada:</strong> <?= $info["created_date"] ?></p>
      <p><strong>Disetujui:</strong> <?= $info["nama_pejabat"] ?>, <?= $info["pangkat_pejabat"] ?></p>
      <p><strong>Disetujui Pada:</strong> <?= $info["tanggal_approve"] ?></p>
    </div>
    <div class="buttons">
      <a href="view_certificate.php?id_user_ini=<?= $info['id_user'] ?>&id_pengajuan=<?= $info['id_pengajuan'] ?>" target="_blank">Lihat Sertifikat</a>
      <a href="view_grade.php?id_user_ini=<?= $info['id_user'] ?>&id_pengajuan=<?= $info['id_pengajuan'] ?>" target="_blank">Lihat Nilai</a>
    </div>
  </div>
</body>

</html>