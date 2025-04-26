<?php
include "functions.php";

// Ambil data sekolah dan perguruan tinggi
$sekolah = query("SELECT id_pendidikan, nama_pendidikan, jurusan FROM tb_pendidikan WHERE fakultas IS NULL OR fakultas = '' ");
$perguruan_tinggi = query("SELECT id_pendidikan, nama_pendidikan, fakultas, jurusan FROM tb_pendidikan WHERE fakultas IS NOT NULL AND fakultas != '' ");

// Struktur data sekolah
$sekolahData = [];
foreach ($sekolah as $school) {
    $sekolahData[$school['nama_pendidikan']][] = [
        'id_pendidikan' => $school['id_pendidikan'],
        'jurusan' => $school['jurusan']
    ];
}

// Struktur data perguruan tinggi
$universitasData = [];
foreach ($perguruan_tinggi as $kampus) {
    $universitasData[$kampus['nama_pendidikan']][$kampus['fakultas']][] = [
        'id_pendidikan' => $kampus['id_pendidikan'],
        'jurusan' => $kampus['jurusan']
    ];
}



if (isset($_GET['confirm']) && $_GET['confirm'] === "gunakan_data_lama") {
    $id_user_lama = $_GET['id_user_lama'];
    echo "<div class='alert alert-warning'>";
    echo "<p><strong>Info:</strong> Email sudah terdaftar sebagai anggota kelompok. Ingin daftar ulang sebagai ketua?</p>";
    echo "<a class='btn btn-primary' href='register.php?use_old_data=true&id_user_lama=$id_user_lama'>Gunakan Data Lama</a>";
    echo "</div>";
}

if (isset($_GET['use_old_data']) && $_GET['use_old_data'] === "true") {
    $id_user_lama = $_GET['id_user_lama'];
    $id_user_baru = generateUserId($conn);

    // Salin data dengan ID baru
    mysqli_query($conn, "UPDATE tb_user SET id_user = '$id_user_baru' WHERE id_user = '$id_user_lama'");
    mysqli_query($conn, "UPDATE tb_profile_user SET id_user = '$id_user_baru' WHERE id_user = '$id_user_lama'");

    header("Location: register.php?success=update_id");
    exit;
}



// Status register
$status = "";
if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/register.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/alert.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="./assets/img/logo_kab_sidoarjo.png" type="image/png">
    <title>Register</title>
    <style>
        select,
        input {
            width: 100%;
            padding: 2px;
            margin: 2px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php if (isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: <?php
                        // Tangkap pesan berdasarkan nilai error
                        if ($_GET['error'] === 'email_terdaftar') {
                            echo "'Email sudah terdaftar. Silakan gunakan email lain.'";
                        } elseif ($_GET['error'] === 'nik_terdaftar') {
                            echo "'NIK sudah terdaftar. Silakan gunakan NIK lain.'";
                        } elseif ($_GET['error'] === 'nisn_terdaftar') {
                            echo "'NISN sudah terdaftar. Silakan gunakan NISN lain.'";
                        } elseif ($_GET['error'] === 'nik_tidak_sesuai') {
                            echo "'NIK Tidak Sesuai, NIK Harus 16 Digit.'";
                        } elseif ($_GET['error'] === 'nisn_tidak_sesuai') {
                            echo "'NISN Tidak Sesuai, NISN Harus 10 Digit.'";
                        }
                        ?>,
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
        </script>
    <?php endif; ?>


    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <header>Register</header>
                <form action="" method="POST" enctype="multipart/form-data" class="d-flex" id="registerForm">

                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="input-field">
                            <input type="text" class="input" name="nama_user" id="nama_user" maxlength="100" required>
                            <label for="nama_user">Nama Lengkap</label>
                        </div>
                        <div class="input-field">
                            <input type="email" class="input" name="email" id="email" maxlength="255" required>
                            <label for="email">Email </label>
                        </div>

                        <div class="input-field">
                            <input type="text" inputmode="numeric" id="nik_user" class="input" name="nik" maxlength="16" required>
                            <label for="nik_user">NIK</label>
                            <span id="nik_error" class="error-message" style="color: red; display: none; font-size: 12px;">NIK harus 16 digit!</span>
                        </div>



                        <div class="mb-3">
                            <label class="form-label">Pilih Pendidikan</label>
                            <select class="form-select" id="educationSelect" required>
                                <option value="">Pilih Pendidikan</option>
                                <option value="sekolah">Sekolah</option>
                                <option value="universitas">Perguruan Tinggi</option>
                            </select>
                        </div>

                        <!-- Opsi untuk Sekolah -->
                        <div id="schoolOptions" class="d-none">
                            <div class="card card-body">
                                <label class="form-label">Nama Sekolah</label>
                                <select class="form-select" id="schoolSelect">
                                    <option value="">Pilih Sekolah</option>
                                    <?php foreach (array_keys($sekolahData) as $namaSekolah) : ?>
                                        <option value="<?= $namaSekolah ?>"><?= $namaSekolah ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label class="form-label mt-2">Jurusan</label>
                                <select class="form-select d-none" id="jurusanSelect">
                                    <option value="">Pilih Jurusan</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <input type="text" maxlength="10" id="nisn" inputmode="numeric" class="input mt-4" name="nisn">
                                <label class="mt-4" for="nisn">NISN</label>
                                <span id="nisn_error" class="error-message" style="color: red; display: none; font-size: 12px;">NISN harus 10 digit!</span>
                            </div>
                        </div>

                        <!-- Opsi untuk Universitas -->
                        <div id="universityOptions" class="d-none">
                            <div class="card card-body">
                                <label class="form-label">Nama Universitas</label>
                                <select class="form-select" id="universitySelect">
                                    <option value="">Pilih Universitas</option>
                                    <?php foreach (array_keys($universitasData) as $namaUniversitas) : ?>
                                        <option value="<?= $namaUniversitas ?>"><?= $namaUniversitas ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label class="form-label mt-2">Fakultas</label>
                                <select class="form-select d-none" id="facultySelect">
                                    <option value="">Pilih Fakultas</option>
                                </select>

                                <label class="form-label mt-2 d-none" id="prodiLabel">Program Studi</label>
                                <select class="form-select d-none" id="prodiSelect">
                                    <option value="">Pilih Program Studi</option>
                                </select>

                            </div>
                            <div class="input-field mt-3">
                                <input type="text" class="input" name="nim" maxlength="15">
                                <label for="nim">NIM</label>
                            </div>
                        </div>

                        <div class="mt-3">
                            <input type="hidden" id="idPendidikanInput" name="id_pendidikan">
                        </div>

                    </div>


                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <!-- Gender -->
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

                        <div class="input-field">
                            <input type="text" class="input" name="tempat_lahir" id="tempat_lahir">
                            <label for="tempat_lahir">Tempat Lahir</label>
                        </div>

                        <div>
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <div class="input-field">
                                <input type="date" class="input" name="tanggal_lahir" id="tanggal_lahir">
                            </div>
                        </div>

                        <div>
                            <textarea name="alamat_user" id="alamat_user" class="form-control" placeholder="Alamat Domisili"></textarea>
                        </div>
                        <div class="input-field">
                            <input type="tel" pattern="[0-9]{8,15}" class="input" name="telepone_user" id="telepone_user" inputmode="numeric" maxlength="15">
                            <label for="telepone_user">No. Telepone</label>
                        </div>

                        <input type="hidden" name="level" id="level" value="3">
                        <!-- Upload Foto Profil -->
                        <div class="input-field">
                            <label for="image">Upload Foto Profil (Max 1MB)</label><br><br>
                            <div class="image-preview" id="imagePreview">
                                <img src="assets/img/avatar1.png" id="previewImage">
                            </div>
                            <input type="file" class="input" id="image" name="gambar_user" accept="image/*" onchange="validateFile()">
                        </div>
                        <button type="submit" name="register" class="submit" id="submitBtn">Signup</button>
                        <div class="login-link">
                            Sudah punya akun? <a href="login.php">Login sekarang</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        <?php if ($status === "success"): ?>
            alertSuccessRegister('Registrasi berhasil dilakukan.', 'login.php');
        <?php elseif ($status === "error"): ?>
            alertErrorRegister('Registrasi gagal dilakukan.', 'register.php');
        <?php endif; ?>
    </script>

    <script>
        function validateFile() {
            const fileInput = document.getElementById('image');
            const previewContainer = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const file = fileInput.files[0];

            if (file) {
                if (file.size > 1048576) { // 1MB = 1048576 bytes
                    alert("Ukuran file terlalu besar! Maksimal 1MB.");
                    fileInput.value = ""; // Reset file input
                    previewImage.src = ""; // Hapus pratinjau
                    previewContainer.style.display = "none";
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        }

        // Kirim data PHP ke JavaScript
        const sekolahData = <?= json_encode($sekolahData) ?>;
        const universitasData = <?= json_encode($universitasData) ?>;

        document.getElementById("nik_user").addEventListener("input", function(e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });
        document.getElementById("nisn").addEventListener("input", function(e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });
        document.getElementById("telepone_user").addEventListener("input", function(e) {
            this.value = this.value.replace(/\D/g, ""); // Hanya izinkan angka
        });


        $(document).ready(function() {
            // Validasi saat tombol submit ditekan
            $('#registerForm').on('submit', function(event) {
                let isValid = true; // Flag untuk validasi
                let nik = $('#nik_user').val().trim();
                let nikError = $('#nik_error');
                let nisn = $('#nisn').val().trim();
                let nisnError = $('#nisn_error');
                let userType = $('#educationSelect').val()

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

                if (userType === 'sekolah') {
                    if (nisn.length === 0) {
                        nisnError.text('NISN tidak boleh kosong!').show();
                        isValid = false;
                    } else if (nisn.length !== 10 || !/^\d+$/.test(nisn)) {
                        nisnError.text('NISN harus terdiri dari 10 digit angka!').show();
                        isValid = false;
                    } else {
                        nisnError.hide();
                    }
                } else {
                    nisnError.hide();
                }


                // Jika tidak valid, hentikan submit
                if (!isValid) {
                    event.preventDefault(); // Mencegah halaman refresh
                }
            });
        });

        // Event listener untuk pilihan pendidikan
        document.getElementById("educationSelect").addEventListener("change", function() {
            let schoolDiv = document.getElementById("schoolOptions");
            let universityDiv = document.getElementById("universityOptions");

            if (this.value === "sekolah") {
                schoolDiv.classList.remove("d-none");
                universityDiv.classList.add("d-none");
            } else if (this.value === "universitas") {
                universityDiv.classList.remove("d-none");
                schoolDiv.classList.add("d-none");
            } else {
                schoolDiv.classList.add("d-none");
                universityDiv.classList.add("d-none");
            }
        });

        // Event listener untuk pilihan sekolah
        document.getElementById("schoolSelect").addEventListener("change", function() {
            let jurusanSelect = document.getElementById("jurusanSelect");
            let selectedSchool = this.value;

            // Kosongkan opsi sebelumnya
            jurusanSelect.innerHTML = '<option value="">Pilih Jurusan</option>';

            if (selectedSchool && sekolahData[selectedSchool]) {
                sekolahData[selectedSchool].forEach(item => {
                    let option = new Option(item.jurusan, item.id_pendidikan);
                    jurusanSelect.appendChild(option);
                });
                jurusanSelect.classList.remove("d-none");
            } else {
                jurusanSelect.classList.add("d-none");
            }
        });

        function updateSelectedId() {
            let selectedId = null;
            let educationType = document.getElementById("educationSelect").value;

            if (educationType === "sekolah") {
                selectedId = document.getElementById("jurusanSelect").value;
            } else if (educationType === "universitas") {
                selectedId = document.getElementById("prodiSelect").value;
            }

            document.getElementById("idPendidikanInput").value = selectedId ?? "";
        }



        // Tambahkan event listener ke semua select yang relevan
        document.getElementById("educationSelect").addEventListener("change", updateSelectedId);
        document.getElementById("schoolSelect").addEventListener("change", updateSelectedId);
        document.getElementById("jurusanSelect").addEventListener("change", updateSelectedId);
        document.getElementById("universitySelect").addEventListener("change", updateSelectedId);
        document.getElementById("facultySelect").addEventListener("change", updateSelectedId);
        document.getElementById("prodiSelect").addEventListener("change", updateSelectedId);

        // Event listener untuk pilihan universitas
        document.getElementById("universitySelect").addEventListener("change", function() {
            let facultySelect = document.getElementById("facultySelect");
            let prodiSelect = document.getElementById("prodiSelect");
            let prodiLabel = document.getElementById("prodiLabel");
            let selectedUniversity = this.value;

            // Kosongkan opsi sebelumnya
            facultySelect.innerHTML = '<option value="">Pilih Fakultas</option>';
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

            if (selectedUniversity && universitasData[selectedUniversity]) {
                Object.keys(universitasData[selectedUniversity]).forEach(fakultas => {
                    let option = new Option(fakultas, fakultas);
                    facultySelect.appendChild(option);
                });
                facultySelect.classList.remove("d-none");
            } else {
                facultySelect.classList.add("d-none");
                prodiSelect.classList.add("d-none");
                prodiLabel.classList.add("d-none");
            }
        });

        // Event listener untuk pilihan fakultas
        document.getElementById("facultySelect").addEventListener("change", function() {
            let prodiSelect = document.getElementById("prodiSelect");
            let prodiLabel = document.getElementById("prodiLabel");
            let selectedUniversity = document.getElementById("universitySelect").value;
            let selectedFaculty = this.value;

            // Kosongkan opsi sebelumnya
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

            if (selectedUniversity && selectedFaculty && universitasData[selectedUniversity][selectedFaculty]) {
                universitasData[selectedUniversity][selectedFaculty].forEach(item => {
                    let option = new Option(item.jurusan, item.id_pendidikan);
                    prodiSelect.appendChild(option);
                });
                prodiSelect.classList.remove("d-none");
                prodiLabel.classList.remove("d-none");
            } else {
                prodiSelect.classList.add("d-none");
                prodiLabel.classList.add("d-none");
            }
        });

        // Event listener untuk tombol submit
        document.getElementById("submitBtn").addEventListener("click", function() {
            let selectedId = null;

            if (document.getElementById("educationSelect").value === "sekolah") {
                selectedId = document.getElementById("jurusanSelect").value;
            } else if (document.getElementById("educationSelect").value === "universitas") {
                selectedId = document.getElementById("prodiSelect").value;
            }

            if (selectedId) {
                // Tampilkan ID Pendidikan di span
                document.getElementById("idPendidikanResult").textContent = selectedId;

                // Isi value input hidden
                document.getElementById("idPendidikanInput").value = selectedId;
            } else {
                document.getElementById("idPendidikanResult").textContent = "Pilihan tidak valid";
                document.getElementById("idPendidikanInput").value = ""; // Kosongkan jika tidak valid
            }
        });
    </script>
</body>

</html>