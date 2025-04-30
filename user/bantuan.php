<?php 
include "../layout/sidebarUser.php";
$email_super = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email from tb_user WHERE level = '1'"));
?>

<style>
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    padding: 0;
}

.container.main-content {
    flex: 1;
    padding-bottom: 20px;
}

.footer {
    margin-top: auto;
    background-color: #f8f9fa;
    padding: 20px 0;
    width: 100%;
}
</style>

<div class="container main-content mt-4">
    <h1 class="text-center"><i class="bi bi-question-circle"></i> Pusat Bantuan</h1>
    <p class="text-center text-muted">
        Temukan jawaban atas pertanyaan umum atau hubungi kami jika memerlukan bantuan lebih lanjut.
    </p>

    <div class="accordion mb-4" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Bagaimana cara menghubungi tim dukungan?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat menghubungi tim dukungan melalui email yang tertera di bawah halaman ini.
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 mb-4">
        <h1><i class="bi bi-envelope"></i> Hubungi Kami</h1>
        <p>
            Jika Anda tidak menemukan jawaban yang Anda cari di FAQ, silakan kirim pesan kepada tim dukungan kami.
        </p>
        <div>
            Silahkan hubungi email di bawah ini<br><br>
            <a href="mailto:<?= htmlspecialchars($email_super['email']) ?>" class="text-gray-400 hover:text-white"><?= htmlspecialchars($email_super['email']) ?></a><br/>
        </div>
    </div>
</div>

<?php 
include "../layout/footerDashboard.php"; 
?>