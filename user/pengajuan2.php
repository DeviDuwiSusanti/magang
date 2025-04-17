<?php

// Pengecekan apakah user sudah punya pengajuan atau belum
if (isset($_SESSION['email'])  && isset($_SESSION['id_user'])) {
    $email = $_SESSION['email'];
    $id_user = $_SESSION['id_user']; // Ambil id_user dari sesi login
    if (cekStatusUser($id_user) == 'Anggota'){?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php
        showAlert('Peringatan!', 'Kamu Sudah Menjadi Anggota Yang Sudah Terdaftar.', 'warning', "../web/lowongan.php");
        exit();
    }else if (isset($_SESSION['status_pengajuan']) && !isset($_GET['id_pengajuanEdit'])){
        if (cekStatusUser($id_user) == 'Ketua' && $_SESSION['status_pengajuan'] == '1' || $_SESSION['status_pengajuan'] == '4'){?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <?php
            showAlert('Peringatan!', 'Kamu Sudah Mengajukan Pengajuan Magang Atau Kamu Sudah Punya Kegiatan Magang Yang Masih Berlangsung.', 'warning', "../web/lowongan.php");
            exit();
        }
    }
} else {
    echo "<script> window.location.href='../login.php' </script>";
    exit;
}

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



<!-- Modal -->

<div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengajuanModalLabel">Tambah Pengajuan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-container" id="formContainer">
                    <div class="form-wrapper" id="formWrapper">
                        <form id="pengajuanForm" class="form-profile" method="POST" enctype="multipart/form-data">
                            <div id="step1">
                                <h4>Step 1: Daftar Pengajuan</h4>
                                <div class="mb-3">
                                    <label for="instansi" class="form-label">Instansi yang Dituju</label>
                                    <select class="form-control select2" name="id_instansi" id="instansi" style="width: 100%;">
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

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pelaksanaan</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder="-- mulai --">
                                        <span class="align-self-center">-</span>
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- js tambah anggota baru -->
<?php if (isset($_GET['pengajuanBaru'])): ?>
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
<?php endif; ?>

