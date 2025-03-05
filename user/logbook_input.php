<?php include "../layout/sidebarUser.php"; 
include "functions.php";

$sqlTanggal = "SELECT * FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$queryTanggal = mysqli_query($conn, $sqlTanggal);
$rowTanggal = mysqli_fetch_assoc($queryTanggal);


if (isset($_POST['input_logbook'])) {
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
        showAlert('Berhasil!', 'Logbook Berhasil Diinput', 'success', "logbook_daftar.php");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal diinput. Silakan coba lagi.', 'error');
    }    
}


?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Logbook</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Logbook Harian</li>
            <a href="logbook_daftar.php" class="btn btn-secondary">Lihat Daftar Logbook</a>
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

            <!-- Jam Pelaksanaan -->
            <div class="mb-3">
                <label for="jam_pelaksanaan" class="form-label">Jam Pelaksanaan</label>
                <div class="d-flex gap-2">
                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                    <span class="align-self-center">sampai</span>
                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                </div>
            </div>

            <!-- Unggah Gambar -->
            <div class="mb-3">
                <label for="gambar_kegiatan" class="form-label">Unggah Gambar Kegiatan</label>
                <input type="file" class="form-control" id="gambar_kegiatan" name="gambar_kegiatan" accept="image/*" required>
            </div>

            <!-- Tanda Tangan -->
            <div class="mb-3">
                <label for="signature-pad" class="form-label">Tanda Tangan</label>
                <canvas id="signature-pad" width="300" height="150" style="border: 1px solid #000; display: block; margin-bottom: 10px;"></canvas>
                <button type="button" class="btn btn-danger btn-sm" id="clear-signature">Hapus Tanda Tangan</button>
                <input type="hidden" name="signature" id="signature-data">
            </div>

    
            <!-- Tombol Submit -->
            <button type="submit" name="input_logbook" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i>Simpan</button>
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

<script>
    // Inisialisasi canvas tanda tangan
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    canvas.addEventListener('mousedown', () => drawing = true);
    canvas.addEventListener('mouseup', () => {
        drawing = false;
        ctx.beginPath();
        saveSignature();
    });
    canvas.addEventListener('mousemove', draw);

    function draw(e) {
        if (!drawing) return;
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = 'black';
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    }

    document.getElementById('clear-signature').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('signature-data').value = '';
    });

    function saveSignature() {
        const signatureData = canvas.toDataURL('image/png');
        document.getElementById('signature-data').value = signatureData;
    }
</script>