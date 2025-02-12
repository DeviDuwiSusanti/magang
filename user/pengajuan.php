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

            <!-- Daftar Anggota -->
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
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-floppy me-1"></i>Kirim
            </button>
        </form>
    </div>
</div>

<!-- Modal Sukses -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Pendaftaran Berhasil!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Pengajuan Anda telah berhasil dikirim. Silakan tunggu konfirmasi.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Gagal -->
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Pendaftaran Gagal!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Terjadi kesalahan, silakan coba lagi nanti.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("pengajuanForm").addEventListener("submit", function(event) {
        event.preventDefault();

        var isSuccess = Math.random() < 0.7; // 70% kemungkinan sukses

        if (isSuccess) {
            var successModal = new bootstrap.Modal(document.getElementById("successModal"));
            successModal.show();
        } else {
            var errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
            errorModal.show();
        }
    });

    document.getElementById("kelompok_pribadi").addEventListener("change", function() {
        var kelompok = this.value;
        document.getElementById("jumlahAnggota").style.display = kelompok === "Kelompok" ? "block" : "none";
        document.getElementById("daftarAnggota").style.display = kelompok === "Kelompok" ? "block" : "none";
    });
</script>
