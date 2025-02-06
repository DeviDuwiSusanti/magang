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
            background-color:#e2ecf4 ;
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
        .list {
        list-style-type: disc !important;
        padding-left: 20px !important;
        }
        .form_daftar {
    background-color: #ffffff;  /* Warna putih untuk latar belakang */
    padding: 20px;              /* Memberikan ruang di dalam form */
    border-radius: 10px;        /* Membuat sudut membulat */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* Efek bayangan halus */
    margin-top: 20px;           /* Memberi jarak dari atas */
}

.form_daftar .card {
    background-color: #ffffff;  /* Memastikan bagian dalam card juga putih */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* Tambahan bayangan untuk kesan mengambang */
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
                        <tr><td><b>Posisi</b></td><td>:</td><td>Web Developer</td></tr>
                        <tr><td><b>Perusahaan</b></td><td>:</td><td>Dinas Komunikasi dan Informatika</td></tr>
                        <tr><td><b>Lokasi</b></td><td>:</td><td>Kab. Sidoarjo</td></tr>
                    </table>
                    <h3>Deskripsi Lowongan</h3>
                    <ul class="list">
                        <li>Jenjang pendidikan: SMA/SMK.</li>
                        <li>Jurusan: Teknik Komputer dan Jaringan.</li>
                        <li>IPK minimal: 3.1</li>
                    </ul>
                    <h3>Persyaratan Dokumen</h3>
                    <ul class="list">
                        <li>CV</li>
                        <li>Surat Badan Kesatuan Bangsa dan Politik Provinsi Jawa Timur</li>
                        <li>Surat Badan Kesatuan Bangsa dan Politik Kabupaten Sidoarjo</li>
                        <li>Proposal</li>
                    </ul></br>
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
                            <select name="jenis_pengajuan" required>
                                <option value="" disabled selected>Pilih Jenis Pengajuan</option>
                                <option value="magang">Magang/Kerja Praktek</option>
                                <option value="magang">Kerja Praktek</option>
                                <option value="kp">PKL</option>
                                <option value="penelitian">Penelitian</option>
                            </select>
                        </div>
                            <div class="form-group">
                                <input type="number" name="jumlah" placeholder="Jumlah" required />
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
</body>
</html>
