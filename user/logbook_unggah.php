<?php include "../layout/sidebarUser.php"; 
include "functions.php";

$id_pengajuan = $_GET['id_pengajuan'];
$sqlTanggal = "SELECT * FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$queryTanggal = mysqli_query($conn, $sqlTanggal);
$rowTanggal = mysqli_fetch_assoc($queryTanggal);


if (isset($_POST['unggah_logbook'])) {
    $id_pengajuan = $_POST['id_pengajuan'];
    $tanggal = $_POST['tanggal'];
    $kegiatan = $_POST['kegiatan'];
    $keterangan = $_POST['keterangan'];

    $id_logbook = generateLogbookId($conn, $id_pengajuan);

    // Query INSERT dengan id_logbook yang sudah dibuat
    $sql = "INSERT INTO tb_logbook (`id_logbook`, `tanggal_logbook`, `kegiatan_logbook`, `keterangan_logbook`, `id_pengajuan`, `id_user`, `create_by`) 
            VALUES ('$id_logbook', '$tanggal', '$kegiatan', '$keterangan', '$id_pengajuan', '$id_user', '$id_user')";
    
    $query = mysqli_query($conn, $sql);

    // Cek apakah data berhasil diinput
    if ($query) {
        showAlert('Berhasil!', 'Logbook Berhasil Diunggah', 'success', "logbook_daftar.php?id_pengajuan={$id_pengajuan}");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal diunggah. Silakan coba lagi.', 'error');
    }    
}


?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Logbook</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Logbook Harian</li>
            <a href="logbook_daftar.php?id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-secondary">Lihat Daftar Logbook</a>
        </ol>
        <div class="dropdown-divider"></div><br><br>
        
         <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan ?>">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" min="<?= $rowTanggal['tanggal_mulai'] ?>" max="<?= $rowTanggal['tanggal_selesai'] ?>">
            </div>
            
            <div class="mb-3">
                <label for="kegiatan" class="form-label">Kegiatan</label>
                <input type="text" class="form-control" id="kegiatan" name="kegiatan">
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
            </div>
    
            <!-- Tombol Submit -->
            <button type="submit" name="unggah_logbook" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i>Simpan</button>
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
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    $('#tanggal').after('<small class="text-danger">Tanggal ini sudah digunakan</small>');
                } else {
                    // Submit form jika semua validasi lolos
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'unggah_logbook',
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