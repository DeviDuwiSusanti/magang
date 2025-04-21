<?php

// Ambil data instansi yang memiliki kuota
$sql_instansi = "SELECT i.id_instansi, i.nama_panjang, SUM(b.kuota_bidang) AS total_kuota FROM tb_instansi i JOIN tb_bidang b ON i.id_instansi = b.id_instansi 
                WHERE b.kuota_bidang > 0 GROUP BY i.id_instansi, i.nama_panjang ORDER BY total_kuota DESC";
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
    } else if (isset($_POST['hapus_pengajuan'])) {
    hapusPengajuan($_POST, $id_user);
    }
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
                                                <select class="form-control select2" name="id_instansi" id="instansi">
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
                                                        <option value="magang">Magang</option>
                                                        <option value="kerja praktek">Kerja Praktek</option>
                                                        <option value="pkl">PKL</option>
                                                        <option value="penelitian">Penelitian</option>
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
                                            </div>

                                            <div class="mb-3">
                                                <label for="jumlah_anggota" class="form-label">Jumlah Anggota</label>
                                                <input type="number" class="form-control" id="jumlah_anggota" name="jumlah_anggota">
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
                                                        <input type="text" class="form-control" value="<?= $pendaftar['email'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <input type="number" class="form-control" value="<?= $pendaftar['nik'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" value="<?= $pendaftar['nisn'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <input type="number" class="form-control" value="<?= !empty($pendaftar['nim']) ? $pendaftar['nim'] : '-' ?>"  readonly>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Placeholder untuk anggota tambahan -->
                                            <div id="anggotaContainer"></div>
                                            <div>
                                                <small class="form-text text-muted" style="font-size: 0.7rem;">Untuk NIM kosongkan jika belum memiliki NIM</small>
                                            </div><br><br>

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
                                    <div class="card-header bg-primary">
                                        <h5 class="card-title text-white mb-0">Detail Bidang</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="defaultBidangMessage">
                                            <p class="text-muted text-center">Silahkan pilih bidang lowongan terlebih dahulu</p>
                                        </div>
                                        <div id="bidangDetailContent" style="display: none;">
                                            <h1 class="card-subtitle mb-2 text-muted" id="bidangNama"></h1><hr>
                                            <p class="text-start"><strong><i class="bi bi-text-paragraph me-2"></i>Deskripsi:</strong></p>
                                            <p class="text-start"id="bidangDeskripsi"></p><hr>
                                            <p class="text-start"><strong><i class="bi bi-list-check me-2"></i>Kriteria:</strong></p>
                                            <p class="text-start" id="bidangKriteria"></p><hr>
                                            <p class="text-start"><strong><i class="bi bi-file-earmark-text me-2"></i>Dokumen Prasyarat:</strong></p>
                                            <p class="text-start"id="bidangDokumen"></p><hr>
                                            <p class="text-start"><strong><i class="bi bi-people-fill me-2"></i>Kuota:</strong> <span id="bidangKuota"></span></p><hr>
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
                                            <select class="form-control select2" name="id_instansi" id="instansi">
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

                                        <div class="mb-3">
                                            <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                                            <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan">
                                                <option value="<?= $pengajuan['jenis_pengajuan'] ?>"><?= ucfirst($pengajuan['jenis_pengajuan']) ?></option>
                                                <option value="magang">Magang</option>
                                                <option value="kerja praktek">Kerja Praktek</option>
                                                <option value="pkl">PKL</option>
                                                <option value="penelitian">Penelitian</option>
                                            </select>
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
                                        </div>

                                            <button type="submit" name="update_pengajuan" class="btn btn-success">
                                                <i class="bi bi-save me-1"></i> Update
                                            </button>
                                            
                                            <input type="hidden" name="hapus_pengajuan"> <!-- Tanda penghapusan -->
                                            <button type="submit" class="btn btn-danger btn-sm" id="hapusPengajuan"><i class="bi bi-trash me-1"></i> Hapus</button>      
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom Detail (4 bagian dari 12) -->
                    <div class="col-lg-4">
                        <div class="detail-lowongan sticky-top" id="detailBidangContainer">
                            <div class="card" id="detailBidangCard">
                                <div class="card-header bg-primary">
                                    <h5 class="card-title text-white mb-0">Detail Bidang</h5>
                                </div>
                                <div class="card-body">
                                    <div id="defaultBidangMessage">
                                        <p class="text-muted text-center">Silahkan pilih bidang lowongan terlebih dahulu</p>
                                    </div>
                                    <div id="bidangDetailContent" style="display: none;">
                                        <h1 class="card-subtitle mb-2 text-muted" id="bidangNama"><?= $pengajuan['nama_bidang'] ?></h1>
                                        <hr>
                                        <p class="text-start"><strong><i class="bi bi-text-paragraph me-2"></i></strong></p>
                                        <p class="text-start"id="bidangDeskripsi"><?= $pengajuan['deskripsi_bidang'] ?></p><hr>
                                        <p class="text-start"><strong><i class="bi bi-list-check me-2"></i>Kriteria:</strong></p>
                                        <p class="text-start" id="bidangKriteria"><?= $pengajuan['kriteria_bidang'] ?></p><hr>
                                        <p class="text-start"><strong><i class="bi bi-file-earmark-text me-2"></i>Dokumen Prasyarat:</strong></p>
                                        <p class="text-start" id="bidangDokumen"><?= $pengajuan['dokumen_prasyarat'] ?></p><hr>
                                        <p class="text-start"><strong><i class="bi bi-people-fill me-2"></i>Kuota:</strong> <span id="bidangKuota"><?= $pengajuan['kuota_bidang'] ?></span></p><hr>
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

<!-- hapus pengajuan -->
<script>
document.getElementById('hapusPengajuan').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah form langsung terkirim

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim form secara manual
            document.getElementById('editPengajuanForm').submit();
        }
    });
});
</script>


<!-- MENGAMBIL DETAIL BIDANG ATAU LOWONGAN  -->
<script>
    $(document).ready(function() {
        $('#instansi').select2({
            placeholder: "-- Pilih Instansi --",
            allowClear: true
        });
    });
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
                        
                        $("#bidangNama").text(response.nama_bidang);
                        $("#bidangDeskripsi").text(response.deskripsi_bidang);
                        $("#bidangKriteria").text(response.kriteria_bidang);
                        $("#bidangDokumen").text(response.dokumen_prasyarat);
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

    if (jumlahAnggotaContainer) jumlahAnggotaContainer.style.display = "none";
    if (step2) step2.style.display = "none";

    if (kelompokPribadi) {
        kelompokPribadi.addEventListener("change", function() {
            if (this.value === "Kelompok") {
                if (jumlahAnggotaContainer) jumlahAnggotaContainer.style.display = "block";
                if (nextButton) nextButton.style.display = "inline-block";
                if (submitButton) submitButton.style.display = "none";
            } else {
                if (jumlahAnggotaContainer) jumlahAnggotaContainer.style.display = "none";
                if (step2) step2.style.display = "none";
                if (nextButton) nextButton.style.display = "none";
                if (submitButton) submitButton.style.display = "inline-block";
            }
        });
    }

    if (bidang) {
        bidang.addEventListener("change", function() {
            maxKuota = parseInt(this.options[this.selectedIndex].getAttribute("data-kuota")) || 0;
        });
    }

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

    function clearError(input) {
        const error = input.parentNode.querySelector(".error-message");
        if (error) {
            error.remove();
        }
    }

    function validateStep1(formId) {
        let isValid = true;
        const form = document.getElementById(formId);
        if (!form) return false;

        const fields = [
            { id: "instansi", message: "Pilih instansi yang dituju!" },
            { id: "bidang", message: "Pilih bidang yang dipilih!" },
            { id: "jenis_pengajuan", message: "Pilih jenis pengajuan!" },
            { id: "tanggal_mulai", message: "Pilih tanggal mulai!" },
            { id: "tanggal_selesai", message: "Pilih tanggal selesai!" }
        ];

        // Hanya tambahkan validasi kelompok_pribadi jika form adalah pengajuanForm
        if (formId === "pengajuanForm") {
            fields.push({ id: "kelompok_pribadi", message: "Pilih personil!" });
        }

        fields.forEach(field => {
            const inputElement = form.querySelector(`#${field.id}`);
            console.log(`Validasi field: ${field.id}, Nilai:`, inputElement ? inputElement.value : "Tidak ditemukan");
            if (!inputElement || !inputElement.value.trim()) {
                if (inputElement) showError(inputElement, field.message);
                isValid = false;
            } else {
                if (inputElement) clearError(inputElement);
            }
        });

        // Validasi jumlah anggota hanya untuk pengajuanForm
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
        const otherFields = [
            { id: "ktp", message: "Upload KTP dalam format PDF!" },
            { id: "cv", message: "Upload CV dalam format PDF!" }
        ];

        const maxFileSize = 1 * 1024 * 1024; // 1 MB
        const allowedMimeTypes = ["application/pdf"];

        otherFields.forEach(({ id }) => {
            const inputElement = document.getElementById(id);
            if (!inputElement) return;

            const file = inputElement.files?.[0];
            if (formId === "pengajuanForm" && !file) {
                showError(inputElement, "File wajib diunggah!");
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

        console.log(`Validasi form ${formId} selesai. Hasil:`, isValid ? "Berhasil" : "Gagal");
     
        return isValid;
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

    function validateAnggota() {
        let isValid = true;
        const emails = new Set();
        const anggotaInputs = document.querySelectorAll('#anggotaContainer .anggota-group');
        const nameRegex = /^[A-Za-z\s]+$/;

        anggotaInputs.forEach((anggota) => {
            const nama = anggota.querySelector("input[name='anggota_nama[]']");
            const email = anggota.querySelector("input[name='anggota_email[]']");
            const nik = anggota.querySelector("input[name='anggota_nik[]']");
            const nisn = anggota.querySelector("input[name='anggota_nisn[]']");
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
                checkEmail(email);
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

            if (!nisn.value.trim()) {
                showError(nisn, `NISN anggota wajib diisi!`);
                isValid = false;
            } else if (!/^\d{10}$/.test(nisn.value)) {
                showError(nisn, `NISN anggota harus 10 digit angka!`);
                isValid = false;
            } else {
                clearError(nisn);
            }

            if (nim.value.trim()) {
                if (!/^\d{12}$/.test(nim.value)) {
                    showError(nim, `NIM anggota harus 12 digit angka jika diisi!`);
                    isValid = false;
                } else {
                    clearError(nim);
                }
            } else {
                // Boleh kosong
                clearError(nim);
            }
        });

        return isValid;
    }

    function prevStep() {
        if (step2) step2.style.display = "none";
        if (step1) step1.style.display = "block";
        if (nextButton) nextButton.style.display = "inline-block";
        if (submitButton) submitButton.style.display = "none";
        if (anggotaContainer) anggotaContainer.innerHTML = "";
    }

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
                        <div class="col"><input type="number" class="form-control" name="anggota_nisn[]" placeholder="NISN" oninput="this.value=this.value.slice(0,10)"></div>
                        <div class="col"><input type="number" class="form-control" name="anggota_nim[]" placeholder="NIM" oninput="this.value=this.value.slice(0,12)"></div>
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

    const pengajuanForm = document.getElementById("pengajuanForm");
    if (pengajuanForm) {
        pengajuanForm.addEventListener("submit", function(event) {
            if (!validateStep1("pengajuanForm") || !validateAnggota()) {
                event.preventDefault();
            }
        });
    }

    const editForm = document.getElementById("editPengajuanForm");
    if (editForm) {
        editForm.addEventListener("submit", function(event) {
            console.log("Validasi form editPengajuanForm dimulai");
            if (!validateStep1("editPengajuanForm")) {
                console.log("Validasi gagal, form tidak di-submit");
                event.preventDefault();
            } else {
                console.log("Validasi berhasil, form akan di-submit");
            }
        });
    }

    window.nextStep = nextStep;
    window.prevStep = prevStep;
    window.checkEmail = checkEmail;
});
</script>