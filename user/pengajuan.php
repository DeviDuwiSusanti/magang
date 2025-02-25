<?php
session_start();
include "functions.php"; 
include "../koneksi.php"; // Pastikan koneksi ke database

if (isset($_SESSION['email'])  && isset($_SESSION['id_user'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM tb_user 
            JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user 
            WHERE tb_user.email = '$email'";
    $hasil = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($hasil);
    $id_user = $row['id_user']; // Ambil id_user dari sesi login
    $level = $row['level'];
} else {
    echo "<script> window.location.href='../login.php' </script>";
    exit;
}

// Ambil data instansi yang memiliki kuota
$sql_instansi = "SELECT i.id_instansi, i.nama_panjang, SUM(b.kuota_bidang) AS total_kuota 
                 FROM tb_instansi i 
                 JOIN tb_bidang b ON i.id_instansi = b.id_instansi 
                 WHERE b.kuota_bidang > 0 
                 GROUP BY i.id_instansi, i.nama_panjang 
                 ORDER BY total_kuota DESC";
$result_instansi = mysqli_query($conn, $sql_instansi);

if (isset($_POST['pengajuan_pribadi']) || isset($_POST['pengajuan_kelompok'])) {
    $id_pengajuan = generateIdPengajuan($conn);
    $id_dokumen_ktp = generateIdDokumen($conn, $id_pengajuan);
    
    $id_instansi = $_POST['id_instansi'];
    $id_bidang = $_POST['id_bidang'];
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
            $id_user4 = generateIdUser4($conn, $id_user);

            $pendidikan = "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'";
            $result = mysqli_query($conn, $pendidikan);
            $id_pendidikan = mysqli_fetch_assoc($result)['id_pendidikan'];
        
            $sql_anggota1 = "INSERT INTO tb_profile_user (id_user, nama_user, nik_user, nisn, nim, id_pengajuan, id_pendidikan, create_by) VALUES ('$id_user4', '$nama', '$nik', '$nim', '$nim', '$id_pengajuan', '$id_pendidikan', '$id_user')";
            $query_anggota1 = mysqli_query($conn, $sql_anggota1);
            
            $sql_anggota2 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user4', '$email', 4, '$id_user')";
            $query_anggota2 = mysqli_query($conn, $sql_anggota2);
        }
    }

    $sql2 = "INSERT INTO tb_pengajuan VALUES ('$id_pengajuan', '$id_user', '$id_instansi', '$id_bidang', '$jenis_pengajuan', '$jumlah_pelamar', '$tanggal_mulai', '$tanggal_selesai', 'Menunggu', 'Y', '$id_user', NOW(), '', '')";
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


// Cek jika ada request AJAX dari JavaScript untuk mengambil bidang
if (isset($_POST["id_instansi"])) {
    header("Content-Type: text/html"); 
    echo getBidangByInstansi($_POST["id_instansi"]);
    exit;
}

// Cek jika ada request AJAX untuk mendapatkan detail bidang
if (isset($_POST["id_bidang"])) {
    header("Content-Type: application/json");
    $id_bidang = mysqli_real_escape_string($conn, $_POST["id_bidang"]); // Hindari SQL Injection
    echo json_encode(getDetailBidang($id_bidang, $conn));
    exit;
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengajuan</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/admin_instansi.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
    /* Layout utama untuk form dan detail lowongan */
    .form-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        transition: all 0.3s ease-in-out;
    }
    
    .form-container.shift-left {
        justify-content: flex-start;
    }

    .form-wrapper {
        width: 50%;
        transition: all 0.3s ease-in-out;
    }

    .detail-lowongan {
        width: 45%;
        margin-left: 20px;
        display: none;
    }
</style>

</head>
<body>

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


        <div class="form-container center-form" id="formContainer">
            <div class="form-wrapper" id="formWrapper">
            <form id="pengajuanForm" action="" class="form-profile" method="POST" enctype="multipart/form-data">
                <div id="step1">
                    <h4>Step 1: Daftar Pengajuan</h4>
                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi yang Dituju</label>
                        <select class="form-control" name="id_instansi" id="instansi" required>
                            <option value="" disabled selected> -- Pilih Instansi --</option>
                            <?php
                            if (mysqli_num_rows($result_instansi) > 0) {
                                while ($row = mysqli_fetch_assoc($result_instansi)) {
                                    echo '<option value="'.$row['id_instansi'].'">'.$row['nama_panjang'].' (Kuota: '.$row['total_kuota'].')</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bidang" class="form-label">Bidang yang Dipilih</label>
                        <select class="form-control" name="id_bidang" id="bidang" required>
                            <option value="" disabled selected> -- Pilih Bidang --</option>
                        </select>
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

            <!-- Card Detail Lowongan -->
            <div class="col-md-6" id="detailBidangContainer" style="display: none;">
                <div class="card" id="detailBidangCard">
                    <div class="card-body">
                        <h5 class="card-title" id="bidangNama"></h5>
                        <p><strong>Deskripsi:</strong></p>
                        <p id="bidangDeskripsi"></p>
                        <p><strong>Kriteria:</strong></p>
                        <p id="bidangKriteria"></p>
                        <p><strong>Dokumen Prasyarat:</strong></p>
                        <p id="bidangDokumen"></p>
                        <p><strong>Kuota:</strong> <span id="bidangKuota"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Ambil bidang saat instansi berubah
    $("#instansi").change(function() {
        var id_instansi = $(this).val();

        $.ajax({
            url: "pengajuan.php",
            type: "POST",
            data: { id_instansi: id_instansi },
            success: function(response) {
                $("#bidang").html('<option value="" disabled selected> -- Pilih Bidang --</option>' + response);
                $("#detailBidangContainer").hide(); // Sembunyikan detail bidang jika instansi berubah
                $("#formWrapper").removeClass("shift-left").addClass("center-form"); // Kembalikan posisi tengah
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    });

     // Ambil detail bidang saat bidang dipilih
     $("#bidang").change(function() {
        var id_bidang = $(this).val();

        $.ajax({
            url: "pengajuan.php",
            type: "POST",
            data: { id_bidang: id_bidang },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    $("#detailBidangContainer").hide();
                } else {
                    $("#bidangNama").text(response.nama_bidang);
                    $("#bidangDeskripsi").text(response.deskripsi_bidang);
                    $("#bidangKriteria").text(response.kriteria_bidang);
                    $("#bidangDokumen").text(response.dokumen_prasyarat);
                    $("#bidangKuota").text(response.kuota_bidang);
                    $("#detailBidangContainer").show();
                    
                    // Geser form ke kiri setelah bidang dipilih
                    $("#formWrapper").removeClass("center-form").addClass("shift-left");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    });

});
</script>

<!-- SCRIPT UNTUK RANGE TANGGAL -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let tanggalMulai = document.getElementById("tanggal_mulai");
        let tanggalSelesai = document.getElementById("tanggal_selesai");

        // Set minimum date untuk tanggal mulai (besok)
        let today = new Date();
        today.setDate(today.getDate() + 1);
        let minDateMulai = today.toISOString().split("T")[0];
        tanggalMulai.setAttribute("min", minDateMulai);

        // Set minimum date untuk tanggal selesai (harus lebih besar dari tanggal mulai)
        tanggalMulai.addEventListener("change", function () {
            let selectedMulai = new Date(this.value);
            selectedMulai.setDate(selectedMulai.getDate() + 1);
            let minDateSelesai = selectedMulai.toISOString().split("T")[0];
            tanggalSelesai.setAttribute("min", minDateSelesai);
        });
    });
</script>

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
