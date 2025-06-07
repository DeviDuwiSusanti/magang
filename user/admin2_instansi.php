<?php include '../layout/sidebarUser.php';

$instansi = "SELECT * 
    FROM tb_instansi
    JOIN tb_profile_user 
        ON tb_instansi.id_instansi = tb_profile_user.id_instansi
    WHERE tb_profile_user.id_user = '$id_user'";

$query = mysqli_query($conn, $instansi);
$instansi = mysqli_fetch_assoc($query);

var_dump($instansi['change_date']);

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

<style>
    /* Light Mode Styles */
    .profile-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: none;
        background-color: #ffffff;
    }

    .profile-header {
        background: linear-gradient(135deg, #0d6efd, #4f46e5);
        color: white;
    }

    .profile-image-container {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: all 0.3s ease;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .profile-image-container:hover .image-overlay {
        opacity: 1;
    }

    .profile-image-container:hover .profile-image {
        transform: scale(1.05);
    }

    .profile-name {
        font-weight: 600;
        color: #2c3e50;
        margin-top: 15px;
    }

    .profile-badge {
        background-color: #e3f2fd;
        color: #0d6efd;
    }

    .website-btn {
        transition: all 0.2s ease;
    }

    .website-btn:hover {
        background-color: #0d6efd;
        color: white;
    }

    .profile-section {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .section-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .contact-info {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .contact-icon {
        font-size: 1.2rem;
        color: #0d6efd;
        margin-right: 10px;
        margin-top: 3px;
    }

    .contact-label {
        font-weight: 600;
        margin-bottom: 3px;
        color: #2c3e50;
    }

    .contact-value {
        margin: 0;
        color: #6c757d;
    }

    .map-placeholder {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    .map-preview {
        margin-bottom: 15px;
    }

    .map-icon {
        font-size: 2.5rem;
        color: #0d6efd;
    }

    .map-text {
        margin-top: 10px;
        color: #6c757d;
    }

    .map-btn {
        transition: all 0.2s ease;
    }

    .map-btn:hover {
        background-color: #0d6efd;
        color: white;
    }

    .empty-alert {
        border: 1px solid #dee2e6;
    }

    .profile-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #eee;
    }

    /* Dark Mode Styles */
    body.dark-mode .profile-card {
        background-color: #2d3748;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    body.dark-mode .profile-header {
        /* background-color: #1e40af; */
        background: linear-gradient(135deg, #1e40af, #3730a3);
    }

    body.dark-mode .profile-name {
        color: #f1f1f1;
    }

    body.dark-mode .section-title {
        color: #f1f1f1;
    }

    body.dark-mode .contact-label {
        color: #e2e8f0;
    }

    body.dark-mode .contact-value {
        color: #a0aec0;
    }

    body.dark-mode .profile-section {
        border-bottom-color: #4a5568;
    }

    body.dark-mode .map-placeholder {
        background-color: #4a5568;
        border-color: #4a5568;
    }

    body.dark-mode .map-text {
        color: #cbd5e0;
    }

    body.dark-mode .empty-alert {
        background-color: #4a5568;
        border-color: #4a5568;
        color: #cbd5e0;
    }

    body.dark-mode .profile-footer {
        background-color: #2d3748;
        border-top-color: #4a5568;
    }

    body.dark-mode .update-text {
        color: #a0aec0 !important;
    }

    body.dark-mode .profile-badge {
        background-color: #1e3656;
        color: #93c5fd;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-image-container {
            width: 150px;
            height: 150px;
        }

        .profile-name {
            font-size: 1.5rem;
        }

        .profile-section {
            margin-top: 20px;
        }
    }

    @media (max-width: 576px) {
        .profile-image-container {
            width: 120px;
            height: 120px;
        }
    }
</style>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mt-3 greeting-text">Profil Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
            <li class="breadcrumb-item active breadcrumb-link text-muted update-text">Profil Instansi</li>
        </ol>
        <div class="card profile-card">
            <div class="card-header profile-header">
                <h5 class="mb-0 profile-title"><i class="bi bi-building me-2"></i>Informasi Instansi</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Bagian Kiri (Foto Profil dan Info Singkat) -->
                    <div class="col-md-4 text-center">
                        <div class="profile-image-container mb-4">
                            <img src="<?= $instansi["gambar_instansi"] ?: 'logo_kab_sidoarjo.png' ?>"
                                class="profile-image"
                                alt="Logo Instansi">
                            <div class="image-overlay">
                                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editInstansiModal">
                                    <i class="bi bi-camera"></i> Ganti Gambar
                                </button>
                            </div>
                        </div>

                        <h4 class="profile-name"><?= $instansi["nama_panjang"] ?></h4>

                        <div class="profile-badge mb-4">
                            <span class="badge profile-badge">
                                <i class="bi bi-house-door me-1"></i> Instansi Pemerintah
                            </span>
                        </div>

                        <div class="profile-website mb-4">
                            <?php if (!empty($instansi["website_resmi_instansi"])): ?>
                                <a href="<?= htmlspecialchars($instansi["website_resmi_instansi"]) ?>"
                                    target="_blank"
                                    class="btn btn-secondary website-btn">
                                    <i class="bi bi-globe me-1"></i> Kunjungi Website
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary website-btn" disabled>
                                    <i class="bi bi-globe me-1"></i> Website Belum Diatur
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editInstansiModal">
                                <i class="bi bi-pencil-square me-1"></i> Edit Profil
                            </button>
                        </div>
                    </div>

                    <!-- Bagian Kanan (Detail Informasi) -->
                    <div class="col-md-8">
                        <div class="profile-section">
                            <h5 class="section-title"><i class="bi bi-info-circle me-2"></i>Deskripsi Instansi</h5>
                            <div class="section-content">
                                <?= $instansi["deskripsi_instansi"] ?:
                                    '<div class="alert alert-light empty-alert" role="alert">
                                        <i class="bi bi-info-circle me-2"></i> Deskripsi instansi belum diatur.
                                    </div>' ?>
                            </div>
                        </div>

                        <div class="profile-section">
                            <h5 class="section-title"><i class="bi bi-geo-alt me-2"></i>Informasi Kontak</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="contact-info">
                                        <i class="bi bi-geo-alt-fill contact-icon"></i>
                                        <div>
                                            <h6 class="contact-label">Alamat</h6>
                                            <p class="contact-value"><?= $instansi["alamat_instansi"] ?: 'Belum diatur' ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-info">
                                        <i class="bi bi-telephone-fill contact-icon"></i>
                                        <div>
                                            <h6 class="contact-label">Telepon</h6>
                                            <p class="contact-value"><?= $instansi["telepone_instansi"] ?: 'Belum diatur' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-section">
                            <h5 class="section-title"><i class="bi bi-map me-2"></i>Lokasi Instansi</h5>
                            <div class="section-content">
                                <?php if (!empty($instansi["lokasi_instansi"])): ?>
                                    <div class="map-placeholder">
                                        <div class="map-preview">
                                            <i class="bi bi-map map-icon"></i>
                                            <p class="map-text">Pratinjau lokasi instansi</p>
                                        </div>
                                        <a href="<?= htmlspecialchars($instansi["lokasi_instansi"]) ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="btn btn-primary map-btn">
                                            <i class="bi bi-geo-alt"></i> Buka di Google Maps
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-light empty-alert" role="alert">
                                        <i class="bi bi-map me-2"></i> Lokasi instansi belum diatur.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer profile-footer">
                <!-- <small class="text-muted update-text">Terakhir diperbarui: <?= $instansi["change_date"] ?></small> -->
                <small class="text-muted update-text">Terakhir diperbarui: <?= date("d-m-Y", strtotime($instansi["change_date"])) ?></small>

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
                            <input type="text" class="form-control" data-error-id="telepone_instansi_error"
                                id="telepone_instansi" name="telepone_instansi"
                                placeholder="(021) 12345678 atau 0812-1234-5678"
                                value="<?= $instansi["telepone_instansi"] ?>">
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
                            <textarea class="form-control" data-error-id="lokasi_instansi_error" id="lokasi_instansi" name="lokasi_instansi" rows="5" placeholder="Masukkan link lokasi"><?= $instansi["lokasi_instansi"] ?></textarea>
                            <small class="text-muted">*Link harus berasal dari Google Maps</small> <br>
                            <small class="text-danger" id="lokasi_instansi_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_website" class="form-label">Link Website</label>
                            <textarea class="form-control" data-error-id="website_instansi_error" id="website_resmi_instansi" name="website_resmi_instansi" rows="5" placeholder="Masukkan link website instansi"><?= $instansi["website_resmi_instansi"] ?></textarea>
                            <small class="text-muted">*Link website resmi instansi</small> <br>
                            <small class="text-danger" id="website_instansi_error"></small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_instansi" class="form-label">Foto Profil</label>
                        <div class="image-preview">
                            <img src="../assets/img/instansi/<?= $instansi["gambar_instansi"] ?: 'logo_kab_sidoarjo.png' ?>" id="previewImage" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                            <input type="hidden" name="gambar_instansi_lama" id="gambar_instansi_lama" value="<?= $instansi["gambar_instansi"] ?>">
                        </div>
                        <input type="file" class="form-control" data-error-id="gambar_instansi_error" id="gambar_instansi_edit" name="gambar_instansi" accept="image/*" onchange="previewFile()">
                        <small class="text-muted">Kosong Jika tidak ingin di ganti (ukuran max. 1MB)</small> <br>
                        <small class="text-danger" id="gambar_instansi_error"></small>
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
                previewImage.src = e.target.result;
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    document.getElementById("telepone_instansi").addEventListener("input", function(e) {
        // Izinkan angka, spasi, tanda kurung, titik, strip, plus
        this.value = this.value.replace(/[^0-9\s\$\-\+\.\(\)]/g, "");

        const maxLength = 15;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    });
</script>