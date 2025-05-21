<?php
include '../layout/sidebarUser.php';
include "update_status.php";
include "functions.php";

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
        p.status_pengajuan,
        p.status_active,
        pembimbing.nama_user AS nama_pembimbing
    FROM tb_pengajuan p
    INNER JOIN tb_profile_user pu ON pu.id_pengajuan = p.id_pengajuan
    INNER JOIN tb_bidang b ON p.id_bidang = b.id_bidang
    LEFT JOIN tb_profile_user AS pembimbing 
        ON pembimbing.id_user = p.id_pembimbing
    WHERE p.id_instansi = '$id_instansi'
        AND p.status_active = '1'
        AND b.status_active = '1'
        AND p.status_pengajuan IN ('4', '5')
    ORDER BY p.id_pengajuan DESC
";


$result = mysqli_query($conn, $sql);
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mt-3">Daftar Pemagang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Data Pemagang</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="datatable-header mb-2"></div> <!-- Tempat search dan show entries -->
            <div class="bungkus-2 datatable-scrollable">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Kegiatan</th>
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
                                    <?php
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        echo formatTanggalLengkapIndonesia($row['tanggal_mulai']) . ' - ' . formatTanggalLengkapIndonesia($row['tanggal_selesai']);
                                    } else {
                                        echo "Periode Tidak Diketahui";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        echo hitungDurasi($row['tanggal_mulai'], $row['tanggal_selesai']);
                                    } else {
                                        echo "Durasi Tidak Diketahui";
                                    }
                                    ?>
                                </td>
                                <td><?= $row["nama_pembimbing"] ?: "Pembimbing Belum Ditentukan" ?></td>
                                <td>
                                    <?php
                                    if ($row['status_pengajuan'] == 5) {
                                        echo '<span class="badge bg-danger">Selesai</span>';
                                    } elseif ($row['status_pengajuan'] == 4) {
                                        echo '<span class="badge bg-primary">Berlangsung</span>';
                                    } elseif ($row['status_pengajuan'] == 3) {
                                        echo '<span class="badge bg-danger">Ditolak</span>';
                                    } elseif ($row['status_pengajuan'] == 2) {
                                        echo '<span class="badge bg-success">Diterima</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary">Diajukan</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="datatable-footer mt-2"></div> <!-- Tempat info dan pagination -->
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>

<script>
    $(document).ready(function() {
        // Cek apakah sedang di mobile untuk scrollX
        var isMobile = window.innerWidth < 768;

        // Inisialisasi DataTable hanya sekali
        var table = $('#myTable').DataTable({
            scrollX: isMobile,
            responsive: true,
            dom: '<"datatable-header row mb-2"' +
                '<"col-md-6 text-md-start text-center"l>' +
                '<"col-md-6 text-md-end text-center d-flex justify-content-end align-items-center gap-2"f>' +
                '>t' +
                '<"datatable-footer row mt-2"' +
                '<"col-md-6 text-md-start text-center"i>' +
                '<"col-md-6 text-md-end text-center"p>' +
                '>',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                emptyTable: "Tidak ada data pemagang yang tersedia",
                zeroRecords: "Tidak ada data pemagang yang cocok",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            },
            columnDefs: [{
                targets: [3, 4, 5, 6, 7],
                orderable: false
            }]
        });
    });
</script>