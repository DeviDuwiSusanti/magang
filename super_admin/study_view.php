<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Sekolah / Universitas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman View Sekolah Atau Universitas Pengguna</li>
        </ol>
    </div>
    <div class="container mt-5 mb-5">                        
        <!-- Tambah Data Button -->
        <div class="mb-3 text-end">
            <a href="study_tambah.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Tambah Data Sekolah / Universitas
            </a>
        </div>
        
        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nama Sekolah / Universitas</th>
                            <th>Fakultas</th>
                            <th>Jurusan / Prodi</th>
                            <th>Alamat</th>
                            <th colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Universitas Trunojoyo</td>
                            <td>Fakultas Teknik</td>
                            <td>Teknik Informatika</td>
                            <td>Jl. Raya Telang No 1 Kecamaan Kamal</td>
                            <td>
                                <a href="study_hapus.php" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Mau Menghapus Data Ini?'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                            <td>
                                <a href="study_edit.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>