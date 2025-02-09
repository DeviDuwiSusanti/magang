<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Super Admin - Sistem Magang Sidoarjo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .settings-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .settings-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="settings-container">
        <h2>Pengaturan Super Admin - Sistem Magang Sidoarjo</h2>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">Pengaturan Umum</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">Pengaturan Pengguna</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="internship-tab" data-bs-toggle="tab" data-bs-target="#internship" type="button" role="tab" aria-controls="internship" aria-selected="false">Pengaturan Magang</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="settingsTabContent">
            <!-- Pengaturan Umum -->
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <form action="save_general_settings.php" method="POST">
                    <div class="form-group">
                        <label for="app_name">Nama Aplikasi</label>
                        <input type="text" class="form-control" id="app_name" name="app_name" value="Sistem Magang Sidoarjo" required>
                    </div>
                    <div class="form-group">
                        <label for="app_description">Deskripsi Aplikasi</label>
                        <textarea class="form-control" id="app_description" name="app_description" rows="3" required>Sistem untuk mengelola magang di Kabupaten Sidoarjo.</textarea>
                    </div>
                    <div class="form-group">
                        <label for="timezone">Zona Waktu</label>
                        <select class="form-control" id="timezone" name="timezone" required>
                            <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                            <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                            <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </form>
            </div>

            <!-- Pengaturan Pengguna -->
            <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                <form action="save_user_settings.php" method="POST">
                    <div class="form-group">
                        <label for="user_registration">Registrasi Pengguna</label>
                        <select class="form-control" id="user_registration" name="user_registration" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email_verification">Verifikasi Email</label>
                        <select class="form-control" id="email_verification" name="email_verification" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="default_role">Role Default</label>
                        <select class="form-control" id="default_role" name="default_role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </form>
            </div>

            <!-- Pengaturan Magang -->
            <div class="tab-pane fade" id="internship" role="tabpanel" aria-labelledby="internship-tab">
                <form action="save_internship_settings.php" method="POST">
                    <div class="form-group">
                        <label for="internship_duration">Durasi Magang (Bulan)</label>
                        <input type="number" class="form-control" id="internship_duration" name="internship_duration" min="1" max="12" value="3" required>
                    </div>
                    <div class="form-group">
                        <label for="max_interns">Maksimal Peserta Magang</label>
                        <input type="number" class="form-control" id="max_interns" name="max_interns" min="1" value="50" required>
                    </div>
                    <div class="form-group">
                        <label for="internship_status">Status Magang</label>
                        <select class="form-control" id="internship_status" name="internship_status" required>
                            <option value="open">Dibuka</option>
                            <option value="closed">Ditutup</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>