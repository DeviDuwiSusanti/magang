<?php
// akses email super admin
$email_super = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email from tb_user WHERE level = '1'"));
?>
    <footer class="footer section">
            <div class="footer__container container grid">
                <div>
                    <a href="#" class="footer__logo">
                        Sid<i class="bx bxs-map"></i>arjo Internship Portal
                    </a>
                    <p class="text-gray-400">
                        Dinas Komunikasi dan Informatika
                    </p>
                    <p class="text-gray-400 mt-2">
                    Jl. Diponegoro No.139, Lemah Putro, Lemahputro,<br/>
                    Kec. Sidoarjo, Kabupaten Sidoarjo,<br/>
                     Jawa Timur 61213
                    </p>
                    <p class="text-gray-400 mt-2">
                        Email: <a href="mailto:<?= htmlspecialchars($email_super['email']) ?>" class="text-gray-400 hover:text-white"><?= htmlspecialchars($email_super['email']) ?></a><br/>
                        Akses peluang magang terbaik di Sidoarjo dengan mudah</p>
                </div>

                <div class="footer__content">
                    <div>
                  <ul class="footer__links space-y-2">
                  <h3 class="footer__title text-xl font-semibold mb-4">Peserta</h3>
                            <li>
                            <a href="#" class="footer__link text-gray-400 hover:text-white">Home</a>
                            </li>
                            <li>
                            <a href="lowongan.php" class="footer__link text-gray-400 hover:text-white">Cari Lowongan</a>
                            </li>
                            <li>
                            <a href="../user/user3_statusPengajuan.php" class="footer__link text-gray-400 hover:text-white">Pengajuan</a>
                            </li>
                            <li>
                            <a href="tentang.php" class="footer__link text-gray-400 hover:text-white">Tentang Kami</a>
                            </li>
                            <li>
                            <a href="../user/user3_histori.php" class="footer__link text-gray-400 hover:text-white">Cek Sertifikat</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                    <h3 class="footer__title text-xl font-semibold mb-4">Ikuti Kami</h3>
                        <ul class="footer__social flex space-x-4">
                            <a href="#" class="footer__social-link text-gray-400 hover:text-white text-2xl">
                            <i class="bx bxl-facebook-circle"></i>
                            </a>
                            <a href="#" class="footer__social-link text-gray-400 hover:text-white text-2xl">
                            <i class="bx bxl-instagram-alt"></i>
                            </a>
                            <a href="#" class="footer__social-link text-gray-400 hover:text-white text-2xl">
                            <i class="bx bxl-tiktok"></i>
                            </a>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer__info container">
                <span class="footer__copy">
                    &#169; Sidoarjo  . Semua hak cipta dilindungi
                </span>
                <div class="footer__privacy">
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
        </footer>

         <!--========== SCROLL UP ==========-->
         <a href="#" class="scrollup" id="scroll-up">
            <i class="bx bx-chevrons-up"></i>
        </a>

        <script src="https://unpkg.com/scrollreveal"></script>

        <!--=============== SCROLLREVEAL ===============-->
        <script src="../assets/libraries/scrollreveal.min.js"></script>

        <!--=============== SWIPER JS ===============-->
        <script src="../assets/libraries/swiper-bundle.min.js"></script>

        <!--=============== MAIN JS ===============-->
        <script src="../assets/js/main.js"></script>
        