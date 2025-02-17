<?php include "../layout/sidebarUser.php"; ?>

<div class="container mt-4">
    <h1 class="text-center"><i class="bi bi-gear"></i> Pengaturan</h1>
    <p class="text-center text-muted">Kelola akun dan sistem aplikasi.</p>

    <!-- Menu Navigasi -->
    <nav class="nav nav-pills justify-content-center mb-4">
        <a class="nav-link" href="#sistem"><i class="bi bi-sliders"></i> Sistem</a>
        <a class="nav-link" href="#keamanan"><i class="bi bi-shield-lock"></i> Keamanan</a>
    </nav>

    <!-- Pengaturan Sistem -->
    <div id="sistem" class="card p-4 mb-4">
        <h4><i class="bi bi-sliders"></i> Pengaturan Sistem</h4>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="notifikasi" checked>
            <label class="form-check-label" for="notifikasi">
                Aktifkan Notifikasi Email
            </label>
        </div>
        <div class="mt-3">
            <label for="tema" class="form-label">Tema Dashboard</label>
            <select class="form-select" id="tema">
                <option value="light" selected>Mode Terang</option>
                <option value="dark">Mode Gelap</option>
            </select>
        </div>
    </div>

    <!-- Pengaturan Keamanan -->
    <div id="keamanan" class="card p-4">
        <h4><i class="bi bi-shield-lock"></i> Keamanan</h4>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="2fa">
            <label class="form-check-label" for="2fa">
                Aktifkan Autentikasi 2 Langkah (2FA)
            </label>
        </div>
        <div class="mt-3">
            <!-- Form Logout -->
            <form id="logoutForm" action="../logout.php" method="POST">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout dari Semua Perangkat
                </button>
            </form>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>