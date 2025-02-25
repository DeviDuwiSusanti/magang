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

if (isset($_GET['id_pengajuan']) && isset($_GET['id_user'])) {
    $id_pengajuan = $_GET['id_pengajuan'];
    $id_user = $_GET['id_user'];

    // akses data pengajuan user
    $sql_pengajuan = "SELECT * FROM tb_profile_user pu, tb_instansi i, tb_bidang b, tb_pengajuan p WHERE pu.id_user = '$id_user' AND p.id_instansi = i.id_instansi AND p.id_bidang = b.id_bidang AND p.id_pengajuan = '$id_pengajuan'"; 
    $query_pengajuan = mysqli_query($conn, $sql_pengajuan);
    $pengajuan = mysqli_fetch_assoc($query_pengajuan);
    $jumlahAnggota = max(1, $pengajuan['jumlah_pelamar']); // Minimal 1 anggota

    $sql_dokumen = "SELECT file_path FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuan' ORDER BY id_dokumen ASC";
    $query_dokumen = mysqli_query($conn, $sql_dokumen);
    $daftar_dokumen = mysqli_fetch_all($query_dokumen, MYSQLI_ASSOC);

    // Ambil data anggota dari tb_profile_user dan tb_user berdasarkan id_pengajuan
    $query_anggota = "SELECT pu.nama_user, pu.nik_user, pu.nim, pu.nisn, u.email 
    FROM tb_profile_user pu 
    JOIN tb_user u ON pu.id_user = u.id_user 
    WHERE pu.id_pengajuan = '$id_pengajuan' 
    ORDER BY pu.id_user ASC";

    $result_anggota = mysqli_query($conn, $query_anggota);
    $anggotaData = mysqli_fetch_all($result_anggota, MYSQLI_ASSOC);
}
// Ambil data instansi yang memiliki kuota
$sql_instansi = "SELECT i.id_instansi, i.nama_panjang, SUM(b.kuota_bidang) AS total_kuota 
                 FROM tb_instansi i 
                 JOIN tb_bidang b ON i.id_instansi = b.id_instansi 
                 WHERE b.kuota_bidang > 0 
                 GROUP BY i.id_instansi, i.nama_panjang 
                 ORDER BY total_kuota DESC";
$result_instansi = mysqli_query($conn, $sql_instansi);

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
    <title>Edit Pengajuan</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <form id="pengajuanForm" action="pengajuan_update.php" class="form-profile" method="POST" enctype="multipart/form-data">
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
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= $pengajuan['tanggal_mulai'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= $pengajuan['tanggal_selesai'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="ktp" class="form-label">Upload KTP</label>
                        <input type="file" class="form-control" id="ktp" name="ktp" accept=".pdf">
                        <p>Dokumen saat ini: <a href="<?= ($daftar_dokumen[0]['file_path']) ?>" target="_blank">Lihat KTP</a></p>
                    </div>

                    <!-- Upload CV -->
                    <div class="mb-3">
                        <label for="cv" class="form-label">Upload CV</label>
                        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf" required>
                            <p>Dokumen saat ini: <a href="<?= ($daftar_dokumen[1]['file_path']) ?>" target="_blank">Lihat CV</a></p>
                    </div>

                        <button type="button" id="nextButton" class="btn btn-primary btn-sm" onclick="nextStep()">Next</button>
                </div>

                <!-- Step 2 -->
                <div id="step2" style="display: none;">
                    <h4>Step 2: Informasi Anggota (Kecuali Kamu)</h4>
                    <div class="mb-3">
                        <label for="jumlah_anggota" class="form-label">Jumlah Anggota (Termasuk Kamu)</label>
                        <input type="number"  class="form-control" id="jumlah_anggota" name="jumlah_anggota" value="<?= $pengajuan['jumlah_pelamar'] ?>" required>
                    </div>
                    <div id="anggotaContainer"></div>
                    <button type="button" id="addMemberButton" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1"><i class="bi bi-person-plus-fill"></i>Tambah Anggota</button>
                    <br><br>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="prevStep()">Back</button>
                    <button type="submit" name="update_pengajuan" class="btn btn-success btn-sm">Update</button>
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
document.addEventListener("DOMContentLoaded", function() {
    const jumlahAnggotaInput = document.getElementById("jumlah_anggota");
    const nextButton = document.getElementById("nextButton");
    const submitButton = document.getElementById("submitButton");
    const step1 = document.getElementById("step1");
    const step2 = document.getElementById("step2");
    const anggotaContainer = document.getElementById("anggotaContainer");
    const addMemberButton = document.getElementById("addMemberButton");

    let anggotaCount = <?= json_encode($jumlahAnggota) ?> - 1; 
    const anggotaData = <?= json_encode($anggotaData) ?>;

    nextButton.addEventListener("click", function() {
        nextStep();
    });

    function nextStep() {
        renderAnggota();
        step1.style.display = "none";
        step2.style.display = "block";
    }

    function prevStep() {
        step2.style.display = "none";
        step1.style.display = "block";
    }

    function renderAnggota() {
        anggotaContainer.innerHTML = ""; 
        for (let i = 1; i <= anggotaCount; i++) {
            const data = anggotaData[i] || {};
            const anggotaHTML = `
                <div class="mb-3 anggota-group" id="anggota-${i}">
                    <label class="form-label">Anggota ${i}</label>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" name="anggota_nama[]" placeholder="Nama" value="${data.nama_user || ''}" required>
                        </div>
                        <div class="col">
                            <input type="email" class="form-control" name="anggota_email[]" placeholder="Email" value="${data.email || ''}" required>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="anggota_nik[]" placeholder="NIK" value="${data.nik_user || ''}" required>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="anggota_nim[]" placeholder="NIM/NISN" value="${data.nim || ''}" required>
                        </div>
                         <div class="col-auto">
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmRemoveAnggota(${i})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            anggotaContainer.insertAdjacentHTML("beforeend", anggotaHTML);
        }
        jumlahAnggotaInput.value = anggotaCount + 1; 
    }

    addMemberButton.addEventListener("click", function() {
        anggotaCount++;
        renderAnggota();
    });

    window.confirmRemoveAnggota = function(index) {
        const anggotaElement = document.getElementById(`anggota-${index}`);
        const nama = anggotaElement.querySelector('input[name="anggota_nama[]"]').value;
        const email = anggotaElement.querySelector('input[name="anggota_email[]"]').value;
        const nik = anggotaElement.querySelector('input[name="anggota_nik[]"]').value;
        const nim = anggotaElement.querySelector('input[name="anggota_nim[]"]').value;

        if (nama || email || nik || nim) {
            const confirmation = confirm("Anggota ini memiliki data yang sudah diisi. Apakah Anda yakin ingin menghapusnya?");
            if (confirmation) {
                removeAnggota(index);
            }
        } else {
            removeAnggota(index);
        }
    };

    window.removeAnggota = function(index) {
        const anggotaElement = document.getElementById(`anggota-${index}`);
        if (anggotaElement) {
            anggotaElement.remove();
            anggotaCount--;
            renderAnggota();
        }
    };

    window.nextStep = nextStep;
    window.prevStep = prevStep;

    renderAnggota();
});

</script>



<script>
$(document).ready(function() {
    // Ambil bidang saat instansi berubah
    $("#instansi").change(function() {
        var id_instansi = $(this).val();

        $.ajax({
            url: "pengajuan_edit.php",
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
            url: "pengajuan_edit.php",
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

