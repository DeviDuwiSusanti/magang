
<?php
function generateIdDokumen($conn, $id_pengajuan) {
    $query = "SELECT MAX(CAST(SUBSTRING(id_dokumen, -2) AS UNSIGNED)) AS max_nomor 
               FROM tb_dokumen 
               WHERE id_dokumen LIKE '$id_pengajuan%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $nextNumber = $row['max_nomor'] ? $row['max_nomor'] + 1 : 1;

    $nomorUrut = str_pad($nextNumber, 2, "0", STR_PAD_LEFT);

    return $id_pengajuan . $nomorUrut;
}

function generateIdAnggota($conn, $id_user) {
    // Ambil dua digit terakhir dari id_user
    $lastTwoDigits = (int)substr($id_user, -2);

    // Basis id_user tanpa dua digit terakhir
    $baseId = substr($id_user, 0, -2);

    // Cari dua digit terakhir terbesar di database untuk id_user tertentu
    $query = "SELECT MAX(CAST(SUBSTRING(id_user, -2) AS UNSIGNED)) as maxCounter 
               FROM tb_user 
               WHERE id_user LIKE CONCAT(?, '__')";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $baseId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Jika ada anggota, tambah 1 dari angka terbesar; jika tidak, mulai dari 01
    $nextId = $row['maxCounter'] ? str_pad($row['maxCounter'] + 1, 2, "0", STR_PAD_LEFT) : "01";

    // Gabungkan baseId dengan dua digit terbaru
    $newId = $baseId . $nextId;

    return $newId;
}

function uploadFileUser($file, $id_pengajuan) {

    $target_dir = "../assets/doc/$id_pengajuan/";

    // Buat folder jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($file["name"]);

    // Pindahkan file ke folder tujuan
    move_uploaded_file($file["tmp_name"], $target_file);

    // Mengembalikan array dengan path dan nama file
    return [
        'path' => $target_file,
        'name' => basename($file["name"])
    ];
}

function uploadFoto($file, $target_dir) {
    $target_file = rtrim($target_dir, '/') . '/' . basename($file["name"]); // Pastikan path selalu benar
    
    // Pindahkan file ke folder tujuan
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return [
            'path' => $target_file,
            'name' => basename($file["name"])
        ];
    }
    return null; // Jika gagal upload
}

function deleteOldDocument($id_dokumen) {
    global $conn;
    // Ambil file lama dari database
    $query = "SELECT file_path FROM tb_dokumen 
               WHERE id_dokumen = '$id_dokumen'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $file_path = $row['file_path'];
    if (file_exists($file_path)) {
        unlink($file_path); // Hapus file fisik
    }
}

function hapusFolderPengajuan($id_pengajuan) {
    $folder = "../assets/doc/$id_pengajuan/";

    // Cek apakah folder ada
    if (is_dir($folder)) {
        // Hapus semua file di dalam folder
        $files = scandir($folder);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                $file_path = $folder . $file;
                if (is_file($file_path)) {
                    unlink($file_path);
                }
            }
        }

        // Hapus foldernya setelah kosong
        rmdir($folder);
        return true; // Sukses
    } else {
        return false; // Folder tidak ditemukan
    }
}

function cekEmail($email) {
    global $conn;
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM tb_user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    return mysqli_num_rows($result) > 0;
}

function getStatusText($status) {
    $statusList = [
        1 => "Diajukan",
        2 => "Diterima",
        3 => "Ditolak",
        4 => "Berlangsung",
        5 => "Selesai",
    ];
    return $statusList[$status] ?? "Tidak Diketahui";
}

function getKategoriText($kategori) {
    $kategoriList = [
        1 => "Identitas",
        2 => "Prasyarat",
        3 => "Laporan Akhir",
        4 => "Nilai & Sertifikat",
    ];
    return $kategoriList[$kategori] ?? "Tidak Diketahui";
}

function showAlert($title, $text, $icon, $redirect = null) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '$title',
                text: '$text',
                icon: '$icon',
                confirmButtonText: 'OK'
            }).then(() => {";
    if ($redirect) {
        echo "window.location.href = '$redirect';";
    }
    echo "    });
        });
    </script>";
}


function confirmDeleteScript() {
    echo "<script>
        function confirmDelete(url, dataName = 'data ini') {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data ' + dataName + ' akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>";
}

// Fungsi untuk menghitung durasi dalam bulan dan hari
function hitungDurasi($tanggal_mulai, $tanggal_selesai) {
    $start_date = new DateTime($tanggal_mulai);
    $end_date = new DateTime($tanggal_selesai);
    $interval = $start_date->diff($end_date);

    $bulan = $interval->m + ($interval->y * 12);
    $hari = $interval->d;

    return ($bulan > 0 ? "$bulan Bulan " : "") . ($hari > 0 ? "$hari Hari" : "");
}

// Fungsi untuk format tanggal Lengkap Indonesia
function formatTanggalLengkapIndonesia($tanggal) {
    $bulan = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    $tanggal_obj = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $tanggal_obj->format('j') . ' ' . $bulan[$tanggal_obj->format('m')] . ' ' . $tanggal_obj->format('Y');
}

// Fungsi untuk format tanggal ke format Indonesia tanpa tahun
function formatTanggalIndonesia($tanggal) {
    $bulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    $dateObj = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $dateObj ? $dateObj->format('d') . ' ' . $bulan[(int)$dateObj->format('m') - 1] : "Format Tidak Valid";
}

// Fungsi untuk format periode (contoh: "1 Januari - 10 Desember 2024" atau "1 Desember 2023 - 10 Januari 2024")
function formatPeriode($tanggal_mulai, $tanggal_selesai) {
    $start_date = DateTime::createFromFormat('Y-m-d', $tanggal_mulai);
    $end_date = DateTime::createFromFormat('Y-m-d', $tanggal_selesai);

    if ($start_date && $end_date) {
        if ($start_date->format('Y') === $end_date->format('Y')) {
            return formatTanggalIndonesia($tanggal_mulai) . ' - ' . formatTanggalIndonesia($tanggal_selesai) . ' ' . $start_date->format('Y');
        } else {
            return formatTanggalIndonesia($tanggal_mulai) . ' ' . $start_date->format('Y') . ' - ' . formatTanggalIndonesia($tanggal_selesai) . ' ' . $end_date->format('Y');
        }
    }
    return "Periode Tidak Diketahui";
}


function cekStatusUser($id_user) {
    // Ambil dua digit terakhir dari id_user
    $dua_digit_terakhir = substr($id_user, -2);

    // Jika dua digit terakhir adalah "00", berarti Ketua
    return $dua_digit_terakhir === '00' ? 'Ketua' : 'Anggota';
}


// ============== LOGBOOK ==================
function generateLogbookId($conn, $id_pengajuan) {
    // Ambil counter terbesar untuk id_pengajuan ini
    $sql_max = "SELECT MAX(CAST(SUBSTRING(id_logbook, -2) AS UNSIGNED)) as max_counter FROM tb_logbook WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $sql_max);
    $row = mysqli_fetch_assoc($result);
    $counter = str_pad($row['max_counter'] + 1, 2, '0', STR_PAD_LEFT); // Tambah 1 ke counter terbesar

    // Buat id_logbook dengan format 10 digit id_pengajuan + 2 digit counter
    $id_logbook = $id_pengajuan . $counter;

    return $id_logbook;
}

function getLogbook($conn, $id_pengajuan, $id_user) {
    // Query untuk mengambil logbook
    $sql = "SELECT * FROM tb_logbook WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user' AND status_active = '1'";
    $query = mysqli_query($conn, $sql);

    // Periksa apakah query berhasil
    if (!$query) {
        die("Query error: " . mysqli_error($conn));
    }
    // Mengembalikan hasil query
    return $query;
}

function inputLogbook($POST, $FILES, $id_pengajuan, $id_user) {
    global $conn;
    $tanggal = $POST['tanggal'];
    $kegiatan = $POST['kegiatan'];
    $keterangan = $POST['keterangan'];
    $jam_mulai = $POST['jam_mulai'];
    $jam_selesai = $POST['jam_selesai'];
    $ttd = $POST['ttd'];
    
    $uploadedFoto = uploadFoto($FILES['gambar_kegiatan'], '../assets/img/logbook/');
    $target_file = $uploadedFoto['path'];

    $id_logbook = generateLogbookId($conn, $id_pengajuan);

    // Query INSERT dengan id_logbook yang sudah dibuat
    $sql = "INSERT INTO tb_logbook (`id_logbook`, `tanggal_logbook`, `kegiatan_logbook`, `keterangan_logbook`, `jam_mulai`, `jam_selesai`, `foto_kegiatan`, `tanda_tangan`, `id_pengajuan`, `id_user`, `create_by`) 
            VALUES ('$id_logbook', '$tanggal', '$kegiatan', '$keterangan', '$jam_mulai', '$jam_selesai', '$target_file', '$ttd', '$id_pengajuan', '$id_user', '$id_user')";

    if (mysqli_query($conn, $sql)) {
        showAlert('Berhasil!', 'Logbook Berhasil Diinput', 'success', "logbook_daftar.php");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal diinput. Silakan coba lagi.', 'error');
    }       
}

function updateLogbook($POST, $FILES, $id_user, $id_logbook, $row){
    global $conn;
    // Inisialisasi foto_kegiatan (default: data lama)
    $foto_kegiatan = $row['foto_kegiatan'];

    // Jika ada file baru diunggah
    if (!empty($FILES['gambar_kegiatan']['name'])) {
        $uploadResult = uploadFoto($FILES['gambar_kegiatan'], "../assets/img/logbook/");
        if ($uploadResult) {
            $foto_kegiatan = $uploadResult['path'];
        }
    }

    $sql2 = "UPDATE tb_logbook SET 
    tanggal_logbook = '$POST[tanggal]',
    kegiatan_logbook = '$POST[kegiatan]',
    keterangan_logbook = '$POST[keterangan]',
    jam_mulai = '$POST[jam_mulai]',
    jam_selesai = '$POST[jam_selesai]',
    foto_kegiatan = '$foto_kegiatan',
    tanda_tangan = '$POST[ttd]',
    change_by = '$id_user' WHERE id_logbook = '$id_logbook'";

    if (mysqli_query($conn, $sql2)) {
        showAlert('Berhasil!', 'Logbook Berhasil Diupdate', 'success', "logbook_daftar.php");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal diupdate. Silakan coba lagi.', 'error');
    }    
}

function hapusLogbook($id_user){
    global $conn;
    $id_logbook = $_GET['id_logbook_hapus'];
    $sql2 =  "UPDATE tb_logbook SET status_active = '0', change_by = '$id_user' WHERE id_logbook = '$id_logbook'";
    $query2 = mysqli_query($conn, $sql2);
    if ($query2) {
        showAlert('Berhasil!', 'Logbook Berhasil Dihapus', 'success', "logbook_daftar.php");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal dihapus. Silakan coba lagi.', 'error');
    }    
}

// ============== PENGAJUAN ==============
function generateIdPengajuan($conn) {
    // Ambil tanggal saat ini dalam format YYYYMMDD
    $tanggal = date("Ymd");

    // Ambil jumlah pengajuan yang sudah ada untuk hari ini
    $query = "SELECT COUNT(*) AS total FROM tb_pengajuan WHERE id_pengajuan LIKE '$tanggal%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalPengajuanHariIni = $row['total'] + 1; // Urutan berikutnya

    // Format XX menjadi dua digit (01, 02, 03, ...)
    $nomorUrut = str_pad($totalPengajuanHariIni, 2, "0", STR_PAD_LEFT);

    // Gabungkan untuk mendapatkan id_pengajuan
    return $tanggal . $nomorUrut;
}

function inputPengajuan($POST, $FILES, $id_user){
    global $conn;

    $id_pengajuan = generateIdPengajuan($conn);
    $id_dokumen_ktp = generateIdDokumen($conn, $id_pengajuan);

    $id_instansi = $POST['id_instansi'];
    $id_bidang = $POST['id_bidang'];
    $jenis_pengajuan = $POST['jenis_pengajuan'];
    $jumlah_pelamar = $POST['jumlah_anggota'];
    if ($jumlah_pelamar == NULL){
        $jumlah_pelamar = 1;
    }
    $tanggal_mulai = $POST['tanggal_mulai']; // Contoh: 09/04/2025
    $tanggal_selesai = $POST['tanggal_selesai']; // Contoh: 10/04/2025

    // Konversi ke format YYYY-MM-DD
    $tanggal_mulai = DateTime::createFromFormat('d/m/Y', $tanggal_mulai)->format('Y-m-d');
    $tanggal_selesai = DateTime::createFromFormat('d/m/Y', $tanggal_selesai)->format('Y-m-d');

    // Menangani upload file KTP dan CV
    $ktp = uploadFileUser($FILES['ktp'], $id_pengajuan);
    $cv = uploadFileUser($FILES['cv'], $id_pengajuan);

    if (ISSET($POST['anggota_nama'])){
        // Mengambil data anggota dari form Step 2
        $anggota_nama = $POST['anggota_nama'];
        $anggota_email = $POST['anggota_email'];
        $anggota_nik = $POST['anggota_nik'];
        $anggota_nim = $POST['anggota_nim'];

        foreach ($anggota_nama as $index => $nama) {
            $email = $anggota_email[$index];
            $nik = $anggota_nik[$index];
            $nim = $anggota_nim[$index];
            $id_user4 = generateIdAnggota($conn, $id_user);

            $pendidikan = "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'";
            $result = mysqli_query($conn, $pendidikan);
            $id_pendidikan = mysqli_fetch_assoc($result)['id_pendidikan'];
        
            $sql_anggota1 = "INSERT INTO tb_profile_user (id_user, nama_user, nik, nisn, nim, id_pengajuan, id_pendidikan, create_by) VALUES ('$id_user4', '$nama', '$nik', '$nim', '$nim', '$id_pengajuan', '$id_pendidikan', '$id_user')";
            $query_anggota1 = mysqli_query($conn, $sql_anggota1);
            
            $sql_anggota2 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user4', '$email', '3', '$id_user')";
            $query_anggota2 = mysqli_query($conn, $sql_anggota2);
        }
    }

    $sql2 = "INSERT INTO tb_pengajuan VALUES ('$id_pengajuan', '$id_user', '$id_instansi', '$id_bidang', '$jenis_pengajuan', '$jumlah_pelamar', '$tanggal_mulai', '$tanggal_selesai', '1', '1', '$id_user', NOW(), '', '')";
    $query2 = mysqli_query($conn, $sql2);

    $sql3 = "INSERT INTO tb_dokumen VALUES ('$id_dokumen_ktp', 'ktp', '1', '$ktp[path]', '$id_pengajuan', '$id_user', '1', '$id_user', NOW(), '', '')";
    $query3 = mysqli_query($conn, $sql3);


    if ($query2 && $query3){
        $id_dokumen_cv = generateIdDokumen($conn, $id_pengajuan);
        $sql4 = "INSERT INTO tb_dokumen VALUES ('$id_dokumen_cv', 'cv', '1', '$cv[path]', '$id_pengajuan', '$id_user', '1', '$id_user', NOW(), '', '')";
        $query4 = mysqli_query($conn, $sql4);
        if ($query4){
            $sql5 = "UPDATE tb_profile_user SET id_pengajuan = '$id_pengajuan' WHERE id_user = '$id_user'";
            $query5 = mysqli_query($conn, $sql5);
        }
    }
    if ($query5) {?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php
        showAlert('Berhasil!', 'Yeayy, Pendaftaran Kamu Berhasil', 'success', "status_pengajuan.php");
        exit();
    } else {
        showAlert('Gagal!', 'Yahh pendaftaran kamu gagal. Silakan coba lagi.', 'error');
    }    
}

function updatePengajuan($POST, $FILES, $id_user){
    global $conn;
    $id_user = $POST['id_user'];
    $id_pengajuan = $POST['id_pengajuan'];
    $id_user = $POST['id_user'];
    $id_instansi = $POST['id_instansi'];
    $id_bidang = $POST['id_bidang'];
    $jenis_pengajuan = $POST['jenis_pengajuan'];
    $tanggal_mulai = $POST['tanggal_mulai'];
    $tanggal_selesai = $POST['tanggal_selesai'];

    // Konversi ke format YYYY-MM-DD
    $tanggal_mulai = DateTime::createFromFormat('d/m/Y', $tanggal_mulai)->format('Y-m-d');
    $tanggal_selesai = DateTime::createFromFormat('d/m/Y', $tanggal_selesai)->format('Y-m-d');

    // UPDATE PENGAJUAN
    $sql_update1 = "UPDATE tb_pengajuan SET 
    id_instansi = '$id_instansi',
    id_bidang = '$id_bidang',
    jenis_pengajuan = '$jenis_pengajuan',
    tanggal_mulai = '$tanggal_mulai',
    tanggal_selesai = '$tanggal_selesai',
    change_by = '$id_user'
    WHERE id_pengajuan = '$id_pengajuan'";
    $query_update1 = mysqli_query($conn, $sql_update1);


    // akses id_dokumen ktp dan cv
    function getDokumenIdentitas($nama_dokumen, $id_pengajuan){
        global $conn;
        $dokumen = "SELECT id_dokumen FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuan' AND nama_dokumen = '$nama_dokumen'";
        $result = mysqli_fetch_assoc(mysqli_query($conn, $dokumen));
        return $result['id_dokumen'];
    }

    // Proses update KTP
    if (!empty($FILES['ktp']['name'])) {
        deleteOldDocument(getDokumenIdentitas('ktp', $id_pengajuan));
        $ktpData = uploadFileUser($FILES['ktp'], $id_pengajuan);
        if ($ktpData) {
            $sql_updateKTP = "UPDATE tb_dokumen SET file_path = '$ktpData[path]', change_by = '$id_user' WHERE nama_dokumen = 'ktp' AND id_pengajuan = '$id_pengajuan'";
            $updateKTP = mysqli_query($conn, $sql_updateKTP);
        }
    }

    // Proses update CV
    if (!empty($FILES['cv']['name'])) {
        deleteOldDocument(getDokumenIdentitas('cv', $id_pengajuan));
        $cvData = uploadFileUser($FILES['cv'], $id_pengajuan);
        if ($cvData) {
            $sql_updateCV = "UPDATE tb_dokumen SET file_path = '$cvData[path]', change_by = '$id_user' WHERE nama_dokumen = 'cv' AND id_pengajuan = '$id_pengajuan'";
            $updateCV = mysqli_query($conn, $sql_updateCV);
        }
    } 
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
     if ($query_update1){
        showAlert('Berhasil!', 'Pengajuan Berhasil Diupdate', 'success', "status_pengajuan.php");
        exit();
    }else{
        showAlert('Gagal!', 'Pengajuan gagal diupdate. Silakan coba lagi.', 'error');
    }   
}

function hapusPengajuan($POST, $id_user){
    global $conn;
    $id_pengajuan = $POST['id_pengajuan'];

    $sql_hapusPengajuan = "UPDATE tb_pengajuan SET status_active = '0', change_by = '$id_user' WHERE id_pengajuan = '$id_pengajuan'";
    if (mysqli_query($conn, $sql_hapusPengajuan)){
        $sql2_hapusPengajuan = "UPDATE tb_profile_user SET id_pengajuan = NULL, change_by = '$id_user' WHERE id_user = '$id_user'";
        $result = mysqli_query($conn, $sql2_hapusPengajuan);

        $anggota = "SELECT * FROM tb_profile_user WHERE id_pengajuan = '$id_pengajuan' AND SUBSTRING(id_user, -2) <> '00'";
        $queryAnggota = mysqli_query($conn, $anggota);
        while ($row = mysqli_fetch_assoc($queryAnggota)){
            $hapus_anggota1 = "UPDATE tb_profile_user SET status_active = '0', change_by = '$id_user' WHERE id_user = '$row[id_user]'";
            mysqli_query($conn, $hapus_anggota1);
            $hapus_anggota2 = "UPDATE tb_user SET status_active = '0', change_by = '$id_user' WHERE id_user = '$row[id_user]'";
            mysqli_query($conn, $hapus_anggota2);
        }

        // 3. Hapus dokumen fisik terkait pengajuan
        $dokumen = "SELECT * FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuan' AND jenis_dokumen = '1'";
        $queryDokumen  = mysqli_query($conn, $dokumen);
        while ($row2 = mysqli_fetch_assoc($queryDokumen)){
            $id_dokumen = $row2['id_dokumen'];
            $hapus_dokumen = "UPDATE tb_dokumen SET status_active = '0', change_by = '$id_user' WHERE id_dokumen = '$id_dokumen'";
            mysqli_query($conn, $hapus_dokumen);
        }
        hapusFolderPengajuan($id_pengajuan);
        
        if ($result){?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <?php
            unset($_SESSION['id_pengajuan']);
            unset($_SESSION['status_pengajuan']);
            showAlert('Berhasil!', 'Pengajuan Berhasil Dihapus', 'success', "status_pengajuan.php");
            exit();
        }
    }
}

// =========== ANGGOTA ===========
function updateAnggota($POST, $id_user){
    global $conn;
    $id_userUpdate = $POST['id_user'];
    $nama_anggota = $POST['nama_user'];
    $email = $POST['email'];
    $nik = $POST['nik'];
    $nim = $POST['nim'];

    $sqlUpdate = "UPDATE tb_profile_user SET nama_user = '$nama_anggota', nik = '$nik', nim = '$nim', nisn = '$nim', change_by = '$id_user' WHERE id_user = '$id_userUpdate'";
    if (mysqli_query($conn, $sqlUpdate)){
        $sqlUpdate2 = "UPDATE tb_user SET email = '$email', change_by = '$id_user' WHERE id_user = '$id_userUpdate'";
    }

    if (mysqli_query($conn, $sqlUpdate2)){
        showAlert('Berhasil!', 'Data Anggota Berhasil Diupdate', 'success', "coba5.php");
        exit();
    }else{
        showAlert('Gagal!', 'Data anggota gagal diupdate. Silakan coba lagi.', 'error');
    } 
}

function tambahAnggota($POST, $id_user, $id_pengajuan){
    global $conn;
    $nama_anggota = $POST['nama_user'];
    $email = $POST['email'];
    $nik = $POST['nik'];
    $nim = $POST['nim'];
    $id_user4  = generateIdAnggota($conn, $id_user);
    $pendidikan = "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $pendidikan);
    $id_pendidikan = mysqli_fetch_assoc($result)['id_pendidikan'];

    $sqlTambah = "INSERT INTO tb_profile_user (id_user, nama_user, nik, nim, nisn, id_pengajuan, id_pendidikan, create_by) VALUES ('$id_user4', '$nama_anggota', '$nik', '$nim', '$nim', '$id_pengajuan', '$id_pendidikan', '$id_user')";
    if (mysqli_query($conn, $sqlTambah)){
        $sqlTambah2 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user4', '$email', '3', '$id_user')";
        if (mysqli_query($conn, $sqlTambah2)){
            showAlert('Berhasil!', 'Data Anggota Berhasil di tambah', 'success', "coba5.php");
            exit();
        }else{
            showAlert('Gagal!', 'Data anggota gagal di tambah. Silakan coba lagi.', 'error');
        }   
    }
}

function hapusAnggota($id_user, $id_pengajuan){
    global $conn;
    $id_userHapus = $_GET['id_userHapus'];
    $sql2 =  "UPDATE tb_user 
            JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user
            SET tb_user.status_active = '0',
                tb_user.change_by = '$id_user',
                tb_profile_user.status_active = '0',
                tb_profile_user.change_by = '$id_user'
            WHERE tb_user.id_user = '$id_userHapus' 
            AND tb_profile_user.id_pengajuan = '$id_pengajuan'";

    if (mysqli_query($conn, $sql2)){
        showAlert('Berhasil!', 'Data Anggota Berhasil Dihapus', 'success', "coba5.php");
        exit();
    }else{
        showAlert('Gagal!', 'Data anggota gagal dihapus. Silakan coba lagi.', 'error');
    }   
}

// ================= PROFILE ==============
function updateProfile($POST, $FILES, $id_user, $dataLama){
    global $conn;
    $nama_user = $POST['nama'];
    $tempat_lahir = $POST['tempat_lahir'];
    $tanggal_lahir = $POST['tanggal_lahir'];
    $jenis_kelamin = $POST['jenis_kelamin'];
    $nik = $POST['nik'];
    $telepone = $POST['telepon'];
    $alamat_user = $POST['alamat'];
    $asal_studi = $POST['asal_studi'];

    if (ISSET($POST['fakultas'])){
        $fakultas = $POST['fakultas'];
        $jurusan = $POST['jurusan'];
        $nim = $POST['nim'];
        $nisn = NULL;
        echo "fakultas";
    }else{
        $fakultas = NULL;
        $jurusan = $POST['jurusan'];
        $nisn = $POST['nim'];
        $nim = NULL;
        echo "$fakultas";
    }

    // Update data pendidikan (ambil id_pendidikan dari nama_pendidikan)
    $query_pendidikan = "SELECT id_pendidikan FROM tb_pendidikan WHERE nama_pendidikan = '$asal_studi' AND fakultas = '$fakultas' AND jurusan = '$jurusan'";
    $result_pendidikan = mysqli_query($conn, $query_pendidikan);
    $row_pendidikan = mysqli_fetch_assoc($result_pendidikan);
    $id_pendidikan = $row_pendidikan['id_pendidikan'] ?? $dataLama['id_pendidikan']; // Pakai data lama jika tidak ditemukan

    // Cek apakah ada file gambar yang diunggah
    if (!empty($FILES['image']['name'])) {
        $image_name = time() . "_" . $FILES['image']['name'];
        $target_dir = "../assets/img/user/";
        $target_file = $target_dir . basename($image_name);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $gambar_update = ", gambar_user = '$image_name'";
        } else {
            $gambar_update = "";
        }
    } else {
        $gambar_update = "";
    }

    // Query update profil di tb_profile_user
    $sql5 = "UPDATE tb_profile_user SET 
        nama_user = '$nama_user',
        tempat_lahir = '$tempat_lahir',
        tanggal_lahir = '$tanggal_lahir',
        jenis_kelamin = '$jenis_kelamin',
        nik = '$nik',
        nim = '$nim',
        nisn = '$nisn',
        id_pendidikan = '$id_pendidikan',
        telepone_user = '$telepone',
        alamat_user = '$alamat_user',
        change_by = '$id_user'
        $gambar_update WHERE id_user = '$id_user'";
    
    $query5 = mysqli_query($conn, $sql5);

    if ($query5) {
        showAlert('Berhasil!', 'Profil Berhasil Diupdate', 'success', "profil.php");
        exit();
    } else {
        showAlert('Gagal!', 'Profil gagal diupdate. Silakan coba lagi.', 'error');
    } 
}   
?>