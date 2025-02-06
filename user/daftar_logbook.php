<?php include "../layout/sidebarUser.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Logbook</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Logbook yang telah diunggah</li>
        </ol>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Keterangan</th>
                    <th>Nama File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2025-02-03</td>
                    <td>Meeting dengan tim</td>
                    <td>Diskusi proyek magang</td>
                    <td>Logbook_1.pdf</td>
                    <td><a href="../assets/doc/logbook_1.pdf" class="btn btn-primary btn-sm" target="_blank">Lihat</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2025-02-02</td>
                    <td>Pengerjaan tugas</td>
                    <td>Mengerjakan laporan harian</td>
                    <td>Logbook_2.pdf</td>
                    <td><a href="../assets/doc/logbook_2.pdf" class="btn btn-primary btn-sm" target="_blank">Lihat</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>2025-02-01</td>
                    <td>Presentasi hasil</td>
                    <td>Mempresentasikan laporan</td>
                    <td>Logbook_3.docx</td>
                    <td><a href="../assets/doc/logbook_3.docx" class="btn btn-primary btn-sm" target="_blank">Lihat</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>