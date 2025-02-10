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

        <form id="pengajuanForm" action="update_profile.php" class="form-profile" method="POST" enctype="multipart/form-data">
            <!-- Dropdown Instansi -->
            <div class="mb-3">
                <label for="instansi" class="form-label">Instansi yang Dipilih</label>
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
                    <option value="Pengajuan 4">Pengajuan Lainnya</option>
                </select>
            </div>

            <!-- Jumlah Orang -->
            <div class="mb-3">
                <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                <input type="number" class="form-control" id="jumlah_orang" name="jumlah_orang" min="1" required>
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

            <!-- Upload CV -->
            <div class="mb-3">
                <label for="cv" class="form-label">Upload CV</label>
                <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                <small class="text-muted">Pilih file CV (PDF, DOC, DOCX)</small>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i>Kirim</button>
        </form>
    </div>
</div>

<script>
    // Event listener untuk form submit
    document.getElementById("pengajuanForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Mencegah form melakukan submit langsung

        // Tampilkan alert setelah klik kirim
        alert("Pendaftaran berhasil!");

        // Redirect ke halaman status_pengajuan.php
        window.location.href = "status_pengajuan.php";
    });
</script>