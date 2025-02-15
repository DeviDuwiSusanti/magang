<?php
include "functions.php";

// Ambil data sekolah dan perguruan tinggi
$sekolah = query("SELECT id_pendidikan, nama, jurusan FROM tb_pendidikan WHERE fakultas IS NULL OR fakultas = '' ");
$perguruan_tinggi = query("SELECT id_pendidikan, nama, fakultas, jurusan FROM tb_pendidikan WHERE fakultas IS NOT NULL AND fakultas != '' ");

// Struktur data sekolah
$sekolahData = [];
foreach ($sekolah as $school) {
    $sekolahData[$school['nama']][] = [
        'id_pendidikan' => $school['id_pendidikan'],
        'jurusan' => $school['jurusan']
    ];
}

// Struktur data perguruan tinggi
$universitasData = [];
foreach ($perguruan_tinggi as $kampus) {
    $universitasData[$kampus['nama']][$kampus['fakultas']][] = [
        'id_pendidikan' => $kampus['id_pendidikan'],
        'jurusan' => $kampus['jurusan']
    ];
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
                <form action="" method="POST" enctype="multipart/form-data" class="d-flex">

                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="input-field">
                            <input type="text" class="input" name="nama" required>
                            <label for="name">Nama Lengkap</label>
                        </div>
                        <div class="input-field">
                            <input type="email" class="input" name="email" required>
                            <label for="email">Email </label>
                        </div>
                        <div class="input-field">
                            <input type="text" class="input" name="nik" maxlength="16" required>
                            <label for="nik">NIK (16)</label>
                        </div>
                        <div class="input-field">
                            <input type="text" maxlength="10" class="input" name="nisn" required>
                            <label for="nisn">NISN (10)</label>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Pilih Pendidikan</label>
                            <select class="form-select" id="educationSelect">
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
                            <h6>ID Pendidikan:</h6>
                            <span id="idPendidikanResult"></span>
                            <input type="hidden" id="idPendidikanInput" name="pendidikan">
                        </div>
                    </div>


                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <!-- Gender -->
                        <div class="form-group">
                            <label class="form-label">Pilih Jenis Kelamin:</label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" id="male" name="jenis_kelamin" value="L" required>
                                    <label class="form-check-label" for="male">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="female" name="jenis_kelamin" value="P" required>
                                    <label class="form-check-label" for="female">Perempuan</label>
                                </div>
                            </div>
                        </div>

                        <div class="input-field">
                            <input type="text" class="input" name="tempat_lahir" required>
                            <label for="tempat_lahir">Tempat Lahir</label>
                        </div>

                        <div>
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <div class="input-field">
                                <input type="date" class="input" name="tanggal_lahir" required>
                            </div>
                        </div>

                        <div>
                            <textarea name="alamat" id="address" class="form-control" placeholder="Alamat Domisili"></textarea>
                        </div>
                        <div class="input-field">
                            <input type="text" class="input" name="telepone">
                            <label for="telepone">Telephone</label>
                        </div>

                        <input type="hidden" name="level" id="level" value="3">
                        <!-- Upload Foto Profil -->
                        <div class="input-field">
                            <label for="image">Upload Foto Profil (Max 1MB)</label><br><br>
                            <div class="image-preview" id="imagePreview">
                                <img src="assets/img/avatar1.png" id="previewImage">
                            </div>
                            <input type="file" class="input" id="image" name="gambar" accept="image/*" onchange="validateFile()">
                        </div>
                        <!-- <input type="submit" class="submit" name="register" value="Sign Up"> -->
                        <button type="submit" name="register" class="submit" id="submitBtn">Signup</button>
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