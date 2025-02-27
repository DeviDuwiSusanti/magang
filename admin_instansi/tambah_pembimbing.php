<?php include "../layout/header.php";

$id_instansi = $_SESSION["id_instansi"];
// $list_bidang = query("SELECT * FROM tb_bidang WHERE id_instansi = '$id_instansi'");
$list_bidang = query("SELECT tb_bidang.*, 
                    IFNULL(tb_profile_user.id_user, '') AS id_pembimbing
                FROM tb_bidang
                LEFT JOIN tb_profile_user 
                    ON tb_bidang.id_bidang = tb_profile_user.id_bidang
                LEFT JOIN tb_user 
                    ON tb_profile_user.id_user = tb_user.id_user
                WHERE tb_bidang.id_instansi = '$id_instansi'
                AND (tb_user.level = '5' OR tb_user.level IS NULL) -- Tetap ambil bidang meskipun tidak ada pembimbing
");

$status = "";
if (isset($_POST["tambah_pembimbing"])) {
    if (tambah_pembimbing($_POST) > 0) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Tambah Pembimbing</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Tambah Pembimbing Bidang</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        <div class="mb-4 text-end">
            <a href="daftar_pembimbing.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>

        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
            <!-- Nama Pembimbing -->
            <div class="mb-3">
                <label for="nama_pembimbing" class="form-label">Nama Pembimbing</label>
                <input type="text" class="form-control" id="nama_pembimbing" name="nama_pembimbing" placeholder="Masukkan nama pembimbing">
            </div>

            <!-- Nama Pembimbing -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Pembimbing</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email pembimbing">
            </div>

            <!-- NIK -->
            <div class="mb-3">
                <label for="nik_pembimbing" class="form-label">NIK Pembimbing</label>
                <input type="text" class="form-control" id="nik_pembimbing" name="nik_pembimbing" placeholder="Masukkan NIK pembimbing">
            </div>

            <!-- NIP -->
            <div class="mb-3">
                <label for="nip" class="form-label">NIP Pembimbing</label>
                <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP pembimbing">
            </div>

            <!-- Jabatan -->
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan pembimbing">
            </div>

            <!-- Gender -->
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
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label for="telepone_pembimbing" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepone_pembimbing" name="telepone_pembimbing" placeholder="Masukkan nomor telepon">
            </div>

            <!-- Bidang -->
            <div class="mb-3">
                <label for="bidang" class="form-label">Pilih Bidang</label>
                <select id="bidang" name="id_bidang" class="form-select select2">
                    <option selected disabled>Pilih Bidang</option>
                    <?php foreach ($list_bidang as $bidang): ?>
                        <option value="<?= $bidang['id_bidang']; ?>"
                            <?= !empty($bidang['id_pembimbing']) ? 'disabled' : ''; ?>>
                            <?= $bidang['nama_bidang']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit" name="tambah_pembimbing"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    <?php if ($status === "success"): ?>
        alertSuccessEdit('Data pembimbing berhasil ditambahkan.', 'daftar_pembimbing.php');
    <?php elseif ($status === "error"): ?>
        alertSuccessEdit('Tidak ada perubahan. Data pembimbing disimpan.', 'daftar_pembimbing.php');
    <?php endif; ?>
</script>