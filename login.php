<?php
session_start();
require 'koneksi.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include './assets/phpmailer/src/PHPMailer.php';
include './assets/phpmailer/src/Exception.php';
include './assets/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Cek apakah email ada di database
    $query = "SELECT * FROM tb_user WHERE email = '$email' AND status_active = '1'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($user['status_active'] == '1') {
            // Generate OTP
            $otp = rand(100000, 999999);
            $otp_expired = date("Y-m-d H:i:s", strtotime("+2 minutes"));

            // Simpan OTP ke database
            $updateQuery = "UPDATE tb_user SET otp = '$otp', otp_expired = '$otp_expired' WHERE email = '$email' AND status_active = '1'";
            mysqli_query($conn, $updateQuery);

            // Kirim OTP melalui email
            $email_pengirim = 'moneyuang25@gmail.com';
            $nama_pengirim = 'Diskominfo Sidoarjo';
            $email_penerima = $email;
            $subject = 'OTP Verification';
            $message = 'Kode OTP Anda adalah: ' . $otp;

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

            $send = $mail->send();

            $_SESSION['email'] = $email;
            header("Location: otp.php");
            exit();
        } else {
            echo "<script>alert('Akun tidak aktif!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.location='login.php';</script>";
    }
}

?>





<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="assets/css/sign_in.css">
    <link rel="icon" href="./assets/img/logo_kab_sidoarjo.png" type="image/png">
    <style>

    </style>
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <div class="text">
                        <p>Welcome <i>- Sidoarjo Internship</i></p>
                    </div>
                </div>
                <div class="col-md-6 right">
                    <div class="input-box">
                        <header>Log In</header>
                        <form action="" method="POST">
                            <div class="input-field">
                                <input type="email" class="input" name="email" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field">
                                <button type="submit" name="login" class="submit">Sign In</button>
                            </div>
                        </form>
                        <p>Belum punya akun? <a href="register.php">Daftar Sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>