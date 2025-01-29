<!--==================== HEADER ====================-->
<header class="header" id="header">
    <nav class="nav container">
        <a href="#home" class="nav__logo">S M<i class="bx bxs-map"></i>TCH</a>

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
                    <a href="pengajuanaktif.php" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'pengajuanaktif.php' ? 'active-link' : ''; ?>">
                       <i class="bx bx-file"></i>
                        <span>Pengajuan</span>
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
        <a class="navbar-brand" href="../index.php">
            <img 
                src="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'assets/img/avatar1.png' : '../assets/img/avatar1.png'; ?>" 
                alt="Logo" 
                style="width:40px;" 
                class="rounded-pill"
            >
        </a>
    </nav>
</header>
