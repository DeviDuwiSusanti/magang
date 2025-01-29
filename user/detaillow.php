<!DOCTYPE html>
<html lang="en">
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
</head>
<body>
<!--==================== MAIN ====================-->
<main class="main">
    <!-- DETAIL LOWONGAN -->
    <section class="blog section" id="blog">
    <div class="blog__container container">
        <div class="content__container">
            <!-- DETAIL LOWONGAN -->
            <div class="blog__detail" style="flex: 1;">
              <h2 class="blog__title">Detail Lowongan</h2>
              <table class="detail-table">
                <tr>
                  <td><b>Posisi</b></td>
                  <td>:</td>
                  <td>Asisten IT</td>
                </tr>
                <tr>
                  <td><b>Perusahaan</b></td>
                  <td>:</td>
                  <td>PT Sucofindo</td>
                </tr>
                <tr>
                  <td><b>Lokasi</b></td>
                  <td>:</td>
                  <td>Kab. Bekasi • Onsite</td>
                </tr>
              </table>
              <h3>Deskripsi Lowongan</h3>
              <ul>
                <li>Jenjang pendidikan: SMA/SMK.</li>
                <li>Jurusan: Teknik Komputer dan Jaringan.</li>
                <li>IPK minimal: 3.1.</li>
              </ul><br>
              <h3>Persyaratan Dokumen</h3>
              <ul>
                <li>CV</li>
                <li>Surat Badan Kesatuan Bangsa dan Politik Provinsi Jawa Timur</li>
                <li>Surat Badan Kesatuan Bangsa dan Politik Kabupaten Sidoarjo</li>
                <li>Proposal</li>
              </ul><br>
              <h3>Rincian Lowongan</h3>
              <ul>
                <li>Status: Pemagang Masih Bersekolah Aktif</li>
              </ul>
            </div>

            <!-- FORM PENDAFTARAN -->
            <div class="package-travel" style="flex: 1;">
              <h3 style="text-align: center;">Formulir Pendaftaran</h3>
              <div class="card">
              <form action="" method="POST">
                <div class="form-group">
                    <input type="text" name="nama" placeholder="Nama Lengkap" required />
                </div>

                <div class="form-group">
                    <label for="asal_studi">Asal Studi:</label>
                    <select id="asal_studi" name="asal_studi" required>
                        <option value="" disabled selected>Pilih Asal Studi</option>
                        <option value="universitas_a">Universitas A</option>
                        <option value="universitas_b">Universitas B</option>
                        <option value="universitas_c">Universitas C</option>
                        <option value="universitas_d">Universitas D</option>
                    </select>
                </div>
                <!-- Tambahan space antara dropdown Asal Studi dan Jurusan -->
                <div class="form-group space-between"></div>
                <div class="form-group">
                    <input type="text" name="jurusan" placeholder="Jurusan" required />
                </div>
                <div class="form-group">
                    <input type="date" name="tanggal_pelaksanaan" placeholder="Tanggal Pelaksanaan" required />
                </div>
                <div class="form-group">
                    <label for="cv">Unggah CV:</label>
                    <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required />
                </div>
                <div class="form-group">
                    <button class="button button-booking" name="kirim">Kirim</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
 </main>

<!--==================== FOOTER ====================-->
<footer class="footer section">
<!-- Footer content here -->
</footer>

<!--========== SCROLL UP ==========-->
<a href="#" class="scrollup" id="scroll-up">
<i class="bx bx-chevrons-up"></i>
</a>

  </body>
</html>
