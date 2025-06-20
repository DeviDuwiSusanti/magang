<?php
include '../layout/sidebarUser.php';

// Query untuk mengambil data user
$user = query("SELECT u.*, p.*, i.nama_pendek, b.nama_bidang FROM tb_profile_user p 
                JOIN tb_user u ON p.id_user = u.id_user 
                LEFT JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                LEFT JOIN tb_bidang b ON p.id_bidang = b.id_bidang
                WHERE u.status_active = '1' AND p.status_active = '1'");
$no = 1;

// Handle hapus data
if (isset($_GET["id_user_ini"])) {
    $id_user_ini = $_GET["id_user_ini"];
    if (hapus_user_super_admin($id_user_ini, $id_user)) { ?>
        <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Hapus Data User Berhasil", "super1_user.php"); </script>
    <?php } else { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Hapus Data User Gagal", "super1_user.php"); </script>
    <?php }
}

// Handle tambah data
if (isset($_POST["tambah_admin_instansi"])) {
    $result = tambah_user_by_super_admin($_POST);
    if ($result === 404) { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Email Sudah Terdaftar Didalam Database, Silahkan Periksa Atau gunakan email Yang Lain", "super1_user.php"); </script>
    <?php } else if ($result === 405) { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "NIK Sudah Terdaftar Didialam Database, Silahkan Periksa Atau Gunakan NIK Yang Lain", "super1_user.php"); </script>
    <?php } else if ($result === 406) { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "NIP Sudah Terdaftar Didialam Database, Silahkan Periksa Atau Gunakan NIP Yang Lain", "super1_user.php"); </script>
    <?php } else if ($result > 0) { ?>
        <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Tambah Data User Berhasil", "super1_user.php"); </script>
    <?php } else { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Tambah Data User Gagal", "super1_user.php"); </script>
    <?php  }
}

// Handle edit data
if (isset($_POST["edit_data_user"])) {
    $result = super_admin_edit($_POST);
    if ($result > 0) { ?>
        <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Tambah Data User Berhasil", "super1_user.php"); </script>
    <?php } else { ?>
        <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Tambah Data User Gagal", "super1_user.php"); </script>
    <?php  }
}
?>


<!-- Modal Preview Gambar -->
<div id="imageModalPreview" class="image-modal" onclick="closeImageModal()">
    <span class="image-modal-close">&times;</span>
    <img class="image-modal-content" id="modalPreviewImage">
</div>

<style>
    /* style for preview image */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999; /* Lebih tinggi dari modal Bootstrap */
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.85);
        justify-content: center;
        align-items: center;
    }

    .image-modal-content {
        max-width: 90%;
        max-height: 90vh;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .image-modal-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10000;
    }

    .image-modal-close:hover {
        color: #ccc;
    }
</style>



<main class="main-content p-3">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Halaman Daftar User</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>
    </div>
    <div class="container mt-5 mb-5">
        <!-- Tambah Data Button -->
        <div class="mb-3 text-end">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Admin Instansi
            </button>
        </div>

        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_user" class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Gender</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Gambar</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $u) :
                            $jenis_kelamin = ($u["jenis_kelamin"] == "0" ? "Perempuan" : "Laki - Laki");
                            $admin_instansi = (($u["id_instansi"] == "") ? "Calon Admin Instansi" : "Admin " . $u["nama_pendek"]);
                            $pembimbing_bidang = (($u["id_bidang"] == "") ? "Calon Pembimbing Bidang" : "Pembimbing " . $u["nama_bidang"]);
                            $level = "";
                            if ($u["level"] == "1") {
                                $level = "Super Admin";
                            }
                            if ($u["level"] == "2") {
                                $level = $admin_instansi;
                            }
                            if ($u["level"] == "3") {
                                $level = "User";
                            }
                            if ($u["level"] == "4") {
                                $level = $pembimbing_bidang;
                            }
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $u["nama_user"] ?></td>
                                <td><?= $jenis_kelamin ?></td>
                                <td><?= $u["tempat_lahir"] ?>, <?= $u["tanggal_lahir"] ?></td>
                                <td><?= $u["telepone_user"] ?></td>
                                <td><?= $u["alamat_user"] ?></td>
                                <td>
                                    <img src="../assets/img/user/<?= !empty($u['gambar_user']) ? $u['gambar_user'] : 'avatar.png' ?>" alt="Gambar user" class="img-thumbnail" style="width: 100px;" onclick="openImageModal(this)">
                                </td>
                                <td><?= $level ?></td>
                                <td class="d-flex justify-content-center gap-2">
                                    <?php if ($u["level"] == '1' || $u["level"] == '2') { ?>
                                        <a href="#" class="btn btn-danger btn-sm" onclick="confirm_hapus_user_super_admin(<?= $u['id_user'] ?>)">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <button type="button" class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-id="<?= $u['id_user'] ?>"
                                            data-nama="<?= htmlspecialchars($u['nama_user']) ?>"
                                            data-tempat-lahir="<?= htmlspecialchars($u['tempat_lahir']) ?>"
                                            data-tanggal-lahir="<?= $u['tanggal_lahir'] ?>"
                                            data-jenis-kelamin="<?= $u['jenis_kelamin'] ?>"
                                            data-telepon="<?= $u['telepone_user'] ?>"
                                            data-alamat="<?= htmlspecialchars($u['alamat_user']) ?>"
                                            data-gambar="<?= $u['gambar_user'] ?>"
                                            data-gambar-lama="<?= $u['gambar_user'] ?>"
                                            data-nik="<?= $u['nik'] ?>"
                                            data-nip="<?= $u['nip'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <?php } else { ?>
                                        <a href="#" class="btn btn-danger btn-sm" onclick="confirm_hapus_user_super_admin(<?= $u['id_user'] ?>)">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Admin Instansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambah" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
                    <input type="hidden" name="level" id="level" value="2">
                    
                    <div class="mb-3">  
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_user" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" required maxlength="16">
                            <small id="nik_error" class="text-danger"></small>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" required maxlength="18">
                            <small id="nip_error" class="text-danger"></small>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-group">
                                <label class="form-label">Pilih Jenis Kelamin:</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="male" name="jenis_kelamin" value="1" required>
                                        <label class="form-check-label" for="male">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="female" name="jenis_kelamin" value="0" required>
                                        <label class="form-check-label" for="female">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="tel" class="form-control" id="telepon" name="telepone_user" pattern="[0-9]{8,15}" maxlength="15">
                            <small id="telepon_error" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat_user" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Upload Foto</label>
                        <div class="image-preview" id="imagePreviewTambah">
                            <img src="../assets/img/avatar1.png" id="previewImageTambah" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;" onclick="openImageModal(this)">
                        </div>
                        <input type="file" class="form-control" id="gambar" name="gambar_user" accept="image/*" onchange="validateFileTambah()">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="tambah_admin_instansi" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Admin Instansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" id="edit_id_user">
                    <input type="hidden" name="gambar_lama" id="gambar_lama">
                    <input type="hidden" name="level" id="edit_level" value="2">

                    <div class="mb-3">
                        <label for="edit_nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_user" required>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="edit_nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="edit_nik" name="nik" required maxlength="16">
                            <small id="edit_nik_error" class="text-danger"></small>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="edit_nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="edit_nip" name="nip" required maxlength="18">
                            <small id="edit_nip_error" class="text-danger"></small>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="edit_tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="edit_tempat_lahir" name="tempat_lahir">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir">
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-group">
                                <label class="form-label">Pilih Jenis Kelamin:</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="edit_male" name="jenis_kelamin" value="1" required>
                                        <label class="form-check-label" for="edit_male">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="edit_female" name="jenis_kelamin" value="0" required>
                                        <label class="form-check-label" for="edit_female">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <label for="edit_telepon" class="form-label">Telepon</label>
                            <input type="tel" class="form-control" id="edit_telepon" name="telepone_user" pattern="[0-9]{8,15}" maxlength="15">
                            <small id="edit_telepon_error" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat_user" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_gambar" class="form-label">Upload Foto</label>
                        <div class="image-preview" id="imagePreviewEdit">
                            <img src="../assets/img/avatar1.png" id="previewImageEdit" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;" onclick="openImageModal(this)">
                        </div>
                        <input type="file" class="form-control" id="edit_gambar" name="gambar_user" accept="image/*" onchange="validateFileEdit()">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="edit_data_user" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include "../layout/footerDashboard.php" ?>

<!-- JavaScript untuk Modal dan Validasi -->
<script>
    // Fungsi untuk validasi file tambah data
    function validateFileTambah() {
        const fileInput = document.getElementById('gambar');
        const previewContainer = document.getElementById('imagePreviewTambah');
        const previewImage = document.getElementById('previewImageTambah');
        const file = fileInput.files[0];

        if (file) {
            if (file.size > 1048576) { // 1MB = 1048576 bytes
                alert("Ukuran file terlalu besar! Maksimal 1MB.");
                fileInput.value = ""; // Reset file input
                previewImage.src = "../assets/img/user/avatar.png"; // Kembalikan ke gambar default
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result; // Tampilkan pratinjau gambar baru
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    function openImageModal(img) {
        const modal = document.getElementById("imageModalPreview");
        const modalImg = document.getElementById("modalPreviewImage");

        modal.style.display = "flex"; // make it center using flex
        modalImg.src = img.src;
    }

    function closeImageModal() {
        document.getElementById("imageModalPreview").style.display = "none";
    }

    // Fungsi untuk validasi file edit data
    function validateFileEdit() {
        const fileInput = document.getElementById('edit_gambar');
        const previewContainer = document.getElementById('imagePreviewEdit');
        const previewImage = document.getElementById('previewImageEdit');
        const file = fileInput.files[0];

        if (file) {
            if (file.size > 1048576) { // 1MB = 1048576 bytes
                alert("Ukuran file terlalu besar! Maksimal 1MB.");
                fileInput.value = ""; // Reset file input
                previewImage.src = "../assets/img/user/avatar.png"; // Kembalikan ke gambar default
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result; // Tampilkan pratinjau gambar baru
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    $(document).ready(function() {
            // Validasi saat tombol submit ditekan
            $('#formTambah, formEdit').on('submit', function(event) {
                let isValid = true; // Flag untuk validasi
                let nik = $('#nik').val().trim();
                let nikError = $('#nik_error');
                let nisn = $('#nip').val().trim();
                let nisnError = $('#nip_error');

                // Validasi NIK
                if (nik.length === 0) {
                    nikError.text('NIK tidak boleh kosong!').show();
                    isValid = false;
                } else if (nik.length !== 16 || !/^\d+$/.test(nik)) {
                    nikError.text('NIK harus terdiri dari 16 digit angka!').show();
                    isValid = false;
                } else {
                    nikError.hide();
                }

                // Validasi NISN
                if (nisn.length === 0) {
                    nisnError.text('NIP tidak boleh kosong!').show();
                    isValid = false;
                } else if (nisn.length !== 18 || !/^\d+$/.test(nisn)) {
                    nisnError.text('NIP harus terdiri dari 18 digit angka!').show();
                    isValid = false;
                } else {
                    nisnError.hide();
                }

                // Jika tidak valid, hentikan submit
                if (!isValid) {
                    event.preventDefault(); // Mencegah halaman refresh
                }
            });
        });
    
    document.getElementById("nik").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    });
    document.getElementById("nip").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    });
    document.getElementById("telepon").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    });
    document.getElementById("edit_telepon").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
    });

    // Event listener untuk modal edit
document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Tombol yang memicu modal

        // Ambil atribut data
        var id = button.getAttribute('data-id');
        var nama = button.getAttribute('data-nama');
        var tempatLahir = button.getAttribute('data-tempat-lahir');
        var tanggalLahir = button.getAttribute('data-tanggal-lahir');
        var jenisKelamin = button.getAttribute('data-jenis-kelamin');
        var telepon = button.getAttribute('data-telepon');
        var alamat = button.getAttribute('data-alamat');
        var gambar = button.getAttribute('data-gambar');
        var gambarLama = button.getAttribute('data-gambar-lama');
        var nik = button.getAttribute('data-nik');
        var nip = button.getAttribute('data-nip');

        // Isi nilai ke dalam form modal
        document.getElementById('edit_id_user').value = id;
        document.getElementById('edit_nama_lengkap').value = nama;
        document.getElementById('edit_tempat_lahir').value = tempatLahir;
        document.getElementById('edit_tanggal_lahir').value = tanggalLahir;
        document.getElementById('edit_telepon').value = telepon;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('gambar_lama').value = gambarLama;
        document.getElementById('edit_nik').value = nik;
        document.getElementById('edit_nip').value = nip;

        // Atur radio button jenis kelamin
        if (jenisKelamin === "1") {
            document.getElementById('edit_male').checked = true;
        } else if (jenisKelamin === "0") {
            document.getElementById('edit_female').checked = true;
        }

        // Tampilkan gambar lama
        if (gambar) {
            document.getElementById('previewImageEdit').src = "../assets/img/user/" + gambar;
        } else {
            document.getElementById('previewImageEdit').src = "../assets/img/user/avatar1.png";
        }
    });
});

</script>

<script>
    $(document).ready(function() {
        $('#table_user').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [{"orderable" : false, "targets" : [2, 3, 4, 5, 6, 7, 8]}],
            "language" : {
                "search" : "Cari : ",
                "lengthMenu" : "Tampilkan _MENU_  data Per Halaman",
                "info" : "Menampilkan _START_ hingga _END_ dari _TOTAL_ Data",
                "paginate" : {
                    "first" : "Awal ",
                    "last" : " Akhir",
                    "next" : "Selanjutnya ",
                    "previous" : " Sebelumnya",
                }
            }, 

            dom : 'Blfrtip',
            buttons : [
                {
                    extend : 'pdfHtml5',
                    text : '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className : 'btn btn-danger m-2',
                    title : 'Laporan Data User',
                    exportOptions : {
                        columns : [0, 1, 2, 3, 4, 5, 7]
                    }
                }
            ]
        })
    })
</script>


<!-- validasi -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const nikInput = document.getElementById("nik");
    const nipInput = document.getElementById("nip");

    nikInput.addEventListener("input", function () {
        const warning = document.getElementById("nik_error");
        if (this.value.length < 16) {
            warning.textContent = "NIK harus terdiri dari 16 digit.";
        } else {
            warning.textContent = "";
        }
    });

    nipInput.addEventListener("input", function () {
        const warning = document.getElementById("nip_error");
        if (this.value.length < 18) {
            warning.textContent = "NIP harus terdiri dari 18 digit.";
        } else {
            warning.textContent = "";
        }
    });
});
</script>
