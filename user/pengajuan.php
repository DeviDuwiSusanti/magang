<?php 
include "../layout/sidebarUser.php";
include "functions.php"; 

if (isset($_GET['id_bidang'])) {
    $id_bidang = $_GET['id_bidang'];

    // Mengambil informasi bidang berdasarkan id_bidang
    $sql = "SELECT * FROM tb_bidang, tb_instansi WHERE tb_bidang.id_bidang = '$id_bidang' AND tb_bidang.id_instansi = tb_instansi.id_instansi";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
}

if (isset($_POST['pengajuan_pribadi']) || isset($_POST['pengajuan_kelompok'])) {
    $id_pengajuan = generateIdPengajuan($conn);
    $id_dokumen_ktp = generateIdDokumen($conn, $id_pengajuan);
    
    $instansi = $_POST['instansi'];
    $bidang = $_POST['bidang'];
    $jenis_pengajuan = $_POST['jenis_pengajuan'];
    $jumlah_pelamar = $_POST['jumlah_anggota'];
    if ($jumlah_pelamar == NULL){
        $jumlah_pelamar = 1;
    }
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    // Menangani upload file KTP dan CV
    $ktp = uploadFile($_FILES['ktp']);
    $cv = uploadFile($_FILES['cv']);

    if (ISSET($_POST['anggota_nama'])){
         // Mengambil data anggota dari form Step 2
        $anggota_nama = $_POST['anggota_nama'];
        $anggota_email = $_POST['anggota_email'];
        $anggota_nik = $_POST['anggota_nik'];
        $anggota_nim = $_POST['anggota_nim'];

        foreach ($anggota_nama as $index => $nama) {
            $email = $anggota_email[$index];
            $nik = $anggota_nik[$index];
            $nim = $anggota_nim[$index];
            $id_user4 = generateIdUser($conn);
        
            $sql_anggota1 = "INSERT INTO tb_profile_user (id_user, nama_user, nik_user, nisn, nim, id_pengajuan, create_by) VALUES ('$id_user4', '$nama', '$nik', '$nim', '$nim', '$id_pengajuan', '$id_user')";
            $query_anggota1 = mysqli_query($conn, $sql_anggota1);
            
            $sql_anggota2 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user4', '$email', 4, '$id_user')";
            $query_anggota2 = mysqli_query($conn, $sql_anggota2);
        }
    }

    $sql2 = "INSERT INTO tb_pengajuan VALUES ('$id_pengajuan', '$id_user', '$instansi', '$bidang', '$jenis_pengajuan', '$jumlah_pelamar', '$tanggal_mulai', '$tanggal_selesai', 'menunggu', 'Y', '$id_user', NOW(), '', '')";
    $query2 = mysqli_query($conn, $sql2);

    $sql3 = "INSERT INTO tb_dokumen VALUES ('$id_dokumen_ktp', '$ktp[name]', 'identitas', '$ktp[path]', '$id_pengajuan', '$id_user', 'Y', '$id_user', NOW(), '', '')";
    $query3 = mysqli_query($conn, $sql3);
    

    if ($query2 && $query3){
        $id_dokumen_cv = generateIdDokumen($conn, $id_pengajuan);
        $sql4 = "INSERT INTO tb_dokumen VALUES ('$id_dokumen_cv', '$cv[name]', 'identitas', '$cv[path]', '$id_pengajuan', '$id_user', 'Y', '$id_user', NOW(), '', '')";
        $query4 = mysqli_query($conn, $sql4);

        $sql5 = "UPDATE tb_profile_user SET id_pengajuan = '$id_pengajuan' WHERE id_user = '$id_user'";
        $query5 = mysqli_query($conn, $sql5);

        if ($query4){
            echo "<script>
            alert('Yeayy, Pendaftaran Kamu Berhasil');
            window.location.href='status_pengajuan.php';
            </script>";
        }
    }
}

?>

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
                <h4>Step 1: Daftar Pengajuan</h4>
                <div class="mb-3">
                    <label for="instansi" class="form-label">Instansi yang Dituju</label>
                    <input type="text" class="form-control" id="instansi" value="<?= $row['nama_panjang'] ?>" readonly>
                     <!-- Input hidden untuk mengirimkan id_bidang ke server -->
                    <input type="hidden" name="instansi" value="<?= $row['id_instansi'] ?>">
                </div>
                
                <div class="mb-3">
                    <label for="jenis_bidang" class="form-label">Bidang yang Dipilih</label>
                    <input type="text" class="form-control" id="bidang" value="<?= $row['nama_bidang'] ?>" readonly>
                     <!-- Input hidden untuk mengirimkan id_bidang ke server -->
                    <input type="hidden" name="bidang" value="<?= $row['id_bidang'] ?>">
                </div>

                <div class="mb-3">
                    <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                    <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan" required>
                        <option value="" disabled selected>Pilih Jenis Pengajuan</option>
                        <option value="magang">Magang</option>
                        <option value="kerja praktek">Kerja Praktek</option>
                        <option value="pkl">PKL</option>
                        <option value="penelitian">Penelitian</option>
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

                <div class="mb-3">
                    <label for="jumlah_anggota" class="form-label">Jumlah Anggota (Termasuk Kamu)</label>
                    <input type="number"  class="form-control" id="jumlah_anggota" name="jumlah_anggota" required>
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
                <button type="submit" id="submitButton" name="pengajuan_pribadi" class="btn btn-success btn-sm" style="display: none;">Kirim</button>
            </div>

            <!-- Step 2 -->
            <div id="step2" style="display: none;">
                <h4>Step 2: Informasi Anggota (Kecuali Kamu)</h4>
                <div id="anggotaContainer"></div>
                
                <button type="button" class="btn btn-secondary btn-sm" onclick="prevStep()">Back</button>
                <button type="submit" name="pengajuan_kelompok" class="btn btn-success btn-sm">Kirim</button>
            </div>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const kelompokPribadi = document.getElementById("kelompok_pribadi");
        const jumlahAnggotaInput = document.getElementById("jumlah_anggota");
        const jumlahAnggotaContainer = jumlahAnggotaInput.closest(".mb-3");
        const nextButton = document.getElementById("nextButton");
        const submitButton = document.getElementById("submitButton");
        const step1 = document.getElementById("step1");
        const step2 = document.getElementById("step2");
        const anggotaContainer = document.getElementById("anggotaContainer");

        // Sembunyikan jumlah anggota & Step 2 di awal
        jumlahAnggotaContainer.style.display = "none";
        step2.style.display = "none";

        kelompokPribadi.addEventListener("change", function() {
            if (this.value === "Kelompok") {
                jumlahAnggotaContainer.style.display = "block"; // Tampilkan input jumlah anggota
                nextButton.style.display = "inline-block"; // Tampilkan tombol Next
                submitButton.style.display = "none"; // Sembunyikan tombol Kirim
                jumlahAnggotaInput.required = true; 
            } else {
                jumlahAnggotaContainer.style.display = "none"; // Sembunyikan input jumlah anggota
                step2.style.display = "none"; // Sembunyikan Step 2
                nextButton.style.display = "none"; // Sembunyikan tombol Next
                submitButton.style.display = "inline-block"; // Tampilkan tombol Kirim
                jumlahAnggotaInput.required = false; 
            }
        });

        function nextStep() {
            const jumlahAnggota = parseInt(jumlahAnggotaInput.value) || 0;
            anggotaContainer.innerHTML = ""; // Bersihkan isi sebelumnya

            if (jumlahAnggota > 1) {
                for (let i = 1; i < jumlahAnggota; i++) { // Dimulai dari 1 agar pendaftar utama tidak dihitung
                    const anggotaHTML = `
                        <div class="mb-3 anggota-group">
                            <label class="form-label">Anggota ${i}</label>
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
                    `;
                    anggotaContainer.insertAdjacentHTML("beforeend", anggotaHTML);
                }
            }

            step1.style.display = "none"; // Sembunyikan Step 1
            step2.style.display = "block"; // Tampilkan Step 2
        }

        function prevStep() {
            step2.style.display = "none";
            step1.style.display = "block";
        }

        window.nextStep = nextStep;
        window.prevStep = prevStep;
    });
</script>
