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

    $cekPesanan = $user->fetchPesananBystatus();
    $cek = $user->fetchPesananByUID($cid);
    // echo $cek;
    if ($cek < 1 && $cekPesanan < 1) {
        $p = $user->addPesanan($id, $idPengambilan, $cid);
        if ($p == true) {
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
    } else {
        // var_dump($cek['id_pesanan']);
        echo 'memiliki pesanan yang belum selesai';
    }
}

// lanjutkan pesanan yang belum terselesaikan
if (isset($_POST['action']) && $_POST['action'] == 'addPesanan_id_') {
    // $id = $_POST['addPesanan_id_'];

    // echo $id;
    $cekPesanan = $user->fetchPesananBystatus();
    $dataa = $user->fetchPesananByUID($cid);
    if ($cekPesanan != null) {
        echo $cekPesanan['id_pesanan'];
    } else {
        echo $dataa['id_pesanan'];
    }
    // echo json_encode($data);
}

if (isset($_POST['add_pilih_pelanggan'])) {
    $id = $_POST['add_pilih_pelanggan'];

    // cek data pelanggan 
    $cek = $user->fetchAllPelangganByID($id);
    $idPelanggan = $cek[0]['id_user'];

    // cek pesanan pelanggan
    $cekPesananPelanggan = $user->fetchPesananByUID_USER($idPelanggan);
    
    // cek status
    $cekStatus = $user->fetchPesananBystatus();
    $idPesanan = $cekStatus['id_pesanan'];
    $idPelangganSudahDipilih = $cekStatus['uid_user'];
    
    // echo $cekPesananPelanggan['uid_akun'];
    if ($idPelangganSudahDipilih != null) {
        if ($idPelangganSudahDipilih != $idPelanggan) {
            $set = $user->upPesananNamaPelanggan($idPelanggan, $idPesanan);
            if ($set == true) {
                echo 'pelanggan diubah';
            } else {
                echo 'gagal';
            }
        } else {
            echo 'pelanggan sudah ditambahkan';
        }
    } else {
        $set = $user->upPesananNamaPelanggan($idPelanggan, $idPesanan);
        if ($set == true) {
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
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

    // cek status
    $cekStatus = $user->fetchPesananBystatus();
    $idPesanan = $cekStatus['id_pesanan'];

    // cek id pesanan jika belum piilih pelanggan
    // $search = $user->fetchPesananByUID_USER($cid);
    // $idPesanan = $search['id_pesanan'];
    $search = $user->fetchAllPesananByID($idPesanan);
    $cekPelanggan = $search['uid_user'];

    // cek kondisi
    if ($cekPelanggan != null) {
        // cek status pesanan masih belum di proses atau sudah
        $searchPesanan = $user->fetchAllPesananByID($idPesanan);
        $uid = $searchPesanan['status_pesanan'];

        // // cek produk apakah sudah ditambahkan pada detail pesanan
        $cekPesanan = $user->fetchDetailPesanan($idPesanan, $idProduk);
        // echo $cekPesanan;

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
    } else {
        echo 'masukkan pelanggan';
    }
}


// if (isset($_POST['editQTY_id'])) {
if (isset($_POST['hapus_id'])) {
    $idProduk = $user->validate($_POST['hapus_id']);

    $search = $user->fetchAllDetailPesananByIDLayanan($idProduk);
    foreach ($search as $row) {
        $idPesanan = $row['uid_pesanan'];
    }
    
    $searchPesanan = $user->fetchAllPesananByID($idPesanan);
    foreach ($searchPesanan as $key) {
        $idPesananCek = $searchPesanan['id_pesanan'];
        $cekStatus = $searchPesanan['status_pesanan'];
    }
    // // // var_dump($search[0]['uid_layanan']);
    // // $idProduk = $search[0]['uid_layanan'];
    // $cekProdukPilihan = $user->cekDetailPesanan($idPesanan);
    // // echo $cekProdukPilihan;
    // // if ($search[]) {
    // //     # code...
    // // } else {
    // //     # code...
    // // }
    // if ($cekProdukPilihan > 1) {
    //     echo 'lebih dari satu';
    // } else {
        if ($idPesanan == $idPesananCek) {
            // cek status
            if ($cekStatus == 'Menunggu Konfirmasi') {
                $del = $user->delProdukPilihan($idProduk, $idPesanan);
                if ($del == true) {
                    echo 'berhasil';
                } else {
                    echo 'gagal';
                }
            } else {
                echo 'tidak sama';
            }
        } else {
            echo 'refresh halaman, dan silahkan coba lagi';
        }
    // }
    
    // echo $id;
    // echo $idPesanan;
    // echo $idPesananCek;
    // // $search = $user->fetchPesananByUID($cid);
    // // $idPesanan = $search['id_pesanan'];

    // // $uid = $searchPesanan['status_pesanan'];


    // if ($setQuery == true) {
    //     // header('location: buat-pesanan.php?id_pesanan=' . $id . '');
    //     echo 'berhasil';
    // } else {
    //     echo 'wrong';
    // }

    // echo $id;
    // echo $uid;
    // echo $idPesanan;
    // echo $update_id;
    // echo $update_value;
} 

// if (isset($_POST['editQTY_id'])) {
if (isset($_POST['action']) && $_POST['action'] == 'editQTY_id') {
    $qty = $_POST['qty_update_new'];
    $id = $_POST['qty_update_id'];
    $idLayanan = $_POST['qty_update_id_layanan'];
    $price = $_POST['qty_update_price_layanan'];
    $subTotal = $qty * $price;

    // echo $qty;
    // echo $id;
    // echo $idLayanan;
    // echo $idProduk[0]['uid_layanan'];
    
    $setQuery = $user->upQtyPilihanProduk($qty, $subTotal, $id, $idLayanan);
    if ($setQuery == true) {
        echo 'berhasil';
    } else {
        echo 'gagal';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'checkout') {
    // print_r($_POST);
    // $idPesanan = $user->idPesananIncrement();
    if (empty($_POST['Metode-select']) && empty($_POST['karyawan-select'])) {
        echo 'metode dan kurir belum diisi';
        die;
    } else if (empty($_POST['Metode-select'])) {
        echo 'metode belum diisi';
        die;
    } elseif (empty($_POST['karyawan-select'])) {
        echo 'karyawan belum diisi';
        die;
    } elseif (empty($_POST['alamat-pelanggan'])) {
        echo 'alamat belum diisi';
        die;
    } else {
        $idPesanan = $user->validate($_POST['id-pesanan']);
        $catatan = $user->validate($_POST['catatan-pesanan']);
        $metode = $user->validate($_POST['Metode-select']);
        $alamat = $user->validate($_POST['alamat-pelanggan']);
        $kurir = $user->validate($_POST['karyawan-select']);
        $grandTotal = $user->validate($_POST['grandtotal']);
        
        // $cek = $user->fetchAllTim($kurir);
        // $noKaryawan = $cek['i'];

        $set = $user->checkoutPesanan($catatan, $metode, $kurir, $grandTotal, $alamat, $idPesanan);
        if ($set == true) {
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
    } 
    
    // if ($metode == '' &&  $kurir == '') {
    //     echo 'metode dan kurir belum diisi';
    // // } elseif (condition) {
    // //     # code...
    // }
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
}

if (isset($_POST['upStatusPesanan_selesai'])) {
    $id = $_POST['upStatusPesanan_selesai'];
    
    $updateStatus = $user->upPesananSelesai($id);
}

if (isset($_POST['upStatusPesanan_batalkan'])) {
    $id = $_POST['upStatusPesanan_batalkan'];
    
    $updateStatus = $user->upPesananBatal($id);
}

if (isset($_POST['konfirmasi_pesanan'])) {
    $id = $_POST['konfirmasi_pesanan'];
    
    $updateStatus = $user->upPesananProses($id);
}
