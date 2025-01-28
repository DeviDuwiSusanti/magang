<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Input</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body{
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
            <form id="otp-form">
                <div class="d-flex justify-content-center">
                    <input type="text" class="otp-input" maxlength="1" id="digit-1" autofocus>
                    <input type="text" class="otp-input" maxlength="1" id="digit-2">
                    <input type="text" class="otp-input" maxlength="1" id="digit-3">
                    <input type="text" class="otp-input" maxlength="1" id="digit-4">
                    <input type="text" class="otp-input" maxlength="1" id="digit-5">
                    <input type="text" class="otp-input" maxlength="1" id="digit-6">
                </div>
                <p class="text-center mt-3" id="timer">Waktu tersisa: 2:00</p>
                <button type="submit" class="btn btn-primary w-100 mt-2">Verifikasi</button>
            </form>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && index > 0 && !e.target.value) {
                    inputs[index - 1].focus();
                }
            });
        });

        document.getElementById('otp-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const otp = Array.from(inputs).map(input => input.value).join('');
            if (otp.length === 6) {
                alert('Verifikasi Berhasil!');
                window.location.href="index.php";
            } else {
                alert('Kode OTP tidak sesuai. Silakan coba lagi.');
            }
        });

        let timeLeft = 120;
        const timerElement = document.getElementById('timer');
        const countdown = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `Waktu tersisa: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (timeLeft === 0) {
                clearInterval(countdown);
                alert('Waktu habis. Silahkan login ulang!')
                window.location.href='login.php';
            }
            timeLeft--;
        }, 1000);
    </script>
</body>
</html>
