<?php include "../layout/sidebarUser.php"; ?>

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
            <li class="breadcrumb-item active">Edit Profile User</li>
        </ol>
        <form action="update_profile.php" class="form-profile" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="Heviaa" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="Heviaa@gmail.com" required>
            </div>

            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="35224233465274" required>
            </div>

            <div class="mb-3">
                <label for="asal_studi" class="form-label">Asal Studi</label>
                <input type="text" class="form-control" id="asal_studi" name="asal_studi" value="Heviaa" required>
            </div>

            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="Bojonegoro" required>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="2005-08-01" required>
            </div>


            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3"  required>Ds.Rajawali, Kec.Kepoh, Kab.Ciamis</textarea>
            </div>

            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="number" class="form-control" id="telepon" name="telepon" value="082487234" required>
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" id="image" name="image" value="" accept="image/*">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit">Simpan Perubahan</button>
        </form>
    </div>
</div>