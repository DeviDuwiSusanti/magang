<?php
include "../functions.php";
include "functions.php";

$id_user_ini = $_GET["id_user_ini"];
$id_pengajuan = $_GET["id_pengajuan"];

// Ambil data user & pengajuan
$sertifikat = query("SELECT pu.*, p.*, n.*, i.*, b.* 
                    FROM tb_profile_user pu
                    JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
                    JOIN tb_nilai n ON p.id_pengajuan = n.id_pengajuan AND n.id_user = pu.id_user
                    JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                    JOIN tb_bidang b ON n.id_bidang = b.id_bidang
                    WHERE pu.id_user = $id_user_ini")[0];

// Ambil background
$id_instansi = query("SELECT id_instansi FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan' ")[0];
$id_instansi_ini = $id_instansi["id_instansi"];
$background = query("SELECT * FROM tb_sertifikat_background 
                    WHERE id_instansi = '$id_instansi_ini' AND background_active = '1' AND status_active = '1'")[0];

$id_pendidikan = $sertifikat["id_pendidikan"];
$pendidikan = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'")[0];
$admin_instansi = query("SELECT * FROM tb_profile_user WHERE id_instansi = '$id_instansi_ini'")[0];

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
    <title>View Sertifikat Magang</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: "Cambria", serif;
            margin: 0;
            padding: 0;
            background-image: url('<?= $background['path_file'] ?>');
            background-color: white;
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            min-height: 100vh;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            pointer-events: none;
        }

        h1,
        h2,
        h3 {
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
            /* margin-top: 5px; */
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


        .logo-header {
            text-align: center;
            margin-bottom: 10px;
            padding-top: 20px;
        }

        .logo-header img {
            height: 100px;
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
            margin-top: 15px;
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
            font-size: 16px;
            /* margin: 20px 0; */
            text-align: center;
        }

        /* Overlay untuk mencegah interaksi */
        .protection-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: transparent;
        }
    </style>
</head>

<body>
    <!-- Overlay untuk mencegah interaksi -->
    <div class="protection-overlay"></div>
    
    <div class="content">
        <!-- Logo Header -->
        <div class="logo-header">
            <img src="../assets/img/logo_kab_sidoarjo.png" alt="Logo Kabupaten Sidoarjo">
        </div>
        <h3>SERTIFIKAT HASIL <?=
                    ($sertifikat["jenis_pengajuan"] == 'Praktik Kerja Lapangan')
                        ? strtoupper($sertifikat["jenis_pengajuan"])
                        : strtoupper('PRAKTIK ' . $sertifikat["jenis_pengajuan"]);
                    ?>
        </h3>
        <p class="center">Nomor: <?= $kode_surat ?></p>

        <p>Diberikan kepada:</p>
        <h3><?= ($sertifikat["nama_user"]) ?></h3>

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
                <td>Bidang Penempatan</td>
                <td><?= ($sertifikat["nama_bidang"]) ?></td>
            </tr>
            <tr>
                <td>Bidang Keahlian</td>
                <td><?= ($sertifikat["bidang_keahlian"]) ?></td>
            </tr>
        </table>

        <p>Telah melaksanakan <?= ($sertifikat["jenis_pengajuan"]) ?> pada <?= ($sertifikat["nama_panjang"]) ?> di Bidang <?= ($sertifikat["nama_bidang"]) ?> selama 1 periode, dari tanggal <?= $tanggal_mulai ?> hingga <?= $tanggal_selesai ?>
            <?php if ($sertifikat["tanggal_extend"] != "") {  ?>
                , Dan Perpanjangan Waktu Hingga <?= formatTanggal($sertifikat["tanggal_extend"]) ?>
            <?php } else { ?>
                .
            <?php } ?></p>

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

            <div class="signature-wrapper">
                <!-- QR Code -->
                <div class="qr-code">
                    <?php if (!empty($sertifikat["url_qr"])) : ?>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($sertifikat['url_qr']) ?>&size=100x100" alt="QR Code">
                    <?php endif; ?>
                </div>

                <!-- Info Pejabat -->
                <div class="signature-info">
                    <p>Ditandatangani Secara Elektronik</p>
                    <p class="nama"><?= htmlspecialchars($sertifikat["nama_pejabat"]) ?></p>
                    <p><?= htmlspecialchars($sertifikat["pangkat_pejabat"]) ?></p>
                </div>
            </div>

            <p><strong><?= $sertifikat["nama_pejabat"] ?></strong></p>
            <p>NIP. <?= $sertifikat["nip_pejabat"] ?></p>
        </div>
    </div>

    <script>
        // Mencegah semua interaksi pengguna
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Blokir semua shortcut keyboard
        document.addEventListener('keydown', function(e) {
            // Blokir semua kombinasi Ctrl + key
            if (e.ctrlKey || e.metaKey) {
                e.preventDefault();
            }

            // Blokir Print Screen dan F12
            if (e.key === 'PrintScreen' || e.keyCode === 44 || e.key === 'F12') {
                e.preventDefault();
            }

            // Blokir Alt + Print Screen
            if (e.altKey && e.keyCode === 44) {
                e.preventDefault();
            }
        });

        // Mencegah drag and drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });

        // Mencegah selection text
        document.addEventListener('selectstart', function(e) {
            e.preventDefault();
        });

        // Mencegah save image
        document.addEventListener('mousedown', function(e) {
            if (e.button === 1 || e.button === 2) {
                e.preventDefault();
            }
        });

        // Mencegah developer tools
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && e.key === 'I') ||
                (e.ctrlKey && e.shiftKey && e.key === 'J') ||
                (e.ctrlKey && e.key === 'U')) {
                e.preventDefault();
            }
        });

        // Anti screenshot technique
        setInterval(function() {
            document.querySelector('.anti-screenshot').style.display = 'block';
            setTimeout(function() {
                document.querySelector('.anti-screenshot').style.display = 'none';
            }, 100);
        }, 200);

        // Blokir iframe embedding
        if (window.self !== window.top) {
            window.top.location = window.self.location;
        }
    </script>
</body>

</html>