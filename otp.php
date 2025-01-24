<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="assets/css/otp.css">
</head>
<body>
    <div class="otp-container">
        <button class="btn btn-link p-0 mb-3" onclick="window.location.href = 'index.php'">
            <i data-feather="arrow-left"></i>
        </button>
        <h5 class="mb-4">Masukkan kode OTP yang telah dikirim ke email Anda</h5>
        <div class="d-flex justify-content-center mb-4">
            <input type="text" class="otp-input" maxlength="1" oninput="handleInput(this, 'otp2', 'otp1')" id="otp1">
            <input type="text" class="otp-input" maxlength="1" oninput="handleInput(this, 'otp3', 'otp1')" id="otp2">
            <input type="text" class="otp-input" maxlength="1" oninput="handleInput(this, 'otp4', 'otp2')" id="otp3">
            <input type="text" class="otp-input" maxlength="1" oninput="handleInput(this, null, 'otp3')" id="otp4">
        </div>
        <p class="mb-4" id="timer" style="font-weight: 500; color: #333; font-size: 18px;">02:00</p>
        <button class="verify-btn" onclick="window.location.href = 'index.php'">Verifikasi</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        feather.replace();

        // Function to handle input and navigate between fields
        function handleInput(current, nextId, prevId) {
            if (current.value.length === current.maxLength && nextId) {
                const nextInput = document.getElementById(nextId);
                if (nextInput) {
                    nextInput.focus();
                }
            } else if (current.value.length === 0 && prevId) {
                const prevInput = document.getElementById(prevId);
                if (prevInput) {
                    prevInput.focus();
                }
            }
        }

        // Countdown timer function
        let timerElement = document.getElementById('timer');
        let time = 120; // 2 minutes in seconds

        function startTimer() {
            const interval = setInterval(() => {
                const minutes = Math.floor(time / 60).toString().padStart(2, '0');
                const seconds = (time % 60).toString().padStart(2, '0');
                timerElement.textContent = `${minutes}:${seconds}`;

                if (time === 0) {
                    clearInterval(interval);
                    alert('Waktu habis! Silahkan login ulang!');
                }

                time--;
            }, 1000);
        }

        startTimer();
    </script>
</body>
</html>
