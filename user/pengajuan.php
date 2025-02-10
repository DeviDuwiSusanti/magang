<?php include "../layout/sidebarUser.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Tambah Pengajuan</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Tambah Pengajuan Baru</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        <div class="mb-4 text-end">
            <a href="status_pengajuan.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>

        <form id="pengajuanForm" action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <!-- Dropdown Instansi -->
            <div class="mb-3">
                <label for="instansi" class="form-label">Instansi yang Dituju</label>
                <select class="form-control" id="instansi" name="instansi" required>
                    <option value="" disabled selected>Pilih Instansi</option>
                    <option value="Instansi 1">Dinas Komunikasi dan Informatika Kab Sidoarjo</option>
                    <option value="Instansi 2">Telekomunikasi Indonesia</option>
                    <option value="Instansi 3">Kimia Farma</option>
                </select>
            </div>
            
            <!-- Dropdown Bidang -->
            <div class="mb-3">
                <label for="jenis_bidang" class="form-label">Bidang yang Dipilih</label>
                <select class="form-control" id="jenis_bidang" name="jenis_bidang" required>
                    <option value="" disabled selected>Pilih Bidang</option>
                    <option value="Pengajuan 1">Web Developer</option>
                    <option value="Pengajuan 2">UI/UX</option>
                    <option value="Pengajuan 3">Admin</option>
                </select>
            </div>

            <!-- Dropdown Jenis Pengajuan -->
            <div class="mb-3">
                <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan" required>
                    <option value="" disabled selected>Pilih Jenis Pengajuan</option>
                    <option value="Pengajuan 1">Magang</option>
                    <option value="Pengajuan 2">Kerja Praktek</option>
                    <option value="Pengajuan 3">PKL</option>
                    <option value="Pengajuan 4">Penelitian</option>
                </select>
            </div>

            <!-- Dropdown Kelompok/Pribadi -->
            <div class="mb-3">
                <label for="kelompok_pribadi" class="form-label">Personil</label>
                <select class="form-control" id="kelompok_pribadi" name="kelompok_pribadi" required>
                    <option value="" disabled selected>Pilih Personil</option>
                    <option value="Kelompok">Kelompok</option>
                    <option value="Pribadi">Pribadi</option>
                </select>
            </div>

            <!-- Jumlah Orang (Disembunyikan saat "Pribadi" dipilih) -->
            <div class="mb-3" id="jumlahAnggota" style="display: none;">
                <label for="jumlah_orang" class="form-label">Jumlah Anggota</label>
                <input type="number" class="form-control" id="jumlah_orang" name="jumlah_orang" min="1">
            </div>

            <!-- Daftar Anggota (Disembunyikan saat "Pribadi" dipilih) -->
            <div class="mb-3" id="daftarAnggota" style="display: none;">
                <label for="daftar_anggota" class="form-label">Daftar Anggota</label>
                <textarea class="form-control" id="daftar_anggota" name="daftar_anggota" rows="3"></textarea>
                <small class="text-muted">Masukkan nama anggota (pisahkan dengan koma jika lebih dari satu)</small>
            </div>

            <!-- Tanggal Mulai dan Selesai -->
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
            </div>

            <!-- Upload KTP -->
            <div class="mb-3">
                <label for="ktp" class="form-label">Upload KTP</label>
                <input type="file" class="form-control" id="ktp" name="ktp" accept=".pdf" required>
                <small class="text-muted">Upload semua KTP terdaftar jadikan 1 file PDF</small>
            </div>

            <!-- Upload CV -->
            <div class="mb-3">
                <label for="cv" class="form-label">Upload CV</label>
                <input type="file" class="form-control" id="cv" name="cv" accept=".pdf" required>
                <small class="text-muted">Pilih file CV (PDF)</small>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i>Kirim</button>
        </form>
    </div>
</div>

<script>
    // Function to toggle the visibility of fields based on the "Personil" selection
    document.getElementById("kelompok_pribadi").addEventListener("change", function() {
        var kelompok = document.getElementById("kelompok_pribadi").value;
        var jumlahAnggota = document.getElementById("jumlahAnggota");
        var daftarAnggota = document.getElementById("daftarAnggota");

        if (kelompok === "Kelompok") {
            // Show fields for group members
            jumlahAnggota.style.display = "block";
            daftarAnggota.style.display = "block";
        } else {
            // Hide fields for group members
            jumlahAnggota.style.display = "none";
            daftarAnggota.style.display = "none";
        }
    });
</script>
