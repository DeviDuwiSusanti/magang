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
                <table id="table_pengajuan" class="table table-bordered table-hover text-center align-middle">
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

<script>
    $(document).ready(function() {
        $('#table_pengajuan').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [{"orderable" : false, "targets" : [2, 3, 4, 5, 8]}],
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
                    title : 'Laporan Data Pengajuan User',
                    exportOptions : {
                        columns : [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ]
        })
    })

</script>