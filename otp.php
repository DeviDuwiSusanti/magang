<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $conn->real_escape_string($_POST['otp']);
    $email = $_SESSION['email'];

    // Cek OTP & waktu kedaluwarsa
    $query = "SELECT u.id_user, p.id_instansi, u.level 
                FROM tb_user u
                LEFT JOIN tb_profile_user p ON u.id_user = p.id_user
                WHERE u.email = '$email' AND u.status_active = '1' AND u.otp = '$otp' AND u.otp_expired > NOW()";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $_SESSION["id_user"] = $user["id_user"];
        $_SESSION["id_instansi"] = $user["id_instansi"];

        // Reset OTP setelah verifikasi
        $conn->query("UPDATE tb_user SET otp = NULL, otp_expired = NULL WHERE email = '$email'");

        // Redirect sesuai level
        switch ($user['level']) {
            case 1:
                header("Location: user/dashboard.php");
                break;
            case 2:
                header("Location: user/dashboard.php");
                break;
            case 3:
                header("Location: user/dashboard.php");
                break;
            case 4:
                header("Location: user/dashboard.php");
                break;
            default:
                header("Location: login.php");
        }
        exit();
    } else {
        echo "<script>
            window.onload = function() {
                showSwalAlert('error', 'OTP Salah atau Kedaluwarsa!', 'Silakan coba lagi.');
            };
        </script>";
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
    <link rel="icon" href="./assets/img/logo_kab_sidoarjo.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* loader */
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

    <div class="loader">
        <div class="spinner"></div>
        <p>Mohon tunggu sebentar...</p>
    </div>

    <script src="./assets/js/alert.js"></script>

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
                otp_expired();
            }
            timeLeft--;
        }, 1000);

        window.addEventListener('load', () => {
            const loader = document.querySelector('.loader');
            if (loader) {
                loader.classList.add("hidden");

                loader.addEventListener('transitionend', () => {
                    loader.remove();
                });
            }
        });

        document.getElementById('otp-form')?.addEventListener('submit', function(e) {
            e.preventDefault(); // Cegah submit form langsung

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

            // Delay 2 detik sebelum submit form
            setTimeout(() => {
                e.target.submit(); // Submit form secara manual setelah delay
            }, 2000); // 2000 ms = 2 detik
        });
    </script>
</body>

</html>