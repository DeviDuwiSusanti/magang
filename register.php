<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/register.css">
    <title>Register</title>
    <style>
        select, input {
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
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <header>Register</header>
                <form action="" method="POST" enctype="multipart/form-data" class="d-flex">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="input-field">
                            <input type="text" class="input" name="name" required>
                            <label for="name">Nama</label>
                        </div>
                        <div class="input-field">
                            <input type="email" class="input" name="email" required>
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field">
                            <input type="number" class="input" name="nik" required>
                            <label for="nik">NIK</label>
                        </div>
                        <div class="input-field">
                            <input type="number" class="input" name="nim" required>
                            <label for="nim">NIM/NISN</label>
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
                                    <option value="sma1">SMA Negeri 1 Sidoarjo</option>
                                    <option value="smk1">SMK Buduran 1</option>
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
                                    <option value="utm">Universitas Trunojoyo Madura</option>
                                    <option value="ui">Universitas Indonesia</option>
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
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label class="form-label">Pilih Jenis Kelamin:</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" id="male" name="gender" value="male" required>
                                        <label class="form-check-label" for="male">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="female" name="gender" value="female" required>
                                        <label class="form-check-label" for="female">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                        
                    </div>


                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="input-field">
                            <input type="text" class="input" name="birth_place" required>
                            <label for="birth_place">Tempat Lahir</label>
                        </div>
                        <div >
                        <label for="birth_place">Tanggal Lahir</label>
                        <div class="input-field">
                            <input type="date" class="input" name="birth_date" required>
                        </div>
                        </div>
                        <div>
                            <textarea name="address" id="address" class="form-control" placeholder="Alamat Domisili"></textarea>
                        </div>
                        <div class="input-field">
                            <input type="number" class="input" name="phone" required>
                            <label for="phone">Telephone</label>
                        </div>

                        <!-- Upload Foto Profil -->
                        <div class="input-field">
                            <label for="image">Upload Foto Profil (Max 1MB)</label><br><br>
                            <div class="image-preview" id="imagePreview">
                                <img src="" id="previewImage">
                            </div>
                            <input type="file" class="input" id="image" name="image" accept="image/*" onchange="previewFile()" required>
                        </div>
                        <input type="submit" class="submit" name="register" value="Sign Up">
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

       // Data jurusan berdasarkan sekolah
       const jurusanData = {
            sma1: ["IPA", "IPS", "Bahasa"],
            smk1: ["Teknik Komputer Jaringan", "Akuntansi", "Multimedia"]
        };

        // Data fakultas & prodi berdasarkan universitas
        const fakultasData = {
            utm: {
                "Fakultas Teknik": ["Teknik Informatika", "Teknik Sipil"],
                "Fakultas Ekonomi": ["Manajemen", "Akuntansi"]
            },
            ui: {
                "Fakultas Kedokteran": ["Pendidikan Dokter", "Kedokteran Gigi"],
                "Fakultas Hukum": ["Hukum Perdata", "Hukum Pidana"]
            }
        };

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

        document.getElementById("schoolSelect").addEventListener("change", function() {
            let jurusanSelect = document.getElementById("jurusanSelect");
            let selectedSchool = this.value;

            // Kosongkan opsi sebelumnya
            jurusanSelect.innerHTML = '<option value="">Pilih Jurusan</option>';

            if (selectedSchool && jurusanData[selectedSchool]) {
                jurusanData[selectedSchool].forEach(jurusan => {
                    let option = new Option(jurusan, jurusan.toLowerCase().replace(/\s+/g, '_'));
                    jurusanSelect.appendChild(option);
                });
                jurusanSelect.classList.remove("d-none");
            } else {
                jurusanSelect.classList.add("d-none");
            }
        });

        document.getElementById("universitySelect").addEventListener("change", function() {
            let facultySelect = document.getElementById("facultySelect");
            let prodiSelect = document.getElementById("prodiSelect");
            let prodiLabel = document.getElementById("prodiLabel");
            let selectedUniversity = this.value;

            // Kosongkan opsi sebelumnya
            facultySelect.innerHTML = '<option value="">Pilih Fakultas</option>';
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

            if (selectedUniversity && fakultasData[selectedUniversity]) {
                Object.keys(fakultasData[selectedUniversity]).forEach(fakultas => {
                    let option = new Option(fakultas, fakultas.toLowerCase().replace(/\s+/g, '_'));
                    facultySelect.appendChild(option);
                });
                facultySelect.classList.remove("d-none");
            } else {
                facultySelect.classList.add("d-none");
                prodiSelect.classList.add("d-none");
                prodiLabel.classList.add("d-none");
            }
        });

        document.getElementById("facultySelect").addEventListener("change", function() {
            let prodiSelect = document.getElementById("prodiSelect");
            let prodiLabel = document.getElementById("prodiLabel");
            let selectedUniversity = document.getElementById("universitySelect").value;
            let selectedFaculty = this.options[this.selectedIndex].text; // Perbaikan di sini

            // Kosongkan opsi sebelumnya
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

            if (selectedUniversity && selectedFaculty && fakultasData[selectedUniversity][selectedFaculty]) {
                fakultasData[selectedUniversity][selectedFaculty].forEach(prodi => {
                    let option = new Option(prodi, prodi.toLowerCase().replace(/\s+/g, '_'));
                    prodiSelect.appendChild(option);
                });
                prodiSelect.classList.remove("d-none");
                prodiLabel.classList.remove("d-none");
            } else {
                prodiSelect.classList.add("d-none");
                prodiLabel.classList.add("d-none");
            }
        });


</script>
</body>
</html>