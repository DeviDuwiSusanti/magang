<?php include "../layout/sidebarUser.php";
include "functions.php";

$sql2 = "SELECT pu.*, u.*, p.* FROM tb_profile_user pu JOIN tb_user u ON pu.id_user = u.id_user LEFT JOIN tb_pendidikan p ON pu.id_pendidikan = p.id_pendidikan WHERE pu.id_user = '$id_user'";
$query2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($query2);
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


<style>
    #alamat {
        height: 200px;
    }
    
    /* Style untuk Select2 */
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px;
        border: 1px solid #ced4da;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>

<!-- Detail Profil -->
<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Profile Saya</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="container mt-5 mb-5">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body top">
                    <img src="../assets/img/user/<?= !empty($row2['gambar_user']) ? $row2['gambar_user'] : 'avatar.png' ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border: 2px solid #ccc;" onclick="openImageModal(this)">
                    <h4 class="card-title"><?= $row2['nama_user'] ?></h4>
                    <p class="text-muted"><?= $row2['email'] ?></p>

                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td><?= $row2['nama_user'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-envelope"></i> <strong>Email</strong></td>
                                    <td><?= $row['email'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar"></i> <strong>TTL</strong></td>
                                    <td>
                                        <?php 
                                        if (!empty($row['tempat_lahir']) && !empty($row['tanggal_lahir'])) {
                                            echo $row['tempat_lahir'] . ', ' . formatTanggalLengkapIndonesia($row['tanggal_lahir']);
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-gender-ambiguous"></i> <strong>Jenis Kelamin</strong></td>
                                    <td>
                                        <?= ($row2['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-credit-card"></i> <strong>NIK</strong></td>
                                    <td><?= $row2['nik'] ?></td>
                                </tr>

                                <?php if (($ketua || $anggota) && $level == "3") : ?>
                                    <tr>
                                        <td><i class="bi bi-mortarboard"></i> <strong> <?= !empty($row['nim']) ? 'NIM' : (!empty($row['nisn']) ? 'NISN' : 'NIM/NISN') ?></strong></td>
                                        <td><?= !empty($row['nim']) ? $row['nim'] : $row['nisn'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-building"></i> <strong>Asal Studi</strong></td>
                                        <td><?= $row2['nama_pendidikan'] ?></td>
                                    </tr>
                                    <?php
                                    if ($row2['fakultas'] != NULL) { ?>
                                        <tr>
                                            <td><i class="bi bi-building-check"></i> <strong>Fakultas</strong></td>
                                            <td><?= $row2['fakultas'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td><i class="bi bi-diagram-3"></i> <strong>Jurusan</strong></td>
                                        <td><?= $row2['jurusan'] ?></td>
                                    </tr>

                                <?php endif; ?>
                                <tr>
                                    <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                                    <td><?= $row2['telepone_user'] ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> <strong>Alamat</strong></td>
                                    <td><?= $row2['alamat_user'] ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-grid">
                            <button type="button" name="update_profil" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil"></i> Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php" ?>

<!-- Modal -->
<?php
// akses data profil pengguna sebelum update
$sql4 = "SELECT * FROM tb_profile_user 
    INNER JOIN tb_user ON tb_profile_user.id_user = tb_user.id_user
    LEFT JOIN tb_pendidikan ON tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
    WHERE tb_profile_user.id_user = '$id_user'";
$query4 = mysqli_query($conn, $sql4);
$dataLama = mysqli_fetch_assoc($query4);

// akses daftar studi
$sql3 = "SELECT * FROM tb_pendidikan";
$query3 = mysqli_query($conn, $sql3);
$dataPendidikan = mysqli_fetch_all($query3, MYSQLI_ASSOC);

if (isset($_POST['update_profil'])) {
    updateProfile($_POST, $_FILES, $id_user, $dataLama);
}
?>
<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="editForm" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Nama Lengkap -->
                    <div class="mb-3 col-6">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" data-error-id="nama-error" id="nama" name="nama" value="<?= $dataLama['nama_user'] ?>">
                        <small class="text-danger" id="nama-error"></small>
                    </div>
                    <!-- NIK -->
                    <div class="mb-3 col-6">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" data-error-id="nik-error" id="nik" name="nik" value="<?= $dataLama['nik'] ?>">
                        <small class="text-danger" id="nik-error"></small>
                    </div>
                </div>

                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" data-error-id="tempat_lahir-error" id="tempat_lahir" name="tempat_lahir" value="<?= $dataLama['tempat_lahir'] ?>">
                            <small class="text-danger" id="tempat_lahir-error"></small>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3 col-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" data-error-id="tanggal_lahir-error" id="tanggal_lahir" name="tanggal_lahir" value="<?= $dataLama['tanggal_lahir'] ?>">
                            <small class="text-danger" id="tanggal_lahir-error"></small>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-3 col-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_l" value="1" <?= ($dataLama['jenis_kelamin'] == '1') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_p" value="0" <?= ($dataLama['jenis_kelamin'] == '0') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                                </div>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="mb-3 col-6">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" data-error-id="error-telepon" pattern="[0-9]{8,15}" id="telepon" name="telepon" value="<?= $row2['telepone_user'] ?>">
                            <small id="error-telepon" class="text-danger"></small>
                        </div>
                    </div>


                    <?php if(($ketua || $anggota) && $level == "3") : ?>

                    <!-- Asal Studi -->
                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="mb-3 col-6">
                        <label for="asal_studi" class="form-label">Asal Studi</label>
                            <select class="form-control select2" id="asal_studi" name="asal_studi" required>
                                <option value="">Pilih Asal Studi</option>
                                <?php 
                                // Current selected value - ambil id_pendidikan dari data lama
                                $currentIdPendidikan = $dataLama['id_pendidikan'] ?? '';
                                
                                // Cari nama_pendidikan yang sesuai dengan id_pendidikan yang disimpan
                                $currentNamaPendidikan = '';
                                foreach ($dataPendidikan as $studi) {
                                    if ($studi['id_pendidikan'] == $currentIdPendidikan) {
                                        $currentNamaPendidikan = $studi['nama_pendidikan'];
                                        break;
                                    }
                                }
                                
                                // Group by nama_pendidikan
                                $groupedPendidikan = [];
                                foreach ($dataPendidikan as $studi) {
                                    $groupedPendidikan[$studi['nama_pendidikan']][] = $studi;
                                }
                                
                                foreach ($groupedPendidikan as $namaPendidikan => $items) {
                                    // Cek apakah ini adalah pilihan yang sedang aktif
                                    $isSelected = ($namaPendidikan === $currentNamaPendidikan);
                                    
                                    // Gunakan id_pendidikan yang sesuai dengan data lama jika ada
                                    $selectedId = $currentIdPendidikan;
                                    if (!$isSelected) {
                                        $selectedId = $items[0]['id_pendidikan'];
                                    }
                                    
                                    echo '<option value="'.htmlspecialchars($selectedId).'" '
                                        .($isSelected ? 'selected' : '').'>'
                                        .htmlspecialchars($namaPendidikan).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <!-- NIK -->
                        <div class="mb-3 col-6" id="fakultasContainer">
                            <label for="fakultas" class="form-label">Fakultas</label>
                            <select class="form-control" id="fakultas" name="fakultas">
                                <?php if (!empty($dataLama['fakultas'])): ?>
                                    <option value="<?= $dataLama['fakultas'] ?>" selected><?= $dataLama['fakultas'] ?></option>
                                <?php endif; ?>
                            </select>
                            <small id="error-fakultas" class="text-danger"></small>           
                        </div>
                    </div>

                <div class="row">
                    <!-- Jurusan -->
                    <div class="mb-3 col-6">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select class="form-control" id="jurusan" name="jurusan" data-current="<?= htmlspecialchars($dataLama['jurusan'] ?? '') ?>" data-current-id="<?= htmlspecialchars($dataLama['id_pendidikan'] ?? '') ?>">
                            <?php if (!empty($dataLama['jurusan'])): ?>
                                <option value="<?= htmlspecialchars($dataLama['jurusan']) ?>" selected><?= htmlspecialchars($dataLama['jurusan']) ?></option>
                            <?php endif; ?>
                        </select>
                        <small id="error-jurusan" class="text-danger"></small>
                    </div>

                        <!-- Input NISN (akan ditampilkan jika bukan universitas) -->
                        <div class="mb-3 col-6" id="nisnContainer" style="flex: 1; <?php echo (isset($dataLama['id_pendidikan']) && strlen($dataLama['id_pendidikan']) === 7 ? 'display:none;' : ''); ?>">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" value="<?= $row['nisn'] ?>" oninput="this.value=this.value.slice(0,10)">
                            <small id="error-nisn" class="text-danger"></small>
                        </div>
                        
                        <!-- Input NIM (akan ditampilkan jika universitas) -->
                        <div class="mb-3 col-6" id="nimContainer" style="flex: 1; <?= (strlen($dataLama['id_pendidikan'] ?? '') === 7 ? '' : 'display:none;') ?>">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" value="<?= !empty($row['nim']) ? $row['nim'] : '' ?>" oninput="this.value=this.value.slice(0,12)">
                            <small id="error-nim" class="text-danger"></small>
                        </div>
                </div>
                    <?php endif; ?>

                    <div class="d-flex gap-4">
                        <div class="mb-3" style="flex: 1;">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $row2['alamat_user'] ?></textarea>
                            <small id="error-alamat" class="text-danger"></small>
                        </div>
                        <div class="mb-3" style="flex: 1;">
                            <label for="image" class="form-label">Foto Profil</label><br>
                            <div class="image-preview mb-3">
                                <img src="<?= !empty($dataLama['gambar_user']) ? '../assets/img/user/' . $dataLama['gambar_user'] : '../assets/img/user/avatar.png' ?>" id="previewImage" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;" onclick="openImageModal(this)">
                            </div>
                            <input type="file" class="form-control" data-error-id="error-image" id="image" name="image" accept="image/*" onchange="previewFile()">
                            <small class="text-muted">Kosong jika tidak ingin diganti</small> <br>
                            <small id="error-image" class="text-danger"></small>
                        </div>
                    </div>
                    
                    <!-- Tombol Submit -->
                    <div class="text-end">
                        <button type="submit" name="update_profil" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function openImageModal(img) {
        const modal = document.getElementById("imageModalPreview");
        const modalImg = document.getElementById("modalPreviewImage");

        modal.style.display = "flex"; // make it center using flex
        modalImg.src = img.src;
    }

    function closeImageModal() {
        document.getElementById("imageModalPreview").style.display = "none";
    }
</script>

<script>
    function previewFile() {
        const fileInput = document.getElementById('image');
        const previewImage = document.getElementById('previewImage');
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Event listener untuk nik
    document.getElementById("telepon").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");

        const maxLength = 15;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    });
    // Event listener untuk nik
    document.getElementById("nik").addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");

        const maxLength = 16;
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    })
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const asalStudiSelect = document.getElementById('asal_studi');
    const fakultasContainer = document.getElementById('fakultasContainer');
    const fakultasSelect = document.getElementById('fakultas');
    const jurusanSelect = document.getElementById('jurusan');
    const nisnContainer = document.getElementById('nisnContainer');
    const nimContainer = document.getElementById('nimContainer');

    // Ambil data pendidikan dari PHP
    const dataPendidikan = <?= json_encode($dataPendidikan) ?>;
    const currentFakultas = "<?= $dataLama['fakultas'] ?? '' ?>";
    const currentJurusan = "<?= $dataLama['jurusan'] ?? '' ?>";
    const currentIdPendidikan = "<?= $dataLama['id_pendidikan'] ?? '' ?>";

    const pendidikanData = {};
    const pendidikanGroups = {};

    dataPendidikan.forEach(item => {
        const id = item.id_pendidikan;
        const nama = item.nama_pendidikan;
        const fakultas = item.fakultas || null;
        const jurusan = item.jurusan;

        pendidikanData[id] = { nama, fakultas, jurusan };

        if (!pendidikanGroups[nama]) {
            pendidikanGroups[nama] = [];
        }

        const index = pendidikanGroups[nama].findIndex(f => f.fakultas === fakultas);
        if (index === -1) {
            pendidikanGroups[nama].push({ fakultas, jurusan: [{ id, jurusan }] });
        } else {
            pendidikanGroups[nama][index].jurusan.push({ id, jurusan });
        }
    });

    function handleAsalStudiChange(selectedId) {
        if (!selectedId) {
            fakultasContainer.style.display = 'none';
            jurusanSelect.innerHTML = '<option value="">Pilih Jurusan</option>';
            nisnContainer.style.display = 'block';
            nimContainer.style.display = 'none';
            return;
        }

        const selected = pendidikanData[selectedId];
        if (!selected) return;

        // Universitas (ID 7 digit)
        if (selectedId.length === 7) {
            fakultasContainer.style.display = 'block';
            nisnContainer.style.display = 'none';
            nimContainer.style.display = 'block';
            loadFaculties(selectedId);
            
            if (currentFakultas) {
                loadMajors(selectedId, currentFakultas);
            }
        } else { // Non-universitas (sekolah)
            fakultasContainer.style.display = 'none';
            nisnContainer.style.display = 'block';
            nimContainer.style.display = 'none';
            loadMajors(selectedId);
        }
    }

    function loadFaculties(pendidikanId) {
        fakultasSelect.innerHTML = '<option value="">Pilih Fakultas</option>';
        
        if (!pendidikanId) return;
        
        const selected = pendidikanData[pendidikanId];
        if (!selected) return;

        const pendidikanName = selected.nama;
        const fakultasList = pendidikanGroups[pendidikanName] || [];
        
        fakultasList.forEach(group => {
            if (group.fakultas) {
                const option = document.createElement('option');
                option.value = group.fakultas;
                option.textContent = group.fakultas;
                fakultasSelect.appendChild(option);
                
                if (group.fakultas === currentFakultas) {
                    option.selected = true;
                }
            }
        });
    }

    function loadMajors(pendidikanId, faculty = null) {
        jurusanSelect.innerHTML = '<option value="">Pilih Jurusan</option>';
        
        if (!pendidikanId) return;
        
        const selected = pendidikanData[pendidikanId];
        if (!selected) return;

        const pendidikanName = selected.nama;
        let jurusanList = [];
        
        if (faculty) {
            const fakultasGroup = pendidikanGroups[pendidikanName].find(f => f.fakultas === faculty);
            if (fakultasGroup) {
                jurusanList = fakultasGroup.jurusan;
            }
        } else {
            const groups = pendidikanGroups[pendidikanName] || [];
            groups.forEach(group => {
                jurusanList = jurusanList.concat(group.jurusan);
            });
        }
        
        jurusanList.forEach(jur => {
            const option = document.createElement('option');
            option.value = jur.jurusan;
            option.textContent = jur.jurusan;
            option.dataset.id = jur.id;
            jurusanSelect.appendChild(option);
            
            if (jur.jurusan === currentJurusan || jur.id === currentIdPendidikan) {
                option.selected = true;
            }
        });
    }

    // Inisialisasi modal dengan Select2
    $('#editProfileModal').on('shown.bs.modal', function() {
        $('#asal_studi').select2({
            dropdownParent: $('#editProfileModal'),
            placeholder: "Pilih Asal Studi",
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            handleAsalStudiChange(this.value);
        });

        // Inisialisasi nilai awal
        if (currentIdPendidikan) {
            $('#asal_studi').val(currentIdPendidikan).trigger('change');
        }
    });

    // Handle perubahan fakultas
    fakultasSelect.addEventListener('change', function() {
        const selectedFakultas = this.value;
        const selectedId = $('#asal_studi').val();
        
        if (selectedFakultas && selectedId) {
            loadMajors(selectedId, selectedFakultas);
        }
    });
});
</script>


<!-- ==== VALIDASI ======= -->
<script>
    // Fungsi untuk menampilkan error
    function showError(inputId, errorId, message) {
        const inputElement = document.getElementById(inputId);
        const errorElement = document.getElementById(errorId);

        if (errorElement) {
            errorElement.textContent = message;
            inputElement.focus();
            inputElement.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        }
    }

    // Fungsi untuk menghapus error ketika user mulai mengetik
    function clearError(event) {
        const input = event.target;
        const errorId = input.dataset.errorId;
        const errorElement = document.getElementById(errorId);

        if (errorElement) {
            errorElement.textContent = "";
        }
    }

    // Tambahkan event listener ke semua input dan textarea agar error dihapus saat user mengetik
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("input, textarea, select").forEach((input) => {
            input.addEventListener("input", clearError);
        });

        document.querySelector(".editForm").addEventListener("submit", function(event) {
            let isValid = true;

            // Reset semua pesan error sebelum validasi baru
            document
                .querySelectorAll(".text-danger")
                .forEach((el) => (el.textContent = ""));

            // Validasi Nama
            const nama = document.getElementById("nama").value.trim();
            if (nama === "") {
                showError("nama", "nama-error", "Nama tidak boleh kosong.");
                isValid = false;
            } else if (!/^[a-zA-Z\s.,'-]+$/.test(nama)) {
                showError(
                    "nama",
                    "nama-error",
                    "Nama hanya boleh berisi huruf, spasi, dan simbol ('-)."
                );
                isValid = false;
            }

            // Validasi Tempat Lahir
            const tempatLahir = document.getElementById("tempat_lahir").value.trim();
            if (tempatLahir === "") {
                showError(
                    "tempat_lahir",
                    "tempat_lahir-error",
                    "Tempat lahir tidak boleh kosong."
                );
                isValid = false;
            } else if (!/^[a-zA-Z\s'-]+$/.test(tempatLahir)) {
                showError(
                    "tempat_lahir",
                    "tempat_lahir-error",
                    "Tempat lahir hanya boleh berisi huruf, spasi, dan simbol ('-)."
                );
                isValid = false;
            }

            // Validasi Tanggal Lahir
            const tanggalLahir = document.getElementById("tanggal_lahir").value.trim();
            if (tanggalLahir === "") {
                showError(
                    "tanggal_lahir",
                    "tanggal_lahir-error",
                    "Tanggal lahir tidak boleh kosong."
                );
                isValid = false;
            }

            // Validasi Telepon
            const telepon = document.getElementById("telepon").value.trim();
            if (telepon === "") {
                showError(
                    "telepon",
                    "error-telepon",
                    "Nomor telepon tidak boleh kosong."
                );
                isValid = false;
            } else if (!/^\d{11,12}$/.test(telepon)) {
                showError(
                    "telepon",
                    "error-telepon",
                    "Telepon harus berisi angka (11-12 digit)."
                );
                isValid = false;
            }

            // Validasi NIK
            const nik = document.getElementById("nik").value.trim();
            if (nik === "") {
                showError("nik", "nik-error", "NIK tidak boleh kosong.");
                isValid = false;
            } else if (!/^\d{16}$/.test(nik)) {
                showError(
                    "nik",
                    "nik-error",
                    "NIK harus berisi angka (16 digit)."
                );
                isValid = false;
            }

            // Validasi NIM/NISN berdasarkan jenis pendidikan
            const asalStudiId = $('#asal_studi').val();
            if (asalStudiId) {
                if (asalStudiId.length === 7) { // Universitas
                    const Nim = document.getElementById("nim").value.trim();
                    if (Nim === "") {
                        showError("nim", "error-nim", "NIM wajib diisi untuk universitas.");
                        isValid = false;
                    } else if (!/^\d{12}$/.test(Nim)) {
                        showError("nim", "error-nim", "NIM harus terdiri dari 12 digit angka.");
                        isValid = false;
                    }
                } else { // Sekolah
                    const nisn = document.getElementById("nisn").value.trim();
                    if (nisn === "") {
                        showError("nisn", "error-nisn", "NISN wajib diisi untuk sekolah.");
                        isValid = false;
                    } else if (!/^\d{10}$/.test(nisn)) {
                        showError("nisn", "error-nisn", "NISN harus terdiri dari 10 digit angka.");
                        isValid = false;
                    }
                }
            }

            // Validasi Fakultas (jika elemen ada)
            const fakultasInput = document.getElementById("fakultas");
            if (fakultasInput) {
                const fakultas = fakultasInput.value.trim();
                if (fakultas === "" && fakultasContainer.style.display !== 'none') {
                    showError("fakultas", "error-fakultas", "Fakultas wajib diisi.");
                    isValid = false;
                }
            }

            // Validasi Jurusan (selalu required jika elemen ada)
            const jurusanInput = document.getElementById("jurusan");
            if (jurusanInput) {
                const jurusan = jurusanInput.value.trim();
                if (jurusan === "") {
                    showError("jurusan", "error-jurusan", "Jurusan wajib diisi.");
                    isValid = false;
                }
            }

            // Validasi Alamat
            const alamat = document.getElementById("alamat").value.trim();
            if (alamat === "") {
                showError("alamat", "error-alamat", "Alamat tidak boleh kosong.");
                isValid = false;
            }

            // Validasi Gambar
            const gambarInput = document.getElementById("image");
            const gambar = gambarInput.files[0];
            if (gambar) {
                if (gambar.size > 1048576) {
                    showError(
                        "image",
                        "error-image",
                        "Ukuran gambar tidak boleh lebih dari 1MB."
                    );
                    isValid = false;
                }
                if (!gambar.type.match("image.*")) {
                    showError(
                        "image",
                        "error-image",
                        "File yang diupload harus berupa gambar."
                    );
                    isValid = false;
                }
            }

            // Jika validasi gagal, mencegah pengiriman form
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>