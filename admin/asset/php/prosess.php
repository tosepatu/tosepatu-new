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

    // file directory
    $folder = 'uploads/';

    $namaFile = $_FILES['foto-produk']['name'];
    $ukuranFile = $_FILES['foto-produk']['size'];
    $errorFile = $_FILES['foto-produk']['error'];
    $tmpName = $_FILES['foto-produk']['tmp_name'];

    // cek gambar atau bukan
    $ektensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ektensiGambar = explode('.', $namaFile);
    $ektensiGambar = strtolower(end($ektensiGambar));
    if (!in_array($ektensiGambar, $ektensiGambarValid)) {
        echo 'gambar-tidak-valid';
        die;
    }

    // cek ukuran file
    if ($ukuranFile > 10000000) {
        echo 'terlalu-besar';
        die;
    }

    // ubah nama random
    $angkarandom = $user->generateRandomString();
    $namaFileBaru = $idProduk . '-' . date('dmy') . '-' . $angkarandom;
    $namaFileBaru .= '.';
    $namaFileBaru .= $ektensiGambar;

    // pindah file 
    $newDir = $folder . $namaFileBaru;
    move_uploaded_file($tmpName, $newDir);

    $up = $user->tambahProduk($idProduk, $namaProduk, $hargaProduk, $namaFileBaru, $cid);
    if ($up == true) {
        echo 'berhasil';
    } else {
        echo 'gagal';
    }
}

if (isset($_FILES['foto-profile'])) {
    $idProfile = $user->validate($_POST['id-profile']);
    $name = $user->validate($_POST['nama-pengguna']);
    $email = $user->validate($_POST['email-pengguna']);
    $alamat = $user->validate($_POST['alamat-pengguna']);
    $notelp = $user->validate($_POST['no_telp-pengguna']);
    $oldImage = $user->validate($_POST['old-foto-profile']);

    $folder = 'uploads/';

    // cek user mengganti gambar atau tidak
    if ($_FILES['foto-profile']['error'] != 0) {
        $gambar = $oldImage;

        $p = $user->updateProfile($name, $email, $gambar, $alamat, $notelp, $cid);
        if ($p == true) {
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
        die;
    } else {
        $namaFile = $_FILES['foto-profile']['name'];
        $ukuranFile = $_FILES['foto-profile']['size'];
        $errorFile = $_FILES['foto-profile']['error'];
        $tmpName = $_FILES['foto-profile']['tmp_name'];

        // cek gambar atau bukan
        $ektensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ektensiGambar = explode('.', $namaFile);
        $ektensiGambar = strtolower(end($ektensiGambar));
        if (!in_array($ektensiGambar, $ektensiGambarValid)) {
            echo 'gambar-tidak-valid';
            die;
        }

        // cek ukuran file
        if ($ukuranFile > 10000000) {
            echo 'terlalu-besar';
            die;
        }

        // ubah nama random
        $angkarandom = $user->generateRandomString();
        $namaFileBaru = $idProfile . '-' . date("dmy") . '-' . $angkarandom;
        $namaFileBaru .= '.';
        $namaFileBaru .= $ektensiGambar;

        // pindah file 
        $newDir = $folder . $namaFileBaru;
        move_uploaded_file($tmpName, $newDir);

        // hapus directory
        if ($oldImage != null) {
            unlink($folder . $oldImage);
        }

        $p = $user->updateProfile($name, $email, $namaFileBaru, $alamat, $notelp, $cid);
        if ($p == true) {
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
    }
}

if (isset($_FILES['foto-produk-e'])) {
    $namaProduk = $user->validate($_POST['nama-produk']);
    $hargaProduk = $user->validate($_POST['harga-produk']);
    $idProduk = $user->validate($_POST['id-produk']);
    $oldImage = $user->validate($_POST['old-foto-produk']);

    $folder = 'uploads/';

    // cek user mengganti gambar atau tidak
    if ($_FILES['foto-produk-e']['error'] != 0) {
        $gambar = $oldImage;

        $p = $user->updateProduk($namaProduk, $hargaProduk, $gambar, $cid, $idProduk);
        if ($p == true) {
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
        die;
    } else {
        $namaFile = $_FILES['foto-produk-e']['name'];
        $ukuranFile = $_FILES['foto-produk-e']['size'];
        $errorFile = $_FILES['foto-produk-e']['error'];
        $tmpName = $_FILES['foto-produk-e']['tmp_name'];

        // cek gambar atau bukan
        $ektensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ektensiGambar = explode('.', $namaFile);
        $ektensiGambar = strtolower(end($ektensiGambar));
        if (!in_array($ektensiGambar, $ektensiGambarValid)) {
            echo 'gambar-tidak-valid';
            die;
        }

        // cek ukuran file
        if ($ukuranFile > 10000000) {
            echo 'terlalu-besar';
            die;
        }

        // ubah nama random
        $angkarandom = $user->generateRandomString();
        $namaFileBaru = $idProduk . '-' . date("dmy") . '-' . $angkarandom;
        $namaFileBaru .= '.';
        $namaFileBaru .= $ektensiGambar;

        // pindah file 
        $newDir = $folder . $namaFileBaru;
        move_uploaded_file($tmpName, $newDir);

        // hapus directory
        if ($oldImage != null) {
            unlink($folder . $oldImage);
        }

        $p = $user->updateProduk($namaProduk, $hargaProduk, $namaFileBaru, $cid, $idProduk);
        if ($p == true) {
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
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

    if ($user->user_exist($emailKaryawan)) {
        echo 'exist';
    } else {
        $cek = $user->registerKaryawan($idKaryawan, $namaKaryawan, $emailKaryawan, $passwordKaryawanH, $roleKaryawan);

        if ($cek == true) {
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
    }
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

// buat pesanan
if (isset($_POST['addPesanan_id'])) {
    $id = $_POST['addPesanan_id'];
    $idPengambilan = 'MT220921002';

    $p = $user->addPesanan($id, $idPengambilan, $cid);
    if ($p == true) {
        echo 'berhasil';
    } else {
        echo 'gagal';
    }
}

// add detail pesanan
if (isset($_POST['add_pilih_produk'])) {
    $idProduk = $user->validate($_POST['add_pilih_produk']);

    $hargaProduk = $user->fetchAllProdukByID($idProduk);
    $price = $hargaProduk['harga_layanan'];

    // nilai sementara
    $qty = 1;
    $subTotal = $price * $qty;

    // cek id pesanan sama atau tidak
    $search = $user->fetchPesananByUID($cid);
    $idPesanan = $search['id_pesanan'];
    
    // cek status pesanan masih belum di proses atau sudah
    $searchPesanan = $user->fetchAllPesananByID($idPesanan);
    $uid = $searchPesanan['status_pesanan'];
    
    // cek produk apakah sudah ditambahkan pada detail pesanan
    $cekPesanan = $user->fetchDetailPesanan($idPesanan, $idProduk);
    
    if ($cekPesanan > 0) {
        echo 'already';
    } else {
        if ($idPesanan && $uid != null) {
            $data = $user->addDetailPesanan($idPesanan, $idProduk, $qty, $price, $subTotal);
            echo 'berhasil';
        } else {
            echo 'tidak sama';
        }
    }
    
    // $set = $user->setData($idPesanan);
    // $get = $user->getData();
    // $user = $this->getData();
    // var_dump($iuidPesanan);
    // $idPesanan = $_GET['id_pesanan'];
    // echo $idProduk;
    // echo $namaProduk;
    // echo $hargaProduk;
    // $data = $user->fetchAllProdukByName($namaProduk);
    // echo $data['id_layanan'];

    // $idPesanan = $user->validate($_POST['id-pesanan']);
    // $idPesanan = $_SESSION[''];
    
    // $idPengambilan = 'MT220921002';
    
    // $subTotal = $hargaProduk * $qty;
    // // echo $subTotal;
    
    // } else {
    //     $d = $user->addDetailPesanan($idPesanan, $idProduk, $qty, $hargaProduk, $subTotal);
    //     if ($d == true) {
    //         echo 'berhasil';
    //     } else {
    //         echo 'gagal';
    //     }
    // }
}

// if (isset($_POST['action']) && $_POST['action'] == 'addPesanan') {
    // print_r($_POST);
    // $idPesanan = $user->idPesananIncrement();
    // $idProduk = $user->validate($_POST['id-produk']);
    // $namaProduk = $user->validate($_POST['nama-produk']);
    // $hargaProduk = $user->validate($_POST['harga-produk']);
    // $qty = 1;
    // $subTotal = $hargaProduk * $qty;

    // $cekPesanan = $user->fetchDetailPesanan($idProduk);
    // if ($cekPesanan == true) {
    //     echo 'already';
    //     // $message = 'produk sudah ditambahkan';
    // } else {
    //     $p = $user->addPesanan($idPesanan);
    //     $d = $user->addDetailPesanan($idPesanan, $idProduk, $qty, $hargaProduk, $subTotal);
    //     $message = 'produk berhasil ditambahkan';
    // }
// }
