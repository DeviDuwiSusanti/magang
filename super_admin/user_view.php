<?php 
    include "sidebar.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">User</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"> Halaman View user</li>
        </ol>
    </div>
    <div class="container mt-5 mb-5">                        
        <!-- Tambah Data Button -->
        <div class="mb-3 text-end">
            <a href="user_tambah.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Tambah Admin Instansi
            </a>
        </div>
        
        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_user"  class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Gender</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Gambar</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mishbahus Surur</td>
                            <td>Laki Laki</td>
                            <td>Bangkalan, 30-05-2004</td>
                            <td>0891234432</td>
                            <td>Jl.sakera sepulu</td>
                            <td>
                                <img src="img/login.jpeg" alt="Gambar user" class="img-thumbnail" style="width: 100px;">
                            </td>
                            <td>1. Super Admin</td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="user_hapus.php" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Akan Menghapus Data Ini'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                                <a href="user_edit.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Devi Duwi Susanti</td>
                            <td>Perempuan</td>
                            <td>Bangkalan, 30-05-2004</td>
                            <td>0891234432</td>
                            <td>Jl.sakera sepulu</td>
                            <td>
                                <img src="img/login.jpeg" alt="Gambar user" class="img-thumbnail" style="width: 100px;">
                            </td>
                            <td>3. User Biasa</td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="user_hapus.php" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Akan Menghapus Data Ini'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                                <a href="user_edit.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Hendra Hartono</td>
                            <td>Laki Laki</td>
                            <td>Bangkalan, 30-05-2004</td>
                            <td>0891234432</td>
                            <td>Jl.sakera sepulu</td>
                            <td>
                                <img src="img/login.jpeg" alt="Gambar user" class="img-thumbnail" style="width: 100px;">
                            </td>
                            <td>2. Admin Instansi Diskominfo sidoarjo</td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="user_hapus.php" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Akan Menghapus Data Ini'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                                <a href="user_edit.php" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Revika Syariqatun Alifia</td>
                            <td>Perempuan</td>
                            <td>dangkalan, 9-05-2004</td>
                            <td>0891234432</td>
                            <td>Jl.sakera sepulu</td>
                            <td>
                                <img src="img/login.jpeg" alt="Gambar user" class="img-thumbnail" style="width: 100px;">
                            </td>
                            <td>3. User Biasa</td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="user_hapus.php" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Akan Menghapus Data Ini'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                                <a href="user_edit.php" class="btn btn-warning btn-sm">
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
        $('#table_user').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [{"orderable" : false, "targets" : [2, 3, 4, 5, 6, 7, 8]}],
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
                    title : 'Laporan Data User',
                    exportOptions : {
                        columns : [0, 1, 2, 3, 4, 5, 7]
                    }
                }
            ]
        })
    })

</script>