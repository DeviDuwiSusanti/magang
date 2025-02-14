<?php
session_start();
include "functions.php";

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $conn->real_escape_string($_POST['otp']);
    $email = $_SESSION['email'];

    // Cek OTP & waktu kedaluwarsa
    $query = "SELECT * FROM tb_user WHERE email = '$email' AND otp = '$otp' AND otp_expired > NOW()";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Reset OTP setelah verifikasi
        $conn->query("UPDATE tb_user SET otp = NULL, otp_expired = NULL WHERE email = '$email'");

        // Redirect sesuai level
        switch ($user['level']) {
            case 1: header("Location: super_admin/"); break;
            case 2: header("Location: admin_instansi/"); break;
            case 3: header("Location: user/dashboard.php"); break;
            case 4: header("Location: user/detail_histori.php"); break;
            default: header("Location: login.php");
        }
        exit();
    } else {
        echo "<script>alert('Kode OTP salah atau sudah kedaluwarsa!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #e2ecf4;
        }
        .otp-input {
            width: 3rem;
            height: 3rem;
            text-align: center;
            font-size: 1.5rem;
            margin: 0.2rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .otp-input:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            outline: none;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow-lg" style="width: 22rem;">
            <a href="login.php" class="text-decoration-none text-dark mb-3 d-block">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h4 class="text-center mb-4">Masukkan Kode OTP</h4>
            <p class="text-center text-muted">
                Kami telah mengirimkan kode OTP ke email Anda. Silakan masukkan kode di bawah ini untuk melanjutkan.
            </p>
            <form id="otp-form" method="POST">
                <div class="d-flex justify-content-center">
                    <input type="text" class="otp-input" maxlength="1" name="otp1" autofocus required>
                    <input type="text" class="otp-input" maxlength="1" name="otp2" required>
                    <input type="text" class="otp-input" maxlength="1" name="otp3" required>
                    <input type="text" class="otp-input" maxlength="1" name="otp4" required>
                    <input type="text" class="otp-input" maxlength="1" name="otp5" required>
                    <input type="text" class="otp-input" maxlength="1" name="otp6" required>
                </div>
                <input type="hidden" name="otp" id="full-otp">
                <p class="text-center mt-3" id="timer">Waktu tersisa: 2:00</p>
                <button type="submit" class="btn btn-primary w-100 mt-2">Verifikasi</button>
            </form>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenOtp = document.getElementById('full-otp');

        // Auto move to next input
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                updateHiddenOtp();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && index > 0 && !e.target.value) {
                    inputs[index - 1].focus();
                }
                updateHiddenOtp();
            });
        });

        function updateHiddenOtp() {
            hiddenOtp.value = Array.from(inputs).map(input => input.value).join('');
        }

        // Timer countdown 2 menit (120 detik)
        let timeLeft = 120;
        const timerElement = document.getElementById('timer');
        const countdown = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `Waktu tersisa: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (timeLeft === 0) {
                clearInterval(countdown);
                alert('Waktu habis. Silakan login ulang!');
                window.location.href = 'login.php';
            }
            timeLeft--;
        }, 1000);
    </script>
</body>
</html>
