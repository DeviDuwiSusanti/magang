<?php
session_start();
require 'functions.php';

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

            // Panggil fungsi kirim OTP
            if (kirimOTP($email, $otp)) {
                $_SESSION['email'] = $email;
                header("Location: otp.php");
                exit();
            } else {
                show_alert("Gagal!", "Gagal mengirim OTP melalui email.", "error", "login.php");
                exit();
            }
        } else {
            show_alert("Akun Tidak Aktif!", "Silakan hubungi admin.", "warning", "login.php");
            exit();
        }
    } else {
        show_alert("Email Tidak Ditemukan!", "Silakan coba lagi.", "error", "login.php");
        exit();
    }
}

?>





<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="assets/css/sign_in.css">
    <link rel="icon" href="./assets/img/logo_kab_sidoarjo.png" type="image/png">
    <style>
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
    </style>
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <p class="text-muted source-text" style="font-size: 12px; position: absolute; bottom: 10px; left: 10px; margin: 0; font-weight: 500;">
                        Source foto: <a href="https://id.pinterest.com/pin/637540891031509847/" target="_blank" style="font-weight: 600;">Pinterest</a></p>
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