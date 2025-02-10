<?php include 'header.php'; ?>

<div class="main-content mt-4">
    <h1 class="mb-4">Manajemen Sertifikat</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Kelola Sertifikat Magang</li>
    </ol>
    <div class=" mb-4 dropdown-divider"></div>
    <h1 class="text-center"><i class="bi bi-award"></i> Manajemen Sertifikat Magang</h1>
    <p class="text-center text-muted">Admin Instansi dapat memverifikasi dan menerbitkan sertifikat untuk peserta magang.</p>

    <div class="table-responsive-sm">
        <div class="bungkus-2">
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Peserta</th>
                        <th>Program Magang</th>
                        <th>Tanggal Magang</th>
                        <th>Status Sertifikat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ahmad Fauzi</td>
                        <td>Program IT</td>
                        <td>01 Jan 2025 - 30 Mar 2025</td>
                        <td><span class="badge bg-warning text-dark">Belum Diterbitkan</span></td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm">
                                <i class="bi bi-check-circle"></i> Terbitkan Sertifikat
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Siti Aminah</td>
                        <td>Program Desain</td>
                        <td>05 Feb 2025 - 05 Mei 2025</td>
                        <td><span class="badge bg-success">Sudah Diterbitkan</span></td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm">
                                <i class="bi bi-download"></i> Download Sertifikat
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>