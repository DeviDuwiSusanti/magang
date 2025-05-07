<?php
include "../koneksi.php";
if (isset($_GET['get_pembimbing']) && $_GET['get_pembimbing'] == 'true' && isset($_GET['id_pengajuan'])) {
    $id_pengajuan = $_GET['id_pengajuan'];

    $query = "SELECT 
                pp.id_pembimbing, 
                pu.nama_user AS nama_pembimbing
              FROM tb_persetujuan_pembimbing pp
              JOIN tb_profile_user pu ON pp.id_pembimbing = pu.id_user
              WHERE pp.id_pengajuan = ?
              AND pp.status_persetujuan = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengajuan);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

include "../layout/sidebarUser.php";
include "function.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../assets/phpmailer/src/PHPMailer.php';
include '../assets/phpmailer/src/Exception.php';
include '../assets/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pembimbing = mysqli_real_escape_string($conn, $_POST["id_pembimbing"]);
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST["id_pengajuan"]);
    $status = $_POST["status"];

    // Ambil data pengajuan
    $query = "SELECT id_user, nama_bidang, tanggal_mulai, tanggal_selesai, alamat_instansi, nama_panjang 
            FROM tb_pengajuan 
            JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
            JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
            WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];
        $bidang_magang = $row['nama_bidang'];
        $alamat_instansi = $row['alamat_instansi'];
        $nama_instansi = $row['nama_panjang'];
        $periode_mulai = date("d F Y", strtotime($row['tanggal_mulai']));
        $periode_selesai = date("d F Y", strtotime($row['tanggal_selesai']));

        // Dapatkan semua anggota kelompok berdasarkan id_pengajuan
        $query_anggota = "SELECT pu.nama_user, u.email
                         FROM tb_profile_user pu
                         JOIN tb_user u ON pu.id_user = u.id_user
                         WHERE pu.id_pengajuan = '$id_pengajuan'";
        $result_anggota = mysqli_query($conn, $query_anggota);

        $anggota_kelompok = [];
        while ($row_anggota = mysqli_fetch_assoc($result_anggota)) {
            $anggota_kelompok[] = [
                'nama' => $row_anggota['nama_user'],
                'email' => $row_anggota['email']
            ];
        }

        $email_pengirim = 'moneyuang25@gmail.com';
        $nama_pengirim = 'Diskominfo Sidoarjo';
        $salam = salamBerdasarkanWaktu();
        $email_sent = false;

        if ($status === 'terima') {
            $tanggal_sekarang = date("Y-m-d");
            $sql_update = "UPDATE tb_pengajuan SET status_pengajuan = '2', id_pembimbing = '$id_pembimbing', tanggal_diterima = '$tanggal_sekarang' WHERE id_pengajuan = '$id_pengajuan'";

            if (mysqli_query($conn, $sql_update)) {
                // Kirim email ke semua anggota kelompok
                foreach ($anggota_kelompok as $anggota) {
                    $nama_pelamar = $anggota['nama'];
                    $email = $anggota['email'];

                    if ($email) {
                        $subject = 'Pemberitahuan Penerimaan Magang';
                        $message = "
                            <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
                            <p>Kami dengan senang hati menginformasikan bahwa Anda telah <strong>Diterima</strong> sebagai peserta magang di <strong>{$nama_instansi}</strong> pada bidang <strong>{$bidang_magang}</strong>.</p>
                            <p>Berikut adalah detail program magang Anda:</p>
                            <ul>
                                <li>📍 <strong>Instansi:</strong> {$nama_instansi}</li>
                                <li>📆 <strong>Periode Magang:</strong> {$periode_mulai} - {$periode_selesai}</li>
                                <li>🏢 <strong>Lokasi:</strong> {$alamat_instansi}</li>
                                <li>📑 <strong>Bidang:</strong> {$bidang_magang}</li>
                            </ul>
                            <p>Kami mengucapkan <strong>selamat</strong> atas pencapaian Anda dan berharap Anda dapat memperoleh pengalaman yang berharga selama mengikuti program ini.</p>
                            <p>Untuk informasi lebih lanjut, silakan akses <a href='#'>dashboard Anda</a>.</p>
                            <br>
                            <p>Hormat kami,<br><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
                        ";
                        $email_sent = kirimEmail($email_pengirim, $nama_pengirim, $email, $subject, $message, false);
                    }
                }

                // Ambil data pembimbing
                $query_pembimbing = "SELECT nama_user, email
                                FROM tb_user 
                                JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user
                                WHERE tb_user.id_user = '$id_pembimbing'";
                $result_pembimbing = mysqli_query($conn, $query_pembimbing);

                if ($result_pembimbing && $row_pembimbing = mysqli_fetch_assoc($result_pembimbing)) {
                    $nama_pembimbing = $row_pembimbing['nama_user'];
                    $email_pembimbing = $row_pembimbing['email'];

                    if ($email_pembimbing) {
                        // Buat daftar nama anggota kelompok untuk email pembimbing
                        $list_anggota = "";
                        foreach ($anggota_kelompok as $index => $anggota) {
                            $list_anggota .= "<li>👤 <strong>Nama Mahasiswa " . ($index + 1) . ":</strong> {$anggota['nama']}</li>";
                        }

                        $subject_pembimbing = 'Informasi Mahasiswa Bimbingan Magang';
                        $message_pembimbing = "
                            <p>{$salam} <strong>{$nama_pembimbing}</strong>,</p>
                            <p>Anda telah ditunjuk sebagai <strong>pembimbing</strong> bagi " .
                            (count($anggota_kelompok) > 1 ? "kelompok" : "peserta") . " magang berikut:</p>
                                <ul>
                                {$list_anggota}
                                <li>📍 <strong>Instansi:</strong> {$nama_instansi}</li>
                                <li>📑 <strong>Bidang:</strong> {$bidang_magang}</li>
                                <li>📆 <strong>Periode:</strong> {$periode_mulai} - {$periode_selesai}</li>
                                </ul>
                            <p>Silakan pantau kemajuan " . (count($anggota_kelompok) > 1 ? "kelompok" : "mahasiswa") . " melalui dashboard Anda.</p>
                            <br>
                            <p>Hormat kami,<br><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
                            ";
                        kirimEmail($email_pengirim, $nama_pengirim, $email_pembimbing, $subject_pembimbing, $message_pembimbing, $email_sent);
                    }
                }
            }
        } elseif ($status === 'tolak') {
            $alasan = mysqli_real_escape_string($conn, $_POST["alasan_tolak"]);
            $sql_update = "UPDATE tb_pengajuan SET status_pengajuan = '3', alasan_tolak = '$alasan' WHERE id_pengajuan = '$id_pengajuan'";

            if (mysqli_query($conn, $sql_update)) {
                // Kosongkan id_pengajuan di profile user
                $sql_update_profile = "UPDATE tb_profile_user SET id_pengajuan = NULL WHERE id_pengajuan = '$id_pengajuan'";
                mysqli_query($conn, $sql_update_profile);
                // Kirim email ke semua anggota kelompok
                foreach ($anggota_kelompok as $anggota) {
                    $nama_pelamar = $anggota['nama'];
                    $email = $anggota['email'];

                    if ($email) {
                        $subject = 'Pemberitahuan Penolakan Magang';
                        $message = "
                            <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
                            <p>Terima kasih atas pengajuan magang Anda di <strong>{$nama_instansi}</strong>.</p>
                            <p>Namun dengan berat hati, kami harus menyampaikan bahwa pengajuan Anda <strong>belum dapat kami terima</strong> untuk saat ini.</p>
                            <p><strong>Alasan penolakan:</strong> <em>{$alasan}</em></p>
                            <p>Jangan berkecil hati, Anda tetap memiliki kesempatan di kemudian hari.</p>
                            <br>
                            <p>Hormat kami,<br><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
                        ";
                        $email_sent = kirimEmail($email_pengirim, $nama_pengirim, $email, $subject, $message, $email_sent);
                    }
                }
            }
        }

        if ($email_sent) {
            echo "<script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Status pengajuan dan email berhasil dikirim ke semua anggota kelompok!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'pengajuan.php';
                });
            </script>";
        }
    }
}

// Fungsi kirim email yang dimodifikasi dengan parameter $show_alert
function kirimEmail($email_pengirim, $nama_pengirim, $email_penerima, $subject, $message, $show_alert = true)
{
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $email_pengirim;
    $mail->Password = 'leeufuyyxfovbqtb';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';

    $mail->setFrom($email_pengirim, $nama_pengirim);
    $mail->addAddress($email_penerima);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $result = $mail->send();

    if ($result && $show_alert) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Status pengajuan dan email berhasil dikirim!',
                icon: 'success'
            }).then(() => {
                window.location.href = 'pengajuan.php';
            });
        </script>";
    } elseif (!$result && $show_alert) {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Gagal mengirim email!',
                icon: 'warning'
            }).then(() => {
                window.location.href = 'pengajuan.php';
            });
        </script>";
    }

    return $result;
}

function salamBerdasarkanWaktu()
{
    date_default_timezone_set('Asia/Jakarta');
    $jam = date("H");
    if ($jam < 11) return "Selamat pagi";
    if ($jam < 15) return "Selamat siang";
    if ($jam < 19) return "Selamat sore";
    return "Selamat malam";
}
