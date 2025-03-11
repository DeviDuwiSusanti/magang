<?php
session_start();
include "functions.php"; 
include "../koneksi.php"; 


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM tb_user u, tb_profile_user pu WHERE u.email = '$email' AND u.id_user = pu.id_user";

    $hasil = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($hasil);
    $_SESSION['id_user'] = $row['id_user']; // Ambil id_user dari sesi login
    $_SESSION['level'] = $row['level'];

    $id_user = $_SESSION['id_user'];
    $level = $_SESSION['level'];

    $id_pengajuan = null; // Inisialisasi default

    if ($row && !empty($row['id_pengajuan'])) {
        $_SESSION['id_pengajuan'] = $row['id_pengajuan'];
        $id_pengajuan = $_SESSION['id_pengajuan'];
        $sql2 = "SELECT * FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
    }

} else{
    echo "<script> window.location.href='../login.php' </script>";
    exit;
}


if (isset($_SESSION['id_pengajuan']) && isset($_SESSION['id_user'])) {
    $id_pengajuan = $_SESSION['id_pengajuan'];
    $id_user = $_SESSION['id_user'];

    // akses data pengajuan user
    $sql_pengajuan = "SELECT * FROM tb_pengajuan p, tb_bidang b, tb_instansi i WHERE p.id_pengajuan = '$id_pengajuan' AND p.id_bidang = b.id_bidang AND p.id_instansi = i.id_instansi;"; 
    $query_pengajuan = mysqli_query($conn, $sql_pengajuan);
    $pengajuan = mysqli_fetch_assoc($query_pengajuan);

    $sql_dokumen = "SELECT file_path FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuan' ORDER BY id_dokumen ASC";
    $query_dokumen = mysqli_query($conn, $sql_dokumen);
    $daftar_dokumen = mysqli_fetch_all($query_dokumen, MYSQLI_ASSOC);

    // Ambil data instansi yang memiliki kuota
    $sql_instansi = "SELECT i.id_instansi, i.nama_panjang, SUM(b.kuota_bidang) AS total_kuota 
    FROM tb_instansi i 
    JOIN tb_bidang b ON i.id_instansi = b.id_instansi 
    WHERE b.kuota_bidang > 0 
    GROUP BY i.id_instansi, i.nama_panjang 
    ORDER BY total_kuota DESC";
    $result_instansi = mysqli_query($conn, $sql_instansi);
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
            <form id="pengajuanForm" action="pengajuan_update.php" class="form-profile" method="POST" enctype="multipart/form-data" novalidate>
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
                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= $pengajuan['tanggal_mulai'] ?>">
                        <small class="text-danger error-message" id="error_tanggal_mulai"></small>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= $pengajuan['tanggal_selesai'] ?>">
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
<?php include "../layout/footerDashboard.php"; ?>
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

<!-- ======= VALIDASIII ========  -->
<script>
    $(document).ready(function() {
        $('#pengajuanForm').on('submit', function(e) {
            let isValid = true;

            // Clear previous error messages
            $('.error-message').text('');

            // Validasi Tanggal Mulai
            const tanggalMulai = $('#tanggal_mulai').val();
            if (!tanggalMulai) {
                $('#error_tanggal_mulai').text('Tanggal mulai harus diisi.');
                isValid = false;
            }

            // Validasi Tanggal Selesai
            const tanggalSelesai = $('#tanggal_selesai').val();
            if (!tanggalSelesai) {
                $('#error_tanggal_selesai').text('Tanggal selesai harus diisi.');
                isValid = false;
            }

            // Validasi range tanggal
            if (tanggalMulai && tanggalSelesai && new Date(tanggalMulai) > new Date(tanggalSelesai)) {
                $('#error_tanggal_selesai').text('Tanggal selesai harus setelah tanggal mulai.');
                isValid = false;
            }

            // Validasi KTP (jika diisi)
            const ktp = $('#ktp')[0].files[0];
            if (ktp) {
                if (ktp.size > 1024 * 1024) {
                    $('#error_ktp').text('Ukuran KTP maksimal 1MB.');
                    isValid = false;
                }
                if (ktp.type !== 'application/pdf') {
                    $('#error_ktp').text('File KTP harus berformat PDF.');
                    isValid = false;
                }
            }

            // Validasi CV (jika diisi)
            const cv = $('#cv')[0].files[0];
            if (cv) {
                if (cv.size > 1024 * 1024) {
                    $('#error_cv').text('Ukuran CV maksimal 1MB.');
                    isValid = false;
                }
                if (cv.type !== 'application/pdf') {
                    $('#error_cv').text('File CV harus berformat PDF.');
                    isValid = false;
                }
            }

            // Jika tidak valid, cegah submit form
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>