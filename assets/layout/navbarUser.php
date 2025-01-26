<!--==================== HEADER ====================-->
<header class="header" id="header">
    <nav class="nav container">
        <a href="#home" class="nav__logo">S M<i class="bx bxs-map"></i>TCH</a>

        <div class="nav__menu">
            <ul class="nav__list">
                <li class="nav__item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'index.php' : '../index.php'; ?>" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active-link' : ''; ?>">
                        <i class="bx bx-home-alt"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'user/lowongan.php' : 'lowongan.php'; ?>" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'lowongan.php' ? 'active-link' : ''; ?>">
                        <i class="bx bx-building-house"></i>
                        <span>Lowongan</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'user/pengajuan.php' : 'pengajuan.php'; ?>" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'pengajuan.php' ? 'active-link' : ''; ?>">
                        <i class="bx bx-building-house"></i>
                        <span>Pengajuan</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'user/about.php' : 'about.php'; ?>" 
                       class="nav__link <?php echo basename($_SERVER['PHP_SELF']) === 'about.php' ? 'active-link' : ''; ?>">
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
        <a class="navbar-brand" href="#">
            <img 
                src="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'assets/img/avatar1.png' : '../assets/img/avatar1.png'; ?>" 
                alt="Logo" 
                style="width:40px;" 
                class="rounded-pill"
            >
        </a>
    </nav>
</header>
