<?php
include "../koneksi.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "../assets/phpmailer/src/PHPMailer.php";
include "../assets/phpmailer/src/Exception.php";
include "../assets/phpmailer/src/SMTP.php";

$email_pengirim = 'moneyuang25@gmail.com';
$nama_pengirim = 'Diskominfo Sidoarjo';

$sql = "
    SELECT p.id_pengajuan, p.id_user, u.email, pu.nama_user, p.tanggal_diterima, 
           i.nama_panjang AS nama_instansi, p.dokumen_lengkap,
           p.pengingat_dokumen, p.penolakan_otomatis
    FROM tb_pengajuan p
    JOIN tb_user u ON p.id_user = u.id_user
    JOIN tb_profile_user pu ON p.id_user = pu.id_user
    JOIN tb_instansi i ON p.id_instansi = i.id_instansi
    WHERE p.status_pengajuan = 2
    AND (p.pengingat_dokumen = 0 OR p.penolakan_otomatis = 0)
    AND p.tanggal_diterima IS NOT NULL
    AND p.status_active = 1
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $salam            = salamBerdasarkanWaktu();
    $email_penerima   = $row['email'];
    $nama_pelamar     = $row['nama_user'];
    $id_pengajuan     = $row['id_pengajuan'];
    $nama_instansi    = $row['nama_instansi'];
    $dokumen_lengkap  = $row['dokumen_lengkap'];
    $tanggal_diterima = strtotime($row['tanggal_diterima']);
    $hari_ini         = strtotime(date('Y-m-d'));

    $pengingat_5hari  = $row['pengingat_dokumen'];
    $penolakan_10hari = $row['penolakan_otomatis'];

    // Kirim email penolakan otomatis jika >10 hari penuh dan belum ditolak otomatis
    if (!$dokumen_lengkap && $penolakan_10hari == 0 && $tanggal_diterima <= strtotime('-11 days')) {
        $subject = 'Pengajuan Magang Ditolak';
        $message = "
        <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
        <p>Pengajuan magang Anda dengan ID <strong>{$id_pengajuan}</strong> telah diterima oleh <strong>{$nama_instansi}</strong> sejak lebih dari 10 hari yang lalu.</p>
        <p>Namun hingga saat ini, dokumen pendukung Anda <strong>belum lengkap</strong>.</p>
        <p>Dengan berat hati, kami informasikan bahwa pengajuan magang Anda kami tolak karena dokumen tidak lengkap.</p>
        <p>Terima kasih atas perhatian dan kerja samanya.</p>
        <br>
        <p>Hormat kami,<br><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
    ";
        kirimEmail($email_pengirim, $nama_pengirim, $email_penerima, $subject, $message);

        // Update status jadi ditolak dan tandai sudah ditolak otomatis
        mysqli_query($conn, "
        UPDATE tb_pengajuan 
        SET status_pengajuan = 3, penolakan_otomatis = 1, status_active = 0
        WHERE id_pengajuan = $id_pengajuan
    ");

        // Kirim email pengingat jika >5 hari dan belum dikirim
    } elseif (!$dokumen_lengkap && $pengingat_5hari == 0 && $tanggal_diterima <= strtotime('-5 days')) {
        $subject = 'Pengingat Kelengkapan Dokumen Pengajuan Magang';
        $message = "
            <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
            <p>Pengajuan magang Anda dengan ID <strong>{$id_pengajuan}</strong> telah diterima oleh <strong>{$nama_instansi}</strong> sejak 5 hari yang lalu.</p>
            <p>Namun hingga saat ini, dokumen pendukung Anda <strong>belum lengkap</strong>.</p>
            <p>Segera unggah dokumen yang diperlukan melalui dashboard Anda agar proses pengajuan tidak tertunda.</p>
            <p>Terima kasih atas perhatian dan kerja samanya.</p>
            <br>
            <p>Hormat kami,<br><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
        ";
        kirimEmail($email_pengirim, $nama_pengirim, $email_penerima, $subject, $message);

        // Update flag sudah dikirim email pengingat
        mysqli_query($conn, "
            UPDATE tb_pengajuan 
            SET pengingat_dokumen = 1 
            WHERE id_pengajuan = $id_pengajuan
        ");
    }
}

function kirimEmail($email_pengirim, $nama_pengirim, $email_penerima, $subject, $message)
{
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $email_pengirim;
    $mail->Password = 'leeufuyyxfovbqtb';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';

    $mail->setFrom($email_pengirim, $nama_pengirim);
    $mail->addAddress($email_penerima);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
}

function salamBerdasarkanWaktu()
{
    date_default_timezone_set('Asia/Jakarta');
    $jam = date("H");
    if ($jam < 11) return "Selamat pagi";
    if ($jam < 15) return "Selamat siang";
    if ($jam < 19) return "Selamat sore";
    return "Selamat malam";
}
