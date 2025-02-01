<?php include "sidebar.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Calon Admin Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Tambah Calon Admin Instansi</li>
        </ol>
        <form action="profile_view.php" class="form-profile" method="POST" enctype="multipart/form-data">
            
            <!-- Nama -->
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap Calon Admin Instansi" required>
            </div>

            <!-- NIK -->
            <div class="mb-3">
                <label for="nik_admin_instansi" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik_admin_instansi" name="nik_admin_instansi" placeholder="Masukkan NIK Calon Admin Instansi (16)" required maxlength="16">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email_admin_instansi" class="form-label">Email</label>
                <input type="text" class="form-control" id="email_admin_instansi" name="email_admin_instansi" placeholder="Masukkan Email Calon Admin Instansi" required>
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir Calon Admin Instansi"  required>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir Calon Admin Instansi" required>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label"> Jenis Kelamin </label>
                <div class="form-check">
                    <input type="radio" name="gender" id="gender_l" value="L" class="form-check-input">
                    <label for="gender_l" class="form-check-label">Laki - Laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="gender" id="gender_p" value="P" class="form-check-input">
                    <label for="gender_p" class="form-check-label">Perempuan</label>
                </div>
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="Masukkan Nomor telepone Calon Admin Instansi" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat Calon Admin Instansi" required></textarea>
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
                <img src="img/login.jpeg" alt="gambaredit" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                <input type="file" class="form-control" id="image" name="image" accept="image/*" placeholder="Masukkan Gambar (OPSIONAL)">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit">Tambah Data</button>
        </form>
        <a href="user_view.php" class="btn btn-danger bi bi-arrow-left-circle"> Kembali</a>
    </div>
</div>