<?php
include "../layout/header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../assets/phpmailer/src/PHPMailer.php';
include '../assets/phpmailer/src/Exception.php';
include '../assets/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST["id_pengajuan"]);

    // Ambil id_user dari tb_pengajuan
    $query = "SELECT id_user FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];

        // Ambil email dari tb_user
        $query_user = "SELECT email FROM tb_user WHERE id_user = '$id_user'";
        $result_user = mysqli_query($conn, $query_user);

        if ($result_user && $row_user = mysqli_fetch_assoc($result_user)) {
            $email = $row_user['email'];

            if ($email) {
                // Update status pengajuan menjadi 2 (Diterima)
                $sql_update = "UPDATE tb_pengajuan SET status_pengajuan = '2' WHERE id_pengajuan = '$id_pengajuan'";

                if (mysqli_query($conn, $sql_update)) {
                    // Kirim Email Notifikasi
                    $email_pengirim = 'moneyuang25@gmail.com';
                    $nama_pengirim = 'Diskominfo Sidoarjo';
                    $email_penerima = $email;
                    $subject = 'Pemberitahuan Penerimaan Pengajuan';
                    $message = "Selamat, pengajuan Anda telah diterima. Silakan cek dashboard untuk informasi lebih lanjut.";

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

                    if ($mail->send()) {
                        echo "<script>
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Pengajuan diterima dan email berhasil dikirim!',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'pengajuan.php';
                            });
                        </script>";
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Pengajuan diterima tetapi gagal mengirim email!',
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
                            text: 'Gagal memperbarui status pengajuan!',
                            icon: 'error'
                        }).then(() => {
                            window.history.back();
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
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'User tidak ditemukan!',
                    icon: 'error'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Data pengajuan tidak ditemukan!',
                icon: 'error'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
}
?>
