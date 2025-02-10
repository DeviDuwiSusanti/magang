<!--==================== HEADER ====================-->
<header class="header" id="header">
    <nav class="nav container">
        <a href="#home" class="nav__logo">SID<i class="bx bxs-map"></i>ARJO<span>&nbsp;INTERNSHIP</span></a>

        <div class="nav__menu">
            <ul class="nav__list">
                <li class="nav__item">
                    <a href="beranda.php" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'beranda.php' ? 'active-link' : ''; ?>">
                        <i class="bx bx-home-alt"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="lowongan.php" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'lowongan.php' ? 'active-link' : ''; ?>">
                        <i class="bx bx-building-house"></i>
                        <span>Lowongan</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="aktivitas.php" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'aktivitas.php' ? 'active-link' : ''; ?>">
                       <i class="bx bx-file"></i>
                        <span>Terdaftar</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="tentang.php" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'tentang.php' ? 'active-link' : ''; ?>">
                        <i class="bx bx-award"></i>
                        <span>Tentang Kami</span>
                    </a>
                </li>
                <li class="nav__item">
                    <i class="bx bx-moon change-theme" id="theme-button"></i>
                </li>
            </ul>
        </div>

        <!-- Kondisi untuk mengatur jalur gambar -->
        <a class="navbar-brand" href="../user/dashboard.php">
            <img 
                src="../assets/img/avatar1.png" 
                alt="Logo" 
                style="width:40px;" 
                class="rounded-pill"
            >
        </a>
    </nav>
</header>
