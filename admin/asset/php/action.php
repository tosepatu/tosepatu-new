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
    $data = $user->fetchAllPelanggan();
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="5%">Foto Pelanggan</th>
                                <th width="20%">ID Pelanggan</th>
                                <th width="35%">Nama Pelanggan</th>
                                <th width="30%">No. Telepon</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>';
        foreach ($data as $row) {
            // if ($row['foto'] != '') {
            //     $ufoto = $path . $row['foto'];
            // } else {
            $ufoto = '../asset/img/avatarr.png';
            // }
            // if ($row['verified'] == 0) {
            //     $row['verified'] = 'Belum Verifikasi';
            // } else {
            //     $row['verified'] = 'Sudah Verifikasi';
            // }
            // $ccreated = $row['created_at'];
            // $reg_on = date('d M Y', strtotime($ccreated));

            $output .= '<tbody>
                            <tr>
                                <td><img src="' . $ufoto . '"></td>
                                <td>' . $row['id_user'] . '</td>
                                <td>' . $row['username_user'] . '</td>
                                <td>' . $row['no_telp_user'] . '</td>
                                <td>
                                    <a href="view-pelanggan.php?id_akun=' . $row['id_user'] . '" id="' . $row['id_user'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-circle-info view"></i></a>&nbsp;&nbsp;
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada data pelanggan</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// search all pelanggan 
if (isset($_POST['searchPelanggan'])) {
    $output = '';
    $keyword = $_POST['searchPelanggan'];
    $data = $user->searchPelanggan($keyword);
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="5%">Foto Pelanggan</th>
                                <th width="20%">ID Pelanggan</th>
                                <th width="35%">Nama Pelanggan</th>
                                <th width="30%">No. Telepon</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>';
        foreach ($data as $row) {
            // if ($row['foto'] != '') {
            //     $ufoto = $path . $row['foto'];
            // } else {
            $ufoto = '../asset/img/avatarr.png';
            // }
            // if ($row['verified'] == 0) {
            //     $row['verified'] = 'Belum Verifikasi';
            // } else {
            //     $row['verified'] = 'Sudah Verifikasi';
            // }
            // $ccreated = $row['created_at'];
            // $reg_on = date('d M Y', strtotime($ccreated));

            $output .= '<tbody>
                            <tr>
                                <td><img src="' . $ufoto . '"></td>
                                <td>' . $row['id_user'] . '</td>
                                <td>' . $row['username_user'] . '</td>
                                <td>' . $row['no_telp_user'] . '</td>
                                <td>
                                    <a href="view-pelanggan.php?id_akun=' . $row['id_user'] . '" id="' . $row['id_user'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-circle-info view"></i></a>&nbsp;&nbsp;
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada data pelanggan</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
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
                                <td>Rp. ' . number_format($row['harga_layanan']) . '</td>
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
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada data produk</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// search all produk
if (isset($_POST['searchProdukk'])) {
    $output = '';
    $keyword = $_POST['searchProdukk'];
    $data = $user->searchProduk($keyword);
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
                                <td>Rp. ' . number_format($row['harga_layanan']) . '</td>
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
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada data produk</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// show pesanan baru
if (isset($_POST['action']) && $_POST['action'] == 'showPesananBaru') {
    $output = '';
    $data = $user->fetchPesananBaru();


    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="10%">ID Pesanan</th>
                                <th width="15%">Metode Pengiriman</th>
                                <th width="20%">Nama Pelanggan</th>
                                <th width="10%">Total Keseluruhan</th>
                                <th width="15%">Tanggal Pesanan</th>
                                <th width="15%">Estimasi Pengiriman</th>
                                <th width="10%">Status Pesanan</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            $mt = $user->fetchAllMetodePengambilanByID($row['uid_pengiriman']);
            $metode = $mt['nama_pengiriman'];

            $namaPelanggan = $user->fetchAllPelangganByID($row['uid_user']);
            if ($namaPelanggan != null) {
                $formatNamaPelanggan = $namaPelanggan[0]['username_user'];
            } else {
                $formatNamaPelanggan = 'Belum Memasukkan Nama Pelanggan';
            }

            $pesananMasuk = $row['tanggal_masuk'];
            $estimasi = $row['tanggal_selesai'];
            $formatPesananMasuk = date('d M Y', strtotime($pesananMasuk));
            $formatEstimasi = date('d M Y', strtotime($estimasi));

            $konfirmasi = $row['status_pesanan'] == "Menunggu Konfirmasi";
            $konfirmasi = 'Konfirmasi';
            $output .= '<tr>
                                <td>' . $row['id_pesanan'] . '</td>
                                <td>' . $metode . '</td>
                                <td>' . $formatNamaPelanggan . '</td>
                                <td>Rp. ' . number_format($row['grand_total']) . '</td>
                                <td>' . $formatPesananMasuk . '</td>
                                <td>' . $formatEstimasi . '</td>
                                <td class="status-now">
                                    <a href="edit-status-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" class="status-pesanan-konfirmasi">
                                        ' . $konfirmasi . '
                                    </a>
                                </td>
                                <td>
                                <a href="view-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" id="' . $row['id_pesanan'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-ellipsis-vertical dot"></i></a>&nbsp;&nbsp;
                                    <form action="" method="post" id="form-pilih-produk">
                                    </form>
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada pesanan baru</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// show pesanan proses
if (isset($_POST['action']) && $_POST['action'] == 'showPesananProses') {
    $output = '';
    $data = $user->fetchPesananProses();


    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="10%">ID Pesanan</th>
                                <th width="15%">Metode Pengiriman</th>
                                <th width="20%">Nama Pelanggan</th>
                                <th width="10%">Total Keseluruhan</th>
                                <th width="15%">Tanggal Pesanan</th>
                                <th width="15%">Estimasi Pengiriman</th>
                                <th width="10%">Status Pesanan</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            $mt = $user->fetchAllMetodePengambilanByID($row['uid_pengiriman']);
            $metode = $mt['nama_pengiriman'];

            $namaPelanggan = $user->fetchAllPelangganByID($row['uid_user']);
            $formatNamaPelanggan = $namaPelanggan[0]['username_user'];

            $pesananMasuk = $row['tanggal_masuk'];
            $estimasi = $row['tanggal_selesai'];
            $formatPesananMasuk = date('d M Y', strtotime($pesananMasuk));
            $formatEstimasi = date('d M Y', strtotime($estimasi));
            $output .= '<tr>
                                <td>' . $row['id_pesanan'] . '</td>
                                <td>' . $metode . '</td>
                                <td>' . $formatNamaPelanggan . '</td>
                                <td>Rp. ' . number_format($row['grand_total']) . '</td>
                                <td>' . $formatPesananMasuk . '</td>
                                <td>' . $formatEstimasi . '</td>
                                <td class="status-now">
                                    <a href="" class="status-pesanan-proses">
                                        ' . $row['status_pesanan'] . '
                                    </a>
                                </td>
                                <td>
                                <a href="view-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" id="' . $row['id_pesanan'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-ellipsis-vertical dot"></i></a>&nbsp;&nbsp;
                                    <form action="" method="post" id="form-pilih-produk">
                                    </form>
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada pesanan diproses</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// show pesanan selesai
if (isset($_POST['action']) && $_POST['action'] == 'showPesananSelesai') {
    $output = '';
    $data = $user->fetchPesananSelesai();


    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="10%">ID Pesanan</th>
                                <th width="15%">Metode Pengiriman</th>
                                <th width="20%">Nama Pelanggan</th>
                                <th width="10%">Total Keseluruhan</th>
                                <th width="15%">Tanggal Pesanan</th>
                                <th width="15%">Estimasi Pengiriman</th>
                                <th width="10%">Status Pesanan</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            $mt = $user->fetchAllMetodePengambilanByID($row['uid_pengiriman']);
            $metode = $mt['nama_pengiriman'];

            $namaPelanggan = $user->fetchAllPelangganByID($row['uid_user']);
            $formatNamaPelanggan = $namaPelanggan[0]['username_user'];

            $pesananMasuk = $row['tanggal_masuk'];
            $estimasi = $row['tanggal_selesai'];
            $formatPesananMasuk = date('d M Y', strtotime($pesananMasuk));
            $formatEstimasi = date('d M Y', strtotime($estimasi));
            $output .= '<tr>
                                <td>' . $row['id_pesanan'] . '</td>
                                <td>' . $metode . '</td>
                                <td>' . $formatNamaPelanggan . '</td>
                                <td>Rp. ' . number_format($row['grand_total']) . '</td>
                                <td>' . $formatPesananMasuk . '</td>
                                <td>' . $formatEstimasi . '</td>
                                <td class="status-now">
                                    <a href="" class="status-pesanan-selesai">
                                        ' . $row['status_pesanan'] . '
                                    </a>
                                </td>
                                <td>
                                <a href="view-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" id="' . $row['id_pesanan'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-ellipsis-vertical dot"></i></a>&nbsp;&nbsp;
                                    <form action="" method="post" id="form-pilih-produk">
                                    </form>
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada pesanan selesai</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// show pesanan batal
if (isset($_POST['action']) && $_POST['action'] == 'showPesananBatal') {
    $output = '';
    $data = $user->fetchPesananBatal();


    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="10%">ID Pesanan</th>
                                <th width="15%">Metode Pengiriman</th>
                                <th width="20%">Nama Pelanggan</th>
                                <th width="10%">Total Keseluruhan</th>
                                <th width="15%">Tanggal Pesanan</th>
                                <th width="15%">Estimasi Pengiriman</th>
                                <th width="10%">Status Pesanan</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            $mt = $user->fetchAllMetodePengambilanByID($row['uid_pengiriman']);
            $metode = $mt['nama_pengiriman'];

            $namaPelanggan = $user->fetchAllPelangganByID($row['uid_user']);
            $formatNamaPelanggan = $namaPelanggan[0]['username_user'];

            $pesananMasuk = $row['tanggal_masuk'];
            $estimasi = $row['tanggal_selesai'];
            $formatPesananMasuk = date('d M Y', strtotime($pesananMasuk));
            $formatEstimasi = date('d M Y', strtotime($estimasi));
            $output .= '<tr>
                                <td>' . $row['id_pesanan'] . '</td>
                                <td>' . $metode . '</td>
                                <td>' . $formatNamaPelanggan . '</td>
                                <td>Rp. ' . number_format($row['grand_total']) . '</td>
                                <td>' . $formatPesananMasuk . '</td>
                                <td>' . $formatEstimasi . '</td>
                                <td class="status-now">
                                    <a href="" class="status-pesanan-batal">
                                        ' . $row['status_pesanan'] . '
                                    </a>
                                </td>';

            $output .=  '<td>
                            <a href="view-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" id="' . $row['id_pesanan'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-ellipsis-vertical dot"></i></a>&nbsp;&nbsp;
                            <form action="" method="post" id="form-pilih-produk">
                        </td>
                    </tr>
                </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada pesanan dibatalkan</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// show semua Pesanan 
if (isset($_POST['action']) && $_POST['action'] == 'showAllPesanan') {
    $output = '';
    $data = $user->fetchAllPesanan();

    if ($data) {
        $output .= '<table id="table_id">
                        <thead>
                            <tr>
                                <th width="10%">ID Pesanan</th>
                                <th width="15%">Metode Pengiriman</th>
                                <th width="20%">Nama Pelanggan</th>
                                <th width="10%">Total Keseluruhan</th>
                                <th width="15%">Tanggal Pesanan</th>
                                <th width="15%">Estimasi Pengiriman</th>
                                <th width="10%">Status Pesanan</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            $mt = $user->fetchAllMetodePengambilanByID($row['uid_pengiriman']);
            $metode = $mt['nama_pengiriman'];

            $namaPelanggan = $user->fetchAllPelangganByID($row['uid_user']);
            if ($namaPelanggan != null) {
                $formatNamaPelanggan = $namaPelanggan[0]['username_user'];
            } else {
                $formatNamaPelanggan = 'Belum Memasukkan Nama Pelanggan';
            }


            $pesananMasuk = $row['tanggal_masuk'];
            $estimasi = $row['tanggal_selesai'];
            $formatPesananMasuk = date('d M Y', strtotime($pesananMasuk));
            $formatEstimasi = date('d M Y', strtotime($estimasi));

            $konfirmasi = $row['status_pesanan'] == "Menunggu Konfirmasi";
            $konfirmasi = 'Konfirmasi';
            $output .= '<tr>
                                <td>' . $row['id_pesanan'] . '</td>
                                <td>' . $metode . '</td>
                                <td>' . $formatNamaPelanggan . '</td>
                                <td>Rp. ' . number_format($row['grand_total']) . '</td>
                                <td>' . $formatPesananMasuk . '</td>
                                <td>' . $formatEstimasi . '</td>
                                <td class="status-now">';
            if ($row['status_pesanan'] == 'Proses') {
                $output .= '<a href="" class="status-pesanan-proses" id="' . $row['id_pesanan'] . '">
                                ' . $row['status_pesanan'] . '
                            </a>';
            } else if ($row['status_pesanan'] == 'Selesai') {
                $output .= '<a href="" class="status-pesanan-selesai" title="Lihat Nota">
                                ' . $row['status_pesanan'] . '
                            </a>';
            } else if ($row['status_pesanan'] == 'Dibatalkan') {
                $output .= '<a href="" class="status-pesanan-batal">
                                ' . $row['status_pesanan'] . '
                            </a>';
            } else {
                $output .= '<a href="edit-status-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" id="' . $row['id_pesanan'] . '" class="status-pesanan-konfirmasi">
                                ' . $konfirmasi . '
                            </a>';
            }
            $output .= '</td>';
            $output .= '<td>
                            <a href="view-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" id="' . $row['id_pesanan'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-ellipsis-vertical dot"></i></a>&nbsp;&nbsp;
                        </td>
                    </tr>
                </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada pesanan</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
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
                                    <div class="price">Rp. ' . number_format($row['harga_layanan']) . '</div>
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

                                    <a href="#" id="' . $row['id_akun'] . '" title="Non Aktifkan Karyawan" class="hapusUserIcon"><i class="fa-solid fa-user-slash "></i></a>&nbsp;&nbsp;
                                    <a href="#" id="' . $row['id_akun'] . '" title="Hapus Akun" class="deleteUserIcon"><i class="fa-solid fa-trash delete"></i></a>&nbsp;&nbsp;
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
                                <td><p>Karyawan tidak ditemukan</p></td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// all tim tidak Aktif
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllUserNoAktif') {
    $output = '';
    $data = $user->fetchAllTimNot(2);
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
                                    <a href="#" id="' . $row['id_akun'] . '" title="Aktifkan Karyawan" class="restoreUserIcon"><i class="fa-solid fa-trash-can-arrow-up"></i></a>&nbsp;&nbsp;
                                    <a href="#" id="' . $row['id_akun'] . '" title="Hapus Akun" class="deleteUserIcon"><i class="fa-solid fa-trash delete"></i></a>&nbsp;&nbsp;
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
                                <td><p>Karyawan tidak ditemukan</p></td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// nonaktifkan karyawan
if (isset($_POST['del_id'])) {
    $id = $_POST['del_id'];
    // echo $id;
    $data = $user->delUser($id, 0);

    // echo json_encode($data);
}

// nonaktifkan karyawan
if (isset($_POST['delU_id'])) {
    $id = $_POST['delU_id'];
    // echo $id;
    $data = $user->delUserKaryawan($id);

    // echo json_encode($data);
}

// aktifkan karyawan
if (isset($_POST['restore_id'])) {
    $id = $_POST['restore_id'];
    // echo $id;
    $data = $user->delUser($id, 1);

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
    $data = $user->fetchAllPelanggan();
    // $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table class="cari-pelanggan">
                    <h4>Pelanggan Terdaftar</h4><br>';
        foreach ($data as $row) {
            $ufoto = '../asset/img/avatarr.png';
            $output .= '<tbody style="border-top: 1px solid #ddd;">
                            <tr>
                                <td width="10%"><img src="' . $ufoto . '"></td>
                                <td width="75%" class="tage">' . $row['username_user'] . '<br>' . $row['no_telp_user'] . '</td>
                                <td width="15%">
                                    <input type="submit" value="Pilih Pelanggan" id="' . $row['id_user'] . '" class="pilihPelangganPopup">
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
                                <td><p>Ketuk <a href="">"Simpan" </a>untuk membuat pelanggan ini</p></td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'fetchAllProdukPilihan') {
    $output = '';
    $data = $user->fetchPesananBystatus();
    $idPesanan = $data['id_pesanan'];
    $cek = $user->fetchAllDetailPesananByID($idPesanan);

    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table id="table_id">';
        foreach ($cek as $row) {
            // panggil fungsi tampil data produk layanan
            $fotoProduk = $user->fetchAllProdukByID($row['uid_layanan']);
            $namaProduk = $fotoProduk['nama_layanan'];
            $foto = $fotoProduk['foto_layanan'];
            if ($foto != '') {
                $ufoto = $path . $foto;
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            $output .= '<tbody>
                            <tr>
                                <td width="5%"><img src="' . $ufoto . '"></td>
                                <td width="10%">' . $namaProduk . '</td>
                                <td width="10%">' . number_format($row['harga_layanan']) . '</td>
                                <td width="15%">
                                    <input type="number" name="qty_update_new" min="1" value="' . $row['qty'] . '">
                                </td>
                                <td width="15%">' . $row['sub_total'] . '</td>
                                <td width="15%">
                                <a href="" id="' . $row['uid_layanan'] . '" title="Hapus produk" class="hapusProdukBtn">Hapus Produk</a>
                                </td>
                            </tr>
                        </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'sala';
    }
}

if (isset($_POST['action']) && $_POST['action'] == '-') {
    $output = '';
    $data = $user->fetchPesananBystatus();
    $idPesanan = $data['id_pesanan'];

    $pilihan = $user->fetchAllDetailPesananByID($idPesanan);

    $path = '../asset/php/uploads/';

    if ($pilihan != null) {
        // $output = '<div class="bungkus-box">';
        foreach ($pilihan as $row) {
            // insiasi
            $hargaProduk = $row['harga_layanan'];
            $subTotal = $row['sub_total'];

            // panggil fungsi tampil data produk layanan
            $dataProduk = $user->fetchAllProdukByID($row['uid_layanan']);
            $namaProduk = $dataProduk['nama_layanan'];
            $foto = $dataProduk['foto_layanan'];

            if ($foto != '') {
                $ufoto = $path . $foto;
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            $output .= '<form action="" method="post" id="qty_form">
                <div class="box-pilihan-produk">
                    <div class="foto-produk-pilihan">
                        <img src="' . $ufoto . '">
                    </div>
                    <div class="data-produk-pilihan">
                        <p>' . $namaProduk . '</p>
                        <input type="hidden" name="nama-produk-pilihan">
                        <p>' . $hargaProduk . '</p>
                        <input type="hidden" name="harga-produk-pilihan">
                    </div>
                    <div class="data-produk-pilihan-aksi">    
                        <input type="hidden" name="qty_update_id" value="' . $row['uid_pesanan'] . '">
                        <input type="hidden" name="qty_update_id_layanan" value="' . $row['uid_layanan'] . '">
                        <input type="number" name="qty_update_new" min="1" value="' . $row['qty'] . '">
                        <input type="submit" name="qty_update_btn" value="Perbarui Jumlah" id="' . $row['uid_layanan'] . '" class="qty_update_btn">
                        <input type="text" name="subtotal-produk-pilihan" readonly value="' . $subTotal . '">
                        <a href="#" id="' . $row['uid_layanan'] . '" title="Hapus produk" class="hapusProdukBtn">Hapus Produk</a>
                    </div>        
                </div>
            </form>';
        }
        // $output .= '</div>';
        echo $output;
    } else {
        $output .= '<a href="keranjang.php?id_pesanan=' . $idPesanan . '">
        <i class="fa-solid fa-box-open"></i>
        <label>Tambah Produk</label>
    </a>';
        echo $output;
    }
}

// pilih pelanggan
if (isset($_POST['search'])) {
    $keyword = $_POST['search'];
    $data = $user->searchPelanggan($keyword);
    $output = '';
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table class="cari-pelanggan">
                    <h4>Pelanggan Terdaftar</h4><br>';
        foreach ($data as $row) {
            $ufoto = '../asset/img/avatarr.png';
            $output .= '<tbody style="border-top: 1px solid #ddd;">
                                <tr>
                                    <td width="10%"><img src="' . $ufoto . '"></td>
                                    <td width="75%" class="tage">' . $row['username_user'] . '<br>' . $row['no_telp_user'] . '</td>
                                    <td width="15%">
                                        <input type="submit" value="Pilih Pelanggan" id="' . $row['id_user'] . '" class="pilihPelangganPopup">
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
                                <td><p>Pelanggan tidak ditemukan</p></td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// pilih pelanggan berdasarkan nama
if (isset($_POST['searchByName'])) {
    $keyword = $_POST['searchByName'];
    $data = $user->searchPelangganByName($keyword);
    $output = '';
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table class="cari-pelanggan">
                    <h4>Pelanggan Terdaftar</h4><br>';
        foreach ($data as $row) {
            $ufoto = '../asset/img/avatarr.png';
            $output .= '<tbody style="border-top: 1px solid #ddd;">
                                <tr>
                                    <td width="10%"><img src="' . $ufoto . '"></td>
                                    <td width="75%" class="tage">' . $row['username_user'] . '<br>' . $row['no_telp_user'] . '</td>
                                    <td width="15%">
                                        <input type="submit" value="Pilih Pelanggan" id="' . $row['id_user'] . '" class="pilihPelangganPopup">
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
                                <td><p>Pelanggan tidak ditemukan</p></td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}

// pilih pelanggan berdasarkan no telp
if (isset($_POST['searchByNoTelp'])) {
    $keyword = $_POST['searchByNoTelp'];
    $data = $user->searchPelangganByNoTelp($keyword);
    $output = '';
    $path = '../asset/php/uploads/';

    if ($data) {
        $output .= '<table class="cari-pelanggan">
                    <h4>Pelanggan Terdaftar</h4><br>';
        foreach ($data as $row) {
            $ufoto = '../asset/img/avatarr.png';
            $output .= '<tbody style="border-top: 1px solid #ddd;">
                                <tr>
                                    <td width="10%"><img src="' . $ufoto . '"></td>
                                    <td width="75%" class="tage">' . $row['username_user'] . '<br>' . $row['no_telp_user'] . '</td>
                                    <td width="15%">
                                        <input type="submit" value="Pilih Pelanggan" id="' . $row['id_user'] . '" class="pilihPelangganPopup">
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
                                <td><p>Pelanggan tidak ditemukan</p></td>
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
                                    <div class="price">Rp. ' . number_format($row['harga_layanan']) . '</div>
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

if (isset($_POST['searchKaryawan'])) {
    $keyword = $_POST['searchKaryawan'];
    $output = '';
    $data = $user->searchKaryawan($keyword);
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
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Karyawan tidak ditemukan</td>
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

if (isset($_POST['qty'])) {
    $idp = $_POST['idp'];
    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];

    $tprice = $qty * $pprice;

    $up = $user->upQtyPilihanProduk($qty, $tprice, $idp, $pid);
}

if (isset($_POST['mtd'])) {
    $idp = $_POST['idp'];
    $mtd = $_POST['mtd'];

    $up = $user->upMetodePengiriman($mtd, $idp);
}

if (isset($_POST['changeAlamat'])) {
    $key = $_POST['changeAlamat'];
    $idp = $_POST['idp'];
    $up = $user->upAlamat($key, $idp);
}

if (isset($_POST['kar'])) {
    $kar = $_POST['kar'];
    $idp = $_POST['idp'];
    // echo $kar;
    // echo $idp;
    $up = $user->upKaryawan($kar, $idp);
}

if (isset($_POST['searchPesanan'])) {
    $keyword = $_POST['searchPesanan'];
    $output = '';
    $data = $user->searchPesanan($keyword);

    if ($data) {
        $output .= '<table>
                        <thead>
                            <tr>
                                <th width="10%">ID Pesanan</th>
                                <th width="15%">Metode Pengiriman</th>
                                <th width="20%">Nama Pelanggan</th>
                                <th width="10%">Total Keseluruhan</th>
                                <th width="15%">Tanggal Pesanan</th>
                                <th width="15%">Estimasi Pengiriman</th>
                                <th width="10%">Status Pesanan</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            $mt = $user->fetchAllMetodePengambilanByID($row['uid_pengiriman']);
            $metode = $mt['nama_pengiriman'];

            $namaPelanggan = $user->fetchAllPelangganByID($row['uid_user']);
            if ($namaPelanggan != null) {
                $formatNamaPelanggan = $namaPelanggan[0]['username_user'];
            } else {
                $formatNamaPelanggan = 'Belum Memasukkan Nama Pelanggan';
            }


            $pesananMasuk = $row['tanggal_masuk'];
            $estimasi = $row['tanggal_selesai'];
            $formatPesananMasuk = date('d M Y', strtotime($pesananMasuk));
            $formatEstimasi = date('d M Y', strtotime($estimasi));

            $konfirmasi = $row['status_pesanan'] == "Menunggu Konfirmasi";
            $konfirmasi = 'Konfirmasi';
            $output .= '<tr>
                                <td>' . $row['id_pesanan'] . '</td>
                                <td>' . $metode . '</td>
                                <td>' . $formatNamaPelanggan . '</td>
                                <td>Rp. ' . number_format($row['grand_total']) . '</td>
                                <td>' . $formatPesananMasuk . '</td>
                                <td>' . $formatEstimasi . '</td>
                                <td class="status-now">';
            if ($row['status_pesanan'] == 'Proses') {
                $output .= '<a href="" class="status-pesanan-proses" id="' . $row['id_pesanan'] . '">
                                ' . $row['status_pesanan'] . '
                            </a>';
            } else if ($row['status_pesanan'] == 'Selesai') {
                $output .= '<a href="" class="status-pesanan-selesai" title="Lihat Nota">
                                ' . $row['status_pesanan'] . '
                            </a>';
            } else if ($row['status_pesanan'] == 'Dibatalkan') {
                $output .= '<a href="" class="status-pesanan-batal">
                                ' . $row['status_pesanan'] . '
                            </a>';
            } else {
                $output .= '<a href="edit-status-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" id="' . $row['id_pesanan'] . '" class="status-pesanan-konfirmasi">
                                ' . $konfirmasi . '
                            </a>';
            }
            $output .= '</td>';
            $output .= '<td>
                            <a href="view-pesanan.php?id_pesanan=' . $row['id_pesanan'] . '" id="' . $row['id_pesanan'] . '" title="Lihat Detail" class="userDetailIcon"><i class="fa-solid fa-ellipsis-vertical dot"></i></a>&nbsp;&nbsp;
                        </td>
                    </tr>
                </tbody>';
        }
        $output .= '</table>';
        echo $output;
    } else {
        $output .= '<table>';
        $output .= '<tbody class="cariProduk">
                            <tr>
                                <td>Tidak ada pesanan</td>
                            </tr>
                        </tbody>';
        $output .= '</table>';
        echo $output;
    }
}
