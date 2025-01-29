<?php include "header.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- <div class="mb-4">
            <a href="profile.php" class="btn btn-secondary">
                &larr; Kembali
            </a>
        </div> -->
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Edit Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Edit Profile Admin Instansi</li>
        </ol>
        <form action="update_profile.php" class="form-profile" method="POST" enctype="multipart/form-data">
            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="" disabled selected>Pilih Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir" required>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit">Simpan Perubahan</button>
        </form>
    </div>
</div>