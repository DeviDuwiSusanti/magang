<?php
include "../koneksi.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../assets/phpmailer/src/PHPMailer.php';
include '../assets/phpmailer/src/Exception.php';
include '../assets/phpmailer/src/SMTP.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST["id"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    // Ambil data pengajuan
    $query = "SELECT id_user, nama_bidang, tanggal_mulai, tanggal_selesai, alamat_instansi, nama_panjang 
              FROM tb_pengajuan 
              JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
              JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
              WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];
        $bidang_magang = $row['nama_bidang'];
        $alamat_instansi = $row['alamat_instansi'];
        $nama_instansi = $row['nama_panjang'];
        $periode_mulai = date("d F Y", strtotime($row['tanggal_mulai']));
        $periode_selesai = date("d F Y", strtotime($row['tanggal_selesai']));

        // Ambil data user
        $query_user = "SELECT nama_user FROM tb_user 
                       JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user
                       WHERE tb_user.id_user = '$id_user'";
        $result_user = mysqli_query($conn, $query_user);

        if ($result_user && $row_user = mysqli_fetch_assoc($result_user)) {
            $nama_pelamar = $row_user['nama_user'];
            $salam = salamBerdasarkanWaktu();

            // Kirim email pengingat
            $email_pengirim = 'moneyuang25@gmail.com';
            $nama_pengirim = 'Diskominfo Sidoarjo';
            $subject = 'Pengingat Status Pengajuan Magang';
            $message = "
                <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
                <p>Kami dari <strong>{$nama_pengirim}</strong> ingin mengingatkan bahwa pengajuan magang Anda di <strong>{$nama_instansi}</strong> <em>belum dapat kami proses lebih lanjut</em> karena terdapat dokumen yang <strong>belum lengkap</strong>.</p>
                <p>Berikut detail pengajuan Anda:</p>
                <ul>
                    <li>📍 <strong>Instansi:</strong> {$nama_instansi}</li>
                    <li>📆 <strong>Periode Magang:</strong> {$periode_mulai} - {$periode_selesai}</li>
                    <li>🏢 <strong>Lokasi:</strong> {$alamat_instansi}</li>
                    <li>📑 <strong>Bidang:</strong> {$bidang_magang}</li>
                </ul>
                <p>Mohon untuk segera melengkapi dokumen yang dibutuhkan agar proses pengajuan dapat segera kami tindaklanjuti.</p>
                <p>Apabila Anda telah mengunggah dokumen namun masih menerima email ini, silakan hubungi admin untuk verifikasi lebih lanjut.</p>
                <br>
                <p>Terima kasih atas perhatian dan kerja samanya.</p>
                <p>Hormat kami,<br><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
            ";

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $email_pengirim;
            $mail->Password = 'leeufuyyxfovbqtb'; // Gunakan App Password Gmail
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';

            $mail->setFrom($email_pengirim, $nama_pengirim);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            if ($mail->send()) {
                $sql_update = "UPDATE tb_pengajuan SET pengingat_dokumen = '1' WHERE id_pengajuan = '$id_pengajuan'";
                mysqli_query($conn, $sql_update);
                echo json_encode(["success" => true, "message" => "Email pengingat berhasil dikirim."]);
            } else {
                echo json_encode(["success" => false, "message" => "Gagal mengirim email."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Data user tidak ditemukan."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Data pengajuan tidak ditemukan."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Metode tidak valid."]);
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
