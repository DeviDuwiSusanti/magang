<?php include "sidebar.php"; ?>

<div class="main-content">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Edit Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Edit Profile</li>
        </ol>
        <form action="profile_view.php" class="form-profile" method="POST" enctype="multipart/form-data">
            
            <!-- Nama -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required value="Mishbahus Surur">
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="Bangkalan" required>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="2004-05-30" required>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                    <input type="radio" name="gender" id="gender_l" class="form-check-input" value="L" checked>
                    <label for="gender_l" class="form-check-label">Laki - Laki</label>
                </div>
                <div class="form-check">    
                    <input type="radio" name="gender" id="gender_p" class="form-check-input" value="P">
                    <label for="gender_p" class="form-check-label">Perempuan</label>
                </div>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="no_telepone" class="form-label">No. Telepone</label>
                <input type="text" class="form-control" id="no_telepone" name="no_telepone" value="089680255502" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>Jl. Sakera Sepulu No 52. Bangkalan</textarea>
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
                <img src="../assets/img/login.jpeg" alt="gambaredit" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit">Simpan Perubahan</button>
        </form>
        <a href="profile_view" class="btn btn-danger bi bi-arrow-left-circle"> Kembali</a>
    </div>
</div>
<?php include "footer.php" ?>