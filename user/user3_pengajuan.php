<?php

// Ambil data instansi yang memiliki kuota
$sql_instansi = "SELECT i.id_instansi, i.nama_panjang, SUM(b.kuota_bidang) AS total_kuota FROM tb_instansi i JOIN tb_bidang b ON i.id_instansi = b.id_instansi 
                WHERE b.kuota_bidang > 0 AND i.status_active = '1' AND b.status_active = '1' GROUP BY i.id_instansi, i.nama_panjang ORDER BY total_kuota DESC";
$result_instansi = mysqli_query($conn, $sql_instansi);

// ambil data pendaftar
$sql_pendaftar = "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_user = '$id_user' AND u.id_user = pu.id_user";
$query_pendaftar = mysqli_query($conn, $sql_pendaftar);
$pendaftar = mysqli_fetch_assoc($query_pendaftar);

// CRUD PENGAJUAN
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pengajuan_pribadi']) || isset($_POST['pengajuan_kelompok'])) {
        inputPengajuan($_POST, $_FILES, $id_user);
    } else if (isset($_POST['update_pengajuan'])) {
    updatePengajuan($_POST, $_FILES, $id_user);
    } 
}

// Ambil satu contoh jenis pengajuan dari database
$sql_jenis = "SELECT jenis2_pengajuan FROM tb_instansi WHERE jenis2_pengajuan IS NOT NULL LIMIT 1";
$result_jenis = mysqli_query($conn, $sql_jenis);
$row_jenis = mysqli_fetch_assoc($result_jenis);
$jenis_pengajuan_options = json_decode($row_jenis['jenis2_pengajuan'], true) ?? ['Magang', 'Praktek Kerja Lapangan', 'Penelitian'];

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tambahkan stylesheet Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Tambahkan script Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
        .detail-lowongan {
            top: 20px;
            height: calc(100vh - 150px);
            overflow-y: auto;
        }

        #detailBidangCard {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        @media (max-width: 992px) {
            .detail-lowongan {
                position: static;
                height: auto;
                margin-top: 20px;
            }
        }

        #defaultBidangMessage {
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-style: italic;
        }
        .swal2-container {
            z-index: 99999 !important;
        }
        .card-subtitle.text-muted {
            font-size: 15px !important;
            color: #6c757d !important; /* Warna abu-abu Bootstrap */
        }
    </style>
</head>
<body>

<!-- ======== INPUT PENGAJUAN ======= -->
<?php if (isset($_GET['pengajuanBaru'])){ ?>
    <!-- untuk menampilkan modal pengajuan -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('pengajuanModal'));
            modal.show();
            
            // Saat modal ditutup, hapus query string id_logbook_tambah dan reload halaman
            const modalElement = document.getElementById('pengajuanModal');
            modalElement.addEventListener('hidden.bs.modal', function () {
                const url = new URL(window.location.href);
                url.searchParams.delete('pengajuanBaru');
                window.location.href = url.toString();
            });
        });
    </script>
    <div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengajuanModalLabel">Tambah Pengajuan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Form (7 bagian dari 12) -->
                        <div class="col-lg-8">
                            <div class="form-container" id="formContainer">
                                <div class="form-wrapper" id="formWrapper">
                                    <form id="pengajuanForm" class="form-profile" method="POST" enctype="multipart/form-data">
                                        <div id="step1">
                                            <h4>Step 1: Daftar Pengajuan</h4>
                                            <div class="mb-3">
                                                <label for="instansi" class="form-label">Instansi yang Dituju</label>
                                                <select class="form-control" name="id_instansi" id="instansi">
                                                    <option value="" disabled selected>-- Pilih Instansi --</option>
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
                                                <select class="form-control" name="id_bidang" id="bidang">
                                                    <option value="" disabled selected> -- Pilih Bidang --</option>
                                                </select>
                                            </div>

                                            <div class="d-flex gap-4">
                                                <div class="mb-3" style="flex: 1;">
                                                    <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                                                    <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan">
                                                        <option value="" disabled selected> -- Pilih Pengajuan --</option>
                                                        <?php foreach ($jenis_pengajuan_options as $jenis): ?>
                                                            <option value="<?= htmlspecialchars($jenis) ?>"><?= htmlspecialchars($jenis) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3" style="flex: 1;">
                                                    <label for="kelompok_pribadi" class="form-label">Personil</label>
                                                    <select class="form-control" id="kelompok_pribadi" name="kelompok_pribadi">
                                                        <option value="" disabled selected> -- Pilih Personil --</option>
                                                        <option value="Kelompok">Kelompok</option>
                                                        <option value="Pribadi">Pribadi</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" style="flex: 1;">
                                                    <label for="jumlah_anggota" class="form-label">Jumlah Anggota</label>
                                                    <input type="number" class="form-control" id="jumlah_anggota" name="jumlah_anggota">
                                                </div>
                                            </div>

                                            <div class="d-flex gap-4">
                                                <div class="mb-3" style="flex: 1;">
                                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                                    <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder="-- mulai --">
                                                </div>
                                                <div class="mb-3" style="flex: 1;">
                                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                    <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" placeholder="-- selesai --">
                                                </div>
                                            </div>
                                        
                                            <div class="d-flex gap-4">
                                                <!-- KTP -->
                                                <div class="mb-3 position-relative" style="flex: 1;">
                                                    <label for="ktp" class="form-label">Unggah KTP</label>
                                                    <input type="file" class="form-control pe-5" id="ktp" name="ktp" accept=".pdf" onchange="handleFileLabel('ktp')">
                                                    <small id="ktp-label" class="form-text text-primary" style="cursor: pointer;" onclick="previewFile('ktp')"></small>
                                                </div>

                                                <!-- CV -->
                                                <div class="mb-3 position-relative" style="flex: 1;">
                                                    <label for="cv" class="form-label">Unggah CV</label>
                                                    <input type="file" class="form-control pe-5" id="cv" name="cv" accept=".pdf" onchange="handleFileLabel('cv')">
                                                    <small id="cv-label" class="form-text text-primary" style="cursor: pointer;" onclick="previewFile('cv')"></small>
                                                </div>

                                                 <!-- PROPOSAL -->
                                                 <div class="mb-3 position-relative" style="flex: 1;">
                                                    <label for="proposal" class="form-label">Unggah Proposal</label>
                                                    <input type="file" class="form-control pe-5" id="proposal" name="proposal" accept=".pdf" onchange="handleFileLabel('proposal')">
                                                    <small id="proposal-label" class="form-text text-primary" style="cursor: pointer;" onclick="previewFile('proposal')"></small>
                                                </div>
                                            </div>
                                            <button type="submit" id="submitButton" name="pengajuan_pribadi" class="btn btn-success btn-sm" style="display: inline-block;" onclick="validateForm(event)">Kirim</button>
                                            <button type="button" id="nextButton" class="btn btn-primary btn-sm" onclick="nextStep(event)"  style="display: none;">Next</button>
                                        </div>

                                        <!-- Step 2 -->
                                        <div id="step2" style="display: none;">
                                            <h4>Step 2: Informasi Anggota</h4><br><br>
                                            <!-- Column Headers -->
                                             <?php 
                                              $studi = mysqli_query($conn, "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'");
                                              $id_studi = mysqli_fetch_assoc($studi)['id_pendidikan'];
                                            ?>
                                            <div class="row mb-2 fw-bold text-center">
                                                <div class="col-md-3">Nama Lengkap</div>
                                                <div class="col-md-3">Email</div>
                                                <div class="col-md-3">NIK</div>
                                                <?php if (strlen($id_studi) == 7) : ?>
                                                    <div class="col-md-3">NIM</div>
                                                <?php else : ?>
                                                    <div class="col-md-3">NISN</div>
                                                <?php endif; ?>
                                            </div>
                                            <div id="ketuaContainer">
                                                <!-- Anggota 1 (Readonly, diisi otomatis dari profil user) -->
                                                <div class="mb-3 anggota-group d-flex align-items-center">
                                                    <span class="me-2 fw-bold">1.</span>
                                                    <div class="row flex-grow-1 gx-2">
                                                    <div class="col">
                                                        <input type="text" class="form-control" value="<?= $pendaftar['nama_user'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" value="<?= $pendaftar['email'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <input type="number" class="form-control" value="<?= $pendaftar['nik'] ?>" readonly>
                                                    </div>
                                                    <?php
                                                    if (strlen($id_studi) == 7) : ?>
                                                        <div class="col">
                                                            <input type="number" class="form-control" value="<?= $pendaftar['nim'] ?>"  readonly>
                                                        </div>
                                                        <?php else : ?>
                                                        <div class="col">
                                                            <input type="text" class="form-control" value="<?= $pendaftar['nisn'] ?>" readonly>
                                                        </div>
                                                    <?php endif; ?>
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
                            </div>
                        </div>

                        <!-- Kolom Detail (4 bagian dari 12) -->
                        <div class="col-lg-4">
                            <div class="detail-lowongan sticky-top" id="detailBidangContainer">
                                <div class="card" id="detailBidangCard">
                                    
                                    <div class="card-body">
                                        <div id="defaultBidangMessage">
                                            <p class="text-muted text-center">Silahkan pilih bidang lowongan terlebih dahulu</p>
                                        </div>
                                        <div id="bidangDetailContent" style="display: none;">
                                            <strong><h4 class="card-subtitle" id="instansiNama"></h4></strong><hr>
                                            <h1 class="card-subtitle text-muted" id="bidangNama"></h1><hr>
                                            <p class="text-start"><i class="bi bi-text-paragraph me-2"></i>Deskripsi:</p>
                                            <p class="text-start text-muted" id="bidangDeskripsi"></p><hr>
                                            <p class="text-start"><i class="bi bi-list-check me-2"></i>Kriteria:</p>
                                            <p class="text-start text-muted" id="bidangKriteria"></p><hr>
                                            <p class="text-start"><i class="bi bi-file-earmark-text me-2"></i>Dokumen Persyaratan:</p>
                                            <p class="text-start text-muted"id="bidangDokumen"></p><hr>
                                            <div class="alert alert-info mt-2 p-2 small">
                                                <i class="bi bi-info-circle me-1"></i> 
                                                <strong>Catatan:</strong> Dokumen selain KTP, CV, dan Proposal dapat diunggah setelah pengajuan diterima.
                                                </div>
                                                <hr>
                                            <p class="text-start"><i class="bi bi-people-fill me-2"></i>Kuota : <span id="bidangKuota"></span></p><hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- ============= UPDATE PENGAJUAN =========== -->

<?php
} else if (isset($_GET['id_pengajuanEdit'])){?>
<!-- untuk menjalankan modal edit pengajuan -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('editPengajuanModal'));
            modal.show();
            
            // Saat modal ditutup, hapus query string id_logbook_tambah dan reload halaman
            const modalElement = document.getElementById('editPengajuanModal');
            modalElement.addEventListener('hidden.bs.modal', function () {
                const url = new URL(window.location.href);
                url.searchParams.delete('id_pengajuanEdit');
                window.location.href = url.toString();
            });
        });
    </script>
<?php
// query untuk akses data pengajuan sebelumnya
    $id_pengajuanEdit  = $_GET['id_pengajuanEdit'];
    // akses data pengajuan user
    $sql_pengajuan = "SELECT * FROM tb_pengajuan p, tb_bidang b, tb_instansi i WHERE p.id_pengajuan = '$id_pengajuanEdit' AND p.id_bidang = b.id_bidang AND p.id_instansi = i.id_instansi;"; 
    $query_pengajuan = mysqli_query($conn, $sql_pengajuan);
    $pengajuan = mysqli_fetch_assoc($query_pengajuan);

    $sql_dokumen = "SELECT file_path FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuanEdit' ORDER BY id_dokumen ASC";
    $query_dokumen = mysqli_query($conn, $sql_dokumen);
    $daftar_dokumen = mysqli_fetch_all($query_dokumen, MYSQLI_ASSOC);

?>
<!-- Modal Edit Pengajuan -->
<div class="modal fade" id="editPengajuanModal" tabindex="-1" aria-labelledby="editPengajuanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPengajuanModalLabel">Edit Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom Form (8 bagian dari 12) -->
                    <div class="col-lg-8">
                        <div class="form-container" id="formContainer">
                            <div class="form-wrapper" id="formWrapper">
                                <form id="editPengajuanForm" class="form-profile" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_pengajuan" value="<?= $pengajuan['id_pengajuan'] ?>">
                                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
                                    
                                    <div id="step1">
                                        <h4>Informasi Pengajuan</h4>
                                        <div class="mb-3">           
                                            <label for="instansi" class="form-label">Instansi yang Dituju</label>
                                            <select class="form-control" name="id_instansi" id="instansi">
                                                <option value="<?= $pengajuan['id_instansi'] ?>"><?= $pengajuan['nama_panjang'] ?></option>
                                                <?php
                                                if (mysqli_num_rows($result_instansi) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result_instansi)) {
                                                        echo '<option value="'.$row['id_instansi'].'">'.$row['nama_panjang'].' (Kuota: '.$row['total_kuota'].')</option>';
                                                    }
                                                }else{
                                                    echo '<option> no name </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bidang" class="form-label">Bidang yang Dipilih</label>
                                            <select class="form-control" name="id_bidang" id="bidang">
                                                <option value="<?= $pengajuan['id_bidang'] ?>"><?= $pengajuan['nama_bidang'] ?></option>
                                            </select>
                                        </div>

                                        <div class="d-flex gap-4">
                                            <div class="mb-3" style="flex: 1;">
                                                <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                                                <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan">
                                                    <option value="<?= $pengajuan['jenis_pengajuan'] ?>"><?= ucfirst($pengajuan['jenis_pengajuan']) ?></option>
                                                    <?php foreach ($jenis_pengajuan_options as $jenis): ?>
                                                            <option value="<?= htmlspecialchars($jenis) ?>"><?= htmlspecialchars($jenis) ?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-4">
                                            <div class="mb-3" style="flex: 1;">
                                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                                <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= !empty($pengajuan['tanggal_mulai']) ? date('d/m/Y', strtotime($pengajuan['tanggal_mulai'])) : '' ?>" placeholder="dd/mm/yyyy">
                                            </div>
                                            <div class="mb-3" style="flex: 1;">
                                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= !empty($pengajuan['tanggal_selesai']) ? date('d/m/Y', strtotime($pengajuan['tanggal_selesai'])) : '' ?>" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    
                                        <div class="d-flex gap-4">
                                            <!-- KTP -->
                                            <div class="mb-3 position-relative" style="flex: 1;">
                                                <label for="ktp" class="form-label">Unggah KTP</label>
                                                <input type="file" class="form-control pe-5" id="ktp" name="ktp" accept=".pdf" onchange="handleFileLabel('ktp')">
                                                <small id="ktp-label" class="form-text text-primary" style="cursor: pointer;" onclick="previewFile('ktp')"></small>
                                                <p class="mt-1">Dokumen saat ini: <a href="<?= ($daftar_dokumen[0]['file_path']) ?>" target="_blank">Lihat KTP</a></p>
                                            </div>

                                            <!-- CV -->
                                            <div class="mb-3 position-relative" style="flex: 1;">
                                                <label for="cv" class="form-label">Unggah CV</label>
                                                <input type="file" class="form-control pe-5" id="cv" name="cv" accept=".pdf" onchange="handleFileLabel('cv')">
                                                <small id="cv-label" class="form-text text-primary" style="cursor: pointer;" onclick="previewFile('cv')"></small>
                                                <p class="mt-1">Dokumen saat ini: <a href="<?= ($daftar_dokumen[1]['file_path']) ?>" target="_blank">Lihat CV</a></p>
                                            </div>

                                            <!-- PROPOSAL -->
                                            <div class="mb-3 position-relative" style="flex: 1;">
                                                <label for="proposal" class="form-label">Unggah Proposal</label>
                                                <input type="file" class="form-control pe-5" id="proposal" name="proposal" accept=".pdf" onchange="handleFileLabel('proposal')">
                                                <small id="proposal-label" class="form-text text-primary" style="cursor: pointer;" onclick="previewFile('proposal')"></small>
                                                <p class="mt-1">Dokumen saat ini: <a href="<?= ($daftar_dokumen[2]['file_path']) ?>" target="_blank">Lihat Proposal</a></p>
                                            </div>
                                        </div>

                                        <button type="submit" name="update_pengajuan" class="btn btn-success"><i class="bi bi-arrow-repeat me-1"></i> Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom Detail (4 bagian dari 12) -->
                    <div class="col-lg-4">
                        <div class="detail-lowongan sticky-top" id="detailBidangContainer">
                            <div class="card" id="detailBidangCard">
                                <div class="card-body">
                                    <div id="defaultBidangMessage">
                                        <p class="text-muted text-center">Silahkan pilih bidang lowongan terlebih dahulu</p>
                                    </div>
                                    
                                    <div id="bidangDetailContent" style="display: none;">
                                        <strong><h4 class="card-subtitle" id="instansiNama"></h4></strong><hr>
                                        <h1 class="card-subtitle text-muted" id="bidangNama"></h1><hr>
                                        <p class="text-start"><i class="bi bi-text-paragraph me-2"></i>Deskripsi:</p>
                                        <p class="text-start text-muted" id="bidangDeskripsi">p><hr>
                                        <p class="text-start"><i class="bi bi-list-check me-2"></i>Kriteria:</p>
                                        <p class="text-start text-muted" id="bidangKriteria"></p><hr>
                                        <p class="text-start"><i class="bi bi-file-earmark-text me-2"></i>Dokumen Persyaratan:</p>
                                        <p class="text-start text-muted"id="bidangDokumen"></p><hr>
                                        <div class="alert alert-info mt-2 p-2 small">
                                            <i class="bi bi-info-circle me-1"></i> 
                                            <strong>Catatan:</strong> Dokumen selain KTP, CV, dan Proposal dapat diunggah setelah pengajuan diterima.
                                        </div><hr>
                                        <p class="text-start"><i class="bi bi-people-fill me-2"></i>Kuota : <span id="bidangKuota"></span></p><hr>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
</body>
</html>


<!-- MENGAMBIL DETAIL BIDANG ATAU LOWONGAN  -->
<script>
    function initSelect2InModal(modalId) {
        $(`#${modalId}`).on('shown.bs.modal', function () {
            $('#instansi').select2({
                dropdownParent: $(`#${modalId}`),
                placeholder: "Pilih Instansi",
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0
            });
        });
    }

    // Inisialisasi hanya untuk modal pengajuan
    initSelect2InModal('editPengajuanModal');
    initSelect2InModal('pengajuanModal');
</script>

<script>
    $(document).ready(function() {
        // Cek apakah ada data bidang yang sudah dipilih sebelumnya
        <?php if(isset($pengajuan['id_bidang']) && !empty($pengajuan['id_bidang'])): ?>
            // Jika ada data sebelumnya, tampilkan detail bidang
            $("#defaultBidangMessage").hide();
            $("#bidangDetailContent").show();
            $("#detailBidangContainer").show();
        <?php else: ?>
            // Jika tidak ada data, tampilkan pesan default
            $("#defaultBidangMessage").show();
            $("#bidangDetailContent").hide();
        <?php endif; ?>

        // Ambil bidang saat instansi berubah
        $("#instansi").change(function() {
            var id_instansi = $(this).val();

            $.ajax({
                url: "cek.php",
                type: "POST",
                data: { id_instansi: id_instansi },
                success: function(response) {
                    $("#bidang").html('<option value="" disabled selected> -- Pilih Bidang --</option>' + response);
                    $("#defaultBidangMessage").show();
                    $("#bidangDetailContent").hide();
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
                url: "cek.php",
                type: "POST",
                data: { id_bidang: id_bidang },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        $("#detailBidangContainer").hide();
                    } else {
                        // Sembunyikan pesan default dan tampilkan detail
                        $("#defaultBidangMessage").hide();
                        $("#bidangDetailContent").show();
                        
                        $("#instansiNama").text(response.nama_panjang);
                        $("#bidangNama").text(response.nama_bidang);
                        $("#bidangDeskripsi").text(response.deskripsi_bidang);
                        // Di dalam success callback AJAX:
                        $("#bidangKriteria").html(response.kriteria_bidang);
                        $("#bidangDokumen").html(response.dokumen_persyaratan);
                        $("#bidangKuota").text(response.kuota_bidang);
                        $("#detailBidangContainer").show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                    $("#detailBidangContainer").hide();
                }
            });
        });

        // Jika ada bidang yang dipilih sebelumnya, pilih opsi yang sesuai
        <?php if(isset($pengajuan['id_bidang']) && !empty($pengajuan['id_bidang'])): ?>
            // Trigger change event untuk menampilkan detail bidang
            $("#bidang").val("<?= $pengajuan['id_bidang'] ?>").trigger('change');
        <?php endif; ?>
    });
</script>

<!-- Melihat preview dokumen -->
<script>
    function handleFileLabel(id) {
        const input = document.getElementById(id);
        const label = document.getElementById(`${id}-label`);

        if (input.files.length > 0) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = '';
        }
    }

    function previewFile(id) {
        const input = document.getElementById(id);
        const file = input.files[0];

        if (file) {
            const fileURL = URL.createObjectURL(file);
            const previewWindow = window.open(fileURL, '_blank');
            previewWindow.focus();
        } else {
            alert("Tidak ada file yang dipilih untuk preview.");
        }
    }
</script>


<!-- SCRIPT UNTUK VALIDASI FORM -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const kelompokPribadi = document.getElementById("kelompok_pribadi");
    const jumlahAnggotaInput = document.getElementById("jumlah_anggota");
    const jumlahAnggotaContainer = jumlahAnggotaInput ? jumlahAnggotaInput.closest(".mb-3") : null;
    const nextButton = document.getElementById("nextButton");
    const submitButton = document.getElementById("submitButton");
    const step1 = document.getElementById("step1");
    const step2 = document.getElementById("step2");
    const anggotaContainer = document.getElementById("anggotaContainer");
    const bidang = document.getElementById("bidang");
    let maxKuota = 0;
    
    // Inisialisasi elemen
    if (jumlahAnggotaInput) {
        jumlahAnggotaInput.disabled = true;
        jumlahAnggotaContainer.style.display = "block";
    }

    if (step2) step2.style.display = "none";

    // Event listener untuk perubahan jenis pengajuan (kelompok/pribadi)
    if (kelompokPribadi) {
        kelompokPribadi.addEventListener("change", function() {
            if (this.value === "Kelompok") {
                if (jumlahAnggotaInput) {
                    jumlahAnggotaInput.disabled = false;
                }
                if (nextButton) nextButton.style.display = "inline-block";
                if (submitButton) submitButton.style.display = "none";
            } else {
                if (jumlahAnggotaInput) {
                    jumlahAnggotaInput.disabled = true;
                    jumlahAnggotaInput.value = "";
                }
                if (step2) step2.style.display = "none";
                if (nextButton) nextButton.style.display = "none";
                if (submitButton) submitButton.style.display = "inline-block";
            }
        });
    }

    // Event listener untuk perubahan bidang
    if (bidang) {
        bidang.addEventListener("change", function() {
            maxKuota = parseInt(this.options[this.selectedIndex].getAttribute("data-kuota")) || 0;
        });
    }

    // Fungsi untuk menampilkan pesan error
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

    // Fungsi untuk menghapus pesan error
    function clearError(input) {
        const error = input.parentNode.querySelector(".error-message");
        if (error) {
            error.remove();
        }
    }

    // Validasi format email
    function validateEmailFormat(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Validasi step 1 form
    function validateStep1(formId) {
        let isValid = true;
        const form = document.getElementById(formId);
        if (!form) return false;

        // Daftar field yang wajib diisi
        const fields = [
            { id: "instansi", message: "Pilih instansi yang dituju!" },
            { id: "bidang", message: "Pilih bidang yang dipilih!" },
            { id: "jenis_pengajuan", message: "Pilih jenis pengajuan!" },
            { id: "tanggal_mulai", message: "Pilih tanggal mulai!" },
            { id: "tanggal_selesai", message: "Pilih tanggal selesai!" }
        ];

        // Tambahkan validasi kelompok_pribadi hanya untuk form pengajuan baru
        if (formId === "pengajuanForm") {
            fields.push({ id: "kelompok_pribadi", message: "Pilih personil!" });
        }

        // Validasi setiap field
        fields.forEach(field => {
            const inputElement = form.querySelector(`#${field.id}`);
            if (!inputElement || !inputElement.value.trim()) {
                if (inputElement) showError(inputElement, field.message);
                isValid = false;
            } else {
                if (inputElement) clearError(inputElement);
            }
        });

        // Validasi khusus untuk jumlah anggota (hanya form pengajuan baru)
        if (formId === "pengajuanForm" && kelompokPribadi && jumlahAnggotaInput) {
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
        }

        // Validasi file upload
        const fileFields = [
            { id: "ktp", message: "Upload KTP dalam format PDF!" },
            { id: "cv", message: "Upload CV dalam format PDF!" },
            { id: "proposal", message: "Upload proposal dalam format PDF!" }
        ];

        const maxFileSize = 1 * 1024 * 1024; // 1 MB
        const allowedMimeTypes = ["application/pdf"];

        fileFields.forEach(({ id, message }) => {
            const inputElement = document.getElementById(id);
            if (!inputElement) return;

            const file = inputElement.files?.[0];
            if (formId === "pengajuanForm" && !file) {
                showError(inputElement, message);
                isValid = false;
            } else if (file) {
                if (file.size > maxFileSize) {
                    showError(inputElement, "File tidak boleh lebih dari 1 MB!");
                    isValid = false;
                } else if (!allowedMimeTypes.includes(file.type)) {
                    showError(inputElement, "File harus dalam format PDF!");
                    isValid = false;
                } else {
                    clearError(inputElement);
                }
            }
        });

        return isValid;
    }

    // Fungsi untuk memeriksa ketersediaan email via AJAX
    function checkEmail(emailInput) {
        const email = emailInput.value.trim();
        if (email === "") return;

        // Validasi format email terlebih dahulu
        if (!validateEmailFormat(email)) {
            showError(emailInput, "Format email tidak valid!");
            return;
        }

        // Cek ke server
        fetch("cek.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `email=${encodeURIComponent(email)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(result => {
            if (result === "exists") {
                showError(emailInput, "Email sudah digunakan!");
            } else {
                clearError(emailInput);
            }
        })
        .catch(error => {
            console.error("Error checking email:", error);
        });
    }

    // Validasi data anggota
    function validateAnggota() {
        let isValid = true;
        const emails = new Set();
        const anggotaInputs = document.querySelectorAll('#anggotaContainer .anggota-group');
        const nameRegex = /^[A-Za-z\s]+$/;

        anggotaInputs.forEach((anggota) => {
            const nama = anggota.querySelector("input[name='anggota_nama[]']");
            const email = anggota.querySelector("input[name='anggota_email[]']");
            const nik = anggota.querySelector("input[name='anggota_nik[]']");

            // Validasi nama
            if (!nama.value.trim()) {
                showError(nama, "Nama harus diisi!");
                isValid = false;
            } else if (!nameRegex.test(nama.value.trim())) {
                showError(nama, "Nama hanya boleh mengandung huruf!");
                isValid = false;
            } else {
                clearError(nama);
            }

            // Validasi email
            if (!email.value.trim()) {
                showError(email, "Email harus diisi!");
                isValid = false;
            } else if (!validateEmailFormat(email.value)) {
                showError(email, "Format email tidak valid!");
                isValid = false;
            } else if (emails.has(email.value)) {
                showError(email, "Email sudah digunakan!");
                isValid = false;
            } else {
                emails.add(email.value);
                // Tidak memanggil checkEmail() di sini karena async
                // Error akan ditampilkan via onblur handler
            }

            // Validasi NIK
            if (!nik.value.trim()) {
                showError(nik, "NIK wajib diisi!");
                isValid = false;
            } else if (nik.value.length !== 16 || !/^\d+$/.test(nik.value)) {
                showError(nik, "NIK harus terdiri dari 16 digit angka!");
                isValid = false;
            } else {
                clearError(nik);
            }

            // Validasi Pendidikan (NIM/NISN)
            const isUniversity = <?= strlen($id_studi) == 7 ? 'true' : 'false' ?>;

            if (isUniversity) {
                const nim = anggota.querySelector("input[name='anggota_nim[]']");
                if (!nim.value.trim()) {
                    showError(nim, `NIM wajib diisi!`);
                    isValid = false;
                } else if (!/^\d{12}$/.test(nim.value)) {
                    showError(nim, `NIM anggota harus 12 digit angka!`);
                    isValid = false;
                } else {
                    clearError(nim);
                }
            } else {
                const nisn = anggota.querySelector("input[name='anggota_nisn[]']");
                if (!nisn.value.trim()) {
                    showError(nisn, `NISN anggota wajib diisi!`);
                    isValid = false;
                } else if (!/^\d{10}$/.test(nisn.value)) {
                    showError(nisn, `NISN anggota harus 10 digit angka!`);
                    isValid = false;
                } else {
                    clearError(nisn);
                }
            }
        });

        // Periksa apakah ada error email yang sudah ditampilkan
        const emailErrors = document.querySelectorAll('.anggota-email + .error-message');
        if (emailErrors.length > 0) {
            isValid = false;
        }

        return isValid;
    }

    // Fungsi untuk kembali ke step sebelumnya
    function prevStep() {
        if (step2) step2.style.display = "none";
        if (step1) step1.style.display = "block";
        if (nextButton) nextButton.style.display = "inline-block";
        if (submitButton) submitButton.style.display = "none";
        if (anggotaContainer) anggotaContainer.innerHTML = "";
    }

    // Fungsi untuk lanjut ke step berikutnya
    function nextStep(event) {
        event.preventDefault();
        if (!validateStep1("pengajuanForm")) return;

        const jumlahAnggota = parseInt(jumlahAnggotaInput.value) || 0;
        if (anggotaContainer && anggotaContainer.children.length !== jumlahAnggota - 1) {
            anggotaContainer.innerHTML = "";
            for (let i = 1; i < jumlahAnggota; i++) {
                const anggotaHTML = `
                <div class="mb-3 anggota-group d-flex align-items-center">
                    <span class="me-2 fw-bold">${i + 1}.</span>
                    <div class="row flex-grow-1 gx-2">
                        <div class="col"><input type="text" class="form-control" name="anggota_nama[]" placeholder="Nama"></div>
                        <div class="col"><input type="email" class="form-control anggota-email" name="anggota_email[]" placeholder="Email" onblur="checkEmail(this)"></div>
                        <div class="col"><input type="number" class="form-control" name="anggota_nik[]" placeholder="NIK" oninput="this.value=this.value.slice(0,16)"></div>
                        <?php
                         $studi = mysqli_query($conn, "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'");
                         $id_studi = mysqli_fetch_assoc($studi)['id_pendidikan'];
                         if (strlen($id_studi) == 7) : ?>
                            <div class="col"><input type="number" class="form-control" name="anggota_nim[]" placeholder="NIM" oninput="this.value=this.value.slice(0,12)"></div>
                        <?php else : ?>
                            <div class="col"><input type="number" class="form-control" name="anggota_nisn[]" placeholder="NISN" oninput="this.value=this.value.slice(0,10)"></div>
                        <?php endif ?>
                    </div>
                </div>`;
                anggotaContainer.insertAdjacentHTML("beforeend", anggotaHTML);
            }
        }

        if (step1) step1.style.display = "none";
        if (step2) step2.style.display = "block";
        if (nextButton) nextButton.style.display = "none";
        if (submitButton) submitButton.style.display = "inline-block";
    }

    // Event listener untuk form pengajuan
    const pengajuanForm = document.getElementById("pengajuanForm");
    if (pengajuanForm) {
        pengajuanForm.addEventListener("submit", function(event) {
            if (!validateStep1("pengajuanForm") || !validateAnggota()) {
                event.preventDefault();
            }
        });
    }

    // Event listener untuk form edit pengajuan
    const editForm = document.getElementById("editPengajuanForm");
    if (editForm) {
        editForm.addEventListener("submit", function(event) {
            if (!validateStep1("editPengajuanForm")) {
                event.preventDefault();
            }
        });
    }

    // Ekspos fungsi ke global scope untuk digunakan di inline event handlers
    window.nextStep = nextStep;
    window.prevStep = prevStep;
    window.checkEmail = checkEmail;
});
</script>