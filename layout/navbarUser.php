<?php
session_start();
include "../koneksi.php";

$default_image = "../assets/img/user/avatar.png"; // Gambar default
$user_image = $default_image; // Set default gambar terlebih dahulu

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM tb_user 
            JOIN tb_profile_user ON tb_profile_user.id_user = tb_user.id_user 
            WHERE tb_user.email = '$email'";
    $hasil = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($hasil)) {
        // Jika ada gambar di database, gunakan gambar tersebut
        if (!empty($row['gambar_user']) && file_exists("../assets/img/user/" . $row['gambar_user'])) {
            $user_image = "../assets/img/user/" . $row['gambar_user'];
        }
    }
}
?>

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
        <a class="navbar-brand" href="../user/dashboard.php" data-bs-toggle="tooltip" title="Dashboard">
            <img 
                src="<?= $user_image ?>" 
                alt="User Image" 
                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
            >
        </a>
    </nav>
</header>

<!-- Script untuk mengaktifkan tooltip Bootstrap -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
