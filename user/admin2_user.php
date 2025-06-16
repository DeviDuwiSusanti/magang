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
        p.tanggal_extend,
        p.id_pengajuan,
        p.status_pengajuan,
        p.status_active,
        pembimbing.nama_user AS nama_pembimbing,
        pu.id_user
    FROM tb_pengajuan p
    INNER JOIN tb_profile_user pu ON pu.id_pengajuan = p.id_pengajuan
    INNER JOIN tb_bidang b ON p.id_bidang = b.id_bidang
    LEFT JOIN tb_profile_user AS pembimbing 
        ON pembimbing.id_user = p.id_pembimbing
    WHERE p.id_instansi = '$id_instansi'
        AND p.status_active = '1'
        AND b.status_active = '1'
        AND pu.status_active = '1'
        AND p.status_pengajuan IN ('4', '5')
        AND pu.status_active = '1'
    ORDER BY p.id_pengajuan ASC
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
            <div class="datatable-header mb-2"></div>
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
                            <th>Absensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) {
                            // Count total absensi for this user and pengajuan
                            $total_absensi = query("SELECT COUNT(*) as total FROM tb_absensi 
                                                   WHERE id_user = '" . $row['id_user'] . "' 
                                                   AND id_pengajuan = '" . $row['id_pengajuan'] . "'
                                                   AND status_active = '1'");
                            $absensi_count = $total_absensi[0]['total'];
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row["nama_user"] ?></td>
                                <td><?= $row["nama_bidang"] ?></td>
                                <td><?= $row["jenis_pengajuan"] ?></td>
                                <td>
                                    <?php
                                    // Tentukan tanggal akhir: gunakan tanggal_extend jika ada, selain itu tanggal_selesai
                                    $tanggal_akhir = !empty($row['tanggal_extend']) ? $row['tanggal_extend'] : $row['tanggal_selesai'];

                                    if (!empty($row['tanggal_mulai']) && $tanggal_akhir) {
                                        echo formatTanggalLengkapIndonesia($row['tanggal_mulai']) . ' - ' . formatTanggalLengkapIndonesia($tanggal_akhir);
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
                                    echo getStatusBadge(
                                        $row['status_pengajuan'],
                                        $row['tanggal_extend'] ?? null,
                                        $row['tanggal_selesai'] ?? null
                                    );
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm viewAbsensi"
                                        data-id_pengajuan="<?= $row['id_pengajuan'] ?>"
                                        data-id_user="<?= $row['id_user'] ?>"
                                        data-nama_user="<?= $row['nama_user'] ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#absensiModal">
                                        <i class="bi bi-calendar-check"></i> (<?= $absensi_count ?>)
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="datatable-footer mt-2"></div>
        </div>
    </div>
</div>

<!-- Modal untuk Absensi -->
<div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="absensiModalLabel">Daftar Absensi <span id="namaPeserta"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="absensiContent">
                <!-- Content akan diisi via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
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
                targets: [3, 4, 5, 6, 7, 8],
                orderable: false
            }]
        });

        // Absensi Modal
        $(document).on('click', '.viewAbsensi', function() {
            const idPengajuan = $(this).data('id_pengajuan');
            const idUser = $(this).data('id_user');
            const namaUser = $(this).data('nama_user');

            $('#namaPeserta').text(namaUser);

            $.ajax({
                url: 'pembimbing4_view_absensi.php',
                type: 'GET',
                data: {
                    id_pengajuan: idPengajuan,
                    id_user: idUser
                },
                beforeSend: function() {
                    $('#absensiContent').html('<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p>Memuat data absensi...</p></div>');
                },
                success: function(response) {
                    $('#absensiContent').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading absensi:", error);
                    $('#absensiContent').html('<div class="alert alert-danger">Gagal memuat data absensi</div>');
                }
            });
        });
    });
</script>