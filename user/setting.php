<?php include "../layout/sidebarUser.php"; ?>

<div class="container mt-4">
    <h1 class="text-center"><i class="bi bi-gear"></i> Pengaturan</h1>
    <p class="text-center text-muted">Kelola akun dan sistem aplikasi.</p>

    <!-- Menu Navigasi -->
    <nav class="nav nav-pills justify-content-center mb-4">
        <a class="nav-link active" href="#akun"><i class="bi bi-person-circle"></i> Akun</a>
        <a class="nav-link" href="#sistem"><i class="bi bi-sliders"></i> Sistem</a>
        <a class="nav-link" href="#keamanan"><i class="bi bi-shield-lock"></i> Keamanan</a>
    </nav>

    <!-- Pengaturan Akun -->
    <div id="akun" class="card p-4 mb-4">
        <h4><i class="bi bi-person-circle"></i> Pengaturan Akun</h4>
        <form>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" value="Hendra hartono">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="hendra815@gmail.com">
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepon" value="085760786535">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" id="foto" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </form>
    </div>

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
            <button class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Logout dari Semua Perangkat</button>
        </div>
    </div>
</div>