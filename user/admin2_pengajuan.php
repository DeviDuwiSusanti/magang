<?php
include '../layout/sidebarUser.php';
include "functions.php";

$id_instansi = $_SESSION['id_instansi'];
$no = 1;

// Query untuk data utama pengajuan
$sql = "SELECT  
        pu.nama_user,
        b.nama_bidang,
        b.kuota_bidang AS kuota_bidang,
        COALESCE(pa.jumlah_pemagang_aktif, 0) AS jumlah_pemagang_aktif,
        u.email,
        p.jenis_pengajuan, 
        p.jumlah_pelamar, 
        p.tanggal_mulai, 
        p.tanggal_selesai, 
        p.id_pengajuan, 
        p.id_user, 
        p.status_pengajuan, 
        p.status_active, 
        p.tanggal_zoom, 
        p.pengingat_dokumen
    FROM tb_pengajuan AS p
        INNER JOIN tb_profile_user AS pu ON p.id_user = pu.id_user
        INNER JOIN tb_bidang AS b ON p.id_bidang = b.id_bidang
        INNER JOIN tb_user AS u ON p.id_user = u.id_user
        LEFT JOIN (
            SELECT id_bidang, COUNT(*) AS jumlah_pemagang_aktif
            FROM tb_pengajuan
            WHERE status_pengajuan IN (2, 4)
            GROUP BY id_bidang
        ) AS pa ON b.id_bidang = pa.id_bidang
    WHERE p.id_instansi = '$id_instansi'
        AND p.status_active = '1'
        AND p.status_pengajuan IN ('1', '2')
    ORDER BY p.id_pengajuan ASC";
$result = mysqli_query($conn, $sql);

// Query untuk mendapatkan daftar nama pengaju
$sql2 = "SELECT 
            p.id_pengajuan, GROUP_CONCAT(pu.nama_user SEPARATOR ', ') AS daftar_nama
        FROM tb_pengajuan AS p
            JOIN tb_profile_user AS pu ON p.id_pengajuan = pu.id_pengajuan
        WHERE p.id_instansi = '$id_instansi'
        GROUP BY p.id_pengajuan
        ORDER BY p.id_pengajuan DESC
";

// Simpan daftar nama pengaju dalam array
$nama_pengaju = [];
$result2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_assoc($result2)) {
    $nama_pengaju[$row2['id_pengajuan']] = $row2['daftar_nama'];
}
$json_nama_pengaju = json_encode($nama_pengaju);

// Query untuk mendapatkan daftar dokumen
$sql3 = "SELECT 
            d.id_pengajuan, 
            d.id_user, 
            GROUP_CONCAT(CONCAT(d.nama_dokumen, '|', d.file_path) SEPARATOR '||') AS daftar_dokumen
        FROM tb_dokumen AS d
            JOIN tb_pengajuan AS p ON d.id_pengajuan = p.id_pengajuan
        WHERE p.id_instansi = '$id_instansi'
        GROUP BY d.id_pengajuan, d.id_user";
$result3 = mysqli_query($conn, $sql3);

// Simpan daftar dokumen dalam array
while ($row3 = mysqli_fetch_assoc($result3)) {
    $id_user = $row3['id_user'];
    $id_pengajuan = $row3['id_pengajuan'];
    $dokumen_raw = explode('||', $row3['daftar_dokumen']);

    $dokumen_list = [];

    foreach ($dokumen_raw as $item) {
        list($nama, $path) = explode('|', $item);
        $dokumen_list[] = ['nama' => $nama, 'path' => $path];
    }
    $daftar_dokumen[$id_user][$id_pengajuan] = $dokumen_list;
}
$daftar_dokumen_json = json_encode($daftar_dokumen, JSON_PRETTY_PRINT);
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Daftar Pengajuan User</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="datatable-header mb-2"></div> <!-- Tempat search dan show entries -->
            <div class="bungkus-2 datatable-scrollable">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Pengajuan</th>
                            <th>Calon Pelamar</th>
                            <th>Periode</th>
                            <th>Durasi</th>
                            <!-- <th>Dokumen</th>
                            <th>Zoom</th> -->
                            <th style="width: 200px; text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <?php
                            $id_pengajuan = $row['id_pengajuan'];
                            $status_pengajuan = $row['status_pengajuan'];
                            $bidang = $row['nama_bidang'];
                            $jenis_pengajuan = $row['jenis_pengajuan'];

                            // Menghitung durasi magang dari tanggal mulai dan selesai
                            $tanggal_mulai = new DateTime($row['tanggal_mulai']);
                            $tanggal_selesai = new DateTime($row['tanggal_selesai']);
                            $durasi_magang = $tanggal_mulai->diff($tanggal_selesai)->m + ($tanggal_mulai->diff($tanggal_selesai)->y * 12); // durasi dalam bulan

                            $kuota_bidang = $row['kuota_bidang'];
                            $jumlah_pemagang_aktif = $row['jumlah_pemagang_aktif'];
                            $jumlah_pelamar = $row['jumlah_pelamar'];

                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_user'] ?></td>
                                <td><?= $row['nama_bidang'] ?></td>
                                <td><?= $row['jenis_pengajuan'] ?></td>
                                <td>
                                    <a href="#" class="show-detail" title="Lihat Detail"
                                        data-detail='<?= isset($nama_pengaju[$row['id_pengajuan']]) ? json_encode(explode(', ', $nama_pengaju[$row['id_pengajuan']])) : '[]' ?>'>
                                        <?= isset($nama_pengaju[$row['id_pengajuan']]) ? count(explode(', ', $nama_pengaju[$row['id_pengajuan']])) : 0 ?>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        echo formatTanggalLengkapIndonesia($row['tanggal_mulai']) . ' - ' . formatTanggalLengkapIndonesia($row['tanggal_selesai']);
                                    } else {
                                        echo "Periode Tidak Diketahui";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        echo hitungDurasi($row['tanggal_mulai'], $row['tanggal_selesai']);
                                    } else {
                                        echo "Durasi Tidak Diketahui";
                                    }
                                    ?>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="#"
                                        class="show-doc btn btn-sm btn-primary me-2"
                                        title="Lihat Dokumen"
                                        data-bs-toggle="modal"
                                        data-bs-target="#dokumenModal"
                                        data-doc='<?= htmlspecialchars(json_encode(
                                                        $daftar_dokumen[$row['id_user']][$row['id_pengajuan']] ?? [],
                                                        JSON_UNESCAPED_SLASHES
                                                    ), ENT_QUOTES, "UTF-8") ?>'>
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <?php
                                    $tanggal_zoom = $row['tanggal_zoom'];
                                    $today = date('Y-m-d');
                                    $harusDisable = (!empty($tanggal_zoom) && $tanggal_zoom !== '0000-00-00' && $tanggal_zoom < $today);
                                    $btn_class = $harusDisable ? 'btn-secondary' : 'btn-info';
                                    $disabled = $harusDisable ? 'disabled' : '';

                                    $title = (!empty($tanggal_zoom) && $tanggal_zoom !== '0000-00-00')
                                        ? 'Informasi Zoom sudah dikirim'
                                        : 'Tambah Informasi Zoom';
                                    ?>
                                    <button type="button" class="btn <?= $btn_class ?> btn-sm zoom-btn me-2"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="<?= $title ?>"
                                        data-bs-target="#zoomModal" data-id="<?= $row['id_pengajuan'] ?>" <?= $disabled ?>>
                                        <i class="bi bi-zoom-in"></i>
                                    </button>
                                    <?php
                                    $tanggal_zoom = $row['tanggal_zoom'];
                                    $today = date('Y-m-d');

                                    // Tombol aktif hanya jika tanggal_zoom valid dan sudah lewat dari hari ini
                                    $bisaProses = (!empty($tanggal_zoom) && $tanggal_zoom !== '0000-00-00' && $tanggal_zoom < $today);
                                    $btnClass = $bisaProses ? 'btn-success' : 'btn-secondary';
                                    $disabled = $bisaProses ? '' : 'disabled';
                                    ?>
                                    <!-- <button
                                        class="btn <?= $btnClass ?> btn-sm aksi-btn me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#aksiModal"
                                        data-id="<?= $id_pengajuan ?>"
                                        data-status="<?= $status_pengajuan ?>"
                                        <?= $disabled ?>
                                        title="Proses Pengajuan">
                                        <i class="bi bi-ui-checks"></i>
                                    </button> -->
                                    <button
                                        class="btn <?= $btnClass ?> btn-sm aksi-btn me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#aksiModal"
                                        data-id="<?= $id_pengajuan ?>"
                                        data-status="<?= $status_pengajuan ?>"
                                        data-bidang="<?= $bidang ?>"
                                        data-jenis="<?= $jenis_pengajuan ?>"
                                        data-durasi="<?= $durasi_magang ?>"
                                        data-kuota-awal="<?= $kuota_bidang ?>"
                                        data-pemagang-aktif="<?= $jumlah_pemagang_aktif ?>"
                                        data-jumlah-pelamar="<?= $jumlah_pelamar ?>"
                                        <?= $disabled ?>
                                        title="Proses Pengajuan">
                                        <i class="bi bi-ui-checks"></i>
                                    </button>
                                    <!-- tambah tombol kirim pengingat -->
                                    <!-- <?php if ($row['status_pengajuan'] == 2): ?>
                                        <?php
                                                $sudahTerkirim = $row['pengingat_dokumen'] == 1;
                                                $btnClass = $sudahTerkirim ? 'btn-secondary' : 'btn-danger';
                                                $btnDisabled = $sudahTerkirim ? 'disabled' : '';
                                        ?>
                                        <button
                                            class="btn <?= $btnClass ?> btn-sm kirimPengingatBtn me-2"
                                            data-id="<?= $row['id_pengajuan'] ?>"
                                            data-email="<?= $row['email'] ?>"
                                            <?= $btnDisabled ?>
                                            title="Kirim Pengingat">
                                            <i class="bi bi-envelope-fill"></i>
                                        </button>
                                    <?php endif; ?> -->
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="datatable-footer mt-2"></div> <!-- Tempat info dan pagination -->
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>

<!-- Modal untuk Menampilkan Daftar Dokumen -->
<div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dokumenModalLabel">Dokumen yang Dilengkapi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="docTabList" role="tablist"></ul>
                <div class="tab-content pt-3" id="docTabContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Proses Pengajuan -->
<div class="modal fade" id="aksiModal" tabindex="-1" aria-labelledby="aksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formAksiPengajuan">
                <div class="modal-header">
                    <h5 class="modal-title" id="aksiModalLabel">Proses Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
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
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Query untuk mengambil semua pembimbing beserta bidangnya
$query = "SELECT pu.id_user, pu.nama_user, b.nama_bidang 
          FROM tb_profile_user pu
          JOIN tb_bidang b ON pu.id_bidang = b.id_bidang
          JOIN tb_user u ON pu.id_user = u.id_user
          WHERE u.level = 4";

$result = mysqli_query($conn, $query);
?>

<!-- Modal untuk Informasi Zoom -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomModalLabel">Informasi Wawancara Zoom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pembimbing" class="form-label">Pilih Pembimbing</label>
                            <select class="form-control select2" id="pembimbing" name="pembimbing">
                                <option value="">-- Pilih Pembimbing --</option>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <option value="<?= $row['id_user']; ?>">
                                        <?= $row['nama_user'] . ' - <span class="badge bg-primary">' . $row['nama_bidang'] . '</span>'; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <small class="text-muted">*Pilih pembimbing sesuai bidang yang diajukan oleh user</small> <br>
                            <small class="text-danger" id="pembimbing_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_zoom" class="form-label">Link Zoom</label>
                            <input type="url" class="form-control" id="link_zoom" name="link_zoom" placeholder="https://us02web.zoom.us/j/123456789">
                            <small class="text-danger" id="link_zoom_error"></small>
                        </div>
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
    // ==========Inisialisasi Select2 pada Modal Zoom ==========
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
        let zoomModal = document.getElementById("zoomModal");
        let zoomForm = document.getElementById("zoomForm");
        let submitButton = document.getElementById("submitButton");

        // Event listener untuk semua tombol Zoom
        document.querySelectorAll(".zoom-btn").forEach(function(button) {
            button.addEventListener("click", function() {
                let idPengajuan = this.getAttribute("data-id");
                document.getElementById("pengajuan_id_zoom").value = idPengajuan;

                let modal = new bootstrap.Modal(zoomModal);
                modal.show();
            });
        });

        zoomModal.addEventListener("show.bs.modal", function() {
            zoomModal.removeAttribute("aria-hidden");
        });

        zoomModal.addEventListener("hidden.bs.modal", function() {
            zoomModal.setAttribute("aria-hidden", "true");
        });

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
                    let formData = new FormData(zoomForm);
                    let urlEncodedData = new URLSearchParams();
                    formData.forEach((value, key) => urlEncodedData.append(key, value));

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "admin2_simpan_zoom.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onload = function() {
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
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Tidak dapat menghubungi server.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    };

                    xhr.send(urlEncodedData.toString());
                }

                // Hapus inert setelah SweetAlert selesai
                zoomModal.removeAttribute("inert");
            });
        });
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
            }
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

                const tabList = document.getElementById('docTabList');
                const tabContent = document.getElementById('docTabContent');

                tabList.innerHTML = '';
                tabContent.innerHTML = '';

                if (!Array.isArray(data) || data.length === 0) {
                    tabList.innerHTML = `
                    <li class="nav-item">
                        <span class="nav-link active">Tidak ada dokumen</span>
                    </li>`;
                    tabContent.innerHTML = `
                    <div class="tab-pane fade show active p-2">
                        Tidak tersedia dokumen untuk ditampilkan.
                    </div>`;
                    return;
                }

                data.forEach((doc, index) => {
                    const tabId = `doc-tab-${index}`;
                    const filename = doc.path.split('/').pop();
                    const displayName = (doc.nama || `Dokumen ${index + 1}`).toUpperCase();
                    // displayName = displayName.toUpperCase();

                    // Tab header
                    const tab = document.createElement('li');
                    tab.classList.add('nav-item');
                    tab.innerHTML = `
                        <button class="nav-link ${index === 0 ? 'active' : ''}" 
                                id="${tabId}-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#${tabId}" 
                                type="button" 
                                role="tab" 
                                aria-controls="${tabId}" 
                                aria-selected="${index === 0 ? 'true' : 'false'}">
                            ${displayName}
                        </button>`;
                    tabList.appendChild(tab);

                    // Tab content
                    const tabPane = document.createElement('div');
                    tabPane.classList.add('tab-pane', 'fade', 'p-2');
                    if (index === 0) tabPane.classList.add('show', 'active');
                    tabPane.id = tabId;
                    tabPane.setAttribute('role', 'tabpanel');
                    tabPane.setAttribute('aria-labelledby', `${tabId}-tab`);

                    const isPdf = doc.path.toLowerCase().endsWith('.pdf');
                    const isImage = /\.(jpg|jpeg|png|gif|webp)$/i.test(doc.path);

                    if (isPdf) {
                        tabPane.innerHTML = `<iframe src="${doc.path}" width="100%" height="500px" style="border: none;"></iframe>`;
                    } else if (isImage) {
                        tabPane.innerHTML = `<img src="${doc.path}" alt="${filename}" class="img-fluid rounded shadow">`;
                    } else {
                        tabPane.innerHTML = `<a href="${doc.path}" target="_blank" class="btn btn-outline-primary">
                        Lihat atau Unduh ${filename}
                    </a>`;
                    }
                    tabContent.appendChild(tabPane);
                });

            });
        });
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

        // Variabel untuk menyimpan data yang akan digunakan di submit
        let sisaKuota = 0;
        let jumlahPelamar = 0;

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
                document.getElementById("resumeDurasi").textContent = durasi + " bulan";
                document.getElementById("resumeKuotaTersisa").textContent = sisaKuota + " orang";
                document.getElementById("resumeJumlahPelamar").textContent = jumlahPelamar + " orang";

                // Reset form & isi data baru
                form.reset();
                alasanContainer.style.display = "none";
                infoResume.style.display = "none";
                idInput.value = id;

                // Atur status radio "terima" sesuai kondisi
                radioTerima.disabled = (status === "2");
            });
        });

        // Show/hide alasan penolakan dan info resume
        radioTolak.addEventListener("change", function() {
            alasanContainer.style.display = "block";
            infoResume.style.display = "none";
        });

        radioTerima.addEventListener("change", function() {
            alasanContainer.style.display = "none";
            infoResume.style.display = "block";
        });

        // Submit form
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            const id_pengajuan = idInput.value;
            const status = form.querySelector("input[name='status']:checked")?.value;
            const alasan = alasanTolak.value.trim();

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
                    const formData = new FormData();
                    formData.append('id_pengajuan', id_pengajuan);
                    formData.append('status', status);
                    if (status === "tolak") {
                        formData.append('alasan_tolak', alasan);
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
                            Swal.fire("Sukses!", "Pengajuan berhasil diproses dan email terkirim.", "success").then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire("Gagal!", "Terjadi kesalahan saat mengirim.", "error");
                        });
                }
            });
        });
    });
</script>