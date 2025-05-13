<?php
include '../layout/sidebarUser.php';
include "functions.php";

// Get all pengajuan being supervised by this pembimbing
$pengajuan_list = query("SELECT id_pengajuan, id_user, status_pengajuan, tanggal_selesai, tanggal_extend 
                         FROM tb_pengajuan 
                         WHERE id_pembimbing = '$id_user' 
                         AND (status_pengajuan = '5' OR status_pengajuan = '2' OR status_pengajuan = '4')");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["upload"])) {
        if (pembimbing_input_nilai($_POST)) {
            echo "<script>alert_berhasil_gagal_super_admin('success', 'Berhasil !!', 'Input Nilai Berhasil', 'pembimbing4.php');</script>";
        } else {
            echo "<script>alert_berhasil_gagal_super_admin('error', 'Gagal !!', 'Input Nilai Gagal', 'pembimbing4.php');</script>";
        }
    }

    if (isset($_POST["update"])) {
        if (pembimbing_update_nilai($_POST)) {
            echo "<script>alert_berhasil_gagal_super_admin('success', 'Berhasil !!', 'Update Nilai Berhasil', 'pembimbing4.php');</script>";
        } else {
            echo "<script>alert_berhasil_gagal_super_admin('error', 'Gagal !!', 'Update Nilai Gagal', 'pembimbing4.php');</script>";
        }
    }

    if (isset($_POST["verify_logbooks"])) {
        $selected_logbooks = $_POST["selected_logbooks"] ?? [];
        if (!empty($selected_logbooks)) {
            $success = true;
            foreach ($selected_logbooks as $logbook_id) {
                $query = "UPDATE tb_logbook SET status_active = '2' WHERE id_logbook = '$logbook_id'";
                if (!mysqli_query($conn, $query)) $success = false;
            }
            echo $success ?
                "<script>alert_berhasil_gagal_super_admin('success', 'Berhasil !!', 'Logbook berhasil diverifikasi', 'pembimbing4.php');</script>" :
                "<script>alert_berhasil_gagal_super_admin('error', 'Gagal !!', 'Terjadi kesalahan saat memverifikasi logbook', 'pembimbing4.php');</script>";
        } else {
            echo "<script>alert_berhasil_gagal_super_admin('warning', 'Peringatan !!', 'Tidak ada logbook yang dipilih', 'pembimbing4.php');</script>";
        }
    }

    if (isset($_POST["extend"])) {
        $id_pengajuan = $_POST["id_pengajuan"];
        $new_end_date = $_POST["new_end_date"];
        $query = "UPDATE tb_pengajuan SET tanggal_extend = '$new_end_date', change_by = '$id_user', change_date = NOW() 
                  WHERE id_pengajuan = '$id_pengajuan'";
        echo mysqli_query($conn, $query) ?
            "<script>alert_berhasil_gagal_super_admin('success', 'Berhasil !!', 'Perpanjangan waktu berhasil disimpan', 'pembimbing4.php');</script>" :
            "<script>alert_berhasil_gagal_super_admin('error', 'Gagal !!', 'Terjadi kesalahan saat menyimpan perpanjangan waktu', 'pembimbing4.php');</script>";
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Anggota Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Berikut adalah anggota peserta magang yang Anda bimbing</li>
        </ol>
    </div>

    <?php if (!empty($pengajuan_list)) : ?>
        <?php foreach ($pengajuan_list as $pengajuan): ?>
            <?php
            $pengajuan_user = $pengajuan["id_pengajuan"];
            $user_id = $pengajuan["id_user"]; // This is the user who submitted the pengajuan
            $status_pengajuan = $pengajuan["status_pengajuan"];
            
            // Convert status to readable format
            if($status_pengajuan == 2) {
                $status_pengajuan = "Diterima";
            } else if ($status_pengajuan == 4) {
                $status_pengajuan = "Berlangsung";
            } else if($status_pengajuan == 5) {
                $status_pengajuan = "Selesai";
            }
            
            $tanggal_selesai = $pengajuan["tanggal_selesai"];
            $tanggal_extend = $pengajuan["tanggal_extend"];

            // Get all anggota for this pengajuan
            $daftar_anggota = query("SELECT pu.id_user, pu.nama_user, pu.gambar_user, u.email, pu.id_pendidikan
                                   FROM tb_profile_user pu 
                                   JOIN tb_user u ON pu.id_user = u.id_user 
                                   WHERE pu.id_pengajuan = '$pengajuan_user' AND pu.status_active = '1'");

            $show_extend_button = false;
            $show_extend_info = false;

            // Only show extend options if magang is not yet completed
            if ($pengajuan["status_pengajuan"] != '5' && !empty($tanggal_selesai)) {
                $current_date = new DateTime();
                $end_date = new DateTime($tanggal_selesai);
                $interval = $current_date->diff($end_date);

                if ($end_date > $current_date && $interval->days < 14) {
                    $show_extend_button = true;
                }

                if (!empty($tanggal_extend)) {
                    $show_extend_info = true;
                }
            }
            ?>

            <div class="container mt-5">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white fw-bold">
                        Pengajuan ID: <?= $pengajuan_user ?> &nbsp; | &nbsp; Status: <?= $status_pengajuan ?>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($daftar_anggota)) : ?>
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Foto</th>
                                        <th>Pendidikan</th>
                                        <th>Jurusan</th>
                                        <th>Logbook</th>
                                        <th>Laporan</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($daftar_anggota as $anggota) :
                                        // Get pendidikan info for each anggota
                                        $pendidikan_data = [];
                                        if (!empty($anggota['id_pendidikan'])) {
                                            $pendidikan_data = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '" . $anggota['id_pendidikan'] . "'");
                                            $pendidikan_data = $pendidikan_data[0] ?? [];
                                        }
                                        
                                        // Check if nilai already exists
                                        $check_nilai = query("SELECT * FROM tb_nilai WHERE id_user = '" . $anggota['id_user'] . "' AND id_pengajuan = '$pengajuan_user' AND status_active = '1'");
                                        $nilai_exists = !empty($check_nilai);
                                        $nilai_data = $nilai_exists ? $check_nilai[0] : null;

                                        // Count unseen logbooks
                                        $logbook_unseen = query("SELECT COUNT(*) as total FROM tb_logbook 
                                                                 WHERE id_user = '" . $anggota['id_user'] . "' 
                                                                 AND id_pengajuan = '$pengajuan_user'
                                                                 AND status_active = '1'");
                                        $unseen_count = $logbook_unseen[0]['total'];

                                        // Check if laporan exists
                                        $check_laporan = query("SELECT id_dokumen, file_path FROM tb_dokumen 
                                                                WHERE jenis_dokumen = '3' 
                                                                AND id_user = '" . $anggota['id_user'] . "' 
                                                                AND status_active = '1'");
                                        $laporan_exists = !empty($check_laporan);
                                        $laporan_data = $laporan_exists ? $check_laporan[0] : null;
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $anggota["nama_user"] ?></td>
                                            <td><?= $anggota["email"] ?></td>
                                            <td><img src="../assets/img/user/<?= $anggota["gambar_user"] ?: 'avatar.png' ?>" width="50" class="rounded-circle"></td>
                                            <td><?= $pendidikan_data['nama_pendidikan'] ?? '-' ?></td>
                                            <td><?= $pendidikan_data['jurusan'] ?? '-' ?></td>
                                            <td>
                                                <button class="btn btn-info btn-sm openLogbook"
                                                    data-id_pengajuan="<?= $pengajuan_user ?>"
                                                    data-id_user="<?= $anggota['id_user'] ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#logbookModal">
                                                    <i class="bi bi-book"></i>
                                                    <?php if ($unseen_count > 0): ?>
                                                        <span class="badge bg-danger"><?= $unseen_count ?></span>
                                                    <?php endif; ?>
                                                </button>
                                            </td>
                                            <td>
                                                <?php if ($laporan_exists) : ?>
                                                    <a href="../<?= $pengajuan_user ?>/<?= $laporan_data['file_path'] ?>" target="_blank" class="btn btn-success btn-sm">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </a>
                                                <?php else : ?>
                                                    <span class="badge bg-secondary">Belum Upload</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!$nilai_exists) : ?>
                                                    <button class="btn btn-success btn-sm openNilai"
                                                        data-id_pengajuan="<?= $pengajuan_user ?>"
                                                        data-id_user="<?= $anggota['id_user'] ?>"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="<?= ($pengajuan['status_pengajuan'] == '5' && $laporan_exists) ? '#nilaiModal' : '' ?>"
                                                        <?= ($pengajuan['status_pengajuan'] != '5' || !$laporan_exists) ? 'disabled' : '' ?>
                                                        title="<?= ($pengajuan['status_pengajuan'] != '5') ? 'Magang belum selesai' : (!$laporan_exists ? 'Peserta belum upload laporan' : 'Input Nilai') ?>">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                <?php else : ?>
                                                    <button class="btn btn-primary btn-sm viewNilai"
                                                        data-id_nilai="<?= $nilai_data['id_nilai'] ?>"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewNilaiModal">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <?php if (empty($nilai_data["tanda_tangan_admin"])) : ?>
                                                        <button class="btn btn-warning btn-sm editNilai"
                                                            data-id_nilai="<?= $nilai_data['id_nilai'] ?>"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editNilaiModal">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <?php if ($pengajuan['status_pengajuan'] != '5'): ?>
                                <?php if ($show_extend_button || $show_extend_info): ?>
                                    <div class="alert <?= $show_extend_info ? 'alert-info' : 'alert-warning' ?>">
                                        <?php if ($show_extend_info): ?>
                                            <h5><i class="bi bi-info-circle-fill"></i> Tanggal Perpanjangan</h5>
                                            <p>Tanggal awal: <strong><?= date('d F Y', strtotime($tanggal_selesai)) ?></strong></p>
                                            <p>Perpanjangan: <strong><?= date('d F Y', strtotime($tanggal_extend)) ?></strong></p>
                                            <button class="btn btn-warning btn-sm editExtendBtn"
                                                data-id_pengajuan="<?= $pengajuan_user ?>"
                                                data-tanggal_selesai="<?= $tanggal_selesai ?>"
                                                data-tanggal_extend="<?= $tanggal_extend ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#extendModal">
                                                <i class="bi bi-pencil"></i> Edit Perpanjangan
                                            </button>
                                        <?php elseif ($show_extend_button): ?>
                                            <p><i class="bi bi-hourglass-split"></i> Magang akan selesai: <strong><?= date('d F Y', strtotime($tanggal_selesai)) ?></strong></p>
                                            <button class="btn btn-primary btn-sm addExtendBtn"
                                                data-id_pengajuan="<?= $pengajuan_user ?>"
                                                data-tanggal_selesai="<?= $tanggal_selesai ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#extendModal">
                                                <i class="bi bi-calendar-plus"></i> Perpanjang Waktu
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle-fill"></i> Magang selesai: <strong><?= date('d F Y', strtotime($tanggal_selesai)) ?></strong>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        <?php else : ?>
                            <div class="alert alert-warning">Belum ada anggota aktif.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="container mt-5">
            <div class="alert alert-warning text-center">
                Tidak ada data pengajuan yang dibimbing.
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal untuk Input Nilai -->
<div class="modal fade" id="nilaiModal" tabindex="-1" aria-labelledby="nilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="nilaiForm" method="POST">
            <input type="hidden" id="nilai_id_pengajuan" name="id_pengajuan">
            <input type="hidden" id="nilai_id_user" name="id_user">
            <input type="hidden" name="upload" value="1">
            <input type="hidden" name="create_by" value="<?= $id_user ?>">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nilaiModalLabel">Input Nilai Peserta Magang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kehadiran/Absensi (0-100)</label>
                            <input type="number" class="form-control" name="kehadiran" min="0" max="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ketepatan Waktu/Disiplin (0-100)</label>
                            <input type="number" class="form-control" name="disiplin" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggung Jawab Terhadap Tugas (0-100)</label>
                            <input type="number" class="form-control" name="tanggung_jawab" min="0" max="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kreativitas (0-100)</label>
                            <input type="number" class="form-control" name="kreativitas" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kerjasama Tim (0-100)</label>
                            <input type="number" class="form-control" name="kerjasama" min="0" max="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kemampuan Penggunaan TI (0-100)</label>
                            <input type="number" class="form-control" name="teknologi_informasi" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan/Komentar</label>
                        <textarea class="form-control" name="catatan" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal untuk View Nilai -->
<div class="modal fade" id="viewNilaiModal" tabindex="-1" aria-labelledby="viewNilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNilaiModalLabel">Detail Nilai Peserta Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewNilaiContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Nilai -->
<div class="modal fade" id="editNilaiModal" tabindex="-1" aria-labelledby="editNilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editNilaiForm" method="POST">
            <input type="hidden" id="edit_id_nilai" name="id_nilai">
            <input type="hidden" name="update" value="1">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNilaiModalLabel">Edit Nilai Peserta Magang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editNilaiContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update Nilai</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal untuk Logbook -->
<div class="modal fade" id="logbookModal" tabindex="-1" aria-labelledby="logbookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logbookModalLabel">Logbook Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="logbookForm" method="POST" action="pembimbing4.php">
                <div class="modal-body" id="logbookContent">
                    <!-- Content akan diisi via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="verify_logbooks">Verifikasi yang Dipilih</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Perpanjangan Waktu -->
<div class="modal fade" id="extendModal" tabindex="-1" aria-labelledby="extendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="extendForm" method="POST">
            <input type="hidden" id="extend_id_pengajuan" name="id_pengajuan">
            <input type="hidden" name="extend" value="1">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="extendModalLabel">Perpanjangan Waktu Magang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Tanggal selesai magang sebelumnya: <strong id="current_end_date"></strong></p>
                        <?php if (!empty($tanggal_extend)): ?>
                            <p>Tanggal perpanjangan saat ini: <strong id="current_extend_date"></strong></p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="new_end_date" class="form-label">Tanggal Selesai Baru</label>
                        <input type="date" class="form-control" id="new_end_date" name="new_end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('table').each(function() {
            $(this).DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthMenu: [5, 10],
                columnDefs: [{
                    orderable: false,
                    targets: [3, 6, 7, 8]
                }],
                language: {
                    search: "Cari : ",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });

        // Untuk Nilai Modal
        $('.openNilai').click(function() {
            const idPengajuan = $(this).data('id_pengajuan');
            const idUser = $(this).data('id_user');
            $('#nilai_id_pengajuan').val(idPengajuan);
            $('#nilai_id_user').val(idUser);
        });

        // View Nilai Modal
        $('.viewNilai').click(function() {
            const idNilai = $(this).data('id_nilai');
            $.ajax({
                url: 'pembimbing4_penilaian.php',
                type: 'GET',
                data: {
                    id_nilai: idNilai,
                    action: 'view'
                },
                success: function(response) {
                    $('#viewNilaiContent').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading nilai:", error);
                    $('#viewNilaiContent').html('<div class="alert alert-danger">Gagal memuat data nilai</div>');
                }
            });
        });

        // Edit Nilai Modal
        $('.editNilai').click(function() {
            const idNilai = $(this).data('id_nilai');
            $.ajax({
                url: 'pembimbing4_penilaian.php',
                type: 'GET',
                data: {
                    id_nilai: idNilai,
                    action: 'edit'
                },
                success: function(response) {
                    $('#editNilaiContent').html(response);
                    $('#edit_id_nilai').val(idNilai);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading edit form:", error);
                    $('#editNilaiContent').html('<div class="alert alert-danger">Gagal memuat form edit</div>');
                }
            });
        });

        // Logbook Modal
        $('.openLogbook').click(function() {
            const idPengajuan = $(this).data('id_pengajuan');
            const idUser = $(this).data('id_user');

            $.ajax({
                url: 'pembimbing4_view_logbook_peserta.php',
                type: 'GET',
                data: {
                    id_pengajuan: idPengajuan,
                    id_user: idUser,
                    id_pembimbing: <?= $id_user ?>
                },
                success: function(response) {
                    $('#logbookContent').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading logbooks:", error);
                    $('#logbookContent').html('<div class="alert alert-danger">Gagal memuat logbook</div>');
                }
            });
        });

        // Untuk Tambah Perpanjangan Modal
        $('.addExtendBtn').click(function() {
            const idPengajuan = $(this).data('id_pengajuan');
            const tanggalSelesai = $(this).data('tanggal_selesai');
            
            $('#extend_id_pengajuan').val(idPengajuan);
            $('#current_end_date').text(formatDate(tanggalSelesai));
            $('#new_end_date').attr('min', tanggalSelesai);
            $('#new_end_date').val('');
        });

        // Untuk Edit Perpanjangan Modal
        $('.editExtendBtn').click(function() {
            const idPengajuan = $(this).data('id_pengajuan');
            const tanggalSelesai = $(this).data('tanggal_selesai');
            const tanggalExtend = $(this).data('tanggal_extend');
            
            $('#extend_id_pengajuan').val(idPengajuan);
            $('#current_end_date').text(formatDate(tanggalSelesai));
            $('#current_extend_date').text(formatDate(tanggalExtend));
            $('#new_end_date').attr('min', tanggalSelesai);
            $('#new_end_date').val(tanggalExtend);
        });

        // Format tanggal untuk tampilan
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        // Handle form submission dengan SweetAlert
        $('#extendForm').submit(function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Perpanjangan',
                text: "Anda yakin ingin memperpanjang waktu magang untuk kelompok ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Perpanjang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika dikonfirmasi
                    this.submit();
                }
            });
        });
    });
</script>