<?php include "../layout/sidebarUser.php"; 

// akses data profil pengguna sebelum update
if (ISSET($_GET['id_user'])){
    $id_user = $_GET['id_user'];
    $sql2 = "SELECT * FROM tb_profile_user, tb_user, tb_pendidikan WHERE tb_profile_user.id_user = '$id_user' AND tb_user.id_user  = '$id_user' AND tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan";
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);
}

// akses daftar studi
$sql3 = "SELECT * FROM tb_pendidikan";
$query3 = mysqli_query($conn, $sql3);
$daftar_studi = mysqli_fetch_all($query3, MYSQLI_ASSOC);

// query update profil
if (ISSET($_POST['update_profil'])){
    $email = $_POST['email'];
    $nama_user = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nik = $_POST['nik'];
    $telepone = $_POST['telepon'];
    $alamat_user = $_POST['alamat'];
    $asal_studi = $_POST['asal_studi'];
    
    // Pastikan update NIM atau NISN sesuai dengan yang ada di database
    if (!empty($row2['nim'])) {
        $nim_or_nisn = $_POST['nim'];
        $field_nim_nisn = "nim";
    } else {
        $nim_or_nisn = $_POST['nim'];
        $field_nim_nisn = "nisn";
    }

    // Update data pendidikan (ambil id_pendidikan dari nama_pendidikan)
    $query_pendidikan = "SELECT id_pendidikan FROM tb_pendidikan WHERE nama_pendidikan = '$asal_studi' LIMIT 1";
    $result_pendidikan = mysqli_query($conn, $query_pendidikan);
    $row_pendidikan = mysqli_fetch_assoc($result_pendidikan);
    $id_pendidikan = $row_pendidikan['id_pendidikan'] ?? $row2['id_pendidikan']; // Pakai data lama jika tidak ditemukan

    // Cek apakah ada file gambar yang diunggah
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . "_" . $_FILES['image']['name'];
        $target_dir = "../assets/img/user/";
        $target_file = $target_dir . basename($image_name);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $gambar_update = ", gambar = '$image_name'";
        } else {
            $gambar_update = "";
        }
    } else {
        $gambar_update = "";
    }

    // Query update email di tb_user
    $sql4 = "UPDATE tb_user SET email = '$email' WHERE id_user = '$id_user'";
    $query4 = mysqli_query($conn, $sql4);

    // Query update profil di tb_profile_user
    $sql5 = "UPDATE tb_profile_user SET 
        nama_user = '$nama_user',
        tempat_lahir = '$tempat_lahir',
        tanggal_lahir = '$tanggal_lahir',
        jenis_kelamin = '$jenis_kelamin',
        nik = '$nik',
        $field_nim_nisn = '$nim_or_nisn',
        id_pendidikan = '$id_pendidikan',
        telepone = '$telepone',
        alamat_user = '$alamat_user' 
        $gambar_update
        WHERE id_user = '$id_user'";
    
    $query5 = mysqli_query($conn, $sql5);

    if ($query4 && $query5) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='profil.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil!');</script>";
    }
}
?>


<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Profile</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Edit Profile Admin Instansi</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        <div class="mb-4 text-end">
            <a href="profil.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $row2['nama_user'] ?>" required>
            </div>
            
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $row2['email'] ?>" required>
            </div>
            
            <!-- Tempat Lahir -->
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $row2['tempat_lahir'] ?>" required>
            </div>
            
            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $row2['tanggal_lahir'] ?>" required>
            </div>
            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_l" value="L" <?= ($row2['jenis_kelamin'] == 'L') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_p" value="P" <?= ($row2['jenis_kelamin'] == 'P') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                    </div>
                </div>
            </div>
            
            <!-- NIK -->
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="<?= $row2['nik'] ?>" required>
            </div>
            
            <!-- NIM -->
            <div class="mb-3">
                <label for="nim" class="form-label"><?= !empty($row['nim']) ? 'NIM' : (!empty($row['nisn']) ? 'NISN' : 'NIM/NISN') ?></label>
                <input type="text" class="form-control" id="nim" name="nim" value="<?= !empty($row['nim']) ? $row['nim'] : $row['nisn'] ?>" required>
            </div>
            
            <!-- Asal Studi -->
            <div class="mb-3">
                <label for="asal_studi" class="form-label">Asal Studi</label>
                <input type="text" class="form-control" id="asal_studi" name="asal_studi" value="<?= $row2['nama_pendidikan'] ?>" list="sekolahList" required>
                <datalist id="sekolahList">
                    <?php foreach($daftar_studi as $studi) : ?>
                        <option value="<?= $studi['nama_pendidikan'] ?>"></option>
                    <?php endforeach; ?>
                </datalist>

            </div>

            
            <!-- Telepon -->
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="number" class="form-control" id="telepon" name="telepon" value="<?= $row2['telepone'] ?>" required>
            </div>
            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $row2['alamat_user'] ?></textarea>
            </div>
            
            <!-- Upload Foto Profil -->
            <div class="mb-3">
                <label for="image">Foto Profil</label><br><br>
                <div class="image-preview" id="imagePreview">
                    <img src="<?= !empty($row2['gambar']) ? '../assets/img/user/'.$row2['gambar'] : '../assets/img/user/avatar.png' ?>" 
                        id="previewImage" 
                        class="rounded-circle mb-3" 
                        style="width: 120px; height: 120px; object-fit: cover; object-position: top;">
                </div>
                <input type="file" class="input form-control" id="image" name="image" accept="image/*" onchange="previewFile()">
                <small class="text-muted">Kosong jika tidak ingin diganti</small>
            </div>
            
            <!-- Tombol Submit -->
            <button type="submit" name="update_profil" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>
<script>
  function previewFile() {
    const fileInput = document.getElementById('image');
    const previewImage = document.getElementById('previewImage');
    const file = fileInput.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImage.src = e.target.result;
      }
      reader.readAsDataURL(file);
    }
  }
</script>