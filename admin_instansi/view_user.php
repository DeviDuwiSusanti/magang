<?php
include "../layout/header.php";

$id_instansi = $_SESSION['id_instansi'];
$no = 1;

// Query untuk data utama pengajuan
$sql = "SELECT
            pu.nama_user,
            b.nama_bidang,
            p.jenis_pengajuan,
            p.jumlah_pelamar,
            p.tanggal_mulai,
            p.tanggal_selesai,
            p.id_pengajuan,
            p.id_user,
            p.status_pengajuan,
            p.status_active,
            pembimbing.nama_user AS nama_pembimbing
        FROM tb_pengajuan AS p
        INNER JOIN tb_profile_user AS pu ON p.id_user = pu.id_user
        INNER JOIN tb_bidang AS b ON p.id_bidang = b.id_bidang
        LEFT JOIN tb_profile_user AS pembimbing 
            ON p.id_bidang = pembimbing.id_bidang
        WHERE p.id_instansi = '$id_instansi'
            AND p.status_active = '1'
            AND p.status_pengajuan IN ('2', '3', '4')
        ORDER BY p.id_pengajuan DESC";

$result = mysqli_query($conn, $sql);

// Query untuk mendapatkan daftar nama pengaju
$sql2 = "SELECT 
            p.id_pengajuan, 
            GROUP_CONCAT(pu.nama_user SEPARATOR ', ') AS daftar_nama
         FROM tb_pengajuan AS p
         JOIN tb_profile_user AS pu ON p.id_pengajuan = pu.id_pengajuan
         WHERE p.id_instansi = '$id_instansi'
         GROUP BY p.id_pengajuan
         ORDER BY p.id_pengajuan DESC";

$nama_pengaju = [];
$result2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_assoc($result2)) {
    $nama_pengaju[$row2['id_pengajuan']] = $row2['daftar_nama'];
}

$json_nama_pengaju = json_encode($nama_pengaju);
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Pemagang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Data Pemagang</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Kegiatan</th>
                            <th>Jumlah Pemagang</th>
                            <th>Periode</th>
                            <th>Durasi</th>
                            <th>Pembimbing</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row["nama_user"] ?></td>
                                <td><?= $row["nama_bidang"] ?></td>
                                <td><?= $row["jenis_pengajuan"] ?></td>
                                <td>
                                    <a href="#" class="show-detail" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail"
                                        data-detail='<?= isset($nama_pengaju[$row['id_pengajuan']]) ? json_encode(explode(', ', $nama_pengaju[$row['id_pengajuan']])) : '[]' ?>'>
                                        <?= isset($nama_pengaju[$row['id_pengajuan']]) ? count(explode(', ', $nama_pengaju[$row['id_pengajuan']])) : 0 ?>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        echo date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai']));
                                    } else {
                                        echo "Periode Tidak Diketahui";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        $start_date = new DateTime($row['tanggal_mulai']);
                                        $end_date = new DateTime($row['tanggal_selesai']);
                                        $interval = $start_date->diff($end_date);

                                        $years = $interval->y;
                                        $months = $interval->m;
                                        $days = $interval->d;

                                        $hasil = "";

                                        if ($years > 0) {
                                            $hasil .= "$years Tahun ";
                                        }
                                        if ($months > 0) {
                                            $hasil .= "$months Bulan ";
                                        }
                                        if ($days > 0) {
                                            $hasil .= "$days Hari";
                                        }

                                        echo trim($hasil); // Hapus spasi berlebih di akhir
                                    } else {
                                        echo "Durasi Tidak Diketahui";
                                    }
                                    ?>
                                </td>
                                <td><?= $row["nama_pembimbing"] ?: "Pembimbing Belum Ditentukan" ?></td>
                                <td>
                                    <span id="status-badge-<?php echo $row['id_pengajuan']; ?>" class="badge"></span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    function updateStatus(id_pengajuan) {

        // Setelah update status di database, baru ambil status terbaru dari get_status.php
        $.ajax({
            url: 'get_status.php',
            type: 'GET',
            data: {
                id_pengajuan: id_pengajuan
            },
            success: function(response) {
                let data = JSON.parse(response);
                let statusBadge = $("#status-badge-" + id_pengajuan);

                if (data.status == 5) {
                    statusBadge.html("Selesai").attr("class", "badge bg-danger");
                } else if (data.status == 4) {
                    statusBadge.html("Berlangsung").attr("class", "badge bg-primary");
                } else if (data.status == 3) {
                    statusBadge.html("Ditolak").attr("class", "badge bg-danger");
                } else if (data.status == 2) {
                    statusBadge.html("Diterima").attr("class", "badge bg-success");
                } else if (data.status == 6) {
                    statusBadge.html("Menunggu Konfirmasi").attr("class", "badge bg-warning");
                } else {
                    statusBadge.html("Diajukan").attr("class", "badge bg-secondary");
                }
            }
        });
    }

    // Fungsi untuk memperbarui status setiap kali halaman dimuat
    $(document).ready(function() {
        $("span[id^='status-badge-']").each(function() {
            let id_pengajuan = $(this).attr("id").replace("status-badge-", "");
            updateStatus(id_pengajuan);
        });
    });
</script>