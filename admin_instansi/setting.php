<?php include "../layout/header.php"; ?>

<div class="container mt-4">
    <h1 class="text-center"><i class="bi bi-gear"></i> Pengaturan</h1>
    <p class="text-center text-muted">Atur preferensi akun, tampilan, dan keamanan aplikasi Anda.</p>

    <!-- Navigasi Tab -->
    <ul class="nav nav-tabs justify-content-center mb-4" id="settingsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="akun-tab" data-bs-toggle="tab" data-bs-target="#akun" type="button" role="tab" aria-controls="akun" aria-selected="true">
                <i class="bi bi-person-circle"></i> Akun
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sistem-tab" data-bs-toggle="tab" data-bs-target="#sistem" type="button" role="tab" aria-controls="sistem" aria-selected="false">
                <i class="bi bi-sliders"></i> Sistem
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="keamanan-tab" data-bs-toggle="tab" data-bs-target="#keamanan" type="button" role="tab" aria-controls="keamanan" aria-selected="false">
                <i class="bi bi-shield-lock"></i> Keamanan
            </button>
        </li>
    </ul>

    <!-- Konten Tab -->
    <div class="tab-content" id="settingsTabContent">
        <!-- Pengaturan Akun -->
        <div class="tab-pane fade show active" id="akun" role="tabpanel" aria-labelledby="akun-tab">
            <div class="card p-4 mb-4">
                <h1><i class="bi bi-person-circle"></i> Pengaturan Akun</h1>
                <form action="update_account.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="Super Admin" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="superadmin@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="08123456789">
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio Singkat</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3">Tulis bio singkat tentang Anda...</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Pengaturan Sistem -->
        <div class="tab-pane fade" id="sistem" role="tabpanel" aria-labelledby="sistem-tab">
            <div class="card p-4 mb-4">
                <h1><i class="bi bi-sliders"></i> Pengaturan Sistem</h1>
                <form action="update_system.php" method="post">
                    <div class="mb-3">
                        <label for="tema" class="form-label">Tema Aplikasi</label>
                        <select class="form-select" id="tema" name="tema">
                            <option value="light" selected>Mode Terang</option>
                            <option value="dark">Mode Gelap</option>
                            <option value="auto">Otomatis</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bahasa" class="form-label">Bahasa</label>
                        <select class="form-select" id="bahasa" name="bahasa">
                            <option value="id" selected>Bahasa Indonesia</option>
                            <option value="en">English</option>
                            <option value="es">Español</option>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notifikasi_email" name="notifikasi_email" checked>
                        <label class="form-check-label" for="notifikasi_email">Aktifkan Notifikasi Email</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notifikasi_push" name="notifikasi_push">
                        <label class="form-check-label" for="notifikasi_push">Aktifkan Notifikasi Push</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Pengaturan Sistem</button>
                </form>
            </div>
        </div>

        <!-- Pengaturan Keamanan -->
        <div class="tab-pane fade" id="keamanan" role="tabpanel" aria-labelledby="keamanan-tab">
            <div class="card p-4">
                <h1><i class="bi bi-shield-lock"></i> Pengaturan Keamanan</h1>
                <form action="update_security.php" method="post">
                    <div class="mb-3">
                        <label for="password_lama" class="form-label">Password Lama</label>
                        <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                    </div>
                    <div class="mb-3">
                        <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="2fa" name="2fa">
                        <label class="form-check-label" for="2fa">Aktifkan Autentikasi 2 Langkah (2FA)</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui Keamanan</button>
                </form>
                <div class="mt-4">
                    <button class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Logout dari Semua Perangkat</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>