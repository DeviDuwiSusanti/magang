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
                AND (tb_user.level = '5' OR tb_user.level IS NULL)
                AND tb_bidang.status_active = '1' OR tb_bidang.status_active = '0'
");

$no = 1;

$jumlahBidang = count($list_bidang);

// Hitung berapa bidang yang belum punya pembimbing
$bidangBelumAdaPembimbing = array_filter($list_bidang, function ($bidang) {
    return empty($bidang['id_pembimbing']);
});

$jumlahBidangBelumAdaPembimbing = count($bidangBelumAdaPembimbing);

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
            <?php if ($jumlahBidang === 0): ?>
                <!-- Tidak ada bidang, maka tombol tidak ditampilkan -->
            <?php else: ?>
                <div class="mb-4 text-end">
                    <?php
                    $disabled = $jumlahBidangBelumAdaPembimbing === 0;
                    $btnClass = $disabled ? 'btn-secondary' : 'btn-primary';
                    ?>
                    <button type="button"
                        class="btn <?= $btnClass ?> btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#tambahPembimbingModal"
                        <?= $disabled ? 'disabled title="Semua bidang sudah memiliki pembimbing"' : '' ?>>
                        <i class="bi bi-plus-circle me-1"></i> Tambah Pembimbing
                    </button>
                </div>
            <?php endif; ?>


            <!-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPembimbingModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Pembimbing
            </button> -->
        </div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
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
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= ($pembimbing['nama_pembimbing']) ?></td>
                                    <td><?= ($pembimbing['nama_bidang']) ?></td>
                                    <td><?= ($pembimbing['jabatan']) ?></td>
                                    <td><?= ($pembimbing['telepone_pembimbing']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm editPembimbingBtn"
                                            data-bs-toggle="modal" data-bs-target="#editPembimbingModal"
                                            data-id_pembimbing="<?= $pembimbing['id_pembimbing'] ?>"
                                            data-nama_pembimbing="<?= $pembimbing['nama_pembimbing'] ?>"
                                            data-nik="<?= $pembimbing['nik_pembimbing'] ?>"
                                            data-nip="<?= $pembimbing['nip'] ?>"
                                            data-jabatan="<?= $pembimbing['jabatan'] ?>"
                                            data-telepon="<?= $pembimbing['telepone_pembimbing'] ?>"
                                            data-id_bidang="<?= $pembimbing['id_bidang'] ?>">
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
        </div>
    </div>
</div>

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

                    <div class="mb-3">
                        <label for="nama_pembimbing" class="form-label">Nama Pembimbing</label>
                        <input type="text" class="form-control" id="nama_pembimbing" name="nama_pembimbing" placeholder="Masukkan nama pembimbing">
                        <small id="nama_pembimbing_error" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Pembimbing</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email pembimbing">
                        <small id="email_error" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label for="nik_pembimbing" class="form-label">NIK Pembimbing</label>
                        <input type="text" class="form-control" id="nik_pembimbing" name="nik_pembimbing" placeholder="Masukkan NIK pembimbing">
                        <small id="nik_pembimbing_error" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP Pembimbing</label>
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP pembimbing">
                        <small id="nip_error" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan pembimbing">
                        <small id="jabatan_error" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
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

                    <div class="mb-3">
                        <label for="telepone_pembimbing" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepone_pembimbing" name="telepone_pembimbing" placeholder="Masukkan nomor telepon">
                        <small id="telepone_error" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
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
                    <div class="mb-3">
                        <label for="nama_pembimbing" class="form-label">Nama Pembimbing</label>
                        <input type="text" class="form-control" id="edit_nama_pembimbing" name="edit_nama_pembimbing">
                        <small id="edit_nama_pembimbing_error" class="text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="nik_pembimbing" class="form-label">NIK Pembimbing</label>
                        <input type="text" class="form-control" id="edit_nik_pembimbing" name="edit_nik_pembimbing">
                        <small id="edit_nik_pembimbing_error" class="text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP Pembimbing</label>
                        <input type="text" class="form-control" id="edit_nip" name="edit_nip">
                        <small id="edit_nip_error" class="text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="edit_jabatan" name="edit_jabatan">
                        <small id="edit_jabatan_error" class="text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="telepone_pembimbing" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="edit_telepone_pembimbing" name="edit_telepone_pembimbing">
                        <small id="edit_telepone_error" class="text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_bidang" class="form-label">Pilih Bidang</label>
                        <select id="edit_bidang" name="id_bidang" class="form-select select2">
                            <option disabled>Pilih Bidang</option>
                            <?php foreach ($list_bidang as $bidang): ?>
                                <option value="<?= $bidang['id_bidang']; ?>"
                                    <?= (!empty($bidang['id_pembimbing']) && $bidang['id_pembimbing'] != $pembimbing['id_pembimbing']) ? 'disabled' : ''; ?>>
                                    <?= $bidang['nama_bidang']; ?>
                                </option>
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

<?php include "../layout/footerDashboard.php" ?>
<script src="../assets/js/validasi.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll(".editPembimbingBtn");

        editButtons.forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("edit_id_pembimbing").value = this.getAttribute("data-id_pembimbing");
                document.getElementById("edit_nama_pembimbing").value = this.getAttribute("data-nama_pembimbing");
                document.getElementById("edit_nik_pembimbing").value = this.getAttribute("data-nik");
                document.getElementById("edit_nip").value = this.getAttribute("data-nip");
                document.getElementById("edit_jabatan").value = this.getAttribute("data-jabatan");
                document.getElementById("edit_telepone_pembimbing").value = this.getAttribute("data-telepon");
                document.getElementById("edit_bidang").value = this.getAttribute("data-id_bidang");

                // Atur bidang yang sesuai dengan id_pembimbing
                let idBidangPembimbing = this.getAttribute("data-id_bidang");
                let bidangSelect = document.getElementById("edit_bidang");

                for (let option of bidangSelect.options) {
                    if (option.value === idBidangPembimbing) {
                        option.selected = true; // Pilih bidang yang sesuai
                        option.disabled = true; // Pastikan bidangnya tidak di-disable
                    } else if (option.hasAttribute("disabled")) {
                        option.disabled = true; // Tetap disable bidang lain yang sudah ada pembimbingnya
                    }
                }
            });
        });
    });
</script>