    <!--==================== HEADER ====================-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#home" class="nav__logo">ACALA BR<i class="bx bxs-map"></i>MO</a>

            <div class="nav__menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="index.html" class="nav__link active-link">
                            <i class="bx bx-home-alt"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="package-travel.php" class="nav__link">
                            <i class="bx bx-building-house"></i>
                            <span>Package Travel</span>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="blog.php" class="nav__link">
                            <i class="bx bx-award"></i>
                            <span>Blog</span>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="contact.php" class="nav__link">
                            <i class="bx bx-phone"></i>
                            <span>Contact</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- theme -->
            <i class="bx bx-moon change-theme" id="theme-button"></i>

            <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"> <?= $row_nama['nama'] ?>/Kasir</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
            <a href="info_user.php" class="navbar-brand">
                <img src="avatar1.png" alt="Logo" style="width:40px;" class="rounded-pill">
            </a>
        </ul>
        </nav>
    </header>