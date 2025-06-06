<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 
include "functions.php"; 

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];
$id_pengajuan = $_SESSION['id_pengajuan'] ?? null; // Bisa null jika belum dipilih

if (!isset($_SESSION['ketua']) || $_SESSION['ketua'] !== true) {
    echo "<script>
            alert('Maaf Anda tidak ada hak akses di halaman ini');
            window.location.href='dashboard.php?id_user=" . $_SESSION['id_user'] . "';
          </script>";
    exit;
}


// Query untuk mengambil daftar pengajuan
$sql = "SELECT * 
        FROM tb_pengajuan
        LEFT JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        LEFT JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.id_user = '$id_user'   AND tb_pengajuan.status_Active = 1";
$query = mysqli_query($conn, $sql);

// Cek apakah tombol "Tambah Pengajuan" perlu disembunyikan
$sembunyikan_tombol = false;
while ($row_check = mysqli_fetch_assoc($query)) {
    if (in_array($row_check['status_pengajuan'], [1, 2, 4])) {
        $sembunyikan_tombol = true;
        break;
    }
}

// hapus pengajuan
if (isset($_POST['hapus_pengajuan'])) {
    hapusPengajuan($_POST, $id_user, $id_pengajuan);
}

// Reset query
$query = mysqli_query($conn, $sql);
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Tabel Histori Pengajuan</h1>
        <div class="mb-4 dropdown-divider"></div>

        <?php if (!$sembunyikan_tombol): ?>
            <div class="d-flex justify-content-end mb-4">
                <a href="?pengajuanBaru=<?= '1' ?>" class="btn btn-primary">Tambah Pengajuan</a>
            </div>
        <?php endif; ?>

        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Perusahaan</th>
                        <th class="text-center">Bidang</th>
                        <th class="text-center">Jenis Pengajuan</th>
                        <th class="text-center">Status Lamaran</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($query) > 0): 
                        while($row = mysqli_fetch_assoc($query)): 
                    ?> 
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= isset($row['nama_panjang']) ? $row['nama_panjang'] : 'Data tidak tersedia'; ?></td> 
                        <td><?= isset($row['nama_bidang']) ? $row['nama_bidang'] : 'Data tidak tersedia'; ?></td> 
                        <td><?= isset($row['jenis_pengajuan']) ? $row['jenis_pengajuan'] : 'Data tidak tersedia'; ?></td> 
                        <td><?= getStatusText($row['status_pengajuan']) ?></td>
                        <td class="text-center">
                            <?php 
                                if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                    $start_date = new DateTime($row['tanggal_mulai']);
                                    $end_date = new DateTime($row['tanggal_selesai']);
                                    $interval = $start_date->diff($end_date);

                                    $bulan = $interval->m;
                                    $hari = $interval->d;
                                    $minggu = floor($hari / 7);

                                    echo $bulan . " Bulan " . $minggu . " Minggu";
                                } else {
                                    echo "Durasi Tidak Diketahui";
                                } 
                            ?>
                        </td>
                        <td class="text-center">
                            <!-- Tombol Detail -->
                            <a href="#" class="btn btn-sm btn-primary" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row['id_pengajuan']; ?>">
                                <i class="bi bi-eye"></i>
                            </a>

                            <?php
                            $status_pengajuan = $row['status_pengajuan'];

                            if ($status_pengajuan == 2 || $status_pengajuan == 4): ?>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#daftarDokumenModal" title="Unggah Dokumen">
                                <i class="bi bi-upload"></i></button>
                            <?php endif; ?>
                            
                            
                            <?php if ($status_pengajuan != 3 && $status_pengajuan != 5): ?>
                                <a href="?id_pengajuan=<?= $row['id_pengajuan'] ?>" class="btn btn-sm btn-info text-white" title="Lihat Anggota">
                                    <i class="bi bi-people"></i>
                                </a>
                                <?php endif; ?>

                            <?php if ($status_pengajuan < 2 || $status_pengajuan > 5): ?>
                                <a href="?id_pengajuanEdit=<?= $row['id_pengajuan'] ?>" class="btn btn-sm btn-warning text-white" title="Edit Pengajuan">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <form action="" method="POST" id="FormHapus">
                                    <input type="hidden" name="alasan_hapus" id="alasanHapus">
                                    <input type="hidden" name="hapus_pengajuan"> 
                                    <button type="submit" class="btn btn-sm btn-danger text-white" id="hapusPengajuan" ><i class="bi bi-trash me-1"></i></button> 
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <!-- Modal Detail -->
                    <?php
                    // Query untuk mengambil detail pengajuan berdasarkan id_pengajuan
                    $sql_detail = "SELECT *
                        FROM tb_pengajuan
                        JOIN tb_profile_user ON tb_profile_user.id_user = '$id_user' 
                        JOIN tb_user ON tb_profile_user.id_user = tb_user.id_user
                        JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
                        JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
                        WHERE tb_pengajuan.id_pengajuan = '{$row['id_pengajuan']}'";
                    $query_detail = mysqli_query($conn, $sql_detail);
                    $detail = mysqli_fetch_assoc($query_detail);
                    ?>
                    <div class="modal fade" id="modalDetail<?= $row['id_pengajuan']; ?>" tabindex="-1" aria-labelledby="modalDetailLabel<?= $row['id_pengajuan']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalDetailLabel<?= $row['id_pengajuan']; ?>">Detail Pengajuan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <img src="../assets/img/logo_kab_sidoarjo.png" 
                                    class="mb-3" 
                                    alt="Sidoarjo" 
                                    style="width: 100px; height: 100px;">
                                    <h4 class="card-title"><?= isset($detail['nama_panjang']) ? $detail['nama_panjang'] : 'Tidak Diketahui' ?></h4>
                                    <hr>
                                    <p><strong>Instansi : </strong> <?= $detail['nama_panjang']; ?></p>
                                    <p><strong>Bidang : </strong> <?= $detail['nama_bidang']; ?></p>
                                    <p><strong>Jenis Pengajuan : </strong> <?= $detail['jenis_pengajuan']; ?></p>
                                    <p><strong>Status Lamaran : </strong> <?= getStatusText($detail['status_pengajuan']); ?></p>
                                    <p><strong>Durasi : </strong><?= isset($interval) ? $interval->m . " Bulan " . floor($interval->d / 7) . " Minggu" : "Durasi Tidak Diketahui"; ?></p>                                    <p><strong>Periode Magang:</strong> <?= formatPeriode($detail['tanggal_mulai'], $detail['tanggal_selesai']) ?> </p>

                                 <!-- Tombol Aksi dalam Modal -->
                                    <div class="modal-footer flex-column align-items-start">
                                            <div class="d-flex justify-content-end w-100 mt-2">
                                                <button type="button" class="btn btn-danger btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada status pengajuan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
include "user3_persyaratan_daftar.php";
include "user3_anggota.php";
include "user3_pengajuan.php";
include "../layout/footerDashboard.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('hapusPengajuan').addEventListener('click', function(event) {
    event.preventDefault();

    Swal.fire({
        title: 'Alasan Penghapusan',
        html: `
            <div style="margin-bottom: 10px;">Silakan berikan alasan penghapusan pengajuan</div>
            <textarea id="alasanTextarea" class="swal2-textarea" 
                    placeholder="Masukkan alasan Anda di sini..." 
                    aria-label="Masukkan alasan penghapusan"
                    maxlength="200" 
                    style="min-height: 100px; width: 100%; padding: 10px;"></textarea>
            <div style="text-align: right; margin-top: 5px; color: #666; font-size: 0.8em;">
                <span id="charCounter">0</span>/200
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal',
        width: '600px',  // Lebar modal lebih besar
        padding: '2em',
        focusConfirm: false,
        preConfirm: () => {
            return document.getElementById('alasanTextarea').value;
        },
        didOpen: () => {
            const textarea = document.getElementById('alasanTextarea');
            const counter = document.getElementById('charCounter');
            
            textarea.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        },
        inputValidator: (value) => {
            if (!value) {
                return 'Anda harus memberikan alasan!';
            }
            if (value.length > 200) {
                return 'Alasan maksimal 200 karakter!';
            }
        }
    }).then((firstResult) => {
        if (firstResult.isConfirmed) {
            const alasan = firstResult.value;
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Anda akan menghapus pengajuan ini dengan alasan:<br><br>
                      <strong>${alasan}</strong><br><br>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((secondResult) => {
                if (secondResult.isConfirmed) {
                    document.getElementById('alasanHapus').value = alasan;
                    document.querySelector('input[name="hapus_pengajuan"]').value = '1';
                    document.getElementById('FormHapus').submit();
                }
            });
        }
    });
});
</script>