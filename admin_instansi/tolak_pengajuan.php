<?php
include "../layout/header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../assets/phpmailer/src/PHPMailer.php';
include '../assets/phpmailer/src/Exception.php';
include '../assets/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST["id_pengajuan"]);
    $alasan_tolak = mysqli_real_escape_string($conn, $_POST["alasan_tolak"]);

    // Ambil id_user dari tb_pengajuan
    $query = "SELECT id_user FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $query);
    
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];

        // Ambil email dari tb_user
        $query_user = "SELECT email FROM tb_user WHERE id_user = '$id_user'";
        $result_user = mysqli_query($conn, $query_user);

        if ($result_user && $row_user = mysqli_fetch_assoc($result_user)) {
            $email = $row_user['email'];

            if ($email) {
                // Update status pengajuan
                $sql_update = "UPDATE tb_pengajuan SET status_pengajuan = '0' WHERE id_pengajuan = '$id_pengajuan'";
                
                if (mysqli_query($conn, $sql_update)) {
                    // Kirim OTP melalui email
                    $email_pengirim = 'moneyuang25@gmail.com';
                    $nama_pengirim = 'Diskominfo Sidoarjo';
                    $email_penerima = $email;
                    $subject = 'Pemberitahuan Penolakan Pengajuan';
                    $message = $alasan_tolak;

                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Username = $email_pengirim;
                    $mail->Password = 'leeufuyyxfovbqtb';
                    $mail->Port = 465;
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'ssl';

                    $mail->setFrom($email_pengirim, $nama_pengirim);
                    $mail->addAddress($email_penerima);
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    if ($mail->send()) {
                        echo "<script>alert('Email berhasil dikirim ke email!'); window.location.href='pengajuan.php';</script>";
                    } else {
                        echo "<script>alert('Gagal mengirim email!'); window.history.back();</script>";
                    }
                } else {
                    echo "<script>alert('Gagal memperbarui status pengajuan!'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Email tidak ditemukan!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('User tidak ditemukan!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Data pengajuan tidak ditemukan!'); window.history.back();</script>";
    }
}
?>
