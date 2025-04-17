<?php
// Query untuk anggota
$sql_anggota = "SELECT * FROM tb_profile_user pu, tb_user u 
              WHERE pu.id_pengajuan = '$id_pengajuan' 
              AND pu.id_user = u.id_user 
              AND u.status_active = '1'";
$query_anggota = mysqli_query($conn, $sql_anggota);
?>

<!-- Modal Daftar Anggota -->
<div class="modal fade" id="daftarAnggotaModal<?= $id_pengajuan ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Anggota <?= $detail['jenis_pengajuan'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Nim/Nisn</th>
                                <?php if ($detail['status_pengajuan'] == '1'): ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_anggota = 1;
                            while ($anggota = mysqli_fetch_assoc($query_anggota)):
                            ?>
                            <tr>
                                <td><?= $no_anggota++ ?></td>
                                <td><?= htmlspecialchars($anggota['nama_user']) ?></td>
                                <td><?= htmlspecialchars($anggota['email']) ?></td>
                                <td><?= htmlspecialchars($anggota['nik']) ?></td>
                                <td><?= !empty($anggota['nim']) ? htmlspecialchars($anggota['nim']) : htmlspecialchars($anggota['nisn']) ?></td>
                                <?php if ($detail['status_pengajuan'] == '1'): ?>
                                    <td>
                                        <!-- ... tombol aksi ... -->
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>