<?php include '../layout/sidebarUser.php';

$id_instansi = $_SESSION['id_instansi'];
$bidang = "SELECT b.id_bidang, b.nama_bidang, b.status_active, b.deskripsi_bidang, b.kuota_bidang, b.kriteria_bidang, b.dokumen_persyaratan,
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
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    if (edit_bidang($_POST) > 0) {
        echo "
            <script>
                edit_bidang_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                edit_bidang_admin_instansi_gagal();
            </script>
        ";
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Bidang Instansi</h1>
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
                                <td><?= $bd["deskripsi_bidang"] ?></td>
                                <td><?= $bd["kriteria_bidang"] ?></td>
                                <td><?= $bd["kuota_bidang"] ?></td>
                                <td><?= $bd["dokumen_persyaratan"] ?></td>
                                <td style="width: 85px;">
                                    <button type="button" class="btn btn-warning btn-sm editBidangBtn me-2"
                                        data-bs-toggle="modal" data-bs-target="#editBidangModal"
                                        data-id_bidang="<?= $bd['id_bidang'] ?>"
                                        data-nama_bidang="<?= $bd['nama_bidang'] ?>"
                                        data-deskripsi="<?= $bd['deskripsi_bidang'] ?>"
                                        data-kriteria="<?= $bd['kriteria_bidang'] ?>"
                                        data-kuota="<?= $bd['kuota_bidang'] ?>"
                                        data-dokumen="<?= $bd['dokumen_persyaratan'] ?>"
                                        title="Edit Data Bidang">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" onclick="hapus_bidang_admin_instansi('<?= $bd['id_bidang'] ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="datatable-footer mt-2"></div>
        </div>
    </div>
</div>

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
                            <textarea class="form-control" data-error-id="kriteria_error" id="kriteria" name="kriteria" rows="5" placeholder="Masukkan kriteria bidang"></textarea>
                            <!-- <small class="text-muted">*Pisahkan dengan koma</small> <br> -->
                            <small class="text-danger" id="kriteria_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dokumen" class="form-label">Dokumen Persyaratan</label>
                            <textarea class="form-control" data-error-id="dokumen_error" id="dokumen" name="dokumen" rows="5" placeholder="Masukkan dokumen prasyarat"></textarea>
                            <!-- <small class="text-muted">*Pisahkan dengan koma</small> <br> -->
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

<!-- <div class="loader hidden">
    <div class="spinner"></div>
    <p>Mohon tunggu sebentar...</p>
</div> -->

<?php include "../layout/footerDashboard.php" ?>
<script src="../assets/js/validasi.js"></script>

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

    // Inisialisasi tooltip secara global
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
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
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            }
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
        </button>
    `;
        $('.dataTables_filter').append(tombolTambahBidang);

        // Aktifkan tooltip jika pakai Bootstrap Tooltip
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function(el) {
            return new bootstrap.Tooltip(el);
        });
    });

    // const form = document.getElementById('tambahBidangForm');

    // if (form) {
    //     form.addEventListener('submit', function(event) {
    //         event.preventDefault(); // Hindari submit langsung

    //         let loader = document.querySelector('.loader');

    //         if (!loader) {
    //             loader = document.createElement('div');
    //             loader.className = 'loader';
    //             loader.innerHTML = `
    //             <div class="spinner"></div>
    //             <p>Mohon tunggu sebentar...</p>
    //         `;
    //             document.body.appendChild(loader);
    //         } else {
    //             loader.classList.remove("hidden");
    //         }

    //         // ⏱️ Delay 2 detik sebelum submit
    //         setTimeout(function() {
    //             form.submit();
    //         }, 2000);
    //     });
    // }

    // document.getElementById('editBidangForm')?.addEventListener('submit', function(e) {
    //     e.preventDefault(); // Cegah submit langsung
    //     let loader = document.querySelector('.loader');

    //     // Kalau loader belum ada, buat
    //     if (!loader) {
    //         loader = document.createElement('div');
    //         loader.className = 'loader';
    //         loader.innerHTML = `
    //         <div class="spinner"></div>
    //         <p>Mohon tunggu sebentar...</p>
    //     `;
    //         document.body.appendChild(loader);
    //     } else {
    //         loader.classList.remove("hidden");
    //     }

    //     console.log("Submit jalan");

    //     setTimeout(function() {
    //         console.log("Form akan disubmit!");
    //         document.getElementById('editBidangForm').submit();
    //     }, 2000);

    // });
</script>