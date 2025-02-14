<?php include "../layout/sidebarUser.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Tambah Pengajuan</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Tambah Pengajuan Baru</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        <div class="mb-4 text-end">
            <a href="status_pengajuan.php" class="btn btn-danger btn-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>

        <form id="pengajuanForm" action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <!-- Step 1 -->
            <div id="step1">
                <h4>Step 1: Informasi Anggota</h4>
                <div class="mb-3">
                    <label for="instansi" class="form-label">Instansi yang Dituju</label>
                    <select class="form-control" id="instansi" name="instansi" required>
                        <option value="" disabled selected>Pilih Instansi</option>
                        <option value="Instansi 1">Dinas Komunikasi dan Informatika Kab Sidoarjo</option>
                        <option value="Instansi 2">Telekomunikasi Indonesia</option>
                        <option value="Instansi 3">Kimia Farma</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="jenis_bidang" class="form-label">Bidang yang Dipilih</label>
                    <select class="form-control" id="jenis_bidang" name="jenis_bidang" required>
                        <option value="" disabled selected>Pilih Bidang</option>
                        <option value="Pengajuan 1">Web Developer</option>
                        <option value="Pengajuan 2">UI/UX</option>
                        <option value="Pengajuan 3">Admin</option>
                    </select>
                </div>

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

                <div class="mb-3">
                    <label for="kelompok_pribadi" class="form-label">Personil</label>
                    <select class="form-control" id="kelompok_pribadi" name="kelompok_pribadi" required>
                        <option value="" disabled selected>Pilih Personil</option>
                        <option value="Kelompok">Kelompok</option>
                        <option value="Pribadi">Pribadi</option>
                    </select>
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
                </div>

                <!-- Upload CV -->
                <div class="mb-3">
                    <label for="cv" class="form-label">Upload CV</label>
                    <input type="file" class="form-control" id="cv" name="cv" accept=".pdf" required>
                </div>

                <button type="button" id="nextButton" class="btn btn-primary btn-sm" onclick="nextStep()">Next</button>
                <button type="submit" id="submitButton" class="btn btn-success btn-sm" style="display: none;">Kirim</button>
            </div>

           <!-- Step 2 -->
            <div id="step2" style="display: none;">
                <h4>Step 2: Informasi Anggota</h4>
                <div id="anggotaContainer">
                    <div class="mb-3 anggota-group">
                        <label class="form-label">Anggota 1</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="anggota_nama[]" placeholder="Nama" required>
                            </div>
                            <div class="col">
                                <input type="email" class="form-control" name="anggota_email[]" placeholder="Email" required>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="anggota_nik[]" placeholder="NIK" required>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="anggota_nim[]" placeholder="NIM/NISN" required>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" onclick="tambahAnggota()">
                    <i class="bi bi-person-plus-fill"></i> Tambah Anggota
                </button><br><br>
                <button type="button" class="btn btn-secondary btn-sm" onclick="prevStep()">Back</button>
                <button type="submit" class="btn btn-success btn-sm">Kirim</button>
            </div>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const kelompokPribadi = document.getElementById("kelompok_pribadi");
        const nextButton = document.getElementById("nextButton");
        const submitButton = document.getElementById("submitButton");
        const step2 = document.getElementById("step2");

        kelompokPribadi.addEventListener("change", function() {
            if (this.value === "Kelompok") {
                nextButton.style.display = "inline-block";
                submitButton.style.display = "none";
            } else {
                nextButton.style.display = "none";
                submitButton.style.display = "inline-block";
                step2.style.display = "none"; // Sembunyikan Step 2 jika pilih Pribadi
            }
        });
    });

    function nextStep() {
        document.getElementById("step1").style.display = "none";
        document.getElementById("step2").style.display = "block";
    }

    function prevStep() {
        document.getElementById("step2").style.display = "none";
        document.getElementById("step1").style.display = "block";
    }

    function tambahAnggota() {
        var anggotaContainer = document.getElementById('anggotaContainer');
        var newAnggota = document.createElement('div');
        newAnggota.classList.add('mb-3', 'anggota-group');
        newAnggota.innerHTML = `
            <label class="form-label">Anggota ${anggotaContainer.children.length + 1}</label>
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="anggota_nama[]" placeholder="Nama" required>
                </div>
                <div class="col">
                    <input type="email" class="form-control" name="anggota_email[]" placeholder="Email" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="anggota_nik[]" placeholder="NIK" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="anggota_nim[]" placeholder="NIM/NISN" required>
                </div>
            </div>
        `;
        anggotaContainer.appendChild(newAnggota);
    }
</script>
