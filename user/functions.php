
<?php

use Dom\Mysql;

function generateIdDokumen($conn, $id_pengajuan)
{
    $query = "SELECT MAX(CAST(SUBSTRING(id_dokumen, -2) AS UNSIGNED)) AS max_nomor 
               FROM tb_dokumen 
               WHERE id_dokumen LIKE '$id_pengajuan%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $nextNumber = $row['max_nomor'] ? $row['max_nomor'] + 1 : 1;

    $nomorUrut = str_pad($nextNumber, 2, "0", STR_PAD_LEFT);

    return $id_pengajuan . $nomorUrut;
}

function generateIdAnggota($conn, $id_user)
{
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

function uploadFileUser($file, $id_pengajuan)
{

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

function uploadFoto($file, $target_dir)
{
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

function deleteOldDocument($id_dokumen)
{
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

function deleteGambarLogbook($id_logbook)
{
    global $conn;
    // Ambil file lama dari database
    $query = "SELECT foto_kegiatan FROM tb_logbook 
               WHERE id_logbook = '$id_logbook'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $file_path = $row['foto_kegiatan'];
    if (file_exists($file_path)) {
        unlink($file_path); // Hapus file fisik
    }
}

function deleteGambarUser($id_user)
{
    global $conn;
    // Ambil file lama dari database
    $query = "SELECT gambar_user FROM tb_profile_user 
               WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $file_path = "../assets/img/user/" . $row['gambar_user'];
    if (file_exists($file_path)) {
        unlink($file_path); // Hapus file fisik
    }
}

function hapusFolderPengajuan($id_pengajuan)
{
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

function cekEmail($email)
{
    global $conn;
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM tb_user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    return mysqli_num_rows($result) > 0;
}

function getStatusText($status)
{
    $statusList = [
        1 => "Diajukan",
        2 => "Diterima",
        3 => "Ditolak",
        4 => "Berlangsung",
        5 => "Selesai",
    ];
    return $statusList[$status] ?? "Tidak Diketahui";
}

function getKategoriText($kategori)
{
    $kategoriList = [
        1 => "Identitas",
        2 => "Prasyarat",
        3 => "Laporan Akhir",
        4 => "Nilai & Sertifikat",
    ];
    return $kategoriList[$kategori] ?? "Tidak Diketahui";
}

function showAlert($title, $text, $icon, $redirect = null)
{
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


function confirmDeleteScript()
{
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

// Fungsi untuk menghitung durasi dalam bulan dan minggu
function hitungDurasi($tanggal_mulai, $tanggal_selesai)
{
    // Memeriksa apakah kedua tanggal tersedia
    if (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
        // Membuat objek DateTime dari tanggal mulai dan selesai
        $start_date = new DateTime($tanggal_mulai);
        $end_date = new DateTime($tanggal_selesai);

        // Menghitung selisih antara kedua tanggal
        $interval = $start_date->diff($end_date);

        // Mendapatkan jumlah bulan dan hari
        $bulan = $interval->m;
        $hari = $interval->d;
        $minggu = floor($hari / 7); // Menghitung minggu berdasarkan sisa hari

        // Mengembalikan string dalam format "X Bulan Y Minggu"
        return $bulan . " Bulan " . $minggu . " Minggu";
    } else {
        // Jika tanggal tidak valid, kembalikan pesan
        return "Durasi Tidak Diketahui";
    }
}



// Fungsi untuk format tanggal Lengkap Indonesia
function formatTanggalLengkapIndonesia($tanggal)
{
    $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    $tanggal_obj = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $tanggal_obj->format('j') . ' ' . $bulan[$tanggal_obj->format('m')] . ' ' . $tanggal_obj->format('Y');
}

// Fungsi untuk format tanggal ke format Indonesia tanpa tahun
function formatTanggalIndonesia($tanggal)
{
    $bulan = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    $dateObj = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $dateObj ? $dateObj->format('d') . ' ' . $bulan[(int)$dateObj->format('m') - 1] : "Format Tidak Valid";
}

// Fungsi untuk format periode (contoh: "1 Januari - 10 Desember 2024" atau "1 Desember 2023 - 10 Januari 2024")
function formatPeriode($tanggal_mulai, $tanggal_selesai)
{
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


function cekStatusUser($id_user)
{
    // Ambil dua digit terakhir dari id_user
    $dua_digit_terakhir = substr($id_user, -2);

    // Jika dua digit terakhir adalah "00", berarti Ketua
    return $dua_digit_terakhir === '00' ? 'Ketua' : 'Anggota';
}


// ============== LOGBOOK ==================
function generateLogbookId($conn, $id_pengajuan)
{
    // Ambil counter terbesar untuk id_pengajuan ini
    $sql_max = "SELECT MAX(CAST(SUBSTRING(id_logbook, -2) AS UNSIGNED)) as max_counter FROM tb_logbook WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $sql_max);
    $row = mysqli_fetch_assoc($result);
    $counter = str_pad($row['max_counter'] + 1, 2, '0', STR_PAD_LEFT); // Tambah 1 ke counter terbesar

    // Buat id_logbook dengan format 10 digit id_pengajuan + 2 digit counter
    $id_logbook = $id_pengajuan . $counter;

    return $id_logbook;
}

function getLogbook($conn, $id_pengajuan, $id_user)
{
    // Query untuk mengambil logbook
    $sql = "SELECT * FROM tb_logbook WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user' AND (status_active = '1' OR status_active = '2')";
    $query = mysqli_query($conn, $sql);

    // Periksa apakah query berhasil
    if (!$query) {
        die("Query error: " . mysqli_error($conn));
    }
    // Mengembalikan hasil query
    return $query;
}

function inputLogbook($POST, $FILES, $id_pengajuan, $id_user)
{
    global $conn;
    $tanggal = $POST['tanggal'];
    $kegiatan = $POST['kegiatan'];
    $keterangan = $POST['keterangan'];
    $jam_mulai = $POST['jam_mulai'];
    $jam_selesai = $POST['jam_selesai'];
    $ttd = $POST['ttd'];

    // Buat folder user jika belum ada
    $user_folder = '../assets/img/logbook/' . $id_user . '/';
    if (!file_exists($user_folder)) {
        mkdir($user_folder, 0777, true);
    }

    // Upload foto ke folder user
    $uploadedFoto = uploadFoto($FILES['gambar_kegiatan'], $user_folder);
    $target_file = $uploadedFoto['path'];

    $id_logbook = generateLogbookId($conn, $id_pengajuan);

    // Query INSERT dengan id_logbook yang sudah dibuat
    $sql = "INSERT INTO tb_logbook (`id_logbook`, `tanggal_logbook`, `kegiatan_logbook`, `keterangan_logbook`, `jam_mulai`, `jam_selesai`, `foto_kegiatan`, `tanda_tangan`, `id_pengajuan`, `id_user`, `create_by`) 
            VALUES ('$id_logbook', '$tanggal', '$kegiatan', '$keterangan', '$jam_mulai', '$jam_selesai', '$target_file', '$ttd', '$id_pengajuan', '$id_user', '$id_user')";

    if (mysqli_query($conn, $sql)) {
        showAlert('Berhasil!', 'Logbook Berhasil Diinput', 'success', "user3_logbook.php");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal diinput. Silakan coba lagi.', 'error');
    }
}

function updateLogbook($POST, $FILES, $id_user, $id_logbook, $row)
{
    global $conn;
    // Inisialisasi foto_kegiatan (default: data lama)
    $foto_kegiatan = $row['foto_kegiatan'];

    // Jika ada file baru diunggah
    if (!empty($FILES['gambar_kegiatan']['name'])) {
        deleteGambarLogbook($id_logbook);
        $uploadResult = uploadFoto($FILES['gambar_kegiatan'], '../assets/img/logbook/' . $id_user . '/');
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
        showAlert('Berhasil!', 'Logbook Berhasil Diupdate', 'success', "user3_logbook.php");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal diupdate. Silakan coba lagi.', 'error');
    }
}

function hapusLogbook($id_user)
{
    global $conn;
    $id_logbook = $_GET['id_logbook_hapus'];
    $sql2 =  "UPDATE tb_logbook SET status_active = '0', change_by = '$id_user' WHERE id_logbook = '$id_logbook'";
    $query2 = mysqli_query($conn, $sql2);
    if ($query2) {
        deleteGambarLogbook($id_logbook);
        showAlert('Berhasil!', 'Logbook Berhasil Dihapus', 'success', "user3_logbook.php");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal dihapus. Silakan coba lagi.', 'error');
    }
}

// ============== PENGAJUAN ==============
function generateIdPengajuan($conn)
{
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

function inputPengajuan($POST, $FILES, $id_user)
{
    global $conn;

    $id_pengajuan = generateIdPengajuan($conn);
    $id_dokumen_ktp = generateIdDokumen($conn, $id_pengajuan);

    $id_instansi = $POST['id_instansi'];
    $id_bidang = $POST['id_bidang'];
    $jenis_pengajuan = $POST['jenis_pengajuan'];
    if (isset($_POST['jumlah_anggota'])) {
        $jumlah_pelamar = $POST['jumlah_anggota'];
    } else {
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
    $proposal = uploadFileUser($FILES['proposal'], $id_pengajuan);

    if (isset($POST['anggota_nama'])) {
        // Mengambil data anggota dari form Step 2
        $anggota_nama = $POST['anggota_nama'];
        $anggota_email = $POST['anggota_email'];
        $anggota_nik = $POST['anggota_nik'];
        if (isset($POST['anggota_nisn'])) {
            $anggota_nisn = $POST['anggota_nisn'];
            $anggota_nim = NULL;
        } else if (isset($POST['anggota_nim'])) {
            $anggota_nisn = NULL;
            $anggota_nim = $POST['anggota_nim'];
        }

        foreach ($anggota_nama as $index => $nama) {
            $email = $anggota_email[$index];
            if ($anggota_nisn == NULL) {
                $nisn = NULL;
                $nim = $anggota_nim[$index];
            } else if ($anggota_nisn != NULL) {
                $nim = NULL;
                $nisn = $anggota_nisn[$index];
            }

            $nik = $anggota_nik[$index];
            $id_userAnggota = generateIdAnggota($conn, $id_user);

            $pendidikan = "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'";
            $result = mysqli_query($conn, $pendidikan);
            $id_pendidikan = mysqli_fetch_assoc($result)['id_pendidikan'];

            $sql_anggota1 = "INSERT INTO tb_profile_user (id_user, nama_user, nik, nisn, nim, id_pengajuan, id_pendidikan, create_by) VALUES ('$id_userAnggota', '$nama', '$nik', '$nisn', '$nim', '$id_pengajuan', '$id_pendidikan', '$id_user')";
            $query_anggota1 = mysqli_query($conn, $sql_anggota1);

            $sql_anggota2 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_userAnggota', '$email', '3', '$id_user')";
            $query_anggota2 = mysqli_query($conn, $sql_anggota2);
        }
    }

    $sql2 = "INSERT INTO tb_pengajuan (id_pengajuan, id_user, id_instansi, id_bidang, jenis_pengajuan, jumlah_pelamar, tanggal_mulai, tanggal_selesai, status_pengajuan, status_active, create_by, create_date, change_by, change_date) 
    VALUES ('$id_pengajuan', '$id_user', '$id_instansi', '$id_bidang', '$jenis_pengajuan', '$jumlah_pelamar', '$tanggal_mulai', '$tanggal_selesai', '1', '1', '$id_user', NOW(), '', '')";
    $query2 = mysqli_query($conn, $sql2);

    $sql3 = "INSERT INTO tb_dokumen VALUES ('$id_dokumen_ktp', '$ktp[name]', '1', '$ktp[path]', '$id_pengajuan', '$id_user', '1', '$id_user', NOW(), '', '')";
    $query3 = mysqli_query($conn, $sql3);


    if ($query2 && $query3) {
        // query cv
        $id_dokumen_cv = generateIdDokumen($conn, $id_pengajuan);
        $sql4 = "INSERT INTO tb_dokumen VALUES ('$id_dokumen_cv', '$cv[name]', '1', '$cv[path]', '$id_pengajuan', '$id_user', '1', '$id_user', NOW(), '', '')";
        $query4 = mysqli_query($conn, $sql4);
        // query proposal
        $id_dokumen_proposal = generateIdDokumen($conn, $id_pengajuan);
        $sql5 = "INSERT INTO tb_dokumen VALUES ('$id_dokumen_proposal', '$proposal[name]', '1', '$proposal[path]', '$id_pengajuan', '$id_user', '1', '$id_user', NOW(), '', '')";
        $query5 = mysqli_query($conn, $sql5);
        // query update id_pengajuan user
        $sql6 = "UPDATE tb_profile_user SET id_pengajuan = '$id_pengajuan' WHERE id_user = '$id_user'";
        $query6 = mysqli_query($conn, $sql6);
    }
    if ($query2 && $query3 && $query4 && $query5 && $query6) { ?>
        <?php
        showAlert('Berhasil!', 'Yeayy, Pendaftaran Kamu Berhasil', 'success', "user3_statusPengajuan.php");
        exit();
    } else {
        showAlert('Gagal!', 'Yahh pendaftaran kamu gagal. Silakan coba lagi.', 'error');
    }
}

function updatePengajuan($POST, $FILES, $id_user)
{
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


    // akses id_dokumen ktp, cv dan proposal
    $sql_dokumen = "SELECT id_dokumen FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuan' ORDER BY id_dokumen ASC";
    $query_dokumen = mysqli_query($conn, $sql_dokumen);
    $dokumen = mysqli_fetch_all($query_dokumen, MYSQLI_ASSOC);

    // Proses update KTP
    if (!empty($FILES['ktp']['name'])) {
        deleteOldDocument($dokumen[0]['id_dokumen']);
        $id_dokumenKTP = $dokumen[0]['id_dokumen'];
        $ktpData = uploadFileUser($FILES['ktp'], $id_pengajuan);
        if ($ktpData) {
            $sql_updateKTP = "UPDATE tb_dokumen SET 
            nama_dokumen = '$ktpData[name]', 
            file_path = '$ktpData[path]', 
            change_by = '$id_user' WHERE id_dokumen = '$id_dokumenKTP' AND id_pengajuan = '$id_pengajuan'";
            $updateKTP = mysqli_query($conn, $sql_updateKTP);
        }
    }

    // Proses update CV
    if (!empty($FILES['cv']['name'])) {
        deleteOldDocument($dokumen[1]['id_dokumen']);
        $id_dokumenCV = $dokumen[1]['id_dokumen'];
        $cvData = uploadFileUser($FILES['cv'], $id_pengajuan);
        if ($cvData) {
            $sql_updateCV = "UPDATE tb_dokumen SET 
            nama_dokumen = '$cvData[name]', 
            file_path = '$cvData[path]', 
            change_by = '$id_user' WHERE id_dokumen = '$id_dokumenCV' AND id_pengajuan = '$id_pengajuan'";
            $updateCV = mysqli_query($conn, $sql_updateCV);
        }
    }
    // Proses update Proposal
    if (!empty($FILES['proposal']['name'])) {
        deleteOldDocument($dokumen[2]['id_dokumen']);
        $id_dokumenProposal = $dokumen[2]['id_dokumen'];
        $proposalData = uploadFileUser($FILES['proposal'], $id_pengajuan);
        if ($proposalData) {
            $sql_updateProposal = "UPDATE tb_dokumen SET 
            nama_dokumen = '$proposalData[name]', 
            file_path = '$proposalData[path]', 
            change_by = '$id_user' WHERE id_dokumen = '$id_dokumenProposal' AND id_pengajuan = '$id_pengajuan'";
            $updateProposal = mysqli_query($conn, $sql_updateProposal);
        }
    }

    if ($query_update1) {
        showAlert('Berhasil!', 'Pengajuan Berhasil Diupdate', 'success', "user3_statusPengajuan.php");
        exit();
    } else {
        showAlert('Gagal!', 'Pengajuan gagal diupdate. Silakan coba lagi.', 'error');
    }
}

function hapusPengajuan($POST, $id_user, $id_pengajuan)
{
    global $conn;
    $alasan_hapus = $POST['alasan_hapus'];

    $sql_hapusPengajuan = "UPDATE tb_pengajuan SET alasan_hapus = '$alasan_hapus', status_active = '0', change_by = '$id_user' WHERE id_pengajuan = '$id_pengajuan'";
    if (mysqli_query($conn, $sql_hapusPengajuan)) {
        $sql2_hapusPengajuan = "UPDATE tb_profile_user SET id_pengajuan = NULL, change_by = '$id_user' WHERE id_user = '$id_user'";
        $result = mysqli_query($conn, $sql2_hapusPengajuan);

        $anggota = "SELECT * FROM tb_profile_user WHERE id_pengajuan = '$id_pengajuan' AND SUBSTRING(id_user, -2) <> '00'";
        $queryAnggota = mysqli_query($conn, $anggota);
        while ($row = mysqli_fetch_assoc($queryAnggota)) {
            $hapus_anggota1 = "UPDATE tb_profile_user SET status_active = '0', change_by = '$id_user' WHERE id_user = '$row[id_user]'";
            mysqli_query($conn, $hapus_anggota1);
            $hapus_anggota2 = "UPDATE tb_user SET status_active = '0', change_by = '$id_user' WHERE id_user = '$row[id_user]'";
            mysqli_query($conn, $hapus_anggota2);
        }

        // 3. Hapus dokumen fisik terkait pengajuan
        $dokumen = "SELECT * FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuan' AND jenis_dokumen = '1'";
        $queryDokumen  = mysqli_query($conn, $dokumen);
        while ($row2 = mysqli_fetch_assoc($queryDokumen)) {
            $id_dokumen = $row2['id_dokumen'];
            $hapus_dokumen = "UPDATE tb_dokumen SET status_active = '0', change_by = '$id_user' WHERE id_dokumen = '$id_dokumen'";
            mysqli_query($conn, $hapus_dokumen);
        }
        hapusFolderPengajuan($id_pengajuan);

        if ($result) { ?>
            <?php
            unset($_SESSION['id_pengajuan']);
            unset($_SESSION['status_pengajuan']);
            showAlert('Berhasil!', 'Pengajuan Berhasil Dihapus', 'success', "user3_statusPengajuan.php");
            exit();
        }
    }
}

// =========== ANGGOTA ===========
function updateAnggota($POST, $id_user)
{
    global $conn;
    $id_userUpdate = $POST['id_user'];
    $nama_anggota = $POST['nama_user'];
    $email = $POST['email'];
    $nik = $POST['nik'];
    if (isset($_POST['nisn'])) {
        $nisn = $POST['nisn'];
        $nim = NULL;
    } else {
        $nim = $POST['nim'];
        $nisn = NULL;
    }

    $sqlUpdate = "UPDATE tb_profile_user SET nama_user = '$nama_anggota', nik = '$nik', nisn = '$nisn', nim = '$nim', change_by = '$id_user' WHERE id_user = '$id_userUpdate'";
    if (mysqli_query($conn, $sqlUpdate)) {
        $sqlUpdate2 = "UPDATE tb_user SET email = '$email', change_by = '$id_user' WHERE id_user = '$id_userUpdate'";
    }

    if (mysqli_query($conn, $sqlUpdate2)) {
        showAlert('Berhasil!', 'Data Anggota Berhasil Diupdate', 'success', "user3_statusPengajuan.php");
        exit();
    } else {
        showAlert('Gagal!', 'Data anggota gagal diupdate. Silakan coba lagi.', 'error');
    }
}

function tambahAnggota($POST, $id_user, $id_pengajuan)
{
    global $conn;
    $nama_anggota = $POST['nama_user'];
    $email = $POST['email'];
    $nik = $POST['nik'];
    if (isset($_POST['nisn'])) {
        $nisn = $POST['nisn'];
        $nim = NULL;
    } else {
        $nim = $POST['nim'];
        $nisn = NULL;
    }

    $id_userAnggota  = generateIdAnggota($conn, $id_user);
    $pendidikan = "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $pendidikan);
    $id_pendidikan = mysqli_fetch_assoc($result)['id_pendidikan'];

    $sqlTambah = "INSERT INTO tb_profile_user (id_user, nama_user, nik, nisn, nim, id_pengajuan, id_pendidikan, create_by) VALUES ('$id_userAnggota', '$nama_anggota', '$nik', '$nisn', '$nim', '$id_pengajuan', '$id_pendidikan', '$id_user')";
    if (mysqli_query($conn, $sqlTambah)) {
        $sqlTambah2 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_userAnggota', '$email', '3', '$id_user')";
        if (mysqli_query($conn, $sqlTambah2)) {
            showAlert('Berhasil!', 'Data Anggota Berhasil di tambah', 'success', "user3_statusPengajuan.php");
            exit();
        } else {
            showAlert('Gagal!', 'Data anggota gagal di tambah. Silakan coba lagi.', 'error');
        }
    }
}

function hapusAnggota($id_user, $id_pengajuan)
{
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

    if (mysqli_query($conn, $sql2)) {
        showAlert('Berhasil!', 'Data Anggota Berhasil Dihapus', 'success', "user3_statusPengajuan.php");
        exit();
    } else {
        showAlert('Gagal!', 'Data anggota gagal dihapus. Silakan coba lagi.', 'error');
    }
}

// =============== ABSENSI ======================
function generateIdAbsensi($conn, $id_user)
{
    // Ambil counter terbesar untuk id_user ini
    $sql_max = "SELECT MAX(CAST(SUBSTRING(id_absensi, -3) AS UNSIGNED)) as max_counter 
                FROM tb_absensi 
                WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $sql_max);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    // Jika belum ada data, mulai dari 1, else tambah 1 ke counter terbesar
    $counter = ($row['max_counter'] === null) ? 1 : $row['max_counter'] + 1;
    $counter = str_pad($counter, 3, '0', STR_PAD_LEFT); // Format 3 digit dengan leading zero

    // Gabungkan id_user (14 digit) dengan counter (3 digit)
    $id_absensi = $id_user . $counter;

    return $id_absensi;
}

function inputAbsensi($FILES, $id_pengajuan, $id_user)
{
    global $conn;

    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:s');

    // Buat folder user jika belum ada
    $absen_folder = '../assets/img/absensi/' . $id_pengajuan . '/';
    if (!file_exists($absen_folder)) {
        mkdir($absen_folder, 0777, true);
    }

    // Upload foto ke folder user
    $uploadedFoto = uploadFoto($FILES['absensi_foto'], $absen_folder);
    $target_file = $uploadedFoto['path'];

    $cek_absen = mysqli_query($conn, "SELECT id_user, id_pengajuan, tanggal_absensi FROM tb_absensi WHERE id_user = '$id_user' AND id_pengajuan = '$id_pengajuan' AND tanggal_absensi = '$tanggal_sekarang'");
    $absen = mysqli_fetch_assoc($cek_absen);

    if ($absen == NULL) {
        // generate id_absensi
        $id_absensi = generateIdAbsensi($conn, $id_user);
        $absen_masuk = mysqli_query($conn, "INSERT INTO tb_absensi (id_absensi, id_user, id_pengajuan, tanggal_absensi, foto_datang, jam_datang, create_by, create_date)
            VALUES ('$id_absensi', '$id_user', '$id_pengajuan', '$tanggal_sekarang', '$target_file', '$jam_sekarang', '$id_user', NOW())");
        if ($absen_masuk) {
            showAlert('Berhasil!', 'Berhasil Absen Masuk Untuk Hari Ini, Jangan Lupa Untuk Absen Pulang Yaa', 'success', "dashboard.php");
            exit();
        }
    } else {
        $sql_id_absensi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_absensi FROM tb_absensi WHERE id_user = '$id_user' AND id_pengajuan = '$id_pengajuan' AND tanggal_absensi = '$tanggal_sekarang'"));
        $id_absensi = $sql_id_absensi['id_absensi'];
        $absen_pulang = mysqli_query($conn, "UPDATE tb_absensi SET foto_pulang = '$target_file', jam_pulang = '$jam_sekarang', change_by = '$id_user', change_date = NOW() WHERE id_absensi = '$id_absensi'");
        if ($absen_pulang) {
            showAlert('Berhasil!', 'Berhasil Absen Pulang Untuk Hari Ini, Jangan Lupa Untuk Absen Besok Yaa', 'success', "dashboard.php");
            exit();
        }
    }
}

// ================= PROFILE ==============
function updateProfile($POST, $FILES, $id_user, $dataLama)
{
    global $conn;
    $nama_user = $POST['nama'];
    $tempat_lahir = $POST['tempat_lahir'];
    $tanggal_lahir = $POST['tanggal_lahir'];
    $jenis_kelamin = $POST['jenis_kelamin'];
    $jabatan = $POST["jabatan"];
    $nik = $POST['nik'];
    $nip = $POST['nip'];
    $telepone = $POST['telepon'];
    $alamat_user = $POST['alamat'];
    $asal_studi = $POST['asal_studi'];

    // ambil nama pendidikan
    $query_Pendidikan = "SELECT * FROM tb_pendidikan WHERE id_pendidikan = '$asal_studi'";
    $pendidikan = mysqli_fetch_assoc(mysqli_query($conn, $query_Pendidikan));

    // Check if education ID length is 7 (university) or 5 (school)
    if (strlen($asal_studi) === 7) {
        // University - has faculty
        $fakultas = $POST['fakultas'];
        $jurusan = $POST['jurusan'];
        $nim = $POST['nim'];
        $nisn = NULL; // NISN not needed for universities

        // Get education ID with faculty
        $query_pendidikan = "SELECT id_pendidikan FROM tb_pendidikan 
                            WHERE nama_pendidikan = '$pendidikan[nama_pendidikan]' 
                            AND fakultas = '$fakultas' 
                            AND jurusan = '$jurusan'";
    } else {
        // School - no faculty
        $fakultas = NULL;
        $jurusan = $POST['jurusan'];
        $nisn = $POST['nisn'];
        $nim = NULL; // NIM not needed for schools

        // Get education ID without faculty
        $query_pendidikan = "SELECT id_pendidikan FROM tb_pendidikan 
                            WHERE nama_pendidikan = '$pendidikan[nama_pendidikan]' 
                            AND jurusan = '$jurusan'";
    }


    $result_pendidikan = mysqli_query($conn, $query_pendidikan);
    $row_pendidikan = mysqli_fetch_assoc($result_pendidikan);
    $id_pendidikan = $row_pendidikan['id_pendidikan']; // Pakai data lama jika tidak ditemukan

    // Cek apakah ada file gambar yang diunggah
    if (!empty($FILES['image']['name'])) {
        deleteGambarUser($id_user);
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
        nip = '$nip',
        nim = '$nim',
        nisn = '$nisn',
        jabatan = '$jabatan',
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







// =========================== pembimbing ========================
function generateId_nilai($id_pengajuan)
{
    global $conn;
    // Ambil ID nilai terbesar berdasarkan id_pengajuan
    $query = "SELECT id_nilai FROM tb_nilai WHERE id_pengajuan = '$id_pengajuan' ORDER BY id_nilai DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $lastId = mysqli_fetch_assoc($result);

    if ($lastId) {
        // Ambil 2 digit terakhir sebagai counter dan tambahkan 1
        $lastCounter = intval(substr($lastId['id_nilai'], -2));
        $newCounter = str_pad($lastCounter + 1, 2, '0', STR_PAD_LEFT);
    } else {
        $newCounter = '01';
    }

    return $id_pengajuan . $newCounter;
}

function pembimbing_input_nilai($data)
{
    global $conn;

    $id_pengajuan = mysqli_real_escape_string($conn, $data['id_pengajuan']);
    $id_user = mysqli_real_escape_string($conn, $data['id_user']);
    $create_by = mysqli_real_escape_string($conn, $data['create_by']);
    $id_bidang = mysqli_real_escape_string($conn, $data['id_bidang']);
    $id_instansi = mysqli_real_escape_string($conn, $data['id_instansi']);
    $bidang_keahlian = mysqli_real_escape_string($conn, $data['bidang_keahlian']);
    $kehadiran = mysqli_real_escape_string($conn, $data['kehadiran']);
    $disiplin = mysqli_real_escape_string($conn, $data['disiplin']);
    $tanggung_jawab = mysqli_real_escape_string($conn, $data['tanggung_jawab']);
    $kreativitas = mysqli_real_escape_string($conn, $data['kreativitas']);
    $kerjasama = mysqli_real_escape_string($conn, $data['kerjasama']);
    $teknologi_informasi = mysqli_real_escape_string($conn, $data['teknologi_informasi']);
    $catatan = mysqli_real_escape_string($conn, $data['catatan']);

    $id_nilai = generateId_nilai($id_pengajuan);

    // Ambil bulan sekarang
    $bulan = date('m');

    // Ambil nomor urut terakhir dari instansi tersebut di bulan ini
    $query = "SELECT nomor_nilai FROM tb_nilai 
              WHERE id_instansi = '$id_instansi' 
              AND LEFT(nomor_nilai, 2) = '$bulan' 
              ORDER BY nomor_nilai DESC 
              LIMIT 1";

    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        // Ambil 3 digit terakhir, konversi ke int, tambah 1
        $last_number = (int)substr($row['nomor_nilai'], 2, 3);
        $next_number = $last_number + 1;
    } else {
        // Belum ada entri untuk bulan ini dan instansi ini
        $next_number = 1;
    }

    // Format nomor nilai: 2 digit bulan + 3 digit counter
    $nomor_nilai = str_pad($bulan, 2, '0', STR_PAD_LEFT) . str_pad($next_number, 3, '0', STR_PAD_LEFT);

    // Hitung rata-rata
    $rata_rata = ($kehadiran + $disiplin + $tanggung_jawab + $kreativitas + $kerjasama + $teknologi_informasi) / 6;

    // Generate URL untuk QR Code
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $url_qr = $base_url . "/magang/user/view_link_qr.php?id=" . $id_nilai;

    // Simpan ke database
    $query = "INSERT INTO tb_nilai (
        id_nilai, id_pengajuan, id_user, id_bidang, id_instansi, nomor_nilai, bidang_keahlian,
        kehadiran, disiplin, tanggung_jawab, kreativitas, kerjasama, teknologi_informasi,
        rata_rata, catatan, url_qr, create_by
    ) VALUES (
        '$id_nilai', '$id_pengajuan', '$id_user', '$id_bidang', '$id_instansi', '$nomor_nilai',
        '$bidang_keahlian', '$kehadiran', '$disiplin', '$tanggung_jawab', '$kreativitas',
        '$kerjasama', '$teknologi_informasi', '$rata_rata', '$catatan', '$url_qr', '$create_by'
    )";

    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}




function pembimbing_update_nilai($data)
{
    global $conn;

    $id_nilai = mysqli_real_escape_string($conn, $data['id_nilai']);
    $change_by = mysqli_real_escape_string($conn, $data['change_by']);
    $bidang_keahlian = mysqli_real_escape_string($conn, $data['bidang_keahlian']);
    $kehadiran = mysqli_real_escape_string($conn, $data['kehadiran']);
    $disiplin = mysqli_real_escape_string($conn, $data['disiplin']);
    $tanggung_jawab = mysqli_real_escape_string($conn, $data['tanggung_jawab']);
    $kreativitas = mysqli_real_escape_string($conn, $data['kreativitas']);
    $kerjasama = mysqli_real_escape_string($conn, $data['kerjasama']);
    $teknologi_informasi = mysqli_real_escape_string($conn, $data['teknologi_informasi']);
    $catatan = mysqli_real_escape_string($conn, $data['catatan']);

    $rata_rata = ($kehadiran + $disiplin + $tanggung_jawab + $kreativitas + $kerjasama + $teknologi_informasi) / 6;

    // Update data ke database
    $query = "UPDATE tb_nilai SET 
                bidang_keahlian = '$bidang_keahlian',
                kehadiran = '$kehadiran', 
                disiplin = '$disiplin', 
                tanggung_jawab = '$tanggung_jawab', 
                kreativitas = '$kreativitas', 
                kerjasama = '$kerjasama', 
                teknologi_informasi = '$teknologi_informasi', 
                rata_rata = '$rata_rata', 
                catatan = '$catatan'
                change_by = '$change_by',
                WHERE id_nilai = '$id_nilai'";

    return mysqli_query($conn, $query);
}

function update_logbook_seen($id_logbook, $id_pembimbing)
{
    global $conn;
    $query = "UPDATE tb_logbook SET status_active = '2' WHERE id_logbook = '$id_logbook'";
    return mysqli_query($conn, $query);
}



function generateId_persetujuan($id_pembimbing)
{
    global $conn;

    $query = "SELECT id_persetujuan FROM tb_persetujuan_pembimbing WHERE id_pembimbing = '$id_pembimbing' ORDER BY id_persetujuan DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $lastId = mysqli_fetch_assoc($result);

    if ($lastId) {
        // Ambil 3 digit terakhir sebagai counter
        $lastCounter = intval(substr($lastId['id_persetujuan'], -3));
        $newCounter = str_pad($lastCounter + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newCounter = '001';
    }
    return $id_pembimbing . $newCounter;
}


/* 
=============================================================================
                        FUNGSI BAGIAN ADMIN INSTANSI
=============================================================================
*/
// Fungsi untuk mengambil data pengajuan berdasarkan id_instansi
function getDataPengajuanByInstansi($conn, $id_instansi)
{
    $sql = "SELECT  
                pu.nama_user, b.nama_bidang, b.kuota_bidang, b.id_bidang, i.nama_panjang,
                COALESCE(pa.jumlah_pemagang_aktif, 0) AS jumlah_pemagang_aktif, 
                u.email, p.jenis_pengajuan, p.jumlah_pelamar, p.tanggal_mulai,
                p.tanggal_selesai, p.id_pengajuan, p.id_user, p.status_pengajuan, 
                p.status_active, p.tanggal_zoom, p.pengingat_dokumen, p.dokumen_lengkap
            FROM tb_pengajuan AS p
            INNER JOIN tb_profile_user AS pu ON p.id_user = pu.id_user
            INNER JOIN tb_bidang AS b ON p.id_bidang = b.id_bidang
            INNER JOIN tb_instansi AS i ON p.id_instansi = i.id_instansi
            INNER JOIN tb_user AS u ON p.id_user = u.id_user
            LEFT JOIN (
                SELECT id_bidang, SUM(jumlah_pelamar) AS jumlah_pemagang_aktif
                FROM tb_pengajuan
                WHERE status_pengajuan IN ('2', '4')
                GROUP BY id_bidang
            ) AS pa ON b.id_bidang = pa.id_bidang
            WHERE p.id_instansi = ?
            AND p.status_active = '1'
            AND b.status_active = '1'
            AND p.status_pengajuan IN ('1', '2')
            ORDER BY p.id_pengajuan ASC";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return [];

    mysqli_stmt_bind_param($stmt, "s", $id_instansi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $data;
}

// Fungsi untuk mengambil data nama pelamar berdasarkan id_instansi
function getNamaPelamarByPengajuan($conn, $id_instansi)
{
    $sql = "SELECT 
                p.id_pengajuan, 
                GROUP_CONCAT(pu.nama_user SEPARATOR ', ') AS daftar_nama
            FROM tb_pengajuan AS p
            JOIN tb_profile_user AS pu ON p.id_pengajuan = pu.id_pengajuan
            WHERE p.id_instansi = ?
            GROUP BY p.id_pengajuan
            ORDER BY p.id_pengajuan DESC";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Error preparing statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $id_instansi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $nama_pelamar = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $nama_pelamar[$row['id_pengajuan']] = $row['daftar_nama'];
    }

    mysqli_stmt_close($stmt);

    return $nama_pelamar;
}

// Fungsi untuk mengambil data dokumen berdasarkan id_instansi
function getDokumenByInstansi($conn, $id_instansi)
{
    $sql = "SELECT 
                d.id_pengajuan, 
                d.id_user, 
                GROUP_CONCAT(CONCAT(d.nama_dokumen, '|', d.file_path) SEPARATOR '||') AS daftar_dokumen
            FROM tb_dokumen AS d
            JOIN tb_pengajuan AS p ON d.id_pengajuan = p.id_pengajuan
            WHERE p.id_instansi = ?
              AND d.status_active = '1'
            GROUP BY d.id_pengajuan, d.id_user";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Error preparing statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $id_instansi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $daftar_dokumen = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];
        $id_pengajuan = $row['id_pengajuan'];
        $dokumen_raw = explode('||', $row['daftar_dokumen']);

        $dokumen_list = [];
        foreach ($dokumen_raw as $item) {
            // Cek apakah format item benar (memiliki separator '|')
            if (strpos($item, '|') !== false) {
                list($nama, $path) = explode('|', $item);
                $dokumen_list[] = ['nama' => $nama, 'path' => $path];
            }
        }

        $daftar_dokumen[$id_user][$id_pengajuan] = $dokumen_list;
    }

    mysqli_stmt_close($stmt);
    return $daftar_dokumen;
}






// pembuatan nomor sertifikat
function generateKodeSurat($no_urut, $id_instansi)
{
    $tahun = date('Y');

    // Format ID instansi jadi xxx.xx.xx.xx
    $id_str = str_pad($id_instansi, 9, '0', STR_PAD_LEFT);
    $id_formatted = substr($id_str, 0, 3) . '.' .
        substr($id_str, 3, 2) . '.' .
        substr($id_str, 5, 2) . '.' .
        substr($id_str, 7, 2);
    // Gabungkan semuanya ke dalam format akhir
    $kode = "404.14.5.4/{$no_urut}/{$id_formatted}/{$tahun}";
    return $kode;
}






            ?>