<?php include "../layout/header.php"; ?>

<div class="container mt-4">
    <h1 class="text-center"><i class="bi bi-question-circle"></i> Pusat Bantuan</h1>
    <p class="text-center text-muted">
        Temukan jawaban atas pertanyaan umum atau hubungi kami jika memerlukan bantuan lebih lanjut.
    </p>

    <!-- Accordion FAQ -->
    <div class="accordion mb-4" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Bagaimana cara mengubah password saya?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Untuk mengubah password, buka halaman pengaturan, pilih tab <strong>Keamanan</strong>, masukkan password lama dan password baru, lalu simpan perubahan.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Bagaimana cara menghubungi tim dukungan?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat menghubungi tim dukungan melalui formulir kontak di bawah halaman ini atau dengan mengirim email ke <a href="mailto:support@example.com">support@example.com</a>.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Apa itu Autentikasi Dua Langkah (2FA)?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Autentikasi Dua Langkah (2FA) adalah lapisan keamanan tambahan yang memerlukan dua bentuk verifikasi (misalnya, password dan kode yang dikirim melalui SMS atau email) untuk mengakses akun Anda.
                </div>
            </div>
        </div>

        <!-- Tambahkan FAQ lain sesuai kebutuhan -->
    </div>

    <!-- Formulir Kontak -->
    <div class="card p-4 mb-4">
        <h1><i class="bi bi-envelope"></i> Hubungi Kami</h1>
        <p>
            Jika Anda tidak menemukan jawaban yang Anda cari di FAQ, silakan kirim pesan kepada tim dukungan kami.
        </p>
        <form action="submit_help.php" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="subjek" class="form-label">Subjek</label>
                <input type="text" class="form-control" id="subjek" name="subjek" required>
            </div>
            <div class="mb-3">
                <label for="pesan" class="form-label">Pesan</label>
                <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i> Kirim Pesan</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>