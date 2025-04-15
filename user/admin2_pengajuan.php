<?php
include '../layout/sidebarUser.php';
include "functions.php";

$id_instansi = $_SESSION['id_instansi'];
$no = 1;

// Query untuk data utama pengajuan
$sql = "SELECT  
            pu.nama_user,
            b.nama_bidang,
            p.jenis_pengajuan, p.jumlah_pelamar, p.tanggal_mulai, p.tanggal_selesai, p.id_pengajuan, p.id_user, p.status_pengajuan, p.status_active, p.kirim_zoom
        FROM tb_pengajuan AS p
            INNER JOIN tb_profile_user AS pu ON p.id_user = pu.id_user
            INNER JOIN tb_bidang AS b ON p.id_bidang = b.id_bidang
        WHERE p.id_instansi = '$id_instansi'
            AND p.status_active = '1'
            AND p.status_pengajuan IN ('1', '6')
        ORDER BY p.id_pengajuan ASC
";
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
            d.id_user, GROUP_CONCAT(d.file_path SEPARATOR ', ') AS daftar_dokumen
        FROM tb_dokumen AS d
            JOIN tb_pengajuan AS p ON d.id_pengajuan = p.id_pengajuan
        WHERE p.id_instansi = '$id_instansi'
        GROUP BY d.id_pengajuan, d.id_user
";
// Simpan daftar dokumen dalam array
$daftar_dokumen = [];
$result3 = mysqli_query($conn, $sql3);

while ($row3 = mysqli_fetch_assoc($result3)) {
    $id_user = $row3['id_user'];
    $id_pengajuan = $row3['id_pengajuan'];
    $dokumen_list = explode(', ', $row3['daftar_dokumen']);
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
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Pengajuan</th>
                            <th>Calon Pelamar</th>
                            <th>Dokumen</th>
                            <th>Periode</th>
                            <th>Durasi</th>
                            <th>Zoom</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
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
                                <td class="text-center align-middle">
                                    <a href="#" class="show-doc btn btn-sm btn-primary" title="Lihat Dokumen" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Dokumen"
                                        data-doc='<?= !empty($daftar_dokumen[$row['id_user']][$row['id_pengajuan']])
                                                        ? htmlspecialchars(json_encode($daftar_dokumen[$row['id_user']][$row['id_pengajuan']], JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8')
                                                        : '[]' ?>'>
                                        <i class="bi bi-eye-fill"></i>
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
                                    <?php $disabled = ($row['kirim_zoom'] == 1) ? 'disabled' : ''; ?>
                                    <button type="button" class="btn btn-warning btn-sm zoom-btn"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="<?= ($row['kirim_zoom'] == 1) ? 'Informasi Zoom sudah dikirim' : 'Tambah Informasi Zoom' ?>"
                                        data-bs-target="#zoomModal" data-id="<?= $row['id_pengajuan'] ?>" <?= $disabled ?>>
                                        <i class="bi bi-zoom-in"></i>
                                    </button>
                                </td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-success btn-sm terima-btn"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Terima Pengajuan"
                                        data-id="<?= $row['id_pengajuan'] ?>">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </button>
                                    <!-- Menggunakan tooltip, untuk membuka modalnya pakai fungsi -->
                                    <button
                                        class="btn btn-danger btn-sm tolak-btn"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Tolak Pengajuan"
                                        data-bs-target="#tolakModal"
                                        data-bs-toggle-second="modal"
                                        data-id="<?= $row['id_pengajuan'] ?>">
                                        <i class="bi bi-person-x"></i> Tolak
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Menampilkan Daftar Dokumen -->
<div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dokumenModalLabel">Dokumen yang Dilengkapi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <ul id="dokumenList"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Menolak Pengajuan -->
<div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tolakModalLabel">Tolak Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="tolakForm">
                    <p>Apakah Anda yakin ingin menolak pengajuan ini?</p>
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan_tolak">
                    <div class="mb-3">
                        <label for="alasan_tolak" class="form-label tolak-label">Alasan Penolakan</label>
                        <textarea class="form-control" name="alasan_tolak" id="alasan_tolak" rows="3" required></textarea>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Kirim Penolakan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Query untuk mengambil semua pembimbing beserta bidangnya
$query = "SELECT pu.id_user, pu.nama_user, b.nama_bidang 
          FROM tb_profile_user pu
          JOIN tb_bidang b ON pu.id_bidang = b.id_bidang
          JOIN tb_user u ON pu.id_user = u.id_user
          WHERE u.level = 5";

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
                    <div class="mb-3">
                        <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan">
                        <div class="text-danger" id="tanggal_pelaksanaan_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jam_pelaksanaan" class="form-label">Jam Pelaksanaan</label>
                        <div class="input-group clockpicker">
                            <input type="text" class="form-control" id="jam_pelaksanaan" name="jam_pelaksanaan">
                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                        </div>
                        <small class="text-danger" id="jam_pelaksanaan_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="pembimbing" class="form-label">Pilih Pembimbing</label>
                        <select class="form-control" id="pembimbing" name="pembimbing">
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
                    <div class="mb-3">
                        <label for="link_zoom" class="form-label">Link Zoom</label>
                        <input type="url" class="form-control" id="link_zoom" name="link_zoom" placeholder="https://us02web.zoom.us/j/123456789">
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

<?php include "../layout/footerDashboard.php" ?>
<script src="../assets/js/validasi.js"></script>

<script>
    // Fungsi untuk menampilkan dokumen dalam modal
    document.addEventListener("DOMContentLoaded", function() {
        let dokumenModal = document.getElementById("dokumenModal");
        let dokumenList = document.getElementById("dokumenList");

        document.querySelectorAll(".show-doc").forEach(function(element) {
            element.addEventListener("click", function(event) {
                event.preventDefault();

                let docData = this.getAttribute("data-doc");
                let docList = [];

                try {
                    docList = JSON.parse(docData);
                    if (!Array.isArray(docList)) {
                        docList = [];
                    }
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                    docList = [];
                }

                // Bersihkan daftar sebelum menambahkan dokumen baru
                dokumenList.innerHTML = "";

                if (!docList || docList.length === 0) {
                    dokumenList.innerHTML = "<p class='text-muted'>Tidak ada dokumen tersedia.</p>";
                } else {
                    docList.forEach(function(doc) {
                        let listItem = document.createElement("li");
                        let link = document.createElement("a");

                        link.href = doc;
                        link.textContent = doc.split('/').pop(); // Menampilkan nama file
                        link.classList.add("doc-link");

                        if (doc.toLowerCase().endsWith(".pdf")) {
                            link.addEventListener("click", function(event) {
                                event.preventDefault();
                                showPreview(doc);
                            });
                        } else {
                            link.setAttribute("target", "_blank");
                        }

                        listItem.appendChild(link);
                        dokumenList.appendChild(listItem);
                    });
                }

                // Tampilkan modal
                let modal = new bootstrap.Modal(dokumenModal);
                modal.show();
            });
        });

        // Fungsi untuk menampilkan preview dokumen PDF di modal
        function showPreview(url) {
            let modalBody = dokumenModal.querySelector(".modal-body");
            let oldPreview = document.getElementById("pdfPreview");
            if (oldPreview) {
                oldPreview.remove();
            }

            // Gunakan iframe agar lebih kompatibel di semua browser
            let preview = document.createElement("iframe");
            preview.src = url;
            preview.width = "100%";
            preview.height = "500px";
            preview.style.border = "none";
            preview.id = "pdfPreview";

            modalBody.appendChild(preview);
        }

        // Reset hanya bagian daftar dokumen, bukan seluruh modal
        dokumenModal.addEventListener("hidden.bs.modal", function() {
            let preview = document.getElementById("pdfPreview");
            document.querySelectorAll(".modal-backdrop").forEach(function(backdrop) {
                backdrop.remove();
            });

            if (preview) {
                preview.remove();
            }

            document.body.classList.remove("modal-open");
            document.body.style.paddingRight = "";
        });
    });

    // Kode untuk tombol tolak
    document.querySelectorAll('.tolak-btn').forEach((btn) => {
        // Tooltip tetap aktif
        new bootstrap.Tooltip(btn);

        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id'); // Ambil ID dari tombol
            const inputHidden = document.getElementById('id_pengajuan_tolak');
            if (inputHidden) inputHidden.value = id;

            // Show modalnya (jika tidak pakai data-bs-toggle langsung)
            const targetModal = btn.getAttribute('data-bs-target');
            const modal = new bootstrap.Modal(document.querySelector(targetModal));
            modal.show();
        });
    });


    // Fungsi untuk mengirim data penolakan
    function confirmDelete() {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data pengajuan akan ditolak!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tolak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ambil data dari form
                var id_pengajuan = document.getElementById("id_pengajuan_tolak").value;
                var alasan_tolak = document.getElementById("alasan_tolak").value;

                // Kirim data dengan AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "admin2_tolak_pengajuan.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onload = function() {
                    if (xhr.status == 200) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pengajuan telah ditolak.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // Refresh halaman
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

                xhr.send("id_pengajuan=" + id_pengajuan + "&alasan_tolak=" + alasan_tolak);
            }
        });
    }

    // Alert untuk penerimaan pengajuan dengan AJAX
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".terima-btn").forEach(button => {
            button.addEventListener("click", function() {
                let id_pengajuan = this.getAttribute("data-id");

                Swal.fire({
                    title: "Konfirmasi",
                    text: "Apakah Anda yakin ingin menerima pengajuan ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Terima!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim data dengan AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "admin2_terima_pengajuan.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        xhr.onload = function() {
                            if (xhr.status == 200) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Pengajuan telah diterima dan email telah dikirim.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); // Refresh halaman
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

                        xhr.send("id_pengajuan=" + id_pengajuan);
                    }
                });
            });
        });
    });

    // Fungsi untuk menampilkan modal Zoom
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

        // Pastikan aria-hidden dikelola dengan benar saat modal dibuka & ditutup
        zoomModal.addEventListener("show.bs.modal", function() {
            zoomModal.removeAttribute("aria-hidden");
        });

        zoomModal.addEventListener("hidden.bs.modal", function() {
            zoomModal.setAttribute("aria-hidden", "true");
        });

        // Form submit dengan SweetAlert dan AJAX
        zoomForm.addEventListener("submit", function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Informasi Zoom akan dikirim!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
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

    $(document).ready(function() {
        $('.clockpicker').clockpicker({
            autoclose: true,
            donetext: 'Pilih'
        });
    });

    // Inisialisasi tooltip secara global
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            var tooltip = new bootstrap.Tooltip(tooltipTriggerEl);

            // Event listener untuk menghilangkan tooltip setelah diklik
            tooltipTriggerEl.addEventListener("click", function() {
                tooltip.hide();
            });

            return tooltip;
        });
    });
</script>