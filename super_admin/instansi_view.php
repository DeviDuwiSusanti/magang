<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman View Instansi</li>
        </ol>
    </div>
    <div class="container mt-5 mb-5">                        
        <!-- Tambah Data Button -->
        <div class="mb-3 text-end">
            <a href="instansi_tambah.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Tambah Data Instansi
            </a>
        </div>
        
        <!-- Table -->
        <div class="card ">
            <div class="card-body">
                <table id="table_instansi" class="table table-bordered table-hover text-center align-middle">
                    <thead >
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Deskripsi</th>
                            <th>Telepon</th>
                            <th>Gambar</th>
                            <th colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Diskominfo</td>
                            <td>Jl.Sidoarjo</td>
                            <td>Dinas ini berdiri sejak tahun sekian</td>
                            <td>0891234432</td>
                            <td>
                                <img src="../assets/img/login.jpeg" alt="Gambar Instansi" class="img-thumbnail" style="width: 100px;">
                            </td>
                            <td>
                                <a href="instansi_hapus.php" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Mau Menghapus Data Ini?'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                            <td>
                                <a href="instansi_edit.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
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

<script>
    $(document).ready(function() {
        $('#table_instansi').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [{"orderable" : false, "targets" : [1, 2, 3, 4, 5, 6, 7]}],
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
                    title : 'Laporan Data Instansi',
                    exportOptions : {
                        columns : [0, 1, 2, 3, 4]
                    }
                }
            ]
        })
    })

</script>
