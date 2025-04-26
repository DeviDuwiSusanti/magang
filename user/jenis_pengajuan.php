<?php include '../layout/sidebarUser.php';

// Proses Tambah
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $nama = trim($_POST['nama']);
    $nama = ucfirst(strtolower($nama));

    $cek = mysqli_query($conn, "SELECT jenis2_pengajuan FROM tb_instansi LIMIT 1");
    $row = mysqli_fetch_assoc($cek);
    $data = json_decode($row['jenis2_pengajuan'], true);

    if (!is_array($data)) {
        $data = [];
    }

    if (in_array($nama, $data)) {
        echo "
            <script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Jenis pengajuan sudah ada!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        ";
    } else {
        $res = mysqli_query($conn, "SELECT id_instansi, jenis2_pengajuan FROM tb_instansi");
        while ($r = mysqli_fetch_assoc($res)) {
            $d = json_decode($r['jenis2_pengajuan'], true);
            if (!is_array($d)) {
                $d = [];
            }
            $d[] = $nama;
            $json = json_encode($d);
            mysqli_query($conn, "UPDATE tb_instansi SET jenis2_pengajuan='$json' WHERE id_instansi=" . $r['id_instansi']);
        }
        echo "
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Jenis pengajuan berhasil ditambahkan!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                }).then((result) => {
                    window.location.href = 'jenis_pengajuan.php';
                });
            </script>
        ";
    }
}

// Proses Hapus
if (isset($_GET['hapus'])) {
    $hapus = $_GET['hapus'];

    $res = mysqli_query($conn, "SELECT id_instansi, jenis2_pengajuan FROM tb_instansi");
    while ($r = mysqli_fetch_assoc($res)) {
        $d = json_decode($r['jenis2_pengajuan'], true);
        if (!is_array($d)) {
            $d = [];
        }
        $d = array_filter($d, fn($item) => $item !== $hapus);
        $json = json_encode(array_values($d));
        mysqli_query($conn, "UPDATE tb_instansi SET jenis2_pengajuan='$json' WHERE id_instansi=" . $r['id_instansi']);
    }
    echo "
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Jenis pengajuan berhasil dihapus!',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                window.location.href = 'jenis_pengajuan.php';
            });
        </script>
    ";
}

// Proses Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $lama = $_POST['lama'];
    $baru = ucfirst(strtolower(trim($_POST['baru'])));

    $cek = mysqli_query($conn, "SELECT jenis2_pengajuan FROM tb_instansi LIMIT 1");
    $data = json_decode(mysqli_fetch_assoc($cek)['jenis2_pengajuan'], true);

    if (!is_array($data)) {
        $data = [];
    }

    if (in_array($baru, $data)) {
        echo "
            <script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Jenis pengajuan baru sudah ada!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        ";
    } else {
        $res = mysqli_query($conn, "SELECT id_instansi, jenis2_pengajuan FROM tb_instansi");
        while ($r = mysqli_fetch_assoc($res)) {
            $d = json_decode($r['jenis2_pengajuan'], true);
            if (!is_array($d)) {
                $d = [];
            }
            foreach ($d as $i => $v) {
                if ($v == $lama) {
                    $d[$i] = $baru;
                }
            }
            $json = json_encode($d);
            mysqli_query($conn, "UPDATE tb_instansi SET jenis2_pengajuan='$json' WHERE id_instansi=" . $r['id_instansi']);
        }
        echo "
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Jenis pengajuan berhasil diubah!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                }).then((result) => {
                    window.location.href = 'jenis_pengajuan.php';
                });
            </script>
        ";
    }
}

// Ambil data terbaru
$ambil = mysqli_query($conn, "SELECT jenis2_pengajuan FROM tb_instansi LIMIT 1");
$row = mysqli_fetch_assoc($ambil);
$jenis2_pengajuan = json_decode($row['jenis2_pengajuan'], true);

if (!is_array($jenis2_pengajuan)) {
    $jenis2_pengajuan = [];
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Jenis Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Jenis Pengajuan</li>
        </ol>
        <div class="dropdown-divider"></div>
        
        <div class="card mb-4 bungkus-2">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Jenis Pengajuan
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <i class="bi bi-plus-circle"></i> Tambah Jenis
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($jenis2_pengajuan)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data jenis pengajuan</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($jenis2_pengajuan as $i => $jp): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($jp) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                                                data-jenis="<?= htmlspecialchars($jp) ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-hapus" 
                                                data-jenis="<?= htmlspecialchars($jp) ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Jenis Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" onsubmit="return validateJenisPengajuan()">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Jenis Pengajuan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Jenis Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" name="lama" id="editLama">
                    <div class="mb-3">
                        <label for="editBaru" class="form-label">Nama Jenis Pengajuan</label>
                        <input type="text" class="form-control" id="editBaru" name="baru" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>

<script>
    function validateJenisPengajuan() {
        const nama = document.getElementById('nama').value.trim();
        
        if (nama === '') {
            Swal.fire({
                title: 'Error!',
                text: 'Nama jenis pengajuan tidak boleh kosong',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        return true;
    }

    // Script untuk mengisi data di modal edit
    document.addEventListener('DOMContentLoaded', function() {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var jenis = button.getAttribute('data-jenis');
            
            document.getElementById('editLama').value = jenis;
            document.getElementById('editBaru').value = jenis;
        });

        // SweetAlert untuk konfirmasi hapus
        document.querySelectorAll('.btn-hapus').forEach(button => {
            button.addEventListener('click', function() {
                const jenis = this.getAttribute('data-jenis');
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus jenis pengajuan "${jenis}"`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `jenis_pengajuan.php?hapus=${encodeURIComponent(jenis)}`;
                    }
                });
            });
        });
    });
</script>