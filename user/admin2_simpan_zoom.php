<?php
include "../layout/sidebarUser.php";
include "function.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../assets/phpmailer/src/PHPMailer.php';
include '../assets/phpmailer/src/Exception.php';
include '../assets/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST["pengajuan_id"]);
    $tanggal = mysqli_real_escape_string($conn, $_POST["tanggal_pelaksanaan"]);
    $tanggal = date("Y-m-d", strtotime($tanggal));
    $jam = mysqli_real_escape_string($conn, $_POST["jam_pelaksanaan"]);
    $link_zoom = mysqli_real_escape_string($conn, $_POST["link_zoom"]);
    $pembimbing = mysqli_real_escape_string($conn, $_POST["pembimbing"]);
    
    // Ambil nama pembimbing berdasarkan ID pembimbing yang dipilih
    $query_pembimbing = "SELECT pu.nama_user, u.email 
                        FROM tb_profile_user pu 
                        JOIN tb_user u ON pu.id_user = u.id_user
                        WHERE pu.id_user = '$pembimbing'";
    $result_pembimbing = mysqli_query($conn, $query_pembimbing);
    
    if ($result_pembimbing && $row_pembimbing = mysqli_fetch_assoc($result_pembimbing)) {
        $nama_pembimbing = $row_pembimbing['nama_user'];
        $email_pembimbing = $row_pembimbing['email'];
    } else {
        $nama_pembimbing = "Tidak Diketahui";
        $email_pembimbing = "Tidak Diketahui";
    }

    // Ambil data user dari tb_pengajuan
    $query = "SELECT id_user, nama_bidang, nama_panjang 
              FROM tb_pengajuan 
              JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang 
              JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
              WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];
        $bidang_magang = $row['nama_bidang'];
        $nama_instansi = $row['nama_panjang'];

        // Ambil email user dari tb_user
        $query_user = "SELECT nama_user, email FROM tb_user 
                       JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user 
                       WHERE tb_user.id_user = '$id_user'";
        $result_user = mysqli_query($conn, $query_user);

        if ($result_user && $row_user = mysqli_fetch_assoc($result_user)) {
            $nama_pelamar = $row_user['nama_user'];
            $email_pelamar = $row_user['email'];

            if ($email_pelamar) {
                // Kirim email konfirmasi Zoom ke pelamar
                $email_pengirim = 'moneyuang25@gmail.com';
                $nama_pengirim = 'Diskominfo Sidoarjo';
                // $email_penerima = $email;
                $subject_pelamar = 'Undangan Wawancara Zoom Magang';

                $salam = salamBerdasarkanWaktu();
                $message = "
                    <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
                    <p>Kami ingin mengundang Anda dalam sesi wawancara untuk magang di <strong>{$nama_instansi}</strong> pada bidang <strong>{$bidang_magang}</strong>.</p>
                    <p><strong>Detail Zoom:</strong></p>
                    <ul>
                        <li><strong>Tanggal:</strong> {$tanggal}</li>
                        <li><strong>Jam:</strong> {$jam} WIB</li>
                        <li><strong>Nama Pembimbing:</strong> {$nama_pembimbing}</li>
                        <li><strong>Link Zoom:</strong> <a href='{$link_zoom}'>{$link_zoom}</a></li>
                    </ul>
                    <p>Mohon untuk hadir tepat waktu. Jika ada pertanyaan, silakan hubungi kami melalui email ini.</p>
                    <br>
                    <p>Hormat kami,</p>
                    <p><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
                ";

                // Kirim email konfirmasi Zoom ke pembimbing
                if (!empty($email_pembimbing)) {
                    $subject_pembimbing = 'Jadwal Wawancara Magang';
                    $message_pembimbing = "
                        <p>Yth. <strong>{$nama_pembimbing}</strong>,</p>
                        <p>Berikut adalah detail jadwal wawancara untuk calon peserta magang yang akan Anda wawancarai:</p>
                        <p><strong>Detail Wawancara:</strong></p>
                        <ul>
                            <li><strong>Nama Peserta:</strong> {$nama_pelamar}</li>
                            <li><strong>Bidang Magang:</strong> {$bidang_magang}</li>
                            <li><strong>Instansi:</strong> {$nama_instansi}</li>
                            <li><strong>Tanggal:</strong> {$tanggal}</li>
                            <li><strong>Jam:</strong> {$jam} WIB</li>
                            <li><strong>Link Zoom:</strong> <a href='{$link_zoom}'>{$link_zoom}</a></li>
                        </ul>
                        <p>Mohon kesediaannya untuk menghadiri sesi wawancara sesuai jadwal yang telah ditentukan.</p>
                        <br>
                        <p>Hormat kami,</p>
                        <p><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
                    ";

                    // Kirim email ke pembimbing
                    $mail_pembimbing = new PHPMailer();
                    $mail_pembimbing->isSMTP();
                    $mail_pembimbing->Host = 'smtp.gmail.com';
                    $mail_pembimbing->Username = $email_pengirim;
                    $mail_pembimbing->Password = 'leeufuyyxfovbqtb';
                    $mail_pembimbing->Port = 465;
                    $mail_pembimbing->SMTPAuth = true;
                    $mail_pembimbing->SMTPSecure = 'ssl';

                    $mail_pembimbing->setFrom($email_pengirim, $nama_pengirim);
                    $mail_pembimbing->addAddress($email_pembimbing);
                    $mail_pembimbing->isHTML(true);
                    $mail_pembimbing->Subject = $subject_pembimbing;
                    $mail_pembimbing->Body = $message_pembimbing;

                    $mail_pembimbing->send();
                }

                // Kirim email ke pelamar
                $mail_pelamar = new PHPMailer();
                $mail_pelamar->isSMTP();
                $mail_pelamar->Host = 'smtp.gmail.com';
                $mail_pelamar->Username = $email_pengirim;
                $mail_pelamar->Password = 'leeufuyyxfovbqtb';
                $mail_pelamar->Port = 465;
                $mail_pelamar->SMTPAuth = true;
                $mail_pelamar->SMTPSecure = 'ssl';

                $mail_pelamar->setFrom($email_pengirim, $nama_pengirim);
                $mail_pelamar->addAddress($email_pelamar);
                $mail_pelamar->isHTML(true);
                $mail_pelamar->Subject = $subject_pelamar;
                $mail_pelamar->Body = $message;

                if ($mail_pelamar->send()) {
                    echo "<script>
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Email telah dikirim!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'pengajuan.php';
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Email gagal dikirim!',
                            icon: 'warning'
                        }).then(() => {
                            window.location.href = 'pengajuan.php';
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Email tidak ditemukan!',
                        icon: 'error'
                    }).then(() => {
                        window.history.back();
                    });
                </script>";
            }
        }
    }
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
