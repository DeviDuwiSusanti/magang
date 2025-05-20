<?php include '../layout/sidebarUser.php';

$id_instansi = $_SESSION['id_instansi'];
$bidang = "SELECT b.id_bidang, b.nama_bidang, b.status_active, b.deskripsi_bidang, b.kuota_bidang, b.kriteria_bidang, b.dokumen_persyaratan, b.nama_pejabat, b.pangkat_pejabat, b.nip_pejabat,
                  i.id_instansi, i.nama_panjang, 
                  pu.id_user 
            FROM tb_bidang AS b
            JOIN tb_instansi AS i ON b.id_instansi = i.id_instansi
            JOIN tb_profile_user AS pu ON i.id_instansi = pu.id_instansi
            WHERE pu.id_user = '$id_user'
            AND b.status_active = '1'
            ORDER BY b.id_bidang ASC";

$query = mysqli_query($conn, $bidang);
$bidang = mysqli_fetch_all($query, MYSQLI_ASSOC);
$no = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_bidang'])) {
    if (tambah_bidang($_POST) > 0) {
        echo "
            <script>
                tambah_bidang_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                tambah_bidang_admin_instansi_gagal();
            </script>
        ";
    }
}

if (isset($_GET["id_bidang_ini"])) {
    $id = $_GET["id_bidang_ini"];
    if (hapus_bidang($id, $id_user)) {
        echo "
            <script>
                hapus_bidang_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                hapus_bidang_admin_instansi_gagal();
            </script>
        ";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_bidang'])) {

    global $conn;
    $id_user_editor = $_SESSION['id_user'] ?? null;

    if (!$id_user_editor) {
        echo "<script>alert('Anda harus login'); window.history.back();</script>";
        exit;
    }

    $result = rekam_ulang_bidang($conn, $_POST, $id_user_editor);

    if ($result['status'] === 'success') {
        echo "<script>edit_bidang_admin_instansi_success();</script>";
    } else {
        echo "<script>edit_bidang_admin_instansi_gagal('" . addslashes($result['message']) . "');</script>";
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mt-3">Bidang Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Bidang Instansi</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="datatable-header mb-2"></div>
            <div class="bungkus-2 datatable-scrollable">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bidang</th>
                            <th>Kepala Bidang</th>
                            <!-- <th>Pangkat</th>
                            <th>NIP Pejabat</th> -->
                            <th>Deskripsi</th>
                            <th>Kriteria</th>
                            <th>Kuota</th>
                            <th>Dokumen Persyaratan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bidang as $bd) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $bd["nama_bidang"] ?></td>
                                <!-- Tombol Detail -->
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-sm btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail<?= $bd['id_bidang']; ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                </td>
                                <td data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars($bd['deskripsi_bidang']) ?>">
                                    <?= substr(htmlspecialchars($bd['deskripsi_bidang']), 0, 100) ?>...
                                </td>
                                <td><?= $bd["kriteria_bidang"] ?></td>
                                <td><?= $bd["kuota_bidang"] ?></td>
                                <td><?= $bd["dokumen_persyaratan"] ?></td>
                                <td style="width: 85px;">
                                    <button type="button" class="btn btn-warning btn-sm editBidangBtn me-2"
                                        data-bs-toggle="modal" data-bs-target="#editBidangModal"
                                        data-id_bidang="<?= $bd['id_bidang'] ?>"
                                        data-nama_bidang="<?= $bd['nama_bidang'] ?>"
                                        data-nama_pejabat="<?= $bd['nama_pejabat'] ?>"
                                        data-pangkat_pejabat="<?= $bd['pangkat_pejabat'] ?>"
                                        data-nip_pejabat="<?= $bd['nip_pejabat'] ?>"
                                        data-deskripsi="<?= $bd['deskripsi_bidang'] ?>"
                                        data-kriteria="<?= $bd['kriteria_bidang'] ?>"
                                        data-kuota="<?= $bd['kuota_bidang'] ?>"
                                        data-dokumen="<?= $bd['dokumen_persyaratan'] ?>">
                                        <i class="bi bi-pencil-square" title="Edit Data Bidang" data-toggle="tooltip"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" onclick="hapus_bidang_admin_instansi('<?= $bd['id_bidang'] ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Detail Bidang -->
                            <div class="modal fade" id="modalDetail<?= $bd['id_bidang']; ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $bd['id_bidang']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel<?= $bd['id_bidang']; ?>">Detail Kepala Bidang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Kepala Bidang:</strong> <?= htmlspecialchars($bd['pejabat_bidang'] ?? "Tidak Diketahui"); ?></p>
                                            <p><strong>Pangkat:</strong> <?= htmlspecialchars($bd['pangkat_pejabat'] ?? "Tidak Diketahui"); ?></p>
                                            <p><strong>NIP Pejabat:</strong> <?= htmlspecialchars($bd['nip_pejabat'] ?? "Tidak Diketahui"); ?></p>
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


<?php
// Ambil semua nama bidang instansi yang sedang login dari database
$bidang_result = mysqli_query($conn, "SELECT nama_bidang FROM tb_bidang WHERE id_instansi = '$id_instansi'");

$existingBidang = [];
while ($row = mysqli_fetch_assoc($bidang_result)) {
    $existingBidang[] = $row['nama_bidang'];
}
?>
<script>
    const existingNamaBidang = <?php echo json_encode($existingBidang); ?>;
</script>

<!-- Modal Tambah Bidang -->
<div class="modal fade" id="tambahBidangModal" tabindex="-1" aria-labelledby="tambahBidangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBidangModalLabel">Tambah Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="custom-alert" class="alert alert-info d-none" role="alert">
                    Aksi tidak diperbolehkan: Copy, Cut, atau Paste!
                </div>
                <form action="" method="POST" id="tambahBidangForm" enctype="multipart/form-data" onsubmit="return validateTambahBidang()">
                    <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                    <input type="hidden" name="id_instansi" id="id_instansi" value="<?= $id_instansi ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_bidang" class="form-label">Nama Bidang</label>
                            <input type="text" class="form-control" data-error-id="nama_bidang_error" id="nama_bidang" name="nama_bidang" placeholder="Masukkan nama bidang">
                            <small class="text-danger" id="nama_bidang_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kuota" class="form-label">Kuota</label>
                            <input type="number" class="form-control" data-error-id="kuota_error" id="kuota" name="kuota" placeholder="Masukkan kuota bidang">
                            <small class="text-muted">*Biarkan kosong jika tidak membuka lowongan</small> <br>
                            <small class="text-danger" id="kuota_error"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nama_pejabat" class="form-label">Kepala Bidang</label>
                            <input type="text" class="form-control" data-error-id="nama_pejabat_error" id="nama_pejabat" name="nama_pejabat" placeholder="Masukkan nama kepala bidang">
                            <small class="text-danger" id="nama_pejabat_error"></small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pangkat" class="form-label">Pangkat</label>
                            <input type="text" class="form-control" data-error-id="pangkat_error" id="pangkat" name="pangkat" placeholder="Masukkan pangkat">
                            <small class="text-danger" id="pangkat_error"></small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" data-error-id="nip_error" id="nip" name="nip" placeholder="Masukkan NIP">
                            <small class="text-danger" id="nip_error"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kriteria" class="form-label">Kriteria</label>
                            <textarea class="form-control summernote" data-error-id="kriteria_error" id="kriteria" name="kriteria" rows="5" placeholder="Masukkan kriteria bidang"></textarea>
                            <small class="text-danger" id="kriteria_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dokumen" class="form-label">Dokumen Persyaratan</label>
                            <textarea class="form-control summernote" data-error-id="dokumen_error" id="dokumen" name="dokumen" rows="5" placeholder="Masukkan dokumen prasyarat"></textarea>
                            <small class="text-danger" id="dokumen_error"></small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Bidang</label>
                        <textarea class="form-control" data-error-id="deskripsi_error" id="deskripsi" name="deskripsi" rows="5" placeholder="Masukkan deskripsi bidang"></textarea>
                        <small class="text-danger" id="deskripsi_error"></small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="tambah_bidang">Tambah Bidang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Bidang -->
<div class="modal fade" id="editBidangModal" tabindex="-1" aria-labelledby="editBidangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBidangModalLabel">Edit Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="custom-alert" class="alert alert-info d-none" role="alert">
                    Aksi tidak diperbolehkan: Copy, Cut, atau Paste!
                </div>
                <form action="" method="POST" id="editBidangForm" enctype="multipart/form-data" onsubmit="return validateEditBidang()">
                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
                    <input type="hidden" name="edit_id_instansi" id="edit_id_instansi" value="<?= $id_instansi ?>">
                    <input type="hidden" name="id_bidang" id="edit_id_bidang">
                    <input type="hidden" name="edit_bidang_lama" id="edit_bidang_lama">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_bidang" class="form-label fw-bold">Nama Bidang</label>
                            <input type="text" class="form-control" data-error-id="edit_nama_bidang_error" id="edit_nama_bidang" name="nama_bidang">
                            <small class="text-danger" id="edit_nama_bidang_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kuota" class="form-label fw-bold">Kuota</label>
                            <input type="number" class="form-control" data-error-id="edit_kuota_error" id="edit_kuota" name="kuota"">
                            <small class=" text-danger" id="edit_kuota_error"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nama_pejabat" class="form-label">Kepala Bidang</label>
                            <input type="text" class="form-control" data-error-id="edit_nama_pejabat_error" id="edit_nama_pejabat" name="edit_nama_pejabat" placeholder="Masukkan nama kepala bidang">
                            <small class="text-danger" id="edit_nama_pejabat_error"></small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pangkat" class="form-label">Pangkat</label>
                            <input type="text" class="form-control" data-error-id="edit_pangkat_error" id="edit_pangkat" name="edit_pangkat" placeholder="Masukkan pangkat">
                            <small class="text-danger" id="edit_pangkat_error"></small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" data-error-id="edit_nip_error" id="edit_nip" name="edit_nip" placeholder="Masukkan NIP">
                            <small class="text-danger" id="edit_nip_error"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kriteria" class="form-label fw-bold">Kriteria</label>
                            <textarea class="form-control summernote" data-error-id="edit_kriteria_error" id="edit_kriteria" name="kriteria" rows="5"></textarea>
                            <small class="text-danger" id="edit_kriteria_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dokumen" class="form-label fw-bold">Dokumen Persyaratan</label>
                            <textarea class="form-control summernote" data-error-id="edit_dokumen_error" id="edit_dokumen" name="dokumen" rows="5"></textarea>
                            <small class="text-danger" id="edit_dokumen_error"></small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Bidang</label>
                        <textarea class="form-control" data-error-id="edit_deskripsi_error" id="edit_deskripsi" name="deskripsi" rows="5"></textarea>
                        <small class="text-danger" id="edit_deskripsi_error"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="edit_bidang" name="edit_bidang" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>
<script src="../assets/js/validasi.js"></script>

<script>
    // Tangkap event saat modal edit ditampilkan
    document.getElementById('editBidangModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const bidangLama = button.getAttribute('data-nama_bidang');
        document.getElementById('edit_bidang_lama').value = bidangLama;
        document.getElementById('edit_nama_bidang').value = bidangLama;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'));
        let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Function untuk refresh semua tooltip
        function refreshTooltips() {
            // Dispose semua tooltip dulu
            tooltipList.forEach(function(tooltip) {
                tooltip.dispose();
            });
            // Buat lagi
            tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'));
            tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Tangkap SEMUA modal yang punya class .modal
        const modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                refreshTooltips();
            });
        });
    });

    // Array konfigurasi input fields
    const inputConfigs = [
        { id: 'nip', maxLength: 18, allow: /\D/g },
        { id: 'edit_nip', maxLength: 18, allow: /\D/g },
    ];

    // Fungsi umum untuk semua input
    function setInputHandler(config) {
        const el = document.getElementById(config.id);
        if (!el) return;

        el.addEventListener("input", function(e) {
            // Hapus karakter non-digit
            this.value = this.value.replace(config.allow, "");

            // Batasi panjang
            if (this.value.length > config.maxLength) {
                this.value = this.value.slice(0, config.maxLength);
            }
        });
    }

    // Terapkan ke semua input
    inputConfigs.forEach(setInputHandler);

    // Pengaturan DataTable
    $(document).ready(function() {
        var isMobile = window.innerWidth < 768;
        $('#myTable').DataTable({
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
                emptyTable: "Tidak ada data bidang yang tersedia",
                zeroRecords: "Tidak ada data bidang yang cocok",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            },
            columnDefs: [{
                targets: [2, 3, 4, 5, 6],
                orderable: false
            }]
        });

        function showCustomAlert(message, duration = 3000) {
            var $alert = $('#custom-alert');
            $alert.removeClass('d-none').text(message);

            setTimeout(function() {
                $alert.addClass('d-none');
            }, duration);
        }

        // Pengaturan toolbar Summernote
        const summernoteConfig = {
            placeholder: 'Tulis di sini...',
            height: 175,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']]
            ]
        };

        // Fungsi pembatasan aksi copy, cut, paste, klik kanan
        function applyEditorRestrictions($editable) {
            ['copy', 'cut', 'paste', 'contextmenu'].forEach(function(eventType) {
                $editable.on(eventType, function(e) {
                    e.preventDefault();
                    showCustomAlert(
                        eventType === 'copy' ? 'Copy tidak diperbolehkan!' :
                        eventType === 'cut' ? 'Cut tidak diperbolehkan!' :
                        eventType === 'paste' ? 'Paste tidak diperbolehkan!' :
                        'Klik kanan dinonaktifkan.',
                        2500
                    );
                });
            });
        }

        // Inisialisasi Summernote untuk elemen tertentu dalam modal
        function initializeSummernoteInModal(modalSelector, selectors) {
            $(modalSelector).on('shown.bs.modal', function() {
                selectors.forEach(selector => {
                    const $textarea = $(selector);

                    // Jika textarea ada dan belum di-summernote
                    if ($textarea.length && !$textarea.data('summernote')) {
                        $textarea.summernote(summernoteConfig);

                        // Gunakan setTimeout untuk memastikan DOM Summernote sudah siap
                        setTimeout(() => {
                            const $editable = $textarea.next('.note-editor').find('.note-editable');
                            if ($editable.length) {
                                applyEditorRestrictions($editable);
                            } else {
                                console.warn(`Editable area not found for ${selector}`);
                            }
                        }, 100); // Beri jeda kecil agar DOM Summernote sudah dimuat
                    }
                });
            });

            $(modalSelector).on('hidden.bs.modal', function() {
                selectors.forEach(selector => {
                    const $textarea = $(selector);
                    if ($textarea.data('summernote')) {
                        $textarea.summernote('destroy');
                    }
                });
            });
        }

        // Gunakan fungsi dengan ID spesifik untuk setiap modal
        initializeSummernoteInModal('#tambahBidangModal', ['#kriteria', '#dokumen']);
        initializeSummernoteInModal('#editBidangModal', ['#edit_kriteria', '#edit_dokumen']);

        $('#editBidangModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const kriteria = button.attr('data-kriteria');
            const dokumen = button.attr('data-dokumen');

            $('#edit_id_bidang').val(button.attr('data-id_bidang'));
            $('#edit_nama_bidang').val(button.attr('data-nama_bidang'));
            $('#edit_deskripsi').val(button.attr('data-deskripsi'));
            $('#edit_kuota').val(button.attr('data-kuota'));
            $('#edit_nama_pejabat').val(button.attr('data-nama_pejabat'));
            $('#edit_pangkat').val(button.attr('data-pangkat_pejabat'));
            $('#edit_nip').val(button.attr('data-nip_pejabat'));

            // Simpan data ke dalam textarea sebagai "data-content"
            $('#edit_kriteria').data('content', kriteria);
            $('#edit_dokumen').data('content', dokumen);
        });

        $('#editBidangModal').on('shown.bs.modal', function() {
            const kriteriaContent = $('#edit_kriteria').data('content');
            const dokumenContent = $('#edit_dokumen').data('content');

            if ($('#edit_kriteria').data('summernote')) {
                $('#edit_kriteria').summernote('code', kriteriaContent);
            }

            if ($('#edit_dokumen').data('summernote')) {
                $('#edit_dokumen').summernote('code', dokumenContent);
            }
        });

        // Inject tombol ke sebelah kanan search box
        const tombolTambahBidang = `
        <button type="button" class="btn btn-primary btn-sm ms-2" 
            data-bs-toggle="modal" 
            data-bs-target="#tambahBidangModal" 
            title="Tambah Bidang">
            <i class="bi bi-plus-circle-fill"></i>
        </button>`;
        $('.dataTables_filter').append(tombolTambahBidang);

        // Aktifkan tooltip jika pakai Bootstrap Tooltip
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function(el) {
            return new bootstrap.Tooltip(el);
        });
    });
</script>