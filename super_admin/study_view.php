<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Sekolah / Perguruan Tinggi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Daftar Sekolah Atau Perguruan Tinggi Pengguna</li>
        </ol>
    </div>
    <div class="container mt-5 mb-5">                        
        <!-- Tambah Data Button -->
        <div class="mb-3 text-end">
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Data
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="study_tambah_sekolah.php" class="dropdown-item">Sekolah</a>
                    </li>
                    <li>
                        <a href="study_tambah_universitas.php" class="dropdown-item">Perguruan Tinggi</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mb-3 text-end">

        
        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_study" class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Sekolah / Universitas</th>
                            <th>Fakultas</th>
                            <th>Jurusan / Prodi</th>
                            <th>Alamat</th>
                            <th >Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Universitas Trunojoyo</td>
                            <td>Fakultas Teknik</td>
                            <td>Teknik Informatika</td>
                            <td>Jl. Raya Telang No 1 Kecamaan Kamal</td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="study_hapus.php" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Mau Menghapus Data Ini?'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
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

<script>
    $(document).ready(function() {
        $('#table_study').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [{"orderable" : false, "targets" : [2, 3, 4, 5]}],
            "language" : {
                "search" : "Cari : ",
                "lengthMenu" : "Tampilkan _MENU_  data Per Halaman",
                "info" : "Menampilkan _START_ hingga _END_ dari _TOTAL_ Data",
                "paginate" : {
                    "first" : "Awal ",
                    "last" : " Akhir",
                    "next" : "Selanjutnya ",
                    "previous" : " Sebelumnya",
                }
            }, 

            dom : 'Blfrtip',
            buttons : [
                {
                    extend : 'pdfHtml5',
                    text : '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className : 'btn btn-danger m-2',
                    title : 'Laporan Data Study User',
                    exportOptions : {
                        columns : [0, 1, 2, 3, 4]
                    }
                }
            ]
        })
    })

</script>