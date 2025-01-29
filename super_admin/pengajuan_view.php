<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Pengajuan User</li>
        </ol>
    </div>
    <div class="container mt-5">                        
        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nama User</th>
                            <th>Nama Instansi</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Pengajuan</th>
                            <th>Calon Pelamar</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mishbahus Surur</td>
                            <td>Diskominfo Sidoarjo</td>
                            <td>Bidang Informatika</td>
                            <td>Magang</td>
                            <td>4</td>
                            <td>02-01-2025</td>
                            <td>02-05-2025</td>
                            <td>
                                <a href="instansi_hapus.html" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Akan Menghapus Data Ini'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <!-- Tambahkan data lain di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>