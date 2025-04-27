<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Ambil waktu kedaluwarsa OTP dari database
$email = $_SESSION['email'];
$query = "SELECT otp_expired FROM tb_user WHERE email = '$email' AND status_active = '1'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $otpExpiredTime = strtotime($row['otp_expired']);
    $currentTime = time();
    $timeLeft = $otpExpiredTime - $currentTime;
    
    // Jika OTP sudah kedaluwarsa
    if ($timeLeft <= 0) {
        $conn->query("UPDATE tb_user SET otp = NULL, otp_expired = NULL WHERE email = '$email'");
        
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Kode OTP Kedaluwarsa',
                text: 'Kode OTP telah kedaluwarsa. Silakan login kembali.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then((result) => {
                window.location.href = 'login.php';
            });
        </script>";
        exit();
    }
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
        $errorMessage = "<script>
            Swal.fire({
                icon: 'error',
                title: 'OTP Salah!',
                text: 'Silakan coba lagi.',
                confirmButtonText: 'OK'
            });
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
    <?php 
    if (isset($errorMessage)) echo $errorMessage;
    ?>
    
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
                <p class="text-center mt-3" id="timer"></p>
                <button type="submit" class="btn btn-primary w-100 mt-2">Verifikasi</button>
            </form>
        </div>
    </div>

    <div class="loader">
        <div class="spinner"></div>
        <p>Mohon tunggu sebentar...</p>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenOtp = document.getElementById('full-otp');
        const timerElement = document.getElementById('timer');

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

        // Timer countdown berdasarkan waktu server
        let timeLeft = <?php echo isset($timeLeft) && $timeLeft > 0 ? $timeLeft : 0; ?>;
        
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
        }

        // Jika waktu sudah habis, tampilkan pesan dan redirect
        if (timeLeft <= 0) {
            timerElement.textContent = "Kode OTP telah kedaluwarsa";
            Swal.fire({
                icon: 'error',
                title: 'Kode OTP Kedaluwarsa',
                text: 'Kode OTP telah kedaluwarsa. Silakan login kembali.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then((result) => {
                window.location.href = 'login.php';
            });
        } else {
            // Update timer segera
            timerElement.textContent = `Waktu tersisa: ${formatTime(timeLeft)}`;
            
            const countdown = setInterval(() => {
                timeLeft--;
                timerElement.textContent = `Waktu tersisa: ${formatTime(timeLeft)}`;
                
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    timerElement.textContent = "Kode OTP telah kedaluwarsa";
                    Swal.fire({
                        icon: 'error',
                        title: 'Kode OTP Kedaluwarsa',
                        text: 'Kode OTP telah kedaluwarsa. Silakan login kembali.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        window.location.href = 'login.php';
                    });
                }
            }, 1000);
        }

        window.addEventListener('load', () => {
            const loader = document.querySelector('.loader');
            if (loader) {
                loader.classList.add("hidden");

                loader.addEventListener('transitionend', () => {
                    if (loader.classList.contains("hidden")) {
                        loader.style.display = "none";
                    }
                });
            }
        });

        document.getElementById('otp-form')?.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validasi OTP terlebih dahulu
            const otpValue = document.getElementById('full-otp').value;
            if (otpValue.length !== 6) {
                Swal.fire({
                    icon: 'error',
                    title: 'OTP Tidak Lengkap',
                    text: 'Harap masukkan 6 digit kode OTP',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Tampilkan loader
            const loader = document.querySelector('.loader');
            loader.style.display = "flex";
            loader.classList.remove("hidden");

            // Submit form setelah validasi
            setTimeout(() => {
                this.submit();
            }, 1000);
        });
    </script>
</body>

</html>