<?php include "../layout/header.php";

$id_pembimbing = $_GET["id"];
$id_instansi = $_SESSION["id_instansi"];

$edit_pembimbing = query("SELECT * FROM tb_profile_user WHERE id_user = $id_pembimbing")[0];
$list_bidang = query("SELECT tb_bidang.*, 
                    IFNULL(tb_profile_user.id_user, '') AS id_pembimbing
                FROM tb_bidang
                LEFT JOIN tb_profile_user 
                    ON tb_bidang.id_bidang = tb_profile_user.id_bidang
                LEFT JOIN tb_user 
                    ON tb_profile_user.id_user = tb_user.id_user
                WHERE tb_bidang.id_instansi = '$id_instansi'
                AND (tb_user.level = '5' OR tb_user.level IS NULL)
");

$id_bidang_terpilih = "";
foreach ($list_bidang as $bidang) {
    if ($bidang["id_pembimbing"] == $id_pembimbing) {
        $id_bidang_terpilih = $bidang["id_bidang"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_pembimbing'])) {
    if (!isset($_POST["id_bidang"]) || empty($_POST["id_bidang"])) {
        $_POST["id_bidang"] = $id_bidang_terpilih; 
    }
    // Cek apakah ada perubahan sebelum update
    if (cek_edit_pembimbing($conn, $_POST)) {
        echo "
            <script>
                Swal.fire({
                    title: 'Tidak Ada Perubahan!',
                    text: 'Data pembimbing telah disimpan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        ";
    } else {
        if (edit_pembimbing($_POST) > 0) {
            echo "
                <script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data pembimbing berhasil diperbarui!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.location.href = 'daftar_pembimbing.php';
                        }
                    });
                </script>
            ";
        } else {
            echo "
                <script>
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan, data pembimbing gagal diperbarui!',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    });
                </script>
            ";
        }
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Pembimbing</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Kelola Data Pembimbing Bidang</li>
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
            <input type="hidden" name="id_pembimbing" id="id_pembimbing" value="<?= $id_pembimbing ?>">
            <!-- Nama Pembimbing -->
            <div class="mb-3">
                <label for="nama_pembimbing" class="form-label">Nama Pembimbing</label>
                <input type="text" class="form-control" id="nama_pembimbing" name="nama_pembimbing" placeholder="Masukkan nama pembimbing" value="<?= $edit_pembimbing["nama_user"] ?>">
            </div>

            <!-- NIK -->
            <div class="mb-3">
                <label for="nik_pembimbing" class="form-label">NIK Pembimbing</label>
                <input type="text" class="form-control" id="nik_pembimbing" name="nik_pembimbing" placeholder="Masukkan NIK pembimbing" value="<?= $edit_pembimbing["nik"] ?>">
            </div>

            <!-- NIP -->
            <div class="mb-3">
                <label for="nip" class="form-label">NIP Pembimbing</label>
                <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP pembimbing" value="<?= $edit_pembimbing["nip"] ?>">
            </div>

            <!-- Jabatan -->
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan pembimbing" value="<?= $edit_pembimbing["jabatan"] ?>">
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label for="telepone_pembimbing" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepone_pembimbing" name="telepone_pembimbing" placeholder="Masukkan nomor telepon" value="<?= $edit_pembimbing["telepone_user"] ?>">
            </div>

            <!-- Bidang -->
            <div class="mb-3">
                <label for="bidang" class="form-label">Pilih Bidang</label>
                <select id="bidang" name="id_bidang" class="form-select select2">
                    <option disabled>Pilih Bidang</option>
                    <?php foreach ($list_bidang as $bidang): ?>
                        <option value="<?= $bidang['id_bidang']; ?>"
                            <?= ($bidang['id_bidang'] == $id_bidang_terpilih) ? 'selected' : ''; ?>
                            <?= !empty($bidang['id_pembimbing']) ? 'disabled' : ''; ?>>
                            <?= $bidang['nama_bidang']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary edit" name="edit_pembimbing"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>