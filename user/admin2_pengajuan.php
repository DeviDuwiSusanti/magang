<?php
include '../layout/sidebarUser.php';
include "functions.php";
include "update_status.php";

$id_instansi = $_SESSION['id_instansi'];
$id_admin = $_SESSION['id_user'];

// Query untuk data pengajuan
$data_pengajuan = getDataPengajuanByInstansi($conn, $id_instansi);

// Query untuk daftar nama pengaju
$nama_pengaju = getNamaPelamarByPengajuan($conn, $id_instansi);
$json_nama_pengaju = json_encode($nama_pengaju);

// Query untuk daftar dokumen
$daftar_dokumen = getDokumenByInstansi($conn, $id_instansi);

// Query untuk verifikasi dokumen   
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi_verifikasi_dokumen'])) {
    $id_pengajuan = intval($_POST['id_pengajuan']);

    // Query update langsung
    $query = "UPDATE tb_pengajuan SET dokumen_lengkap = 1, change_by = $id_admin WHERE id_pengajuan = $id_pengajuan";
    $result = mysqli_query($conn, $query);
    exit;
}

?>

<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.worker.min.js';
</script>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mt-3">Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Daftar Pengajuan User</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="datatable-header mb-2"></div>
            <div class="bungkus-2 datatable-scrollable">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Pengaju</th>
                            <th class="text-center">Nama Bidang</th>
                            <th class="text-center">Detail Pengajuan</th>
                            <th class="text-center">Calon Pelamar</th>
                            <th class="text-center">Tanggal Wawancara</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Dokumen Lengkap</th>
                            <th style="width: 200px; text-align: center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        foreach ($data_pengajuan as $row): ?>
                            <?php
                            $id_pengajuan = $row['id_pengajuan'];
                            $status_pengajuan = $row['status_pengajuan'];
                            $bidang = $row['nama_bidang'];
                            $id_bidang = $row['id_bidang'];
                            $jenis_pengajuan = $row['jenis_pengajuan'];
                            $dokumen_lengkap = $row['dokumen_lengkap'];
                            $tanggal_mulai = new DateTime($row['tanggal_mulai']);
                            $tanggal_selesai = new DateTime($row['tanggal_selesai']);
                            $durasi_magang = hitungDurasi($row['tanggal_mulai'], $row['tanggal_selesai']);
                            $kuota_bidang = $row['kuota_bidang'];
                            $jumlah_pemagang_aktif = $row['jumlah_pemagang_aktif'];
                            $jumlah_pelamar = $row['jumlah_pelamar'];
                            ?>

                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_user']) ?></td>
                                <td><?= htmlspecialchars($row['nama_bidang']) ?></td>

                                <!-- Tombol Detail -->
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail<?= $row['id_pengajuan']; ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                </td>

                                <!-- Jumlah Pelamar -->
                                <td class="text-center align-middle">
                                    <a href="#" class="show-detail" title="Lihat Detail"
                                        data-detail='<?= isset($nama_pengaju[$id_pengajuan])
                                                            ? json_encode(explode(', ', $nama_pengaju[$id_pengajuan]))
                                                            : '[]' ?>'>
                                        <?= isset($nama_pengaju[$id_pengajuan])
                                            ? count(explode(', ', $nama_pengaju[$id_pengajuan]))
                                            : 0 ?>
                                    </a>
                                </td>

                                <!-- Tanggal Zoom -->
                                <td class="text-center align-middle">
                                    <?= $row['tanggal_zoom'] ? htmlspecialchars(formatTanggalLengkapIndonesia($row['tanggal_zoom'])) : '-' ?>
                                </td>

                                <!-- Status Pengajuan -->
                                <td class="text-center align-middle">
                                    <?php
                                    $status = '';
                                    $badgeClass = '';
                                    if ($row['status_pengajuan'] == 1 && is_null($row['tanggal_zoom'])) {
                                        $status = 'Belum Ditanggapi';
                                        $badgeClass = 'badge bg-secondary';
                                    } elseif ($row['status_pengajuan'] == 1 && !is_null($row['tanggal_zoom']) && $row['tanggal_zoom'] >= date('Y-m-d')) {
                                        $status = 'Wawancara Dikirim';
                                        $badgeClass = 'badge bg-info';
                                    } elseif ($row['status_pengajuan'] == 1 && $row['tanggal_zoom'] < date('Y-m-d')) {
                                        $status = 'Menunggu Keputusan';
                                        $badgeClass = 'badge bg-warning';
                                    } elseif ($row['status_pengajuan'] == 2 && $row['tanggal_mulai'] > date('Y-m-d')) {
                                        $status = 'Diterima';
                                        $badgeClass = 'badge bg-success';
                                    }
                                    echo "<span class='$badgeClass'>$status</span>";
                                    ?>
                                </td>

                                <!-- Dokumen Lengkap -->
                                <td class="text-center align-middle" id="dokumen-cell-<?= $id_pengajuan ?>">
                                    <?php if ($dokumen_lengkap == 1): ?>
                                        <span class="badge bg-success">Dokumen Lengkap</span>
                                    <?php else: ?>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input dokumen-checkbox"
                                                type="checkbox"
                                                value=""
                                                data-id-pengajuan="<?= $id_pengajuan ?>"
                                                data-status-pengajuan="<?= $status_pengajuan ?>"
                                                style="width: 1.2em; height: 1.2em;">
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Aksi -->
                                <td class="text-center align-middle">
                                    <a href="#"
                                        class="show-doc btn btn-sm btn-primary me-2"
                                        title="Lihat Dokumen"
                                        data-doc='<?= htmlspecialchars(json_encode(
                                                        $daftar_dokumen[$row['id_user']][$id_pengajuan] ?? [],
                                                        JSON_UNESCAPED_SLASHES
                                                    ), ENT_QUOTES, "UTF-8") ?>'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <?php
                                    $today = date('Y-m-d');
                                    $tanggal_zoom = $row['tanggal_zoom'];
                                    $harusDisable = (!empty($tanggal_zoom) && $tanggal_zoom !== '0000-00-00' && $tanggal_zoom < $today);
                                    $btn_class = $harusDisable ? 'btn-secondary' : 'btn-info';
                                    $disabled = $harusDisable ? 'disabled' : '';
                                    $title = (!empty($tanggal_zoom) && $tanggal_zoom !== '0000-00-00')
                                        ? 'Informasi Zoom sudah dikirim'
                                        : 'Tambah Informasi Wawancara';
                                    ?>
                                    <button type="button"
                                        class="btn <?= $btn_class ?> btn-sm me-2 zoom-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#zoomModal"
                                        data-pengajuan-id="<?= $id_pengajuan ?>"
                                        <?= $disabled ?>
                                        title="<?= $title ?>">
                                        <i class="bi bi-zoom-in"></i>
                                    </button>

                                    <?php
                                    $bisaProses = (!empty($tanggal_zoom) && $tanggal_zoom !== '0000-00-00' && $tanggal_zoom < $today && $dokumen_lengkap != 1);
                                    $btnClass = $bisaProses ? 'btn-success' : 'btn-secondary';
                                    $disabled = $bisaProses ? '' : 'disabled';
                                    ?>
                                    <button class="btn <?= $btnClass ?> btn-sm aksi-btn me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#aksiModal"
                                        data-id="<?= $id_pengajuan ?>"
                                        data-status="<?= $status_pengajuan ?>"
                                        data-bidang="<?= htmlspecialchars($bidang) ?>"
                                        data-jenis="<?= htmlspecialchars($jenis_pengajuan) ?>"
                                        data-durasi="<?= $durasi_magang ?>"
                                        data-kuota-awal="<?= $kuota_bidang ?>"
                                        data-pemagang-aktif="<?= $jumlah_pemagang_aktif ?>"
                                        data-jumlah-pelamar="<?= $jumlah_pelamar ?>"
                                        <?= $disabled ?>
                                        title="Proses Pengajuan">
                                        <i class="bi bi-ui-checks"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Detail Pengajuan -->
                            <div class="modal fade" id="modalDetail<?= $row['id_pengajuan']; ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $row['id_pengajuan']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel<?= $row['id_pengajuan']; ?>">Detail Pengajuan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Nama Pengaju:</strong> <?= htmlspecialchars($row['nama_user'] ?? "Tidak Diketahui"); ?></p>
                                            <p><strong>Instansi:</strong> <?= htmlspecialchars($row['nama_panjang'] ?? "Tidak Diketahui"); ?></p>
                                            <p><strong>Bidang:</strong> <?= htmlspecialchars($row['nama_bidang'] ?? "Tidak Diketahui"); ?></p>
                                            <p><strong>Jenis Pengajuan:</strong> <?= htmlspecialchars($row['jenis_pengajuan'] ?? "Tidak Diketahui"); ?></p>
                                            <p><strong>Durasi:</strong> <?= isset($row['tanggal_mulai'], $row['tanggal_selesai']) ? hitungDurasi($row['tanggal_mulai'], $row['tanggal_selesai']) : "Tidak Diketahui"; ?></p>
                                            <p><strong>Periode Magang:</strong> <?= isset($row['tanggal_mulai'], $row['tanggal_selesai']) ? formatPeriode($row['tanggal_mulai'], $row['tanggal_selesai']) : "Tidak Diketahui"; ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="datatable-footer mt-2"></div>
        </div>
    </div>
</div>


<?php include "../layout/footerDashboard.php" ?>

<!-- Modal Dokumen -->
<div class="modal fade" id="docModal" tabindex="-1" aria-labelledby="docModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="docModalLabel">Dokumen Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mb-3" id="docList" style="max-height: 600px; overflow-y: auto;">
                        <!-- List dokumen akan diisi via JS -->
                    </div>
                    <div class="col-md-8" id="docPreview" style="min-height: 400px; text-align: center;">
                        <p class="text-muted mt-5">Pilih dokumen untuk melihat preview.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Proses Pengajuan -->
<div class="modal fade" id="aksiModal" tabindex="-1" aria-labelledby="aksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aksiModalLabel">Proses Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info align-items-center" role="alert" id="prosesInfo" style="display: none;">
                    <div>
                        <strong>Harap Tunggu!</strong> Sistem sedang mengirimkan notifikasi email. Proses ini mungkin membutuhkan waktu beberapa detik. Jangan tutup atau reload halaman sampai proses selesai.
                    </div>
                </div>
                <form id="formAksiPengajuan">
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="radioTerima" value="terima">
                        <label class="form-check-label" for="radioTerima">Terima Pengajuan</label>
                    </div>
                    <div id="infoResumePengajuan" class="resume-container" style="display: none;">
                        <h6 class="resume-header">
                            <i class="bi bi-info-circle-fill"></i>
                            Informasi Pengajuan
                        </h6>
                        <ul class="resume-list">
                            <li><strong>Bidang:</strong> <span id="resumeBidang"></span></li>
                            <li><strong>Jenis Pengajuan:</strong> <span id="resumeJenis"></span></li>
                            <li><strong>Durasi Magang:</strong> <span id="resumeDurasi"></span></li>
                            <li><strong>Kuota Tersisa:</strong> <span id="resumeKuotaTersisa" class="kuota-highlight"></span></li>
                            <li><strong>Jumlah Pelamar:</strong> <span id="resumeJumlahPelamar" class="kuota-highlight"></span></li>
                        </ul>
                    </div>
                    <!-- Tambahkan select pembimbing di sini -->
                    <div class="mt-3" id="pembimbingContainer" style="display: none;">
                        <label for="pembimbing" class="form-label">Pilih Pembimbing</label>
                        <select class="form-select" id="pembimbing" name="pembimbing">
                            <option value="">-- Pilih Pembimbing --</option>
                            <!-- Options akan diisi via JavaScript -->
                        </select>
                        <small class="text-muted">*Pilih pembimbing yang tersedia</small>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="radioTolak" value="tolak">
                        <label class="form-check-label" for="radioTolak">Tolak Pengajuan</label>
                    </div>
                    <div id="alasanTolakContainer" class="mt-3" style="display: none;">
                        <label for="alasan_tolak" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="alasan_tolak" name="alasan_tolak" rows="3" placeholder="Tuliskan alasan penolakan..."></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Informasi Zoom -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomModalLabel">Informasi Wawancara Online</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info align-items-center" role="alert" id="zoomInfo" style="display: none;">
                    <div>
                        <strong>Mohon Tunggu!</strong> Sistem sedang mengirimkan informasi wawancara. Proses ini mungkin memerlukan waktu beberapa detik. Jangan tutup atau reload halaman sampai proses selesai.
                    </div>
                </div>
                <form id="zoomForm" onsubmit="return validateZoomForm()">
                    <input type="hidden" name="pengajuan_id" id="pengajuan_id_zoom">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                            <input type="text" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" autocomplete="off">
                            <small class="text-danger" id="tanggal_pelaksanaan_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jam_pelaksanaan" class="form-label">Jam Pelaksanaan</label>
                            <div class="input-group clockpicker">
                                <input type="text" class="form-control" id="jam_pelaksanaan" name="jam_pelaksanaan" autocomplete="off">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            </div>
                            <small class="text-danger" id="jam_pelaksanaan_error"></small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="link_zoom" class="form-label">Link Meet</label>
                        <input type="url" class="form-control" id="link_zoom" name="link_zoom" placeholder="Masukkan link meet">
                        <small class="text-muted">*Link harus berasal dari Zoom atau Google Meet</small> <br>
                        <small class="text-danger" id="link_zoom_error"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitButton">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/validasi.js"></script>

<script>
    // ========== Validasi Checkbox Dokumen ==========
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.dokumen-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const pengajuanId = this.getAttribute('data-id-pengajuan');
                const statusPengajuan = this.getAttribute('data-status-pengajuan');
                const cell = document.getElementById('dokumen-cell-' + pengajuanId);

                if (statusPengajuan != '2') {
                    this.checked = false; // kembalikan centang
                    Swal.fire({
                        icon: 'info',
                        title: 'Belum Bisa Diverifikasi',
                        text: 'Verifikasi dokumen hanya bisa dilakukan setelah pengajuan diterima.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin dokumen persyaratan sudah lengkap?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lengkap',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('aksi_verifikasi_dokumen', '1');
                        formData.append('id_pengajuan', pengajuanId);

                        fetch('', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.text())
                            .then(response => {
                                cell.innerHTML = `<span class="badge bg-success">Dokumen Lengkap</span>`;
                                Swal.fire('Sukses', 'Dokumen berhasil diverifikasi.', 'success')
                                    .then((result) => {
                                        if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer || result.dismiss === Swal.DismissReason.backdrop) {
                                            window.location.reload();
                                        }
                                    });
                            })
                            .catch(err => {
                                console.error('Error:', err);
                                Swal.fire('Gagal', 'Terjadi kesalahan saat memverifikasi.', 'error');
                            });
                    } else {
                        this.checked = false;
                    }
                });
            });
        });
    });

    // ========== Inisialisasi Select2 pada Modal Zoom ==========
    $('#zoomModal').on('shown.bs.modal', function() {
        $('#pembimbing').select2({
            dropdownParent: $('#zoomModal'),
            placeholder: "Pilih Pembimbing",
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0
        });
    });

    // ========== Fungsi untuk mengirim pengingat lengkapi dokumen ==========
    document.addEventListener("DOMContentLoaded", function() {
        const pengingatButtons = document.querySelectorAll(".kirimPengingatBtn");

        pengingatButtons.forEach(button => {
            button.addEventListener("click", function() {
                const id = this.getAttribute("data-id");
                const email = this.getAttribute("data-email");

                Swal.fire({
                    title: 'Kirim Pengingat?',
                    // text: `Kirim pengingat lengkapi dokumen ke email ini: ${email}`,
                    text: `Kirim pengingat lengkapi dokumen ke pengajuan ini?`,
                    icon: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kirim',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('admin2_kirim_pengingat.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `id=${id}&email=${email}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message
                                }).then(() => {
                                    location.reload();
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Gagal mengirim pengingat.'
                                });
                                console.error(error);
                            });
                    }
                });
            });
        });
    });

    // ========== Fungsi untuk menampilkan modal Zoom ==========
    document.addEventListener("DOMContentLoaded", function() {
        let zoomForm = document.getElementById("zoomForm");
        let submitButton = document.getElementById("submitButton");
        let zoomInfo = document.getElementById("zoomInfo");

        $('#zoomModal').on('shown.bs.modal', function(event) {
            let button = event.relatedTarget;
            if (button) {
                let idPengajuan = button.getAttribute('data-pengajuan-id');
                document.getElementById('pengajuan_id_zoom').value = idPengajuan;
            }

            if (zoomInfo) {
                zoomInfo.style.display = "none";
            }
        });

        $('#zoomModal').on('hidden.bs.modal', function() {
            if (zoomInfo) {
                zoomInfo.style.display = "none";
            }
        });

        if (zoomForm) {
            zoomForm.addEventListener("submit", function(event) {
                event.preventDefault();

                // Cek validasi form dulu
                if (!validateZoomForm()) {
                    return;
                }

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Informasi Zoom akan dikirim!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Kirim!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (zoomInfo) {
                            zoomInfo.style.display = "block";
                        }

                        let formData = new FormData(zoomForm);
                        let urlEncodedData = new URLSearchParams();
                        formData.forEach((value, key) => urlEncodedData.append(key, value));

                        let xhr = new XMLHttpRequest();
                        xhr.open("POST", "admin2_simpan_zoom.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        xhr.onload = function() {
                            if (zoomInfo) {
                                zoomInfo.style.display = "none";
                            }

                            if (xhr.status == 200) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Informasi Zoom telah dikirim.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan, coba lagi.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        };

                        xhr.onerror = function() {
                            if (zoomInfo) {
                                zoomInfo.style.display = "none";
                            }

                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Tidak dapat menghubungi server.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        };

                        xhr.send(urlEncodedData.toString());
                    }
                });
            });
        }
    });

    // ========== Inisialisasi tooltip secara global ==========
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    //  ========== Inisialisasi DataTable secara global ==========
    $(document).ready(function() {
        // Cek apakah sedang di mobile untuk scrollX
        var isMobile = window.innerWidth < 768;

        var table = $('#myTable').DataTable({
            scrollX: isMobile,
            responsive: true,
            dom: '<"datatable-header row mb-2"' +
                '<"col-md-6 text-md-start text-center"l>' +
                '<"col-md-6 text-md-end text-center d-flex justify-content-end align-items-center gap-2"f>' +
                '>t' +
                '<"datatable-footer row mt-2"' +
                '<"col-md-6 text-md-start text-center"i>' +
                '<"col-md-6 text-md-end text-center"p>' +
                '>',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                emptyTable: "Tidak ada data pengajuan yang tersedia",
                zeroRecords: "Tidak ada data pengajuan yang cocok",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            },
            columnDefs: [{
                targets: [2, 3, 4, 5, 6, 7, 8],
                orderable: false
            }]
        });

        // ========== Inisialisasi Clockpicker & datepicker ==========
        $('.clockpicker').clockpicker({
            autoclose: true,
            donetext: 'Pilih'
        });
        $("#tanggal_pelaksanaan").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0
        });


        // Event handler untuk tombol "show-detail" pelamar
        $('#myTable tbody').on('click', 'a.show-detail', function(e) {
            e.preventDefault();

            const detailData = $(this).data('detail');
            const tr = $(this).closest('tr');
            const row = table.row(tr);

            // Sembunyikan detail lain jika ada
            if (!row.child.isShown()) {
                $('#myTable tbody tr.shown').not(tr).each(function() {
                    table.row(this).child.hide();
                    $(this).removeClass('shown');
                });
            }

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Generate HTML tab struktur
                let tabNav = '<ul class="nav nav-tabs mb-2" id="detailTab" role="tablist">';
                let tabContent = '<div class="tab-content">';

                detailData.forEach((name, index) => {
                    const activeClass = index === 0 ? 'active' : '';
                    const tabId = `tab-${row.index()}-${index}`;

                    tabNav += `
                <li class="nav-item" role="presentation">
                    <button class="nav-link ${activeClass}" id="${tabId}-tab" data-bs-toggle="tab" data-bs-target="#${tabId}" type="button" role="tab">${index + 1}</button>
                </li>
            `;

                    tabContent += `
                <div class="tab-pane fade ${activeClass ? 'show active' : ''}" id="${tabId}" role="tabpanel">
                    <p>${name}</p>
                </div>
            `;
                });

                tabNav += '</ul>';
                tabContent += '</div>';

                row.child(`<div>${tabNav}${tabContent}</div>`).show();
                tr.addClass('shown');
            }
        });
    });

    // ========== Event handler untuk tombol "show-doc" ==========
    document.addEventListener('DOMContentLoaded', function() {
        const docLinks = document.querySelectorAll('.show-doc');

        docLinks.forEach(link => {
            link.addEventListener('click', function() {
                let data = [];
                try {
                    data = JSON.parse(this.getAttribute('data-doc') || '[]');
                } catch (e) {
                    console.error('Gagal parse dokumen:', e);
                    data = [];
                }

                const docList = document.getElementById('docList');
                const docPreview = document.getElementById('docPreview');

                docList.innerHTML = '';
                docPreview.innerHTML = '<p class="text-muted mt-5">Pilih dokumen untuk melihat preview.</p>';

                if (!Array.isArray(data) || data.length === 0) {
                    docList.innerHTML = '<div class="alert alert-warning">Tidak ada dokumen tersedia.</div>';
                    return;
                }

                data.forEach((doc, index) => {
                    const fileName = doc.path.split('/').pop();
                    const displayName = (doc.nama || `Dokumen ${index + 1}`).toUpperCase();
                    const isPdf = doc.path.toLowerCase().endsWith('.pdf');
                    const isImage = /\.(jpg|jpeg|png|gif|webp|bmp)$/i.test(doc.path);

                    const icon = isPdf ? '📄' : isImage ? '🖼️' : '📁';

                    const docItem = document.createElement('button');
                    docItem.classList.add('list-group-item', 'list-group-item-action', 'text-start', 'mb-2', 'rounded');
                    docItem.innerHTML = `${icon} ${displayName}`;
                    docItem.style.width = '100%';
                    docItem.style.border = '1px solid #ddd';
                    docItem.style.backgroundColor = '#f9f9f9';
                    docItem.style.cursor = 'pointer';
                    docItem.setAttribute('data-path', doc.path);
                    docItem.setAttribute('data-filename', fileName);

                    docItem.addEventListener('click', function() {
                        const path = this.getAttribute('data-path');
                        const fileName = this.getAttribute('data-filename');

                        docPreview.innerHTML = '<div class="text-center mt-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat dokumen...</p></div>';

                        if (isPdf) {
                            renderPdfWithPdfJs(path, fileName, docPreview);
                        } else if (isImage) {
                            docPreview.innerHTML = `
                            <img src="${path}" alt="${fileName}" class="img-fluid rounded shadow" style="max-height: 500px;">
                            <div class="mt-2">
                                <a href="${path}" download="${fileName}" class="btn btn-sm btn-outline-secondary">Unduh Gambar</a>
                            </div>
                        `;
                        } else {
                            docPreview.innerHTML = `
                            <div class="alert alert-info">Dokumen tidak dapat dipreview. Silakan unduh untuk melihat.</div>
                            <a href="${path}" download="${fileName}" class="btn btn-outline-primary">Unduh ${fileName}</a>
                        `;
                        }
                    });

                    docList.appendChild(docItem);
                });

                // Setelah list terbuat, buka modal
                const docModal = new bootstrap.Modal(document.getElementById('docModal'));
                docModal.show();
            });
        });

        // Fungsi untuk render PDF menggunakan PDF.js
        async function renderPdfWithPdfJs(pdfUrl, fileName, container) {
            try {
                // Load PDF document
                const loadingTask = pdfjsLib.getDocument(pdfUrl);
                const pdfDocument = await loadingTask.promise;

                // Get the first page
                const page = await pdfDocument.getPage(1);

                // Set scale for rendering
                const viewport = page.getViewport({
                    scale: 1.5
                });

                // Prepare canvas
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                await page.render(renderContext).promise;

                // Clear container and append canvas
                container.innerHTML = '';

                // Create wrapper for better styling
                const wrapper = document.createElement('div');
                wrapper.style.overflow = 'auto';
                wrapper.style.maxHeight = '500px';
                wrapper.style.border = '1px solid #ddd';
                wrapper.style.borderRadius = '5px';
                wrapper.style.padding = '10px';
                wrapper.style.backgroundColor = '#f5f5f5';
                wrapper.appendChild(canvas);

                // Create download button
                const downloadBtn = document.createElement('a');
                downloadBtn.href = pdfUrl;
                downloadBtn.download = fileName;
                downloadBtn.className = 'btn btn-sm btn-primary mt-3';
                downloadBtn.innerHTML = '<i class="bi bi-download me-2"></i> Unduh PDF';

                // Create page info
                const pageInfo = document.createElement('div');
                pageInfo.className = 'text-muted small mt-2';
                pageInfo.textContent = `Halaman 1 dari ${pdfDocument.numPages}`;

                // Create navigation buttons if more than 1 page
                const navDiv = document.createElement('div');
                navDiv.className = 'd-flex justify-content-between mt-2';

                if (pdfDocument.numPages > 1) {
                    const prevBtn = document.createElement('button');
                    prevBtn.className = 'btn btn-sm btn-primary';
                    prevBtn.textContent = 'Halaman Sebelumnya';
                    prevBtn.disabled = true;

                    const nextBtn = document.createElement('button');
                    nextBtn.className = 'btn btn-sm btn-primary';
                    nextBtn.textContent = 'Halaman Berikutnya';

                    let currentPage = 1;

                    const updatePage = async (newPageNum) => {
                        if (newPageNum < 1 || newPageNum > pdfDocument.numPages) return;

                        currentPage = newPageNum;
                        prevBtn.disabled = currentPage <= 1;
                        nextBtn.disabled = currentPage >= pdfDocument.numPages;
                        pageInfo.textContent = `Halaman ${currentPage} dari ${pdfDocument.numPages}`;

                        // Remove previous canvas
                        while (wrapper.firstChild) {
                            wrapper.removeChild(wrapper.firstChild);
                        }

                        // Render new page
                        const newPage = await pdfDocument.getPage(currentPage);
                        const newViewport = newPage.getViewport({
                            scale: 1.5
                        });

                        canvas.height = newViewport.height;
                        canvas.width = newViewport.width;

                        await newPage.render({
                            canvasContext: context,
                            viewport: newViewport
                        }).promise;

                        wrapper.appendChild(canvas);
                    };

                    prevBtn.addEventListener('click', () => updatePage(currentPage - 1));
                    nextBtn.addEventListener('click', () => updatePage(currentPage + 1));

                    navDiv.appendChild(prevBtn);
                    navDiv.appendChild(nextBtn);
                }

                // Assemble all elements
                container.innerHTML = '';
                container.appendChild(wrapper);
                container.appendChild(pageInfo);
                if (pdfDocument.numPages > 1) {
                    container.appendChild(navDiv);
                }
                container.appendChild(downloadBtn);

            } catch (error) {
                console.error('Error rendering PDF:', error);
                container.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memuat dokumen PDF. Silakan coba unduh dan buka secara manual.
                </div>
                <a href="${pdfUrl}" download="${fileName}" class="btn btn-outline-primary">Unduh ${fileName}</a>
            `;
            }
        }
    });

    // ========== Event handler untuk tombol proses pengajuan ==========
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("aksiModal");
        const form = document.getElementById("formAksiPengajuan");
        const idInput = document.getElementById("id_pengajuan");
        const radioTerima = document.getElementById("radioTerima");
        const radioTolak = document.getElementById("radioTolak");
        const alasanTolak = document.getElementById("alasan_tolak");
        const alasanContainer = document.getElementById("alasanTolakContainer");
        const infoResume = document.getElementById("infoResumePengajuan");
        const pembimbingContainer = document.getElementById("pembimbingContainer"); // Tambahkan ini
        const prosesInfo = document.getElementById("prosesInfo");

        if (prosesInfo) {
            prosesInfo.style.display = "none";
        }

        // Variabel untuk menyimpan data yang akan digunakan di submit
        let sisaKuota = 0;
        let jumlahPelamar = 0;

        $('#aksiModal').on('hidden.bs.modal', function() {
            if (prosesInfo) {
                prosesInfo.style.display = "none";
            }
            form.reset();
        });

        $('#aksiModal').on('shown.bs.modal', function() {
            if (zoomInfo) {
                prosesInfo.style.display = "none";
            }
        });

        document.querySelectorAll(".aksi-btn").forEach(button => {
            button.addEventListener("click", function() {
                const id = this.getAttribute("data-id");
                const status = this.getAttribute("data-status");
                const bidang = this.getAttribute("data-bidang");
                const jenis = this.getAttribute("data-jenis");
                const durasi = this.getAttribute("data-durasi");
                const kuotaAwal = parseInt(this.getAttribute("data-kuota-awal"));
                const pemagangAktif = parseInt(this.getAttribute("data-pemagang-aktif"));
                jumlahPelamar = parseInt(this.getAttribute("data-jumlah-pelamar"));

                sisaKuota = kuotaAwal - pemagangAktif;

                // Isi elemen resume
                document.getElementById("resumeBidang").textContent = bidang;
                document.getElementById("resumeJenis").textContent = jenis;
                document.getElementById("resumeDurasi").textContent = durasi;
                document.getElementById("resumeKuotaTersisa").textContent = sisaKuota + " orang";
                document.getElementById("resumeJumlahPelamar").textContent = jumlahPelamar + " orang";

                // Reset form & isi data baru
                form.reset();
                alasanContainer.style.display = "none";
                infoResume.style.display = "none";
                pembimbingContainer.style.display = "none";
                idInput.value = id;

                pembimbingContainer.style.display = "none";

                loadPembimbing(id);

                // Atur status radio "terima" sesuai kondisi
                radioTerima.disabled = (status === "2");
            });
        });

        // Fungsi untuk memuat data pembimbing
        function loadPembimbing(idPengajuan) {
            if (prosesInfo) prosesInfo.style.display = "block";
            fetch(`admin2_proses_pengajuan.php?get_pembimbing=true&id_pengajuan=${idPengajuan}`)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('pembimbing');
                    select.innerHTML = '<option value="">-- Pilih Pembimbing --</option>';

                    data.forEach(pembimbing => {
                        const option = document.createElement('option');
                        option.value = pembimbing.id_pembimbing;
                        option.textContent = pembimbing.nama_pembimbing;
                        select.appendChild(option);
                    });
                    if (prosesInfo) prosesInfo.style.display = "none";
                })
                .catch(error => {
                    console.error('Error loading pembimbing:', error);
                    if (prosesInfo) prosesInfo.style.display = "none";
                });
        }

        // Show/hide alasan penolakan dan info resume
        radioTolak.addEventListener("change", function() {
            alasanContainer.style.display = "block";
            infoResume.style.display = "none";
            pembimbingContainer.style.display = "none";
        });

        radioTerima.addEventListener("change", function() {
            alasanContainer.style.display = "none";
            infoResume.style.display = "block";
            pembimbingContainer.style.display = "block";
        });

        if (form) {
            form.addEventListener("submit", function(e) {
                e.preventDefault();

                const id_pengajuan = idInput.value;
                const status = form.querySelector("input[name='status']:checked")?.value;
                const alasan = alasanTolak.value.trim();
                const pembimbing = document.getElementById('pembimbing')?.value;

                if (!status) {
                    Swal.fire("Pilihan Wajib!", "Silakan pilih menerima atau menolak pengajuan.", "warning");
                    return;
                }

                if (status === "tolak" && alasan === "") {
                    Swal.fire("Alasan Wajib!", "Silakan isi alasan penolakan.", "warning");
                    return;
                }

                if (status === "terima" && jumlahPelamar > sisaKuota) {
                    Swal.fire("Kuota Tidak Cukup!", "Jumlah pelamar melebihi kuota yang tersedia.", "error");
                    return;
                }

                if (status === "terima" && !pembimbing) {
                    Swal.fire("Pembimbing Wajib!", "Silakan pilih pembimbing untuk pengajuan ini.", "warning");
                    return;
                }

                Swal.fire({
                    title: "Konfirmasi",
                    text: `Anda yakin ingin ${status === 'terima' ? 'menerima' : 'menolak'} pengajuan ini?`,
                    icon: "question",
                    showCancelButton: true,
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Lanjutkan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (prosesInfo) {
                            prosesInfo.style.display = "block";
                        }

                        const formData = new FormData();
                        formData.append('id_pengajuan', id_pengajuan);
                        formData.append('status', status);
                        if (status === "tolak") {
                            formData.append('alasan_tolak', alasan);
                        } else {
                            formData.append('id_pembimbing', pembimbing);
                        }

                        fetch("admin2_proses_pengajuan.php", {
                                method: "POST",
                                body: formData
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Network response was not ok");
                                }
                                return response.text();
                            })
                            .then(data => {
                                if (prosesInfo) prosesInfo.style.display = "none";
                                Swal.fire("Sukses!", "Pengajuan berhasil diproses dan email terkirim.", "success").then(() => {
                                    location.reload();
                                });
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                if (prosesInfo) prosesInfo.style.display = "none";
                                Swal.fire("Gagal!", "Terjadi kesalahan saat mengirim.", "error");
                            });
                    }
                });
            });
        }
    });
</script>