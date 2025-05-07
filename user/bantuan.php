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

    <div class="card p-4 mb-4">
        <h1><i class="bi bi-envelope"></i> Hubungi Kami</h1>
        <div>
            Silahkan hubungi email di bawah ini<br><br>
            <a href="mailto:<?= htmlspecialchars($email_super['email']) ?>" class="text-gray-400 hover:text-white"><?= htmlspecialchars($email_super['email']) ?></a><br/>
        </div>
    </div>
</div>

<?php 
include "../layout/footerDashboard.php"; 
?>
