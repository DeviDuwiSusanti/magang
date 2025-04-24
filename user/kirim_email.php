<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "../assets/phpmailer/src/PHPMailer.php";
include "../assets/phpmailer/src/Exception.php";
include "../assets/phpmailer/src/SMTP.php";

function kirimEmail($email_pengirim, $nama_pengirim, $email_penerima, $subject, $message) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $email_pengirim;
    $mail->Password = 'leeufuyyxfovbqtb'; // App password Gmail
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';

    $mail->setFrom($email_pengirim, $nama_pengirim);
    $mail->addAddress($email_penerima);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send(); // Tidak tampilkan alert karena otomatis
}

function salamBerdasarkanWaktu() {
    date_default_timezone_set('Asia/Jakarta');
    $jam = date("H");
    if ($jam < 11) return "Selamat pagi";
    if ($jam < 15) return "Selamat siang";
    if ($jam < 19) return "Selamat sore";
    return "Selamat malam";
}
?>
