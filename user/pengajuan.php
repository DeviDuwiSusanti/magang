<?php
session_start();
include "functions.php"; 
include "../koneksi.php"; // Pastikan koneksi ke database

if (isset($_SESSION['email'])  && isset($_SESSION['id_user'])) {
    $email = $_SESSION['email'];
    $id_user = $_SESSION['id_user']; // Ambil id_user dari sesi login?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (cekStatusUser($id_user) == 'Anggota'){
        showAlert('Peringatan!', 'Kamu Sudah Menjadi Anggota Yang Sudah Terdaftar.', 'warning', "../web/lowongan.php");
        exit();
    }else if (cekStatusUser($id_user) == 'Ketua' && $_SESSION['status_pengajuan'] == '1' || $_SESSION['status_pengajuan'] == '4'){
        showAlert('Peringatan!', 'Kamu Sudah Mengajukan Pengajuan Magang Atau Kamu Sudah Punya Kegiatan Magang Yang Masih Berlangsung.', 'warning', "../web/lowongan.php");
        exit();
    }
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

// ambil data pendaftar
$sql_pendaftar = "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_user = '$id_user' AND u.id_user = pu.id_user";
$query_pendaftar = mysqli_query($conn, $sql_pendaftar);
$pendaftar = mysqli_fetch_assoc($query_pendaftar);

// INSERT PENGAJUAN
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pengajuan_pribadi']) || isset($_POST['pengajuan_kelompok'])) {
        inputPengajuan($_POST, $_FILES, $id_user);
    }
}

if (ISSET($_POST['update_pengajuan'])){
    updatePengajuan($_POST, $_FILES, $id_user);
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script>
    $(function() {
        var dateFormat = "dd/mm/yy";
        var today = new Date();

        var from = $("#tanggal_mulai").datepicker({
            dateFormat: dateFormat,
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 4,
            minDate: today // Hanya izinkan tanggal mulai dari hari ini
        }).on("change", function() {
            // Reset tanggal selesai saat tanggal mulai diubah
            $("#tanggal_selesai").val("");
            to.datepicker("option", "minDate", getDate(this));
        });

        var to = $("#tanggal_selesai").datepicker({
            dateFormat: dateFormat,
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 4,
            minDate: today // Batas minimal tanggal selesai juga hari ini
        }).on("change", function() {
            from.datepicker("option", "maxDate", getDate(this));
        });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }
            return date;
        }
    });


    </script>
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

    /* Card styling for detail lowongan */
    #detailBidangCard {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background: #ffffff;
    }

    #detailBidangCard h5.card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }

    #detailBidangCard p {
        font-size: 1rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    #detailBidangCard strong {
        color: #000;
    }

    #bidangKuota {
        font-weight: bold;
        color: #28a745;
    }

    /* Tambahkan jarak saat card detail muncul */
    .form-container {
        display: flex;
        align-items: flex-start;
        gap: 30px; /* Jarak antar form dan card */
    }

    .detail-lowongan {
        display: none; /* Tersembunyi secara default */
    }

    .detail-lowongan.show {
        display: block;
    }
        /* Tambahkan border kotak pada card detail */
    #detailBidangCard {
        border: 2px solid #0d6efd; /* Biru */
        border-radius: 15px; /* Sudut membulat */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background: #ffffff;
    }

    </style>


</head>
<body>

<!-- =========== INPUT PENGAJUAN =============== -->
<?php 
if (!ISSET($_GET['id_pengajuanEdit'])){?>
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
            <form id="pengajuanForm" class="form-profile" method="POST" enctype="multipart/form-data">
                <div id="step1">
                    <h4>Step 1: Daftar Pengajuan</h4>
                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi yang Dituju</label>
                        <select class="form-control" name="id_instansi" id="instansi">
                            <option value="" disabled selected> -- Pilih Instansi --</option>
                            <?php
                            if (mysqli_num_rows($result_instansi) > 0) {
                                while ($row = mysqli_fetch_assoc($result_instansi)) {
                                    echo '<option value="'.$row['id_instansi'].'">'.$row['nama_panjang'].' (Kuota: '.$row['total_kuota'].')</option>';
                                }
                            }
                            ?>
                        </select>
                        <div id="error-instansi" class="text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label for="bidang" class="form-label">Bidang yang Dipilih</label>
                        <select class="form-control" name="id_bidang" id="bidang">
                            <option value="" disabled selected> -- Pilih Bidang --</option>
                        </select>
                        <div id="error-bidang" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                        <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan">
                            <option value="" disabled selected>Pilih Jenis Pengajuan</option>
                            <option value="magang">Magang</option>
                            <option value="kerja praktek">Kerja Praktek</option>
                            <option value="pkl">PKL</option>
                            <option value="penelitian">Penelitian</option>
                        </select>
                        <div id="error-jenis_pengajuan" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="kelompok_pribadi" class="form-label">Personil</label>
                        <select class="form-control" id="kelompok_pribadi" name="kelompok_pribadi">
                            <option value="" disabled selected>Pilih Personil</option>
                            <option value="Kelompok">Kelompok</option>
                            <option value="Pribadi">Pribadi</option>
                        </select>
                        <div id="error-kelompok_pribadi" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_anggota" class="form-label">Jumlah Anggota</label>
                        <input type="number"  class="form-control" id="jumlah_anggota" name="jumlah_anggota">
                        <div id="error-jumlah_anggota" class="invalid-feedback"></div>
                    </div>

                    <!-- Tanggal Mulai dan Selesai -->
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                        <div id="error-tanggal_mulai" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                        <div id="error-tanggal_selesai" class="invalid-feedback"></div>
                    </div>

                    <!-- Upload KTP -->
                    <div class="mb-3">
                        <label for="ktp" class="form-label">Upload KTP</label>
                        <input type="file" class="form-control" id="ktp" name="ktp" accept=".pdf">
                        <div id="error-ktp" class="invalid-feedback"></div>
                    </div>

                    <!-- Upload CV -->
                    <div class="mb-3">
                        <label for="cv" class="form-label">Upload CV</label>
                        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf">
                        <div id="error-cv" class="invalid-feedback"></div>
                    </div>

                    <button type="submit" id="submitButton" name="pengajuan_pribadi" class="btn btn-success btn-sm" style="display: inline-block;" onclick="validateForm(event)">Kirim</button>
                    <button type="button" id="nextButton" class="btn btn-primary btn-sm" onclick="nextStep(event)"  style="display: none;">Next</button>
                </div>

                <!-- Step 2 -->
                <div id="step2" style="display: none;">
                    <h4>Step 2: Informasi Anggota</h4><br><br>
                    <div id="ketuaContainer">
                        <!-- Anggota 1 (Readonly, diisi otomatis dari profil user) -->
                        <div class="mb-3 anggota-group d-flex align-items-center">
                            <span class="me-2 fw-bold">1.</span>
                            <div class="row flex-grow-1 gx-2">
                                <div class="col">
                                    <input type="text" class="form-control" value="<?= $pendaftar['nama_user'] ?>" readonly>
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control" value="<?= $pendaftar['email'] ?>" readonly>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" value="<?= $pendaftar['nik'] ?>" readonly>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" value="<?= !empty($pendaftar['nim']) ? $pendaftar['nim'] : $pendaftar['nisn'] ?>"  readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Placeholder untuk anggota tambahan -->
                    <div id="anggotaContainer"></div>
                    
                    <button type="button" class="btn btn-secondary btn-sm" onclick="prevStep()">Back</button>
                    <button type="submit" name="pengajuan_kelompok" onclick="validateForm(event)" class="btn btn-success btn-sm">Kirim</button>
                </div>
            </form>
        </div>
<?php
}
?>

<!-- ============= UPDATE PENGAJUAN =========== -->
<?php
if (ISSET($_GET['id_pengajuanEdit'])){
    $id_pengajuanEdit  = $_GET['id_pengajuanEdit'];
    // akses data pengajuan user
    $sql_pengajuan = "SELECT * FROM tb_pengajuan p, tb_bidang b, tb_instansi i WHERE p.id_pengajuan = '$id_pengajuanEdit' AND p.id_bidang = b.id_bidang AND p.id_instansi = i.id_instansi;"; 
    $query_pengajuan = mysqli_query($conn, $sql_pengajuan);
    $pengajuan = mysqli_fetch_assoc($query_pengajuan);

    $sql_dokumen = "SELECT file_path FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuanEdit' ORDER BY id_dokumen ASC";
    $query_dokumen = mysqli_query($conn, $sql_dokumen);
    $daftar_dokumen = mysqli_fetch_all($query_dokumen, MYSQLI_ASSOC);
?>
<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Pengajuan</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Edit Informasi Pengajuan</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        <div class="mb-4 text-end">
            <a href="status_pengajuan.php" class="btn btn-danger btn-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>


        <div class="form-container center-form" id="formContainer">
            <div class="form-wrapper" id="formWrapper">
            <form id="pengajuanForm" action="" class="form-profile" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="id_pengajuan" value="<?= $pengajuan['id_pengajuan'] ?>">
                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                
                <div id="step1">
                    <h4>Step 1: Daftar Pengajuan</h4>
                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi yang Dituju</label>
                        <select class="form-control" name="id_instansi" id="instansi" required>
                            <option value="<?= $pengajuan['id_instansi'] ?>"><?= $pengajuan['nama_panjang'] ?></option>
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
                            <option value="<?= $pengajuan['id_bidang'] ?>"><?= $pengajuan['nama_bidang'] ?></option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                        <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan" required>
                            <option value="<?= $pengajuan['jenis_pengajuan'] ?>"><?= $pengajuan['jenis_pengajuan'] ?></option>
                            <option value="magang">Magang</option>
                            <option value="kerja praktek">Kerja Praktek</option>
                            <option value="pkl">PKL</option>
                            <option value="penelitian">Penelitian</option>
                        </select>
                    </div>
                    <!-- Tanggal Mulai dan Selesai -->
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= !empty($pengajuan['tanggal_mulai']) ? date('d/m/Y', strtotime($pengajuan['tanggal_mulai'])) : '' ?>">
                        <small class="text-danger error-message" id="error_tanggal_mulai"></small>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= !empty($pengajuan['tanggal_selesai']) ? date('d/m/Y', strtotime($pengajuan['tanggal_selesai'])) : '' ?>">
                        <small class="text-danger error-message" id="error_tanggal_selesai"></small>
                    </div>

                    <div class="mb-3">
                        <label for="ktp" class="form-label">Upload KTP</label>
                        <input type="file" class="form-control" id="ktp" name="ktp" accept=".pdf">
                        <p>Dokumen saat ini: <a href="<?= ($daftar_dokumen[0]['file_path']) ?>" target="_blank">Lihat KTP</a></p>
                        <small class="text-danger error-message" id="error_ktp"></small>
                    </div>

                    <!-- Upload CV -->
                    <div class="mb-3">
                        <label for="cv" class="form-label">Upload CV</label>
                        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf">
                        <p>Dokumen saat ini: <a href="<?= ($daftar_dokumen[1]['file_path']) ?>" target="_blank">Lihat CV</a></p>
                        <small class="text-danger error-message" id="error_cv"></small>
                    </div>

                    <button type="submit" name="update_pengajuan" class="btn btn-success btn-sm">Update</button>
                </div>
            </form>
        </div>
<?php
}
?>

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

<!-- MENGAMBIL DETAIL BIDANG ATAU LOWONGAN  -->
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

<!-- SCRIPT UNTUK VALIDASI FORM -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // mengambil elemen-elemen form yang diperlukan
    const kelompokPribadi = document.getElementById("kelompok_pribadi");
    const jumlahAnggotaInput = document.getElementById("jumlah_anggota"); // Container jumlah anggota
    const jumlahAnggotaContainer = jumlahAnggotaInput.closest(".mb-3");
    const nextButton = document.getElementById("nextButton");
    const submitButton = document.getElementById("submitButton");
    const step1 = document.getElementById("step1");
    const step2 = document.getElementById("step2");
    const anggotaContainer = document.getElementById("anggotaContainer");
    const form = document.getElementById("pengajuanForm");
    const bidang = document.getElementById("bidang");
    let maxKuota = 0; // Untuk menyimpan kuota maksimal bidang yang dipilih

    // Sembunyikan jumlah anggota & step2 di awal
    jumlahAnggotaContainer.style.display = "none";
    step2.style.display = "none";

    // Event listener untuk mengatur visibilitas jumlah anggota berdasarkan pilihan 'Kelompok' atau 'Pribadi'
    kelompokPribadi.addEventListener("change", function() {
        if (this.value === "Kelompok") {
            jumlahAnggotaContainer.style.display = "block";
            nextButton.style.display = "inline-block";
            submitButton.style.display = "none";
        } else { // Untuk pilihan 'Pribadi'
            jumlahAnggotaContainer.style.display = "none";
            step2.style.display = "none";
            nextButton.style.display = "none";
            submitButton.style.display = "inline-block";
        }
    });

    // Mengambil kuota maksimal berdasarkan bidang yang dipilih
    bidang.addEventListener("change", function() {
                maxKuota = parseInt(this.options[this.selectedIndex].getAttribute("data-kuota")) || 0;
            });

    // Menampilkan pesan error
    function showError(input, message) {
        let existingError = input.parentNode.querySelector(".error-message");
        if (existingError) {
            existingError.remove();
        }
        const error = document.createElement("small");
        error.classList.add("error-message");
        error.style.color = "red";
        error.textContent = message;
        input.parentNode.appendChild(error);
    }

    // Menghapus pesan error
    function clearError(input) {
        const error = input.parentNode.querySelector(".error-message");
        if (error) {
            error.remove();
        }
    }

    // Validasi step 1
    function validateStep1() {
        let isValid = true;
        const fields = [
            { id: "instansi", message: "Pilih instansi yang dituju!" },
            { id: "bidang", message: "Pilih bidang yang dipilih!" },
            { id: "jenis_pengajuan", message: "Pilih jenis pengajuan!" },
            { id: "kelompok_pribadi", message: "Pilih personil!" },
            { id: "tanggal_mulai", message: "Pilih tanggal mulai!" },
            { id: "tanggal_selesai", message: "Pilih tanggal selesai!" }
        ];

         // Validasi untuk setiap field yang wajib diisi
        fields.forEach(field => {
            const inputElement = document.getElementById(field.id);
            if (!inputElement.value.trim()) {
                showError(inputElement, field.message);
                isValid = false;
            } else {
                clearError(inputElement);
            }
        });

        // Validasi jumlah anggota untuk kelompok
        const jumlahAnggota = parseInt(jumlahAnggotaInput.value) || 0;
                
        if (kelompokPribadi.value === "Kelompok") {
            if (jumlahAnggota < 2) {
                showError(jumlahAnggotaInput, "Jika memilih Kelompok, jumlah anggota harus minimal 2!");
                isValid = false;
            } else if (jumlahAnggota > maxKuota) {
                showError(jumlahAnggotaInput, "Jumlah anggota melebihi kuota bidang!");
                isValid = false;
            } else {
                clearError(jumlahAnggotaInput);
            }
        } else {
            clearError(jumlahAnggotaInput);
        }

        // Validasi file (KTP dan CV) serta tanggal mulai & selesai
        const otherFields = [
            { id: "ktp", message: "Upload KTP dalam format PDF!" },
            { id: "cv", message: "Upload CV dalam format PDF!" }
        ];

        const maxFileSize = 1 * 1024 * 1024; // 1 MB dalam bytes

        otherFields.forEach(field => {
            const inputElement = document.getElementById(field.id);
            const file = inputElement.files ? inputElement.files[0] : null;

            if (!inputElement.value) {
                showError(inputElement, field.message);
                isValid = false;
            } else if ((field.id === "ktp" || field.id === "cv") && file && file.size > maxFileSize) {
                showError(inputElement, `${field.id.toUpperCase()} tidak boleh lebih dari 1 MB!`);
                isValid = false;
            } else {
                clearError(inputElement);
            }
        });

    return isValid && validateAnggota();

    }

    // Validasi email anggota melalui AJAX
    async function checkEmail(emailInput) {
        const email = emailInput.value.trim();
        if (email === "") return;

        try {
            const response = await fetch("cek.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `email=${email}`
            });
            const result = await response.text();
            if (result === "exists") {
                showError(emailInput, "Email sudah digunakan!");
                return false;
            } else {
                clearError(emailInput);
                return true;
            }
        } catch (error) {
            console.error("Error checking email:", error);
        }
    }

    async function validateAnggota() {
        let isValid = true;
        const emails = new Set();
        const anggotaInputs = document.querySelectorAll('#anggotaContainer .anggota-group');
        const nameRegex = /^[A-Za-z\s]+$/;

        // Kumpulkan semua promise untuk checkEmail
        const emailChecks = [];

        anggotaInputs.forEach((anggota) => {
            const nama = anggota.querySelector("input[name='anggota_nama[]']");
            const email = anggota.querySelector("input[name='anggota_email[]']");
            const nik = anggota.querySelector("input[name='anggota_nik[]']");
            const nim = anggota.querySelector("input[name='anggota_nim[]']");

            if (!nama.value.trim()) {
                showError(nama, "Nama harus diisi!");
                isValid = false;
            } else if (!nameRegex.test(nama.value.trim())) {
                showError(nama, "Nama hanya boleh mengandung huruf!");
                isValid = false;
            } else {
                clearError(nama);
            }

            if (!email.value.trim()) {
                showError(email, "Email anggota harus diisi!");
                isValid = false;
            } else if (emails.has(email.value)) {
                showError(email, "Email anggota sudah digunakan!");
                isValid = false;
            } else {
                emails.add(email.value);
                emailChecks.push(checkEmail(email));
            }

            if (!nik.value.trim()) {
                showError(nik, "NIK wajib diisi!");
                isValid = false;
            } else if (nik.value.length !== 16 || !/^\d+$/.test(nik.value)) {
                showError(nik, "NIK harus terdiri dari 16 digit angka!");
                isValid = false;
            } else {
                clearError(nik);
            }

            if (!nim.value.trim()) {
                showError(nim, "NIM/NISN wajib diisi!");
                isValid = false;
            } else if (!(nim.value.length === 10 || nim.value.length === 12) || !/^\d+$/.test(nim.value)) {
                showError(nim, "NIM harus 12 digit dan NISN harus 10 digit!");
                isValid = false;
            } else {
                clearError(nim);
            }

        });

        // Tunggu semua cek email selesai
        const emailResults = await Promise.all(emailChecks);
        if (emailResults.includes(false)) {
            isValid = false;
        }

        return isValid;
    }

    // Fungsi untuk navigasi ke step berikutnya
    function nextStep(event) {
        event.preventDefault();
        if (!validateStep1()) return;

        const jumlahAnggota = parseInt(jumlahAnggotaInput.value) || 0;
        const anggotaContainer = document.getElementById('anggotaContainer');
        anggotaContainer.innerHTML = "";

        for (let i = 1; i < jumlahAnggota; i++) {
            const anggotaHTML = `
                <div class="mb-3 anggota-group d-flex align-items-center">
            <span class="me-2 fw-bold">${i + 1}.</span>
            <div class="row flex-grow-1 gx-2">
                        <div class="col"><input type="text" class="form-control" name="anggota_nama[]" placeholder="Nama"></div>
                        <div class="col"><input type="email" class="form-control" name="anggota_email[]" placeholder="Email" onblur="checkEmail(this)"></div>
                        <div class="col"><input type="number" class="form-control" name="anggota_nik[]" placeholder="NIK"></div>
                        <div class="col"><input type="number" class="form-control" name="anggota_nim[]" placeholder="NIM/NISN"></div>
                    </div>
                </div>`;
            anggotaContainer.insertAdjacentHTML("beforeend", anggotaHTML);
        }

        step1.style.display = "none";
        step2.style.display = "block";
        nextButton.style.display = "none";
        submitButton.style.display = "inline-block";
    }

    function prevStep() {
        step2.style.display = "none";
        step1.style.display = "block";
        nextButton.style.display = "inline-block";
        submitButton.style.display = "none";
    }

    form.addEventListener("submit", async function(event) {
        const step1Valid = validateStep1();
        const anggotaValid = await validateAnggota();

        if (!step1Valid || !anggotaValid) {
            // Trigger submit form alami agar tombol terdeteksi di PHP
            event.preventDefault(); // cegah submit langsung
        }
    });

    window.nextStep = nextStep;
    window.prevStep = prevStep;
    window.checkEmail = checkEmail;
});

</script>