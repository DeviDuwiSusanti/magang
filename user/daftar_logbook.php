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
                    <th>Nama File</th>
                    <th>Tanggal Unggah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Logbook_1.pdf</td>
                    <td>2025-02-03</td>
                    <td><a href="../assets/doc/logbook_1.pdf" class="btn btn-primary btn-sm" target="_blank">Lihat</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Logbook_2.pdf</td>
                    <td>2025-02-02</td>
                    <td><a href="../assets/doc/logbook_2.pdf" class="btn btn-primary btn-sm" target="_blank">Lihat</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Logbook_3.pdf</td>
                    <td>2025-02-01</td>
                    <td><a href="../assets/doc/logbook_3.docx" class="btn btn-primary btn-sm" target="_blank">Lihat</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
