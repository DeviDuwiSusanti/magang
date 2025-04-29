<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="bi bi-layers me-2"></i>Bidang Instansi</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelola Bidang Instansi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <!-- Content Card -->
        <div class="content-card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-table me-2"></i>Daftar Bidang Instansi</h5>
                <button type="button" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#tambahBidangModal">
                    <i class="bi bi-plus-circle"></i> Tambah Bidang
                </button>
            </div>

            <div class="table-responsive">
                <table id="tableBidang" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Bidang</th>
                            <th>Deskripsi</th>
                            <th>Kriteria</th>
                            <th style="width: 90px;">Kuota</th>
                            <th>Dokumen Persyaratan</th>
                            <th class="action-column">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bidang as $bd) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="fw-medium"><?= $bd["nama_bidang"] ?></td>
                                <td>
                                    <span class="truncate" title="<?= htmlspecialchars($bd["deskripsi_bidang"]) ?>"><?= $bd["deskripsi_bidang"] ?></span>
                                </td>
                                <td>
                                    <span class="truncate" title="<?= htmlspecialchars($bd["kriteria_bidang"]) ?>"><?= $bd["kriteria_bidang"] ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge-kuota"><?= $bd["kuota_bidang"] ?></span>
                                </td>
                                <td>
                                    <div class="doc-indicator">
                                        <i class="bi bi-file-earmark-text doc-icon"></i>
                                        <span class="truncate" title="<?= htmlspecialchars($bd["dokumen_persyaratan"]) ?>"><?= $bd["dokumen_persyaratan"] ?></span>
                                    </div>
                                </td>
                                <td class="action-column">
                                    <button type="button" class="btn btn-warning btn-action editBidangBtn"
                                        data-bs-toggle="modal" data-bs-target="#editBidangModal"
                                        data-id_bidang="<?= $bd['id_bidang'] ?>"
                                        data-nama_bidang="<?= $bd['nama_bidang'] ?>"
                                        data-deskripsi="<?= $bd['deskripsi_bidang'] ?>"
                                        data-kriteria="<?= $bd['kriteria_bidang'] ?>"
                                        data-kuota="<?= $bd['kuota_bidang'] ?>"
                                        data-dokumen="<?= $bd['dokumen_persyaratan'] ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-action"
                                        onclick="hapus_bidang_admin_instansi('<?= $bd['id_bidang'] ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBidangModalLabel">Tambah Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                            <small class="text-danger" id="kuota_error"></small>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBidangModalLabel">Edit Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editBidangForm" enctype="multipart/form-data" onsubmit="return validateEditBidang()">
                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
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
                        <div class="col-md-6 mb-3">
                            <label for="kriteria" class="form-label fw-bold">Kriteria</label>
                            <textarea class="form-control" data-error-id="edit_kriteria_error" id="edit_kriteria" name="kriteria" rows="5"></textarea>
                            <!-- <small class="text-muted">*Pisahkan dengan koma</small> <br> -->
                            <small class="text-danger" id="edit_kriteria_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dokumen" class="form-label fw-bold">Dokumen Persyaratan</label>
                            <textarea class="form-control" data-error-id="edit_dokumen_error" id="edit_dokumen" name="dokumen" rows="5"></textarea>
                            <!-- <small class="text-muted">*Pisahkan dengan koma</small> <br> -->
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
    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll(".editBidangBtn");

        editButtons.forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("edit_id_bidang").value = this.getAttribute("data-id_bidang");
                document.getElementById("edit_nama_bidang").value = this.getAttribute("data-nama_bidang");
                document.getElementById("edit_deskripsi").value = this.getAttribute("data-deskripsi");
                document.getElementById("edit_kuota").value = this.getAttribute("data-kuota");

                // Gunakan Summernote API untuk set konten
                $('#edit_kriteria').summernote('code', this.getAttribute("data-kriteria"));
                $('#edit_dokumen').summernote('code', this.getAttribute("data-dokumen"));
            });
        });
    });

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

        // Modal Tambah
        $('#tambahBidangModal').on('shown.bs.modal', function() {
            $('#kriteria, #dokumen').summernote({
                placeholder: 'Tulis di sini...',
                height: 175
            });
        });

        $('#tambahBidangModal').on('hidden.bs.modal', function() {
            $('#kriteria, #dokumen').summernote('destroy');
        });

        // Modal Edit
        $('#editBidangModal').on('shown.bs.modal', function() {
            $('#edit_kriteria, #edit_dokumen').summernote({
                placeholder: 'Tulis di sini...',
                height: 175
            });
        });

        $('#editBidangModal').on('hidden.bs.modal', function() {
            $('#edit_kriteria, #edit_dokumen').summernote('destroy');
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