<?php 
    include "sidebar.php";
?>

<div class="container mt-4">
    <h2 class="text-center"><i class="bi bi-question-circle"></i> Pusat Bantuan</h2>
    <p class="text-center text-muted">Temukan jawaban atas pertanyaan umum atau hubungi tim dukungan.</p>

    <!-- Menu Navigasi -->
    <nav class="nav nav-pills justify-content-center mb-4">
        <a class="nav-link active" href="#faq"><i class="bi bi-chat-right-dots"></i> FAQ</a>
        <a class="nav-link" href="#kontak"><i class="bi bi-telephone"></i> Kontak</a>
        <a class="nav-link" href="#tiket"><i class="bi bi-envelope"></i> Kirim Tiket</a>
    </nav>

    <!-- FAQ -->
    <div id="faq" class="card p-4 mb-4">
        <h4><i class="bi bi-chat-dots"></i> Pertanyaan Umum</h4>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        Bagaimana cara menambahkan instansi baru?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-danger">
                        Untuk menambahkan instansi baru, masuk ke menu <strong>Instansi</strong> lalu klik tombol <em>"Tambah Instansi"</em>.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Bagaimana cara mengubah status user?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-danger">
                        Masuk ke menu <strong>User</strong>, cari user yang ingin diubah, lalu klik tombol <em>"Edit User"</em>.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak Dukungan -->
    <div id="kontak" class="card p-4 mb-4">
        <h4><i class="bi bi-telephone"></i> Kontak Dukungan</h4>
        <p><i class="bi bi-envelope"></i> Email: <strong>support@example.com</strong></p>
        <p><i class="bi bi-telephone"></i> Telepon: <strong>+62 812-3456-7890</strong></p>
        <p><i class="bi bi-whatsapp"></i> WhatsApp: <strong>+62 812-3456-7890</strong></p>
    </div>

    <!-- Form Kirim Tiket -->
    <div id="tiket" class="card p-4">
        <h4><i class="bi bi-envelope"></i> Kirim Tiket Bantuan</h4>
        <form>
            <div class="mb-3">
                <label for="email" class="form-label">Email Anda</label>
                <input type="email" class="form-control" id="email" placeholder="Masukkan email">
            </div>
            <div class="mb-3">
                <label for="subjek" class="form-label">Subjek</label>
                <input type="text" class="form-control" id="subjek" placeholder="Masukkan subjek">
            </div>
            <div class="mb-3">
                <label for="pesan" class="form-label">Pesan</label>
                <textarea class="form-control" id="pesan" rows="4" placeholder="Tulis pesan Anda"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Kirim Tiket</button>
        </form>
    </div>
</div>
<?php include "footer.php" ?>