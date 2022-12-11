<?php
require_once 'session.php';
require_once 'auth.php';
$user = new Auth();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../home/assets/php/vendor/autoload.php';
require '../../../home/assets/php/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../../home/assets/php/vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../../home/assets/php/vendor/phpmailer/phpmailer/src/Exception.php';
$mail_send = new PHPMailer(true);

if (isset($_FILES['foto-produk'])) {
    $idProduk = $user->validate($_POST['id-produk']);
    $namaProduk = $user->validate($_POST['nama-produk']);
    $hargaProduk = $user->validate($_POST['harga-produk']);

    $folder = 'uploads/';

    if (isset($_FILES['foto-produk']['name']) && ($_FILES['foto-produk']['name'] != "")) {
        $newImage = $folder . $_FILES['foto-produk']['name'];
        move_uploaded_file($_FILES['foto-produk']['tmp_name'], $newImage);
    }
    $up = $user->tambahProduk($idProduk, $namaProduk, $hargaProduk, $newImage, $cid);
    if ($up == true) {
        echo 'berhasil';
    } else {
        echo 'gagal';
    }
}

if (isset($_FILES['foto-profile'])) {
    $name = $user->validate($_POST['nama-pengguna']);
    $email = $user->validate($_POST['email-pengguna']);
    $alamat = $user->validate($_POST['alamat-pengguna']);
    $notelp = $user->validate($_POST['no_telp-pengguna']);

    $oldImage = $_POST['old-foto-profile'];
    $folder = 'uploads/';

    if (isset($_FILES['foto-profile']['name']) && ($_FILES['foto-profile']['name'] != "")) {
        $newImage = $folder . $_FILES['foto-profile']['name'];
        move_uploaded_file($_FILES['foto-profile']['tmp_name'], $newImage);

        if ($oldImage != null) {
            unlink($oldImage);
        }
    } else {
        $newImage = $oldImage;
    }
    $p = $user->updateProfile($name, $email, $newImage, $alamat, $notelp, $cid);
    if ($p == true) {
        echo 'berhasil';
    } else {
        echo 'gagal';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'addPengambilan') {
    $idPengambilan = $user->validate($_POST['id-pengambilan']);
    $namaPengambilan = $user->validate($_POST['nama-pengambilan']);

    $cek = $user->addPengambilan($idPengambilan, $namaPengambilan, $cid);
    if ($cek == true) {
        echo 'berhasil';
        // $_SESSION["sukses"] = 'Data Berhasil Disimpan';
    } else {
        // $_SESSION["gagal"] = 'Tejadi Kesalahan!';
        echo 'gagal';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'addKaryawan') {
    // print_r($_POST);
    $idKaryawan = $user->validate($_POST['id-karyawan']);
    $namaKaryawan = $user->validate($_POST['nama-karyawan']);
    $emailKaryawan = $user->validate($_POST['email-karyawan']);
    $passwordKaryawan = $user->validate($_POST['kata-sandi-karyawan']);
    $roleKaryawan = 2;

    $passwordKaryawanH = password_hash($passwordKaryawan, PASSWORD_DEFAULT);
    
    echo 'berhasil';
    // $cek = $user->registerKaryawan($idKaryawan, $namaKaryawan, $emailKaryawan, $passwordKaryawanH, $roleKaryawan);

    // if ($cek == true) {
    // } else {
    //     echo 'gagal';
    // }
}

if (isset($_POST['action']) && $_POST['action'] == 'change_pass') {
    $cupass = $user->validate($_POST['cupass']);
    $npass = $user->validate($_POST['npass']);
    $cpass = $user->validate($_POST['cpass']);

    $hnpas = password_hash($npass, PASSWORD_DEFAULT);

    if ($npass != $cpass) {
        echo $user->showMessage('danger', 'Kata Sandi tidak cocok!');
        exit();
    } else {
        if (password_verify($cupass, $pass)) {
            $user->changePass($hnpas, $cid);
            echo $user->showMessage('success', 'Kata Sandi berhasil diubah');
            exit();
        } else {
            echo $user->showMessage('danger', 'Kata Sandi saat ini salah!');
            exit();
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'verify-email') {
    try {
        // formulate link
        $link = 'href="http://localhost:3000/admin/asset/php/verify-email.php?email=' . $cemail . '"';
        $link2 = '<span style="width:95%"><a style="color: #40754C; display: flex; justify-content: center; align-items: center; margin: 0, auto;"' . $link . '>Link</a></span>';

        // cofigurasi localhost
        $mail_send->isSMTP();
        $mail_send->Host = 'smtp.gmail.com';
        $mail_send->SMTPAuth = true;
        $mail_send->Username = 'tosepatu.kc@gmail.com';
        $mail_send->Password = 'keycmwufauijzziv';
        $mail_send->SMTPSecure = 'ssl';
        $mail_send->Port = 465;
        // inisialissasi format pesan email
        $to = $cemail;
        $subject = "Verifikasi Email from TOSEPATU";
        $message = "
            <p>Halo '$cemail',</p>
    
            <p>Silakan klik tautan ini untuk verifikasi email anda:</p>
            <p>$link2</p>
            <br>
            <p>Anda Untung Kami Berkah</p>
            <span>- ADMIN TOSEPATU -</span>
        ";
        // $from = "tosepatu.kc@gmail.com";
        $mail_send->setFrom('tosepatu.kc@gmail.com');
        $mail_send->addAddress($to);
        $mail_send->isHTML(true);

        $mail_send->Subject = $subject;
        $mail_send->Body = $message;
        $mail_send->send();

        // echo $user->showMessage('success', 'Link Terkirim, Check email sekarang!');
        // $_SESSION['sukses'] = 'Link Terkirim, Check email sekarang!';
        echo 'terkirim';
    } catch (Exception $e) {
        echo 'gagal';
        // $_SESSION['gagal'] = 'Terjadi Kesalahan, Gagal mengirim ke alamat email';
        // echo $user->showMessage('danger', 'Gagal mengirim ke alamat email');
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'addPesanan') {
    // $idPesanan = $user->validate($_POST['id-pesanan']);
    // $qty = $user->validate($_POST['quantity']);
    // $hargaProduk = $user->validate($_POST['harga_layanan']);

    // $subTotal = $qty * $hargaProduk;

    // $addP = $user->addPesanan($idPesanan, $cid);
    // $addD = $user->addDetailPesanan($idPesanan, $idProduk, $qty, $hargaProduk, $subTotal);
}
