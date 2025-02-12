<?php include '../layout/header.php'; ?>

<div class="main-content p-4">
    <h1 class="mb-4">Manajemen Nilai Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Kelola Nilai Akhir</li>
    </ol>
    <div class="mb-4 dropdown-divider"></div>
    <h1 class="text-center"><i class="bi bi-clipboard-check"></i> Upload Nilai Akhir</h1>
    <p class="text-center text-muted">Admin Instansi dapat mengunggah file yang berisi nilai akhir untuk peserta magang.</p>

    <div class="table-responsive-sm">
        <div class="bungkus-2">
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Jenis Kegiatan</th>
                        <th>Bidang</th>
                        <th>Tanggal Magang</th>
                        <th>File Nilai Akhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ahmad Fauzi</td>
                        <td>Magang</td>
                        <td>Informatika</td>
                        <td>01 Jan 2025 - 30 Mar 2025</td>
                        <td>
                            <form method="POST" action="#" enctype="multipart/form-data">
                                <!-- Kirim id peserta sebagai hidden field -->
                                <input type="hidden" name="peserta_id" value="1">
                                <input type="file" name="grade_file" accept="application/pdf,image/*,application/msword" required>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-upload"></i> Upload
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus file?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Siti Aminah</td>
                        <td>PKL</td>
                        <td>Desain Grafis</td>
                        <td>05 Feb 2025 - 05 Mei 2025</td>
                        <td>
                            <form method="POST" action="#" enctype="multipart/form-data">
                                <input type="hidden" name="peserta_id" value="2">
                                <input type="file" name="grade_file" accept="application/pdf,image/*,application/msword" required>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-upload"></i> Upload
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus file?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>