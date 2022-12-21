<?php
session_start();

require_once 'auth.php';
$user = new Auth();

// Handle login request 
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $user->validate($_POST['email']);
    $pass = $user->validate($_POST['password']);

    if (empty($email) && empty($pass)) {
        echo $user->showMessage('danger', 'Email dan Kata Sandi wajib diisi');
        // header("Location: ../../page/login.php?error=Email dan Kata Sandi wajib diisi");
        exit();
    } else if (empty($email)) {
        echo $user->showMessage('danger', 'Email wajib diisi');
        // header("Location: ../../page/login.php?error=Email wajib diisi");
        exit();
    } else if (empty($pass)) {
        echo $user->showMessage('danger', 'Kata Sandi wajib diisi');
        // header("Location: ../../page/login.php?error=Kata Sandi wajib diisi&email=$email");
        exit();
    } else {
        $loginUser1 = $user->login($email);
        $loginUser2 = $user->loginK($email);
        if ($loginUser1 != null) {
            if (password_verify($pass, $loginUser1['password'])) {
                echo 'loginAdmin';
                $_SESSION['userAdmin'] = $email;
            } else {
                echo $user->showMessage('danger', 'Kata sandi salah');
            }
        } else if ($loginUser2 != null) {
            if (password_verify($pass, $loginUser2['password'])) {
                echo 'loginUser';
                $_SESSION['userKaryawan'] = $email;
            } else {
                echo $user->showMessage('danger', 'Kata sandi salah');
            }
        } else {
            echo $user->showMessage('danger', 'Silahkan masuk melalui aplikasi mobile di Play Store');
        }
    }
}

// all pelanggan 
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllPelanggan') {
    $output = '';
    $data = $user->fetchAllPelanggan(3);
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="5%">Foto Pelanggan</th>
                                <th width="15%">ID Pelanggan</th>
                                <th width="20%">Nama Pelanggan</th>
                                <th width="20%">Email</th>
                                <th width="20%">Alamat</th>
                                <th width="10%">No. Telepon</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>';
        foreach ($data as $row) {
            if ($row['foto'] != '') {
                $ufoto = $path . $row['foto'];
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            if ($row['verified'] == 0) {
                $row['verified'] = 'Belum Verifikasi';
            } else {
                $row['verified'] = 'Sudah Verifikasi';
            }
            $ccreated = $row['created_at'];
            $reg_on = date('d M Y', strtotime($ccreated));

            $output .= '<tbody>
                            <tr>
                                <td><img src="' . $ufoto . '"></td>
                                <td>' . $row['id_akun'] . '</td>
                                <td>' . $row['username'] . '</td>
                                <td>' . $row['email'] . '</td>
                                <td>' . $row['alamat'] . '</td>
                                <td>' . $row['no_telp'] . '</td>
                                <td>
                                    <a href="view-pelanggan.php?id_akun=' . $row['id_akun'] . '" id="' . $row['id_akun'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-circle-info view"></i></a>&nbsp;&nbsp;
                                    
                                
                                    <a href="#" id="' . $row['id_akun'] . '" title="Hapus Pengguna" class="hapusUserIcon"><i class="fa-solid fa-trash delete"></i></a>&nbsp;&nbsp;
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'WRong';
    }
}

// all produk
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllProdukk') {
    $output = '';
    $data = $user->fetchAllProduk();
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="5%">Foto Produk</th>
                                <th width="20%">ID Produk</th>
                                <th width="35%">Nama Produk</th>
                                <th width="25%">Harga</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            if ($row['foto_layanan'] != '') {
                $ufoto = $path . $row['foto_layanan'];
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            $output .= '<tr>
                                <td><img src="' . $ufoto . '"></td>
                                <td>' . $row['id_layanan'] . '</td>
                                <td>' . $row['nama_layanan'] . '</td>
                                <td>' . $row['harga_layanan'] . '</td>
                                <td>
                                <a href="edit-produk.php?id_layanan=' . $row['id_layanan'] . '" id="' . $row['id_layanan'] . '" title="Edit Produk" class="editProdukIcon"><i class="fa-solid fa-pen-to-square edit"></i></a>&nbsp;&nbsp;
                                
                                <a href="#" id="' . $row['id_layanan'] . '" title="Hapus Produk" class="deleteProdukIcon"><i class="fa-solid fa-trash delete"></i></a>&nbsp;&nbsp;
                                
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'WRong';
    }
}

// show semua pesanan
if (isset($_POST['action']) && $_POST['action'] == 'showAllPesanan') {
    $output = '';
    $data = $user->fetchAllPesanan();
    
    
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th >ID Pesanan</th>
                                <th >Metode Pengiriman</th>
                                <th >Nama Pelanggan</th>
                                <th >Catatan</th>
                                <th >Total Keseluruhan</th>
                                <th >Tanggal Pesanan</th>
                                <th >Estimasi Pengiriman</th>
                                <th >Status Pesanan</th>
                                <th >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            $mt = $user->fetchAllMetodePengambilanByID($row['uid_pengiriman']);
            $metode = $mt['nama_pengiriman'];
            $output .= '<tr>
                                <td>' . $row['id_pesanan'] . '</td>
                                <td>' . $metode . '</td>
                                <td>' . $row['uid_akun'] . '</td>
                                <td>' . $row['catatan'] . '</td>
                                <td>' . $row['grand_total'] . '</td>
                                <td>' . $row['tanggal_masuk'] . '</td>
                                <td>' . $row['tanggal_selesai'] . '</td>
                                <td>' . $row['status_pesanan'] . '</td>
                                <td>
                                    <form action="" method="post" id="form-pilih-produk">
                                    </form>
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'WRong';
    }
}

// pilih produk2
if (isset($_POST['action']) && $_POST['action'] == 'pilihProduk') {
    $output = '';
    $data = $user->fetchAllProduk();
    $path = '../asset/php/uploads/';

    if ($data) {
        $output = '<div class="box-produk">';
        foreach ($data as $row) {
            if ($row['foto_layanan'] != '') {
                $ufoto = $path . $row['foto_layanan'];
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            $output .= '<form action="" method="post" id="form-pilih-produk">
                                <div class="box">            
                                    <img src="' . $ufoto . '" height="250px">
                                    <h3>' . $row['nama_layanan'] . '</h3>
                                    <div class="price">' . $row['harga_layanan'] . '</div>
                                    <input type="hidden" name="id-produk" value="' . $row['id_layanan'] . '">
                                    <input type="hidden" name="nama-produk" value="' . $row['nama_layanan'] . '">
                                    <input type="hidden" name="harga-produk" value="' . $row['harga_layanan'] . '">
                                    <input type="submit" name="update_qty_btn" value="Pilih Produk" id="' . $row['id_layanan'] . '" class="addPesanan">
                                </div>
                            </form>';
        }
        $output .= '</div>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Produk tidak ditemukan</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// all tim 
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllUser') {
    $output = '';
    $data = $user->fetchAllTim(2);
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table id="table_id">
                        <thead>
                            <tr>
                                <th width="5%">Foto Karyawan</th>
                                <th width="15%">Id Karyawan</th>
                                <th width="20%">Nama Karyawan</th>
                                <th width="20%">Email</th>
                                <th width="20%">Alamat</th>
                                <th width="10%">No. Telepon</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>';
        foreach ($data as $row) {
            if ($row['foto'] != '') {
                $ufoto = $path . $row['foto'];
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            if ($row['verified'] == 0) {
                $row['verified'] = 'Belum Verifikasi';
            } else {
                $row['verified'] = 'Sudah Verifikasi';
            }
            $ccreated = $row['created_at'];
            $reg_on = date('d M Y', strtotime($ccreated));

            $output .= '<tbody>
                            <tr>
                                <td><img src="' . $ufoto . '"></td>
                                <td>' . $row['id_akun'] . '</td>
                                <td>' . $row['username'] . '</td>
                                <td>' . $row['email'] . '</td>
                                <td>' . $row['alamat'] . '</td>
                                <td>' . $row['no_telp'] . '</td>
                                <td>
                                    <a href="view.php?id_akun=' . $row['id_akun'] . '" id="' . $row['id_akun'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-circle-info view"></i></a>&nbsp;&nbsp;

                                    <a href="#" id="' . $row['id_akun'] . '" title="Hapus Pengguna" class="hapusUserIcon"><i class="fa-solid fa-trash delete"></i></a>&nbsp;&nbsp;
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'WRong';
    }
}

// delet user
if (isset($_POST['del_id'])) {
    $id = $_POST['del_id'];
    // echo $id;
    $data = $user->delUser($id, 0);

    // echo json_encode($data);
}

// delet produk
if (isset($_POST['delP_id'])) {
    $id = $_POST['delP_id'];
    $data = $user->fetchAllProduk();
    foreach ($data as $row) {
        $oldImage = $row['foto_layanan'];
    }
    $folder = 'uploads/';
    unlink($folder . $oldImage);
    $data = $user->delproduk($id);

    // echo json_encode($data);
}

// batal buat pesanan
if (isset($_POST['delBP_id'])) {
    $id = $_POST['delBP_id'];

    // echo $id;
    $dataa = $user->batalPesanan($id);

    // echo json_encode($data);
}

// cek kondisi
if (isset($_POST['add_pilih_produk'])) {
    $id = $_POST['add_pilih_produk'];

    // echo $id;
    $dataa = $user->batalPesanan($id);

    // echo json_encode($data);
}

if (isset($_POST['action']) && $_POST['action'] == 'fetchAllPelangganPesanan') {
    $output = '';
    $data = $user->fetchAllPelanggan(3);
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table class="cari-pelanggan">';
        foreach ($data as $row) {
            if ($row['foto'] != '') {
                $ufoto = $path . $row['foto'];
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            $output .= '<tbody style="border-top: 1px solid #ddd;">
                            <tr>
                                <td width="10%"><img src="' . $ufoto . '"></td>
                                <td width="80%" class="tage">' . $row['username'] . '<br>' . $row['no_telp'] . '</td>
                                <td width="10%">
                                    <a href="" id="' . $row['id_akun'] . '" title="Pilih Pelanggan" class="PelaangganConfirmIcon"><i class="fa-regular fa-square-check cek"></i></a>&nbsp;&nbsp;
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'Tidak Ditemukan';
    }
}

// pilih pelanggan
if (isset($_POST['search'])) {
    $keyword = $_POST['search'];
    $data = $user->search($keyword);
    $output = '';
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table class="cari-pelanggan">';
        foreach ($data as $row) {
            if ($row['foto'] != '') {
                $ufoto = $path . $row['foto'];
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            $output .= '<tbody style="border-top: 1px solid #ddd;">
                                <tr>
                                    <td width="10%"><img src="' . $ufoto . '"></td>
                                    <td width="80%" class="tage">' . $row['username'] . '<br>' . $row['no_telp'] . '</td>
                                    <td width="10%">
                                        <a href="" id="' . $row['id_akun'] . '" onclick="post_value(' . $row['username'] . ')" title="Pilih Pelanggan" class="PelangganConfirmIcon"><i class="fa-regular fa-square-check cek"></i></a>&nbsp;&nbsp;
                                    </td>
                                </tr>
                            </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table class="cari-pelanggan">';
        $output .= '<tbody style="border-top: 1px solid #ddd;">
                            <tr>
                                <td><a href="">Tambah Pelanggan</a></td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// pilih produk
if (isset($_POST['searchProduk'])) {
    $keyword = $_POST['searchProduk'];
    $data = $user->searchProduk($keyword);
    $output = '';
    $path = '../asset/php/uploads/';

    if ($data) {
        $output = '<div class="box-produk">';
        foreach ($data as $row) {
            if ($row['foto_layanan'] != '') {
                $ufoto = $path . $row['foto_layanan'];
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            $output .= '<form action="" method="post" id="form-pilih-produk">
                                <div class="box">            
                                    <img src="' . $ufoto . '" height="250px">
                                    <h3>' . $row['nama_layanan'] . '</h3>
                                    <div class="price">' . $row['harga_layanan'] . '</div>
                                    <input type="hidden" name="nama-produk" value="' . $row['nama_layanan'] . '">
                                    <input type="hidden" name="harga-produk" value="' . $row['harga_layanan'] . '">
                                    <input type="submit" name="update_qty_btn" value="Pilih Produk" id="addPesananProduk" class="addPesanan">
                                </div>
                            </form>';
        }
        $output .= '</div>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Produk tidak ditemukan</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// handle display user detail 
// if (isset($_POST['details_id'])) {
//     $id = $_POST['details_id'];
//     // $idPesanan = $user->validate($_POST['id_pesanan']);

//     // $data = $user->upPesananNamaPelanggan($id, $idPesanan);

//     echo $id;
//     // echo json_encode($data);
// }
