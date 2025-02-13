<?php include "../layout/header.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Pembimbing</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Kelola Data Pembimbing Bidang</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        <div class="mb-4 text-end">
            <a href="daftar_pembimbing.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>

        <form action="update_profile.php" class="form-profile" method="POST" enctype="multipart/form-data">
            <!-- Nama Pembimbing -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pembimbing</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama pembimbing" required>
            </div>

            <!-- Bidang -->
            <div class="mb-3">
                <label for="bidang" class="form-label">Pilih Bidang</label>
                <select id="bidang" class="form-select">
                    <option selected disabled>Pilih Bidang</option>
                    <option>Teknologi Informasi</option>
                    <option>Akuntansi</option>
                    <option>Manajemen</option>
                </select>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="gender_l" value="L">
                        <label class="form-check-label" for="gender_l">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="gender_p" value="P">
                        <label class="form-check-label" for="gender_p">Perempuan</label>
                    </div>
                </div>
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor telepon" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat pembimbing" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit" onclick="event.preventDefault(); alertEdit(this.href);"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>