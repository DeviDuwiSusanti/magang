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
    <title>View Lembar Penilaian Magang</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            position: relative;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            pointer-events: none;
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
            pointer-events: none;
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
            pointer-events: none;
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

        /* Anti-screenshot overlay */
        .anti-screenshot {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(45deg,
                    rgba(255, 0, 0, 0.05),
                    rgba(255, 0, 0, 0.05) 10px,
                    rgba(0, 0, 255, 0.05) 10px,
                    rgba(0, 0, 255, 0.05) 20px);
            z-index: 9998;
            pointer-events: none;
            display: none;
        }

        /* Protection overlay */
        .protection-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: transparent;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            opacity: 0.1;
            font-size: 100px;
            width: 100%;
            text-align: center;
            z-index: 1000;
            color: red;
            pointer-events: none;
            transform: rotate(-45deg);
            top: 40%;
            left: 0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Protection elements -->
    <div class="anti-screenshot"></div>
    <div class="protection-overlay"></div>

    <!-- Background Transparan -->
    <img src="../assets/img/instansi/logo_kab_sidoarjo.png" class="background" alt="Background">
    <div class="background-text"><?= ($sertifikat["nama_panjang"]) ?></div>

    <h2>LEMBAR PENILAIAN PRAKTIK MAGANG</h2>
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