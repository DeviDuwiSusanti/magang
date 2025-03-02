<?php 
include "../layout/sidebarUser.php"; 
include "functions.php";

ISSET($_GET['id_logbook']);
$id_logbook = $_GET['id_logbook'];
$id_pengajuan = $_GET['id_pengajuan'];

$sql = "SELECT * FROM tb_logbook WHERE id_logbook = '$id_logbook'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);


if (ISSET($_POST['update_logbook'])){
    $sql2 = "UPDATE tb_logbook SET 
    tanggal_logbook = '$_POST[tanggal]',
    kegiatan_logbook = '$_POST[kegiatan]',
    keterangan_logbook = '$_POST[keterangan]',
    change_by = '$id_user' WHERE id_logbook = '$id_logbook'";

    $query2 = mysqli_query($conn, $sql2);
    if ($query2) {
        showAlert('Berhasil!', 'Logbook Berhasil Diupdate', 'success', "logbook_daftar.php?id_pengajuan={$id_pengajuan}");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal diupdate. Silakan coba lagi.', 'error');
    }    
}
?>


<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Edit Logbook</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Edit Logbook Harian</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $row['tanggal_logbook'] ?>">
            </div>
            
            <div class="mb-3">
                <label for="kegiatan" class="form-label">Kegiatan</label>
                <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?= $row['kegiatan_logbook'] ?>">
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $row['keterangan_logbook'] ?></textarea>
            </div>
    
            <!-- Tombol Submit -->
            <button type="submit" name="update_logbook" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i>Simpan</button>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>

<!-- ======= VALIDASI ========== -->
<script>
$(document).ready(function() {
    $('.form-profile').on('submit', function(e) {
        e.preventDefault(); // cegah submit default

        let tanggal = $('#tanggal').val();
        let kegiatan = $('#kegiatan').val().trim();
        let keterangan = $('#keterangan').val().trim();
        let id_user = <?= json_encode($id_user); ?>;
        let id_pengajuan = <?= json_encode($id_pengajuan); ?>;
        let tanggal_lama = <?= json_encode($row['tanggal_logbook'] ?? ''); ?>;
        let isValid = true;

        // Bersihkan pesan error sebelumnya
        $('.text-danger').remove();

        // Validasi Kegiatan
        if (kegiatan === '') {
            $('#kegiatan').after('<small class="text-danger">Kegiatan harus diisi</small>');
            isValid = false;
        }

        // Validasi Keterangan
        if (keterangan === '') {
            $('#keterangan').after('<small class="text-danger">Keterangan harus diisi</small>');
            isValid = false;
        }

        // Validasi Tanggal
        if (tanggal === '') {
            $('#tanggal').after('<small class="text-danger">Tanggal harus diisi</small>');
            isValid = false;
        }

        // Jika ada error, hentikan proses
        if (!isValid) {
            return;
        }

        // Cek tanggal unik (AJAX)
        $.ajax({
            url: 'cek.php',
            type: 'POST',
            data: {
                tanggal: tanggal,
                id_user: id_user,
                id_pengajuan: id_pengajuan,
                tanggal_lama: tanggal_lama
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    $('#tanggal').after('<small class="text-danger">Tanggal ini sudah digunakan</small>');
                } else {
                    // Submit form jika semua validasi lolos
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'update_logbook',
                        value: '1'
                    }).appendTo('.form-profile');
                    
                    $('.form-profile')[0].submit();
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengecek tanggal. Silakan coba lagi.');
            }
        });
    });
});



</script>