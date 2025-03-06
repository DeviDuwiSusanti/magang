<?php 
include "../layout/sidebarUser.php"; 
include "functions.php";

$id_logbook = $_GET['id_logbook'];

$sql = "SELECT * FROM tb_logbook WHERE id_logbook = '$id_logbook'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
$ttd = $row['tanda_tangan'];


if (ISSET($_POST['update_logbook'])){
    // Inisialisasi foto_kegiatan (default: data lama)
    $foto_kegiatan = $row['foto_kegiatan'];

    // Jika ada file baru diunggah
    if (!empty($_FILES['gambar_kegiatan']['name'])) {
        $uploadResult = uploadFoto($_FILES['gambar_kegiatan'], "../assets/img/logbook/");
        if ($uploadResult) {
            $foto_kegiatan = $uploadResult['path'];
        }
    }

    $sql2 = "UPDATE tb_logbook SET 
    tanggal_logbook = '$_POST[tanggal]',
    kegiatan_logbook = '$_POST[kegiatan]',
    keterangan_logbook = '$_POST[keterangan]',
    jam_mulai = '$_POST[jam_mulai]',
    jam_selesai = '$_POST[jam_selesai]',
    foto_kegiatan = '$foto_kegiatan',
    tanda_tangan = '$_POST[ttd]',
    change_by = '$id_user' WHERE id_logbook = '$id_logbook'";

    $query2 = mysqli_query($conn, $sql2);
    if ($query2) {
        showAlert('Berhasil!', 'Logbook Berhasil Diupdate', 'success', "logbook_daftar.php");
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
    
            <!-- Jam Pelaksanaan -->
            <div class="mb-3">
                <label for="jam_pelaksanaan" class="form-label">Jam Pelaksanaan</label>
                <div class="d-flex gap-2">
                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="<?= $row['jam_mulai'] ?>">
                    <span class="align-self-center">sampai</span>
                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="<?= $row['jam_selesai'] ?>">
                </div>
            </div>

            <!-- Unggah Gambar -->
            <div class="mb-3">
                <label for="gambar_kegiatan" class="form-label">Unggah Gambar Kegiatan</label>
                <input type="file" class="form-control" id="gambar_kegiatan" name="gambar_kegiatan" accept="image/*">
                <p>Foto saat ini: <a href="<?= ($row['foto_kegiatan']) ?>" target="_blank">Lihat Foto Kegiatan</a></p>
            </div>

            <!-- Tanda Tangan -->
            <div class="mb-3">
                <label for="signature-pad" class="form-label">Tanda Tangan</label>
                <canvas id="signature-pad" width="300" height="150" style="border: 1px solid #000; display: block; margin-bottom: 10px;"></canvas>
                <button type="button" class="btn btn-danger btn-sm" id="clear-signature">Hapus Tanda Tangan</button>
                <input type="hidden" name="ttd" id="signature-data">
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
        let gambar = $('#gambar_kegiatan')[0].files[0];
        let ttd = $('#signature-data').val(); // Ambil tanda tangan dari hidden input
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

                // Validasi Waktu (Jam Mulai dan Jam Selesai)
                if (jam_mulai === '') {
            $('#jam_mulai').after('<small class="text-danger">Jam mulai harus diisi</small>');
            isValid = false;
        }

        if (jam_selesai === '') {
            $('#jam_selesai').after('<small class="text-danger">Jam selesai harus diisi</small>');
            isValid = false;
        }

        // Validasi Jam Mulai < Jam Selesai
        if (jam_mulai && jam_selesai && jam_mulai >= jam_selesai) {
            $('#jam_selesai').after('<small class="text-danger">Jam selesai harus lebih dari jam mulai</small>');
            isValid = false;
        }

        // Validasi Gambar (harus diunggah)
        if (gambar.size > 1048576) { // 1 MB = 1048576 bytes
            $('#gambar_kegiatan').after('<small class="text-danger">Ukuran gambar tidak boleh lebih dari 1 MB</small>');
            isValid = false;
        }

        // Validasi Tanda Tangan
        if (ttd === '') {
            $('#signature-pad').after('<small class="text-danger">Tanda tangan wajib diisi</small>');
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

<script>
    // Inisialisasi canvas tanda tangan
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    // Mengambil data tanda tangan dari PHP
    const previousSignature = <?= json_encode($ttd) ?>;

    // Menampilkan tanda tangan sebelumnya (jika ada)
    if (previousSignature) {
        const img = new Image();
        img.src = previousSignature;
        img.onload = () => {
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            document.getElementById('signature-data').value = previousSignature;
        };
    }

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