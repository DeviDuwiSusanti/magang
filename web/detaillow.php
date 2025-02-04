<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="./assets/libraries/swiper-bundle.min.css" />
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/detailow.css">
    <title>Detail Lowongan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        select, input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<main class="main">
    <section class="blog section" id="blog">
        <div class="blog__container container">
            <div class="content__container">
                <div class="blog__detail">
                    <h2 class="blog__title">Detail Lowongan</h2>
                    <table class="detail-table">
                        <tr><td><b>Posisi</b></td><td>:</td><td>Asisten IT</td></tr>
                        <tr><td><b>Perusahaan</b></td><td>:</td><td>PT Sucofindo</td></tr>
                        <tr><td><b>Lokasi</b></td><td>:</td><td>Kab. Bekasi • Onsite</td></tr>
                    </table>
                    <h3>Deskripsi Lowongan</h3>
                    <ul>
                        <li>Jenjang pendidikan: SMA/SMK.</li>
                        <li>Jurusan: Teknik Komputer dan Jaringan.</li>
                        <li>IPK minimal: 3.1.</li>
                    </ul>
                    <h3>Persyaratan Dokumen</h3>
                    <ul>
                        <li>CV</li>
                        <li>Surat Badan Kesatuan Bangsa dan Politik Provinsi Jawa Timur</li>
                        <li>Surat Badan Kesatuan Bangsa dan Politik Kabupaten Sidoarjo</li>
                        <li>Proposal</li>
                    </ul>
                    <h3>Lokasi Instansi</h3>
                    <div class="maps-container">
                        <iframe src="https://www.google.com/maps/embed?..." referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="form_daftar">
                    <h3 style="text-align: center;">Formulir Pendaftaran</h3>
                    <div class="card">
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="nama" placeholder="Nama Lengkap" required />
                            </div>
                            <div class="form-group">
                                <label for="jenjang">Jenjang Pendidikan:</label>
                                <select id="jenjang" onchange="updateForm()">
                                    <option value="">-- Pilih --</option>
                                    <option value="sma">SMA</option>
                                    <option value="smk">SMK</option>
                                    <option value="universitas">Universitas</option>
                                </select>
                            </div>
                            <div id="jurusanDiv" style="display: none;">
                                <label for="jurusan">Jurusan:</label>
                                <select id="jurusan"></select>
                            </div>
                            <div id="fakultasDiv" style="display: none;">
                                <label for="fakultas">Fakultas:</label>
                                <select id="fakultas" onchange="updateProdi()"></select>
                            </div>
                            <div id="prodiDiv" style="display: none;">
                                <label for="prodi">Program Studi:</label>
                                <select id="prodi"></select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <input type="date" id="tanggal_mulai" name="tanggal_mulai" required />
                            </div>
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai:</label>
                                <input type="date" id="tanggal_selesai" name="tanggal_selesai" required />
                            </div>
                            <div class="form-group">
                                <label for="cv">Unggah CV:</label>
                                <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required />
                            </div>
                            <div class="form-group">
                                <button class="button" name="kirim">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    function updateForm() {
        let jenjang = document.getElementById("jenjang").value;
        let jurusanDiv = document.getElementById("jurusanDiv");
        let fakultasDiv = document.getElementById("fakultasDiv");
        let prodiDiv = document.getElementById("prodiDiv");
        let jurusanSelect = document.getElementById("jurusan");
        let fakultasSelect = document.getElementById("fakultas");
        let prodiSelect = document.getElementById("prodi");

        jurusanDiv.style.display = "none";
        fakultasDiv.style.display = "none";
        prodiDiv.style.display = "none";
        jurusanSelect.innerHTML = "<option value=''>-- Pilih Jurusan --</option>";
        fakultasSelect.innerHTML = "<option value=''>-- Pilih Fakultas --</option>";
        prodiSelect.innerHTML = "<option value=''>-- Pilih Program Studi --</option>";

        if (jenjang === "sma") {
            jurusanDiv.style.display = "block";
            jurusanSelect.innerHTML += "<option value='ipa'>IPA</option><option value='ips'>IPS</option>";
        } else if (jenjang === "smk") {
            jurusanDiv.style.display = "block";
            jurusanSelect.innerHTML += "<option value='rpl'>RPL</option><option value='jaringan'>Jaringan</option>";
        } else if (jenjang === "universitas") {
            fakultasDiv.style.display = "block";
            fakultasSelect.innerHTML += `
                <option value="fik">Fakultas Ilmu Komputer</option>
                <option value="feb">Fakultas Ekonomi dan Bisnis</option>
                <option value="fh">Fakultas Hukum</option>
            `;
        }
    }

    function updateProdi() {
        let fakultas = document.getElementById("fakultas").value;
        let prodiDiv = document.getElementById("prodiDiv");
        let prodiSelect = document.getElementById("prodi");

        prodiDiv.style.display = "none";
        prodiSelect.innerHTML = "<option value=''>-- Pilih Program Studi --</option>";

        if (fakultas === "fik") {
            prodiDiv.style.display = "block";
            prodiSelect.innerHTML += `
                <option value="ti">Teknik Informatika</option>
                <option value="si">Sistem Informasi</option>
                <option value="dkv">Desain Komunikasi Visual</option>
            `;
        } else if (fakultas === "feb") {
            prodiDiv.style.display = "block";
            prodiSelect.innerHTML += `
                <option value="manajemen">Manajemen</option>
                <option value="akuntansi">Akuntansi</option>
                <option value="ekonomi">Ekonomi</option>
            `;
        } else if (fakultas === "fh") {
            prodiDiv.style.display = "block";
            prodiSelect.innerHTML += `
                <option value="ilmu_hukum">Ilmu Hukum</option>
            `;
        }
    }
</script>
</body>
</html>
