<?php include '../layout/sidebarUser.php';

// Ambil id_instansi admin yang sedang login
$get_instansi = "SELECT id_instansi FROM tb_profile_user WHERE id_user = '$id_user'";
$query_instansi = mysqli_query($conn, $get_instansi);
$instansi = mysqli_fetch_assoc($query_instansi);
$id_instansi_admin = $instansi["id_instansi"];
$id_instansi = $_SESSION["id_instansi"];


// Query untuk mendapatkan daftar bidang
$bidang = "SELECT 
            pu.id_user AS id_pembimbing, 
            pu.nama_user AS nama_pembimbing, 
            pu.nik AS nik_pembimbing, 
            u.email AS email_pembimbing,
            pu.nip, 
            pu.jabatan, 
            pu.telepone_user AS telepone_pembimbing, 
            b.nama_bidang,
            b.id_bidang
        FROM tb_profile_user AS pu
        JOIN tb_bidang AS b
            ON pu.id_bidang = b.id_bidang
        JOIN tb_instansi AS i
            ON b.id_instansi = i.id_instansi
        JOIN tb_user AS u
            ON pu.id_user = u.id_user
        WHERE pu.status_active = '1'
        AND u.status_active = '1'
        -- AND b.status_active = '1' 
        AND i.id_instansi = '$id_instansi_admin'
        ORDER BY b.id_bidang ASC";

$query = mysqli_query($conn, $bidang);
$bidang_list = mysqli_fetch_all($query, MYSQLI_ASSOC);

$list_bidang = query("SELECT tb_bidang.*, 
                    IFNULL(tb_profile_user.id_user, '') AS id_pembimbing
                FROM tb_bidang
                LEFT JOIN tb_profile_user 
                    ON tb_bidang.id_bidang = tb_profile_user.id_bidang
                LEFT JOIN tb_user 
                    ON tb_profile_user.id_user = tb_user.id_user
                WHERE tb_bidang.id_instansi = '$id_instansi'
                AND (tb_user.level = '4' OR tb_user.level IS NULL)
                AND (tb_bidang.status_active = '1' OR tb_bidang.status_active = '0')
");

$no = 1;

// Handle tambah pembimbing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_pembimbing'])) {
    if (tambah_pembimbing($_POST) > 0) {
        echo "
            <script>
                tambah_pembimbing_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                tambah_pembimbing_admin_instansi_gagal();
            </script>
        ";
    }
}

// Handle hapus pembimbing
if (isset($_GET['id_pembimbing_ini'])) {
    $id = $_GET['id_pembimbing_ini'];
    if (hapus_pembimbing($id, $id_user)) {
        echo "
            <script>
                hapus_pembimbing_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                hapus_pembimbing_admin_instansi_gagal();
            </script>
        ";
    }
}

// Handle edit pembimbing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_pembimbing'])) {
    if (edit_pembimbing($_POST) > 0) {
        echo "
            <script>
                edit_pembimbing_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                edit_pembimbing_admin_instansi_gagal();
            </script>
        ";
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Pembimbing Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Data Daftar Pembimbing</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <?php
            $jumlahBidang = count($list_bidang);

            // Hitung berapa bidang yang belum punya pembimbing
            $bidangBelumAdaPembimbing = array_filter($list_bidang, function ($bidang) {
                return empty($bidang['id_pembimbing']);
            });

            $jumlahBidangBelumAdaPembimbing = count($bidangBelumAdaPembimbing);
            ?>
            <?php if ($jumlahBidang === 0): ?>
                <!-- Tidak ada bidang, maka tombol tidak ditampilkan -->
            <?php else: ?>
                <div class="mb-4 text-end">
                    <?php
                    $disabled = $jumlahBidangBelumAdaPembimbing === 0;
                    $btnClass = $disabled ? 'btn-secondary' : 'btn-primary';
                    $tombol = '<button type="button"
                        class="btn ' . $btnClass . ' btn-sm ms-2"
                        data-bs-toggle="modal"
                        data-bs-target="#tambahPembimbingModal"
                        title="Tambah Pembimbing"
                        ' . ($disabled ? 'disabled title="Semua bidang sudah memiliki pembimbing"' : '') . '>
                        <i class="bi bi-plus-circle-fill"></i>
                    </button>';
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="table-responsive-sm">
            <div class="datatable-header mb-2"></div> <!-- Tempat search dan show entries -->
            <div class="bungkus-2 datatable-scrollable">
                <table id="myTable" class="table table-striped table-hover nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pembimbing</th>
                            <th>Bidang</th>
                            <th>Jabatan</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bidang_list)): ?>
                            <?php foreach ($bidang_list as $pembimbing): ?>
                                <?php
                                // Ambil semua bidang yang sudah memiliki pembimbing
                                $bidangSudahAdaPembimbing = array_filter($list_bidang, function ($b) {
                                    return !empty($b['id_pembimbing']);
                                });

                                // Ambil id_bidang-nya
                                $idBidangTerpakai = array_column($bidangSudahAdaPembimbing, 'id_bidang');

                                // Hapus id_bidang milik pembimbing ini sendiri dari daftar yang akan di-disable
                                // $disabledBidang = array_values(array_diff($idBidangTerpakai, [$pembimbing['id_bidang']]));
                                $disabledBidang = $idBidangTerpakai;
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= ($pembimbing['nama_pembimbing']) ?></td>
                                    <td><?= ($pembimbing['nama_bidang']) ?></td>
                                    <td><?= ($pembimbing['jabatan'] ?: 'Jabatan belum diisi') ?></td>
                                    <td><?= ($pembimbing['telepone_pembimbing'] ?: 'Telepon belum diisi') ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm editPembimbingBtn me-2"
                                            data-bs-toggle="modal" data-bs-target="#editPembimbingModal"
                                            data-id_pembimbing="<?= $pembimbing['id_pembimbing'] ?>"
                                            data-nama_pembimbing="<?= $pembimbing['nama_pembimbing'] ?>"
                                            data-email_pembimbing="<?= $pembimbing['email_pembimbing'] ?>"
                                            data-nik="<?= $pembimbing['nik_pembimbing'] ?>"
                                            data-nip="<?= $pembimbing['nip'] ?>"
                                            data-jabatan="<?= $pembimbing['jabatan'] ?>"
                                            data-telepon="<?= $pembimbing['telepone_pembimbing'] ?>"
                                            data-id_bidang="<?= $pembimbing['id_bidang'] ?>"
                                            data-disabled_bidang='<?= json_encode($disabledBidang) ?>'
                                            title="Edit Data Pembimbing">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" onclick="hapus_pembimbing_admin_instansi('<?= $pembimbing['id_pembimbing'] ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="datatable-footer mt-2"></div> <!-- Tempat info dan pagination -->
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>

<!-- Modal Tambah Pembimbing -->
<div class="modal fade" id="tambahPembimbingModal" tabindex="-1" aria-labelledby="tambahPembimbingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPembimbingModalLabel">Tambah Pembimbing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateTambahPembimbing()">
                    <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pembimbing" class="form-label">Nama Pembimbing</label>
                            <input type="text" class="form-control" id="nama_pembimbing" name="nama_pembimbing" placeholder="Masukkan nama pembimbing">
                            <small id="nama_pembimbing_error" class="text-danger"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Pembimbing</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email pembimbing">
                            <small id="email_error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik_pembimbing" class="form-label">NIK Pembimbing</label>
                            <input type="text" class="form-control" id="nik_pembimbing" name="nik_pembimbing" placeholder="Masukkan NIK pembimbing">
                            <small id="nik_pembimbing_error" class="text-danger"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nip" class="form-label">NIP Pembimbing</label>
                            <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP pembimbing">
                            <small id="nip_error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan pembimbing">
                            <small id="jabatan_error" class="text-danger"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender_l" value="1">
                                    <label class="form-check-label" for="gender_l">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender_p" value="0">
                                    <label class="form-check-label" for="gender_p">Perempuan</label>
                                </div>
                            </div>
                            <small id="gender_error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepone_pembimbing" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepone_pembimbing" name="telepone_pembimbing" placeholder="Masukkan nomor telepon">
                            <small id="telepone_error" class="text-danger"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bidang" class="form-label">Pilih Bidang</label>
                            <?php if (!empty($list_bidang)): ?>
                                <select id="id_bidang" name="id_bidang" class="form-select select2">
                                    <?php foreach ($list_bidang as $bidang): ?>
                                        <option value="<?= $bidang['id_bidang']; ?>" <?= !empty($bidang['id_pembimbing']) ? 'disabled' : ''; ?>>
                                            <?= $bidang['nama_bidang']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <p>Tidak ada bidang yang tersedia.</p>
                            <?php endif; ?>
                            <small id="bidang_error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="tambah_pembimbing"> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pembimbing -->
<div class="modal fade" id="editPembimbingModal" tabindex="-1" aria-labelledby="editPembimbingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPembimbingModalLabel">Edit Pembimbing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateEditPembimbing()">
                    <input type="hidden" id="edit_id_user" name="edit_id_user" value="<?= $id_user ?>">
                    <input type="hidden" id="edit_id_pembimbing" name="edit_id_pembimbing">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pembimbing" class="form-label">Nama Pembimbing</label>
                            <input type="text" class="form-control" id="edit_nama_pembimbing" name="edit_nama_pembimbing">
                            <small id="edit_nama_pembimbing_error" class="text-danger"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Pembimbing</label>
                            <input type="email" class="form-control" id="edit_email" name="edit_email">
                            <small id="edit_email_error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik_pembimbing" class="form-label">NIK Pembimbing</label>
                            <input type="text" class="form-control" id="edit_nik_pembimbing" name="edit_nik_pembimbing">
                            <small id="edit_nik_pembimbing_error" class="text-danger"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nip" class="form-label">NIP Pembimbing</label>
                            <input type="text" class="form-control" id="edit_nip" name="edit_nip">
                            <small id="edit_nip_error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="edit_jabatan" name="edit_jabatan">
                            <small id="edit_jabatan_error" class="text-danger"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telepone_pembimbing" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="edit_telepone_pembimbing" name="edit_telepone_pembimbing">
                            <small id="edit_telepone_error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_bidang" class="form-label">Pilih Bidang</label>
                        <select id="edit_bidang" class="form-control" name="id_bidang">
                            <?php foreach ($list_bidang as $bidang): ?>
                                <option value="<?= $bidang['id_bidang'] ?>"><?= $bidang['nama_bidang'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small id="edit_bidang_error" class="text-danger"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="edit_pembimbing">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/validasi.js"></script>

<script>
    $('#editPembimbingModal').on('shown.bs.modal', function() {
        $('#edit_bidang').select2({
            dropdownParent: $('#editPembimbingModal'),
            placeholder: "Pilih Data",
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0
        });
    });

    $('#tambahPembimbingModal').on('shown.bs.modal', function() {
        $('#id_bidang').select2({
            dropdownParent: $('#tambahPembimbingModal'),
            placeholder: "Pilih Data",
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0
        });
    });

    // Event listener untuk nik
    document.getElementById("nik_pembimbing").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");

        const maxLength = 16;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    })

    // Event listener untuk nik edit
    document.getElementById("edit_nik_pembimbing").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");

        const maxLength = 16;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    })

    // Event listener untuk nip
    document.getElementById("nip").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");

        const maxLength = 18;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    })

    // Event listener untuk nip edit
    document.getElementById("edit_nip").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");

        const maxLength = 18;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    })

    // Event listener untuk telepon
    document.getElementById("telepone_pembimbing").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");

        const maxLength = 13;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    })

    // Event listener untuk telepon edit
    document.getElementById("edit_telepone_pembimbing").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");

        const maxLength = 13;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll(".editPembimbingBtn");

        editButtons.forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("edit_id_pembimbing").value = this.getAttribute("data-id_pembimbing");
                document.getElementById("edit_nama_pembimbing").value = this.getAttribute("data-nama_pembimbing");
                document.getElementById("edit_email").value = this.getAttribute("data-email_pembimbing");
                document.getElementById("edit_nik_pembimbing").value = this.getAttribute("data-nik");
                document.getElementById("edit_nip").value = this.getAttribute("data-nip");
                document.getElementById("edit_jabatan").value = this.getAttribute("data-jabatan");
                document.getElementById("edit_telepone_pembimbing").value = this.getAttribute("data-telepon");
                document.getElementById("edit_bidang").value = this.getAttribute("data-id_bidang");

                // Reset semua option: enable dulu semua
                const bidangSelect = document.getElementById("edit_bidang");
                Array.from(bidangSelect.options).forEach(option => {
                    option.disabled = false;
                });

                // Ambil bidang yang harus di-disable
                const disabledBidangRaw = this.getAttribute("data-disabled_bidang");
                let disabledBidang = [];

                try {
                    disabledBidang = JSON.parse(disabledBidangRaw);
                } catch (e) {
                    console.error("Gagal parse disabled_bidang:", e);
                }

                // Disable bidang yang tidak boleh dipilih
                Array.from(bidangSelect.options).forEach(option => {
                    if (disabledBidang.includes(option.value)) {
                        option.disabled = true;
                    }
                });

                // Set selected option
                bidangSelect.value = this.getAttribute("data-id_bidang");
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // $('#tambahPembimbingModal').on('shown.bs.modal', function() {
    //     $('#pilih_bidang').select2({
    //         dropdownParent: $('#tambahPembimbingModal')
    //     });
    // });

    $(document).ready(function() {
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
                emptyTable: "Tidak ada data pembimbing yang tersedia",
                zeroRecords: "Tidak ada data pembimbing yang cocok",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            }
        });

        // Tambahkan tombol ke samping search
        var tombol = `<?= $tombol ?>`;
        $('.dataTables_filter').append(tombol);
        // 🔥 Inisialisasi tooltip untuk tombol yang baru ditambahkan
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>