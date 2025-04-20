<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/beranda.css" />
    <link rel="stylesheet" href="../assets/css/style2.css" />
    <link rel="icon" href="../assets/img/logo_kab_sidoarjo.png" type="image/png">
    <title>About</title>
    
</head>

<body>
    <?php include "../layout/navbarUser.php" ?>

    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== About ====================-->
        <section class="contact section" id="contact">
            <div class="contact__container container grid">
                <div class="contact__images">
                    <img src="../assets/img/home4.jpg" alt="" />
                </div>

                <div class="contact__content">
                    <div class="contact__data">
                        <span class="section__subtitle">Butuh Bantuan?</span>
                        <h2 class="section__title">Jangan khawatir!</h2>
                        <p class="contact__description">
                            Jika Kamu menghadapi kendala dalam mencari program magang atau memerlukan panduan lebih lanjut,
                            kami menyediakan informasi lengkap di platform ini untuk membantu Kamu. Eksplor semua fitur dan
                            temukan solusi terbaik untuk kebutuhan magang Kamu!
                        </p>
                    </div>

                    <!-- MENU TUTORIAL -->
                    <div class="contact__card">
                        <!-- Cara Daftar -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bx-user-plus"></i>
                                <div>
                                    <h3 class="contact__card-title">Cara Daftar</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Cara Daftar" 
                            data-steps='[{"step":"Buka halaman detail lowongan yang ingin dilamar.", "img":"../assets/img/tentang/lowongan.png"}, 
                            {"step":"Lihat detail lowongan, dan pastikan Kamu sesuai kriteria yaa! Lalu Kamu bisa klik Daftar Sekarang.", "img":"../assets/img/tentang/detail_lowongan.png"}, 
                            {"step":"Kamu akan diarahkan ke halaman Dashboard, lalu klik Pengajuan.", "img":"../assets/img/tentang/dashboardUser.png"}, 
                            {"step":"Klik Tambah Pengajuan, dan isi form yang tersedia.", "img":"../assets/img/tentang/daftarPengajuan.png"}, 
                            {"step":"Instansi akan mengirimkan link zoom via email untuk wawancara pendaftaran Kamu"},
                            {"step":"Jika status setelah melakukan wawancara Kamu diterima, maka Kamu bisa mengunggah dokumen persyaratan lainnya, agar Kamu benar-benar resmi diterima", "img":"../assets/img/tentang/unggahPrasyarat.png"},
                            {"step":"Jika selama tenggat waktu yang ditentukan, Kamu tidak melengkapi dokumen persyaratan, maka Kamu akan dianggap batal mengajukan magang"}]'>Lihat</button>
                        </div>

                        <!-- Unggah Logbook -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bx-upload"></i>
                                <div>
                                    <h3 class="contact__card-title">Unggah Logbook</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Unggah Logbook" 
                            data-steps='[{"step":"Jika status pengajuan Kamu sudah berlangsung, maka Kamu bisa unggah Logbook Kegiatan Harian."}, 
                            {"step":"Masuk ke dashboard user, dan klik Isi logbook", "img":"../assets/img/tentang/dashboard2.png"},
                            {"step":"Klik Tambah Logbook.", "img":"../assets/img/tentang/logbook.png"}]'>Lihat</button>
                        </div>

                        <!-- Unggah Laporan Akhir -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bxs-file-plus"></i>
                                <div>
                                    <h3 class="contact__card-title">Laporan Akhir</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Unggah Laporan Akhir" 
                            data-steps='[{"step":"Masuk ke dashboard user, dan klik laporan akhir", "img":"../assets/img/tentang/dashboard2.png"}, 
                            {"step":"Klik Tambah Laporan Akhir.", "img":"../assets/img/tentang/laprak.png"}]'>Lihat</button>
                        </div>

                        <!-- Cek Sertifikat -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bxs-file-export"></i>
                                <div>
                                    <h3 class="contact__card-title">Cek Sertifikat dan Nilai</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Cek Sertifikat dan Nilai" 
                            data-steps='[{"step":"Jika magang Kamu sudah selesai, maka kamu bisa cek sertifikat dan nilai."}, 
                            {"step":"Masuk ke dashboard user, dan klik Sertifikat dan Nilai", "img":"../assets/img/tentang/dashboard2.png"},
                            {"step":"Kamu akan diarahkan ke halaman Histori.", "img":"../assets/img/tentang/histori.png"},
                            {"step":"Klik Cetak Sertifikat atau Nilai.", "img":"../assets/img/tentang/detail_histori.png"},
                            {"step":"Jika sertifikat atau nilai belum tersedia, artinya admin instansi belum menggunggah sertifikat dan nilai Kamu. Jadi bersabar yaa."}]'>Lihat</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include "../layout/footerUser.php" ?>

    <!-- Modal -->
    <div class="modal fade" id="tutorialModal" tabindex="-1" aria-labelledby="tutorialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tutorialModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ol id="modalSteps"></ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const tutorialModal = document.getElementById('tutorialModal');
        tutorialModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const steps = JSON.parse(button.getAttribute('data-steps'));

            const modalTitle = tutorialModal.querySelector('.modal-title');
            const modalSteps = tutorialModal.querySelector('#modalSteps');

            // Set title modal
            modalTitle.textContent = title;

            // Bersihkan dan masukkan langkah baru
            modalSteps.innerHTML = ''; // Bersihkan modal lama
            modalSteps.innerHTML = steps.map(step => {
                const hasImage = step.img && step.img.trim() !== ""; // Check jika img ada
                const timestamp = new Date().getTime(); // Cache buster
                return `
                    <li class="mb-3">
                        <p>${step.step}</p>
                        ${hasImage ? `<img src="${step.img}?v=${timestamp}" alt="Step Image" class="img-fluid" />` : ""}
                    </li>
                `;
            }).join('');
        });
    </script>
</body>

</html>
