<?php include "../layout/sidebarUser.php";
include "functions.php";

$sql2 = "SELECT pu.*, u.*, p.* FROM tb_profile_user pu JOIN tb_user u ON pu.id_user = u.id_user LEFT JOIN tb_pendidikan p ON pu.id_pendidikan = p.id_pendidikan WHERE pu.id_user = '$id_user'";
$query2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($query2);



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
                <div class="card-body top">
                    <img src="../assets/img/user/<?= !empty($row2['gambar_user']) ? $row2['gambar_user'] : 'avatar.png' ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border: 2px solid #ccc;">
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
                                    <td><?php echo $row['tempat_lahir'] . ', ' . formatTanggalLengkapIndonesia($row['tanggal_lahir']); ?></td>
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
                                    <tr>
                                        <td><i class="bi bi-mortarboard"></i> <strong> <?= !empty($row['nim']) ? 'NIM' : (!empty($row['nisn']) ? 'NISN' : 'NIM/NISN') ?></strong></td>
                                        <td><?= !empty($row['nim']) ? $row['nim'] : $row['nisn'] ?></td>
                                    </tr>
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
                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" data-error-id="nama-error" id="nama" name="nama" value="<?= $dataLama['nama_user'] ?>">
                        <small class="text-danger" id="nama-error"></small>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" data-error-id="tempat_lahir-error" id="tempat_lahir" name="tempat_lahir" value="<?= $dataLama['tempat_lahir'] ?>">
                        <small class="text-danger" id="tempat_lahir-error"></small>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" data-error-id="tanggal_lahir-error" id="tanggal_lahir" name="tanggal_lahir" value="<?= $dataLama['tanggal_lahir'] ?>">
                        <small class="text-danger" id="tanggal_lahir-error"></small>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
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

                    <!-- NIK -->
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" data-error-id="nik-error" id="nik" name="nik" value="<?= $dataLama['nik'] ?>">
                        <small class="text-danger" id="nik-error"></small>
                    </div>
                    
                    <?php if(($ketua || $anggota) && $level == "3") : ?>

                    <!-- Asal Studi -->
                    <div class="mb-3">
                        <label for="asal_studi" class="form-label">Asal Studi</label>
                        <input type="text" class="form-control" id="asal_studi" name="asal_studi" value="<?= $dataLama['nama_pendidikan'] ?>" list="sekolahList">
                        <datalist id="sekolahList">
                        <?php 
                        // Mengambil hanya nama_pendidikan unik
                        $uniquePendidikan = [];
                        foreach ($dataPendidikan as $studi) {
                            $uniquePendidikan[$studi['nama_pendidikan']] = true;
                        }

                        // Menampilkan opsi tanpa duplikat
                        foreach (array_keys($uniquePendidikan) as $namaPendidikan) : 
                        ?>
                        <option value="<?= htmlspecialchars($namaPendidikan) ?>"></option>
                        <?php endforeach; ?>
                        </datalist>
                    </div>
                    
                    <div class="mb-3" id="fakultasContainer" style="display: none;">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-control" id="fakultas" name="fakultas">
                            <?php foreach($dataPendidikan as $studi) : ?>
                                <option value="<?= $studi['fakultas'] ?>" <?= ($dataLama['fakultas'] == $studi['fakultas']) ? 'selected' : '' ?>><?= $studi['fakultas'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if (($ketua || $anggota) && $level == "4") : ?>

                        <!-- Asal Studi -->
                        <div class="mb-3">
                            <label for="asal_studi" class="form-label">Asal Studi</label>
                            <input type="text" class="form-control" id="asal_studi" name="asal_studi" value="<?= $dataLama['nama_pendidikan'] ?>" list="sekolahList">
                            <datalist id="sekolahList">
                                <?php
                                // Mengambil hanya nama_pendidikan unik
                                $uniquePendidikan = [];
                                foreach ($dataPendidikan as $studi) {
                                    $uniquePendidikan[$studi['nama_pendidikan']] = true;
                                }

                                // Menampilkan opsi tanpa duplikat
                                foreach (array_keys($uniquePendidikan) as $namaPendidikan) :
                                ?>
                                    <option value="<?= htmlspecialchars($namaPendidikan) ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>

                        <div class="mb-3" id="fakultasContainer" style="display: none;">
                            <label for="fakultas" class="form-label">Fakultas</label>
                            <select class="form-control" id="fakultas" name="fakultas">
                                <?php foreach ($dataPendidikan as $studi) : ?>
                                    <option value="<?= $studi['fakultas'] ?>" <?= ($dataLama['fakultas'] == $studi['fakultas']) ? 'selected' : '' ?>><?= $studi['fakultas'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Jurusan -->
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select class="form-control" id="jurusan" name="jurusan">
                                <?php foreach ($dataPendidikan as $studi) : ?>
                                    <option value="<?= $studi['jurusan'] ?>" <?= ($dataLama['jurusan'] == $studi['jurusan']) ? 'selected' : '' ?>><?= $studi['jurusan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM/NISN</label>
                            <input type="text" class="form-control" id="nim" name="nim" value="<?= !empty($row['nim']) ? $row['nim'] : $row['nisn'] ?>">
                            <small id="error-nim" class="text-danger"></small>
                        </div>
                    <?php endif; ?>

                    <!-- Telepon -->
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="number" class="form-control" data-error-id="error-telepon" id="telepon" name="telepon" value="<?= $row2['telepone_user'] ?>">
                        <small id="error-telepon" class="text-danger"></small>
                    </div>
                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $row2['alamat_user'] ?></textarea>
                        <small id="error-alamat" class="text-danger"></small>
                    </div>

                    <!-- Upload Foto Profil -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Profil</label><br>
                        <div class="image-preview mb-3">
                            <img src="<?= !empty($dataLama['gambar_user']) ? '../assets/img/user/' . $dataLama['gambar_user'] : '../assets/img/user/avatar.png' ?>" id="previewImage" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <input type="file" class="form-control" data-error-id="error-image" id="image" name="image" accept="image/*" onchange="previewFile()">
                        <small class="text-muted">Kosong jika tidak ingin diganti</small> <br>
                        <small id="error-image" class="text-danger"></small>
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
    document.addEventListener("DOMContentLoaded", function() {
        const asalStudiInput = document.getElementById('asal_studi');
        const fakultasContainer = document.getElementById('fakultasContainer');
        const fakultasSelect = document.getElementById('fakultas');
        const jurusanSelect = document.getElementById('jurusan');

        // Data Pendidikan dari PHP ke JavaScript
        const dataPendidikan = <?= json_encode($dataPendidikan) ?>;

        function updateFakultasJurusan() {
            const selectedAsalStudi = asalStudiInput.value.toLowerCase();

            // Cek apakah Asal Studi diawali dengan "universitas" atau "smk"
            const isUniversitas = selectedAsalStudi.startsWith("universitas");
            const isSMK = selectedAsalStudi.startsWith("smk");

            // Tampilkan atau sembunyikan Fakultas
            fakultasContainer.style.display = isUniversitas ? "block" : "none";

            // Kosongkan fakultas & jurusan
            fakultasSelect.innerHTML = "";
            jurusanSelect.innerHTML = "";

            // Filter data pendidikan berdasarkan asal studi
            const filteredData = dataPendidikan.filter(item => item.nama_pendidikan.toLowerCase() === selectedAsalStudi);

            if (filteredData.length > 0) {
                if (isUniversitas) {
                    // Tambahkan Fakultas ke dalam Select
                    const fakultasList = [...new Set(filteredData.map(item => item.fakultas))]; // Hapus duplikat
                    fakultasList.forEach(fakultas => {
                        const optionFakultas = document.createElement("option");
                        optionFakultas.value = fakultas;
                        optionFakultas.textContent = fakultas;
                        fakultasSelect.appendChild(optionFakultas);
                    });

                    // Jika ada fakultas yang dipilih, update jurusan
                    if (fakultasSelect.value) {
                        updateJurusan(fakultasSelect.value, filteredData);
                    }
                } else if (isSMK) {
                    // Jika SMK, langsung tampilkan jurusan yang sesuai dengan Asal Studi
                    filteredData.forEach(item => {
                        if (item.jurusan) {
                            const optionJurusan = document.createElement("option");
                            optionJurusan.value = item.jurusan;
                            optionJurusan.textContent = item.jurusan;
                            jurusanSelect.appendChild(optionJurusan);
                        }
                    });

                    // Jika tidak ada jurusan
                    if (jurusanSelect.options.length === 0) {
                        jurusanSelect.innerHTML = "<option value=''>Tidak ada jurusan</option>";
                    }
                }
            } else {
                // Jika tidak ada data, beri opsi kosong
                jurusanSelect.innerHTML = "<option value=''>Tidak ada jurusan</option>";
            }
        }

        function updateJurusan(selectedFakultas, filteredData) {
            // Kosongkan jurusan
            jurusanSelect.innerHTML = "";

            // Filter jurusan berdasarkan fakultas yang dipilih
            const jurusanList = filteredData.filter(item => item.fakultas === selectedFakultas).map(item => item.jurusan);

            if (jurusanList.length > 0) {
                jurusanList.forEach(jurusan => {
                    const optionJurusan = document.createElement("option");
                    optionJurusan.value = jurusan;
                    optionJurusan.textContent = jurusan;
                    jurusanSelect.appendChild(optionJurusan);
                });
            } else {
                jurusanSelect.innerHTML = "<option value=''>Tidak ada jurusan</option>";
            }
        }

        // Event listener untuk perubahan pada input Asal Studi
        asalStudiInput.addEventListener("input", updateFakultasJurusan);

        // Event listener untuk perubahan pada Fakultas (jika Universitas)
        fakultasSelect.addEventListener("change", function() {
            const selectedAsalStudi = asalStudiInput.value.toLowerCase();
            const filteredData = dataPendidikan.filter(item => item.nama_pendidikan.toLowerCase() === selectedAsalStudi);
            updateJurusan(fakultasSelect.value, filteredData);
        });

        // Panggil saat halaman dimuat
        updateFakultasJurusan();
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
            } else if (!/^\d{12,15}$/.test(telepon)) {
                showError(
                    "telepon",
                    "error-telepon",
                    "Telepon harus berisi angka (12-15 digit)."
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

            // Validasi NIM/NISN (opsional, hanya jika elemen ada)
            const NimInput = document.getElementById("nim");
            if (NimInput) {
                const Nim = NimInput.value.trim();

                if (Nim === "") {
                    showError("nim", "error-nim", "NIM/NISN tidak boleh kosong.");
                    isValid = false;
                } else if (!/^(?:\d{10}|\d{12})$/.test(Nim)) {
                    showError(
                        "nim",
                        "error-nim",
                        "NIM/NISN harus terdiri dari 10 digit untuk NISN atau 12 digit untuk NIM."
                    );
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