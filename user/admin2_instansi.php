<?php include '../layout/sidebarUser.php';

$instansi = "SELECT * 
    FROM tb_instansi
    JOIN tb_profile_user 
        ON tb_instansi.id_instansi = tb_profile_user.id_instansi
    WHERE tb_profile_user.id_user = '$id_user'";

$query = mysqli_query($conn, $instansi);
$instansi = mysqli_fetch_assoc($query);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_instansi'])) {
    // Cek apakah ada perubahan sebelum update
    if (cek_edit_instansi($conn, $_POST)) {
        echo "
            <script>
                Swal.fire({
                    title: 'Tidak Ada Perubahan!',
                    text: 'Data instansi telah disimpan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        ";
    } else {
        if (edit_instansi_super_admin($_POST) > 0) {
            echo "
                <script>
                    edit_instansi_admin_instansi_success();
                </script>
            ";
        } else {
            echo "
                <script>
                    edit_instansi_admin_instansi_gagal();
                </script>
            ";
        }
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mt-3">Profile Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Data Profile Instansi</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="container mt-5 mb-5">
            <div class="card mx-auto" style="max-width: 950px;">
                <div class="card-body top-2">
                    <img src="../assets/img/instansi/<?= $instansi["gambar_instansi"] ?: 'logo_kab_sidoarjo.png' ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover; object-position: top;">
                    <h4 class="card-title judul"><?= $instansi["nama_panjang"] ?></h4>

                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-buildings"></i> <strong>Nama Instansi</strong></td>
                                    <td><?= $instansi["nama_panjang"] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-card-text"></i> <strong>Deskripsi</strong></td>
                                    <td><?= $instansi["deskripsi_instansi"] ?: 'Deskripsi belum diatur' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                    <td><?= $instansi["alamat_instansi"] ?: 'Alamat belum diatur' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar"></i> <strong>Telepon</strong></td>
                                    <td><?= $instansi["telepone_instansi"] ?: 'Telepon belum diatur' ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editInstansiModal">
                                <i class="bi bi-pencil me-1"></i>Edit Instansi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Instansi -->
<div class="modal fade" id="editInstansiModal" tabindex="-1" aria-labelledby="editInstansiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInstansiModalLabel">Edit Instansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateEditInstansi()">
                    <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                    <input type="hidden" name="id_instansi" value="<?= $instansi["id_instansi"] ?>">
                    <input type="hidden" id="group_instansi" name="group_instansi" value="<?= $instansi["group_instansi"] ?>">
                    <div class="mb-3">
                        <label for="nama_panjang" class="form-label">Nama Lengkap Instansi</label>
                        <input type="text" class="form-control" data-error-id="nama_panjang_error" id="nama_panjang" name="nama_panjang" placeholder="Masukkan nama instansi" value="<?= $instansi["nama_panjang"] ?>">
                        <small class="text-danger" id="nama_panjang_error"></small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pendek" class="form-label">Nama Singkat Instansi</label>
                            <input type="text" class="form-control" data-error-id="nama_pendek_error" id="nama_pendek" name="nama_pendek" placeholder="Masukkan nama instansi" value="<?= $instansi["nama_pendek"] ?>">
                            <small class="text-danger" id="nama_pendek_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telepone_instansi" class="form-label">Telepon</label>
                            <input type="text" class="form-control" data-error-id="telepone_instansi_error" id="telepone_instansi" name="telepone_instansi" placeholder="Masukkan nomor telepon" value="<?= $instansi["telepone_instansi"] ?>">
                            <small class="text-danger" id="telepone_instansi_error"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="deskripsi_instansi" class="form-label">Deskripsi Instansi</label>
                            <textarea class="form-control" data-error-id="deskripsi_instansi_error" id="deskripsi_instansi" name="deskripsi_instansi" rows="5" placeholder="Masukkan deskripsi instansi"><?= $instansi["deskripsi_instansi"] ?></textarea>
                            <small class="text-danger" id="deskripsi_instansi_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat_instansi" class="form-label">Alamat</label>
                            <textarea class="form-control" data-error-id="alamat_instansi_error" id="alamat_instansi" name="alamat_instansi" rows="5" placeholder="Masukkan alamat lengkap"><?= $instansi["alamat_instansi"] ?></textarea>
                            <small class="text-danger" id="alamat_instansi_error"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lokasi_instansi" class="form-label">Link Lokasi</label>
                            <textarea class="form-control" data-error-id="lokasi_instansi_error" id="lokasi_instansi" name="lokasi_instansi" rows="7" placeholder="Masukkan link lokasi"><?= $instansi["lokasi_instansi"] ?></textarea>
                            <small class="text-muted">*Link harus berasal dari Google Maps</small> <br>
                            <small class="text-danger" id="lokasi_instansi_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gambar_instansi" class="form-label">Foto Profil</label>
                            <div class="image-preview">
                                <img src="../assets/img/instansi/<?= $instansi["gambar_instansi"] ?: 'logo_kab_sidoarjo.png' ?>" id="previewImage" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                                <input type="hidden" name="gambar_instansi_lama" id="gambar_instansi_lama" value="<?= $instansi["gambar_instansi"] ?>">
                            </div>
                            <input type="file" class="form-control" data-error-id="gambar_instansi_error" id="gambar_instansi_edit" name="gambar_instansi" accept="image/*" onchange="previewFile()">
                            <small class="text-muted">Kosong Jika tidak ingin di ganti</small> <br>
                            <small class="text-danger" id="gambar_instansi_error"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="edit_instansi">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>
<script src="../assets/js/validasi.js"></script>

<script>
    // Fungsi untuk validasi file
    function previewFile() {
        const fileInput = document.getElementById('gambar_instansi_edit');
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; // Tampilkan pratinjau gambar baru
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    // Event listener untuk input telepon
    document.getElementById("telepone_instansi").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka

        const maxLength = 15;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    });
</script>