<?php 
    include "sidebar.php";
    $instansi = query("SELECT * FROM tb_instansi WHERE status_active = 1");
    $no = 1;
?>


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
                        <th>Id Instansi</th>
                        <th>Nama Pendek</th>
                        <th>Nama Panjang</th>
                        <th>Group Instansi</th>
                        <th>Gambar Instansi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($instansi as $opd) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $opd["id_instansi"] ?></td>
                        <td><?= $opd["nama_pendek"] ?></td>
                        <td><?= $opd["nama_panjang"] ?></td>
                        <td><?= $opd["group_instansi"] ?></td>
                        <td><img src="../assets/img/instansi/<?= $opd["gambar_instansi"] ?>" alt="gambar_instansi"></td>

                        <td class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirm_hapus_instansi_super_admin(<?= $opd['id_instansi'] ?>)">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                            <a href="instansi_edit.php?id_instansi=<?= $opd["id_instansi"] ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

<script>
    $(document).ready(function() {
        $('#table_instansi').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [
                {
                    "orderable" : false,
                    "targets" : [ 1, 2, 3, 4],
                    render: function(data, type, row) {
                        if(type === 'display' && data.length > 50) {
                            return data.substr(0, 50) + '...';
                        } return data;
                    }
                }
            ],
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
        });
    });
</script>
