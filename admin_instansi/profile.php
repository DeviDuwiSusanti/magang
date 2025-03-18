<?php
include "../layout/header.php";

$profile = query("SELECT * FROM tb_profile_user AS pu, tb_user AS u
                WHERE pu.id_user = '$id_user' 
                AND u.id_user = '$id_user'")[0];

$gender = ($profile["jenis_kelamin"] == '0' ? "Perempuan" : "Laki - Laki");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_profile'])) {
    // Cek apakah ada perubahan sebelum update
    if (cek_edit_profile($conn, $_POST)) {
        echo "
            <script>
                Swal.fire({
                    title: 'Tidak Ada Perubahan!',
                    text: 'Data profile telah disimpan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        ";
    } else {
        if (edit_profile($_POST) > 0) {
            echo "
                <script>
                    edit_profile_admin_instansi_success();
                </script>
            ";
        } else {
            echo "
                <script>
                    edit_profile_admin_instansi_gagal();
                </script>
            ";
        }
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Profile Saya</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman View Profile</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="container mt-5 mb-5">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body top-2">
                    <img src="../assets/img/user/<?= $profile["gambar_user"] ?: 'avatar_admin.jpg' ?>"
                        class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border: 2px solid #ccc;">
                    <h4 class="card-title"><?= $profile["nama_user"] ?></h4>
                    <p class="text-muted"><?= $profile["email"] ?></p>
                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td><?= $profile["nama_user"] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-envelope"></i> <strong>Email</strong></td>
                                    <td><?= $profile["email"] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                                    <td><?= $profile["telepone_user"] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-gender-ambiguous"></i> <strong>Gender</strong></td>
                                    <td><?= $gender ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                    <td><?= $profile["alamat_user"] ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="bi bi-calendar"></i> <strong>TTL</strong>
                                    </td>
                                    <td>
                                        <?= $profile["tempat_lahir"] ?>,
                                        <?php
                                        if (!empty($profile['tanggal_lahir'])) {
                                            echo date('d F Y', strtotime($profile['tanggal_lahir']));
                                        } else {
                                            echo "Tanggal Lahir Tidak Diketahui";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="bi bi-pencil"></i> Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                    <input type="hidden" name="id_user" value="<?= $profile["id_user"] ?>">
                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama_user" value="<?= $profile["nama_user"] ?>">
                        <small class="text-danger" id="nama_error"></small>
                    </div>
                    <!-- Tempat Lahir -->
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $profile["tempat_lahir"] ?>">
                        <small class="text-danger" id="tempat_lahir_error"></small>
                    </div>
                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $profile["tanggal_lahir"] ?>">
                        <small class="text-danger" id="tanggal_lahir_error"></small>
                    </div>
                    <!-- Gender -->
                    <div class="mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender_l" value="1" <?= ($profile["jenis_kelamin"] == 1) ? "checked" : "" ?>>
                                <label class="form-check-label" for="gender_l">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender_p" value="0" <?= ($profile["jenis_kelamin"] == 0) ? "checked" : "" ?>>
                                <label class="form-check-label" for="gender_p">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <!-- Telepon -->
                    <div class="mb-3">
                        <label for="no_telepone" class="form-label">No. Telepon</label>
                        <input type="tel" pattern="[0-9]{8,15}" maxlength="15" inputmode="numeric" class="form-control" id="no_telepone" name="telepone" value="<?= $profile["telepone_user"] ?>">
                        <small id="telepon_error" class="text-danger"></small>
                    </div>
                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat_user" rows="3"><?= $profile["alamat_user"] ?></textarea>
                        <small class="text-danger" id="alamat_error"></small>
                    </div>
                    <!-- Upload Foto Profil -->
                    <div class="mb-3">
                        <label for="image">Foto Profil</label><br><br>
                        <div class="image-preview" id="imagePreview">
                            <img src="../assets/img/user/<?= $profile["gambar_user"] ?: 'avatar.png' ?>" id="previewImage" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; object-position: top;">
                            <input type="hidden" name="gambar_lama" id="gambar_lama" value="<?= $profile["gambar_user"] ?>">
                        </div>
                        <input type="file" class="input form-control" id="image" name="gambar" accept="image/*" onchange="validateFile()">
                        <small class="text-muted">Kosong Jika tidak ingin di ganti</small>
                    </div>
                    <!-- Submit Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="edit_profile" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
<script src="../assets/js/validasi.js"></script>

<!-- JavaScript untuk Modal dan Validasi -->
<script>
    // Fungsi untuk validasi file
    function validateFile() {
        const fileInput = document.getElementById('image');
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const file = fileInput.files[0];

        if (file) {
            if (file.size > 1048576) { // 1MB = 1048576 bytes
                alert("Ukuran file terlalu besar! Maksimal 1MB.");
                fileInput.value = ""; // Reset file input
                previewImage.src = "../assets/img/user/<?= $profile["gambar_user"] ?>"; // Kembalikan ke gambar lama
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; // Tampilkan pratinjau gambar baru
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    // Fungsi untuk validasi form edit
    // function validateEditForm() {
    //     let telepon = document.getElementById('no_telepone').value;
    //     let isValid = true;

    //     // Validasi Telepon
    //     if (!/^\d+$/.test(telepon)) {
    //         document.getElementById('telepon_error').textContent = "Telepon hanya boleh berisi angka.";
    //         isValid = false;
    //     } else {
    //         document.getElementById('telepon_error').textContent = "";
    //     }

    //     return isValid;
    // }

    // // Event listener untuk input telepon
    // document.getElementById("no_telepone").addEventListener("input", function(e) {
    //     this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    // });
</script>