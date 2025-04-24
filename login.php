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
<<<<<<< HEAD

<style>
=======
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: opacity 0.75s ease, visibility 0.75s ease;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader .spinner {
            width: 80px;
            height: 80px;
            border: 10px solid #e3e3e3;
            border-top: 10px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            box-shadow: 0 0 20px rgba(0, 123, 255, 0.3);
        }

        .loader p {
            margin-top: 20px;
            font-size: 1.1rem;
            font-weight: 500;
            color: #333;
            animation: fadeIn 1s ease forwards;
            opacity: 0;
        }

        @keyframes spin {
            0% {
                transform: rotate(0turn);
            }

            100% {
                transform: rotate(1turn);
            }
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        .side-image {
        position: relative;
    }

    .source-text-top {
        position: absolute;
        top: 10px;
        right: 15px;
        margin: 0;
        font-size: 13px;
        font-weight: 600;
        color: #000; /* warna hitam agar kontras */
    }

    .source-text-top a {
        color: #0d6efd;
        font-weight: 600;
        text-decoration: none;
    }

    .source-text-top a:hover {
        text-decoration: underline;
    }
    </style>
>>>>>>> 1da1e4b93e68128e81640566cb23ae43c4405cb5
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
            <div class="col-md-6 side-image" style="position: relative;">
                <!-- Posisi kiri bawah dan teks lebih tebal -->
                <p class="text-muted source-text" style="font-size: 12px; position: absolute; bottom: 10px; left: 10px; margin: 0; font-weight: 500;">
                    Source foto: 
                    <a href="https://id.pinterest.com/pin/637540891031509847/" target="_blank" style="font-weight: 600;">Pinterest</a>
                </p>

                <div class="text">
                    <p>Welcome <i>- Sidoarjo Internship</i></p>
                </div>
            </div>
                     <div class="col-md-6 right">
                    <div class="input-box">
                        <header>Log In</header>
                        <form action="" method="POST" id="login-form">
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
    <div class="loader hidden">
        <div class="spinner"></div>
        <p>Mohon tunggu sebentar...</p>
    </div>

</body>

</html>

<script>
    // Saat halaman selesai dimuat
    // window.addEventListener('load', () => {
    //     const loader = document.querySelector('.loader');
    //     if (loader) {
    //         loader.classList.add("hidden");

    //         loader.addEventListener('transitionend', () => {
    //             loader.remove(); // Hilangkan loader dari DOM setelah animasi selesai
    //         });
    //     }
    // });

    // Saat form dikirim
    document.getElementById('login-form')?.addEventListener('submit', function() {
        let loader = document.querySelector('.loader');

        // Kalau loader sudah dihapus, buat ulang dari awal
        if (!loader) {
            loader = document.createElement('div');
            loader.className = 'loader';
            loader.innerHTML = `
            <div class="spinner"></div>
            <p>Mohon tunggu sebentar...</p>
        `;
            document.body.appendChild(loader);
        } else {
            loader.classList.remove("hidden");
        }
    });
</script>