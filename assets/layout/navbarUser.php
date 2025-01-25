<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="assets/img/toga.png" alt="Logo" style="width:70px;" class="rounded-pill">
                S-Match
            </a>
            <!-- Toggle button for smaller screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="9_menu.php">Cari Lowongan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Pengajuan</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="1_pesan.php">Kegiatan Aktif</a></li>
                            <li><a class="dropdown-item" href="0_viewQr.php">Status Pendaftaran</a></li>
                            <li><a class="dropdown-item" href="0_viewQr.php">Histori</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Profile and Dark Mode Toggle -->
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Heviaa</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="user/profil.php" class="nav-link">
                            <img src="assets/img/avatar1.png" alt="Profile" style="width:40px;" class="rounded-pill">
                        </a>
                    </li>
                    <li class="nav-item">
                        <button id="themeToggle" class="btn btn-outline-light ms-2">Dark Mode</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        // Feather icons replacement
        feather.replace();

        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('bg-dark');
            document.body.classList.toggle('text-light');
            const isDarkMode = document.body.classList.contains('bg-dark');
            themeToggle.textContent = isDarkMode ? 'Light Mode' : 'Dark Mode';
        });
    </script>
</body>
</html>
