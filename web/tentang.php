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
    <link rel="stylesheet" href="../assets/css/web.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
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
                            Jika Anda menghadapi kendala dalam mencari program magang atau memerlukan panduan lebih lanjut,
                            kami menyediakan informasi lengkap di platform ini untuk membantu Anda. Eksplor semua fitur dan
                            temukan solusi terbaik untuk kebutuhan magang Anda!
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
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Cara Daftar" data-steps='[{"step":"Buka halaman detail lowongan yang ingin dilamar.", "img":"../assets/img/tentang/daftar1.png"}, {"step":"Lihat detail lowongan, dan pastikan Kamu sesuai kriteria yaa! Lalu Kamu bisa klik Daftar Sekarang.", "img":"../assets/img/tentang/daftar2.png"}, {"step":"Masuk ke Dashboar user, lalu klik Pengajuan.", "img":"../assets/img/tentang/daftar3.png"}, {"step":"Tunggu konfirmasi dari admin instansi terkait seleksi kriteria pendaftaran."}]'>Lihat</button>
                        </div>

                        <!-- Cek Status -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bx-search-alt"></i>
                                <div>
                                    <h3 class="contact__card-title">Cek Status</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Cek Status" data-steps='[{"step":"Klik bagian foto profil pada navbar.", "img":"../assets/img/tentang/dashboard.png"}, {"step":"Masuk ke menu Status Pengajuan.", "img":"../assets/img/tentang/status2.png"}, {"step":"Status akan tertera pada tabel, dan jika Anda diterima, maka anda bisa melengkapi dokumen persyaratan lainnya.", "img":"../assets/img/tentang/status3.png"}]'>Lihat</button>
                        </div>

                        <!-- Unggah Persyaratan -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bx-cloud-upload"></i>
                                <div>
                                    <h3 class="contact__card-title">Unggah Persyaratan</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Unggah Persyaratan" data-steps='[{"step":"Klik bagian foto profil pada navbar.", "img":"../assets/img/tentang/dashboard.png"}, {"step":"Masuk ke menu Status Pengajuan.", "img":"../assets/img/tentang/status2.png"}, {"step":"Status akan tertera pada tabel, dan jika Anda diterima, maka anda bisa melengkapi dokumen persyaratan lainnya.", "img":"../assets/img/tentang/status3.png"}]'>Lihat</button>
                        </div>

                        <!-- Unggah Logbook -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bx-upload"></i>
                                <div>
                                    <h3 class="contact__card-title">Unggah Logbook</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Unggah Logbook" data-steps='[{"step":"Masuk ke dashboard user, dan klik unggah logbook", "img":"../assets/img/tentang/dashboard1.png"}, {"step":"Klik input logbook pada kegiatan aktif yang Anda jalani.", "img":"../assets/img/tentang/logbook1.png"}, {"step":"Isi logbook harian Anda.", "img":"../assets/img/tentang/logbook2.png"}]'>Lihat</button>
                        </div>

                        <!-- Unggah Laporan Akhir -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bxs-file-plus"></i>
                                <div>
                                    <h3 class="contact__card-title">Laporan Akhir</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Unggah Laporan Akhir" data-steps='[{"step":"Masuk ke dashboard user, dan klik unggah logbook", "img":"../assets/img/tentang/dashboard1.png"}, {"step":"Klik input logbook pada kegiatan aktif yang Anda jalani.", "img":"../assets/img/tentang/logbook1.png"}, {"step":"Isi logbook harian Anda.", "img":"../assets/img/tentang/logbook2.png"}]'>Lihat</button>
                        </div>

                        <!-- Cek Sertifikat -->
                        <div class="contact__card-box">
                            <div class="contact__card-info">
                                <i class="bx bxs-file-export"></i>
                                <div>
                                    <h3 class="contact__card-title">Cek Sertifikat</h3>
                                </div>
                            </div>
                            <button class="button contact__card-button" data-bs-toggle="modal" data-bs-target="#tutorialModal" data-title="Cek Sertifikat" data-steps='[{"step":"Masuk ke dashboard user, dan klik Histori.", "img":"../assets/img/tentang/dashboard1.png"}, {"step":"Unduh Sertifikat pada kolom yang tersedia.", "img":"../assets/img/tentang/sertifikat1.png"}]'>Lihat</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
