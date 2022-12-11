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

// all tim 
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllPelanggan') {
    $output = '';
    $data = $user->fetchAllPelanggan(3);
    $path = '../asset/php/';

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
                                    <a href="#popupDetail" id="' . $row['id_akun'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-circle-info view"></i></a>&nbsp;&nbsp;
                                    
                                    <div id="popupDetail" class="overlay">
                                        <div class="popup">
                                            <h2 id="getName">' . $row['username'] . '</h2>
                                            <h2 id="getId">' . $row['id_akun'] . '</h2>
                                            <a class="close" href="pelanggan.php">&times;</a>
                                            <div class="rec-data">
                                                <div class="rec-data-body">
                                                    <p id="getEmail">E-mail : ' . $row['email'] . '</p>
                                                    <p id="getPhone">No. Telepon : ' . $row['no_telp'] . '</p>
                                                    <p id="getAlamat">Alamat : ' . $row['alamat'] . '</p>
                                                    <p id="getCreated">Terdaftar Pada Tanggal : ' . $reg_on . '</p>
                                                    <p id="getVerified">Verifikasi Akun : ' . $row['verified'] . '</p>
                                                </div>
                                                <div class="rec-data-photos">
                                                    <img src="' . $ufoto . ' " class="imageDetail"">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
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
    $path = '../asset/php/';

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
                                <td><i class="fa-solid fa-pen-to-square"></i><i class="fa-solid fa-trash delete"></i></td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'WRong';
    }
}

// if (isset($_POST['action']) && $_POST['action'] == 'showOption') {
//     $adm = $user->fetchAllRole();
//     $output = '';

//     if ($adm) {
//         $output .= '<select> 
//                         <option>--- Pilih Role ---</option>';
//         // foreach ($adm as $row) {
//             // while ($row <= $adm) {
                
//             //     $output .= '<option value="' . $row['nama_role'] . '">Admin</option>';
//             // }
//             // $output .= '<option id="' . $row['nama_role'] . '">Karyawan</option>';
//         // }
//         $output .= '</select>';
//         echo $output;
//     } else {
//         echo 'wrong';
//     }
// }
// coba
// if (isset($_POST['action']) && $_POST['action'] == 'pilihProduk') {
//     $output = '';
//     $data = $user->fetchAllProduk();
//     $path = '../asset/php/';

//     if ($data) {
//         $output .= '<form action="" method="POST">';
//         foreach ($data as $row) {
//             if ($row['foto_layanan'] != '') {
//                 $ufoto = $path . $row['foto_layanan'];
//             } else {
//                 $ufoto = '../asset/img/avatarr.png';
//             }
//             $output .= '<div class="box">
//                                     <img src="' . $ufoto . '">
//                                     <h3>' . $row['nama_layanan'] . '</h3>
//                                     <div class="price">' . $row['harga_layanan'] . '</div>
//                                     <input type="submit" name="pilihan-produk" id="pilihan-produk" value="Pilih">
//                                 </div>';
//         }
//         $output .= '</form>';
//         echo $output;
//     } else {
//         echo 'Wrong';
//     }
// }

// all tim 
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllUser') {
    $output = '';
    $data = $user->fetchAllTim();
    $path = '../asset/php/';

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
                                    <a href="#popupDetail" id="' . $row['id_akun'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-circle-info view"></i></a>&nbsp;&nbsp;
                                    
                                    <div id="popupDetail" class="overlay">
                                        <div class="popup">
                                            <h2 id="getName">' . $row['username'] . '</h2>
                                            <h2 id="getId">' . $row['id_akun'] . '</h2>
                                            <a class="close" href="kelola tim.php">&times;</a>
                                            <div class="rec-data">
                                                <div class="rec-data-body">
                                                    <p id="getEmail">E-mail : ' . $row['email'] . '</p>
                                                    <p id="getPhone">No. Telepon : ' . $row['no_telp'] . '</p>
                                                    <p id="getAlamat">Alamat : ' . $row['alamat'] . '</p>
                                                    <p id="getCreated">Terdaftar Pada Tanggal : ' . $reg_on . '</p>
                                                    <p id="getVerified">Verifikasi Akun : ' . $row['verified'] . '</p>
                                                </div>
                                                <div class="rec-data-photos">
                                                    <img src="' . $ufoto . ' " class="imageDetail"">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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

// handle display user detail 
// if (isset($_POST['details_id'])) {
//     $id = $_POST['details_id'];

//     $data = $user->fetchAllUserByID($id);

//     echo json_encode($data);
// }
