<?php 

    if(isset($_POST["nama_sekolah_hidden"])) {
        $nama_sekolah = $_POST['nama_sekolah_hidden'];
        echo "Sekolah yang dipilih: " . htmlspecialchars($nama_sekolah);
    }
    
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih atau Input Sekolah</title>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS (Optional, untuk styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Pilih atau Tambahkan Sekolah</h2>
        <label for="nama_sekolah" class="form-label">Nama Sekolah</label>

    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#nama_sekolah").select2({
                placeholder: "Pilih atau Masukkan Sekolah",
                tags: true,  // Memungkinkan input manual
                allowClear: true  // Bisa menghapus input
            });

            // Simpan nilai ke input hidden saat pengguna memilih atau mengetik
            $("#nama_sekolah").on("change", function() {
                $("#nama_sekolah_hidden").val($(this).val());
            });
        });
    </script>

    <form action="" method="POST">
        <!-- Dropdown Select2 -->
        <select id="nama_sekolah" class="form-control" name="nama_sekolah">
            <option value="">Pilih Sekolah</option>
            <option value="SMA Negeri 1 Jakarta">SMA Negeri 1 Jakarta</option>
            <option value="SMA Negeri 2 Bandung">SMA Negeri 2 Bandung</option>
            <option value="SMA Negeri 3 Surabaya">SMA Negeri 3 Surabaya</option>
        </select>
        <input type="hidden" id="nama_sekolah_hidden" name="nama_sekolah_hidden">
        <button type="submit">Simpan</button>
    </form>



</body>
</html>
