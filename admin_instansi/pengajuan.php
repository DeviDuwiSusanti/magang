<?php include "header.php"; ?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Daftar Pengajuan User</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Pengajuan</th>
                            <th>Calon Pelamar</th>
                            <th>Dokumen</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mishbahus Surur</td>
                            <td>Teknologi Informasi</td>
                            <td>Magang</td>
                            <td>
                                <a href="#" class="show-detail" title="Lihat Detail" data-detail='["Mishbahus Surur", "Revika Syariqatun Alifia", "Devi Dwi Susanti", "Hendra Hartono"]'>4</a>
                            </td>
                            <td>
                                <!-- Data dokumen diubah menjadi array of object dengan nama dan URL -->
                                <a href="#" class="show-doc" title="Lihat Dokumen"
                                    data-doc='[
                                     {"name": "KTP", "url": "dokumen/ktp.pdf"},
                                     {"name": "Kartu Keluarga", "url": "dokumen/kk.pdf"},
                                     {"name": "Ijazah", "url": "dokumen/ijazah.pdf"}
                                   ]'>
                                    Lihat Dokumen
                                </a>
                            </td>
                            <td>02-01-2025</td>
                            <td>02-05-2025</td>
                            <td>
                                <a href="terima.php" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle"></i> Terima
                                </a>
                                <a href="hapus_bidang.php" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Syaiful Hidayat</td>
                            <td>Teknologi Informasi</td>
                            <td>Magang</td>
                            <td>
                                <a href="#" class="show-detail" title="Lihat Detail" data-detail='["Syaiful Hidayat", "Siti Aisyah", "Andi Zainuri"]'>3</a>
                            </td>
                            <td>
                                <a href="#" class="show-doc" title="Lihat Dokumen"
                                    data-doc='[
                                     {"name": "KTP", "url": "dokumen/ktp.pdf"},
                                     {"name": "Ijazah", "url": "dokumen/ijazah.pdf"}
                                   ]'>
                                    Lihat Dokumen
                                </a>
                            </td>
                            <td>02-01-2025</td>
                            <td>02-05-2025</td>
                            <td>
                                <a href="terima.php" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle"></i> Terima
                                </a>
                                <a href="hapus_bidang.php" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan dokumen (opsional jika ingin menggunakan modal) -->
<div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dokumenModalLabel">Dokumen yang dilengkapi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <ul id="dokumenList"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>