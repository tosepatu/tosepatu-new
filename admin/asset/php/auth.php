<?php

require_once 'config/config.php';

class Auth extends Database
{
    // property
    public $data;

    // method set
    public function setData($hallo)
    {

        $this->data = $hallo;
    }

    // method get
    public function getData()
    {

        return $this->data;
    }

    // User sudah ada
    public function user_exist($email)
    {
        $sql = "SELECT email FROM akun WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // increment id karyawan
    public function idKaryawan()
    {
        $sql = "SELECT max(id_akun) as maxKode FROM akun WHERE id_role = 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $inc = $stmt->fetch(PDO::FETCH_ASSOC);

        $idKaryawan = $inc['maxKode'];

        $noUrut = (int) substr($idKaryawan, 8, 3);
        $noUrut++;

        $character = 'KT220921';
        $idKaryawan = $character . sprintf("%03s", $noUrut);

        echo $idKaryawan;
    }

    // register request
    public function registerKaryawan($idKaryawan, $name, $email, $password, $roleKaryawan)
    {
        $sql = "INSERT INTO akun (id_akun, username, email, password, id_role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idKaryawan, $name, $email, $password, $roleKaryawan]);
        return true;
    }

    // Login admin request
    public function login($email)
    {
        $sql = "SELECT email, password FROM akun WHERE email = :email AND deleted != 0 AND id_role = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // Login karyawan request
    public function loginK($email)
    {
        $sql = "SELECT email, password FROM akun WHERE email = :email AND deleted != 0 AND id_role = 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // Login karyawan request
    public function loginP($email)
    {
        $sql = "SELECT email, password FROM akun WHERE email = :email AND deleted != 0 AND id_role = 3";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // current user session
    public function currentUser($email)
    {
        $sql = "SELECT * FROM akun WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // forgot request
    public function forgot($code, $email)
    {
        $sql = "UPDATE akun SET code = ?, code_expire = DATE_ADD(NOW(), 
        INTERVAL 5 MINUTE) WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$code, $email]);

        return true;
    }

    // test no ajax
    public function teset($email)
    {
        $sql = "SELECT * FROM akun WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->rowCount();
        return $row;
    }

    // generate code
    public function generateRandomString($length = 6)
    {
        $character = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characterLength = strlen($character);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $character[rand(0, $characterLength - 1)];
        }
        return $randomString;
    }

    // reset_pass no ajax
    public function reset_pass($email, $code)
    {
        $sql = "SELECT id_akun FROM akun WHERE email = ? AND code = ? AND 
        code != '' AND code_expire > NOW() AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email, $code]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //  check role user
    public function checkRole($email)
    {
        $sql = "SELECT id_akun FROM akun WHERE email = ? AND id_role <= 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // update pass no ajax
    public function update_pass($pass, $email)
    {
        $sql = "UPDATE akun SET code = '', password = ? WHERE email = ?
        AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$pass, $email]);

        return true;
    }

    // count total produk layanan
    public function totalCount($tablename)
    {
        $sql = "SELECT * FROM $tablename";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();

        return $count;
    }

    // hitung jumlah pesanan yang masih dalam proses
    public function dalamProses()
    {
        $sql = "SELECT * FROM pesanan WHERE status_pesanan = 'Proses'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }

    // count total toko dilihat
    public function siteHits()
    {
        $sql = "SELECT hits FROM pengunjung";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        return $count;
    }

    // add produk
    public function tambahProduk($idproduk, $namaproduk, $hargaproduk, $fotoproduk, $cid)
    {
        $sql = "INSERT INTO layanan (id_layanan, nama_layanan, harga_layanan, foto_layanan, uid_akun) VALUE (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idproduk, $namaproduk, $hargaproduk, $fotoproduk, $cid]);
        return true;
    }

    // id produk custom
    public function idProdukIncrement()
    {
        $sql = "SELECT max(id_layanan) as maxKode FROM layanan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $inc = $stmt->fetch(PDO::FETCH_ASSOC);

        $idProduk = $inc['maxKode'];

        $noUrut = (int) substr($idProduk, 8, 3);
        $noUrut++;

        $character = 'TL220921';
        $idProduk = $character . sprintf("%03s", $noUrut);

        echo $idProduk;
    }

    // id pesanan custom
    public function idPesananIncrement()
    {
        $sql = "SELECT max(id_pesanan) as maxKode FROM pesanan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $inc = $stmt->fetch(PDO::FETCH_ASSOC);

        $idPesanan = $inc['maxKode'];

        $noUrut = (int) substr($idPesanan, 10, 4);
        $noUrut++;

        date_default_timezone_set("Asia/Jakarta");
        $now = date('dmy');
        $character = 'TP' . $now;
        $idPesanan = $character . sprintf("%04s", $noUrut);

        echo $idPesanan;
        // return $idPesanan;
    }

    // id pengiriman custom
    public function idPengirimanIncrement()
    {
        $sql = "SELECT max(id_pengiriman) as maxKode FROM metode_pengiriman";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $inc = $stmt->fetch(PDO::FETCH_ASSOC);

        $idPengiriman = $inc['maxKode'];

        $noUrut = (int) substr($idPengiriman, 8, 3);
        $noUrut++;

        // $now = date('dmy');
        $character = 'MT220921';
        $idPengiriman = $character . sprintf("%03s", $noUrut);

        echo $idPengiriman;
    }

    // perulangan bulan
    public function bulan($bulan)
    {
        switch ($bulan) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }
        return $bulan;
    }

    // tampil data pelanggan berdsarkan role
    public function fetchAllPelanggan()
    {
        $sql = "SELECT * FROM akun_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data pelanggan berdasarkan id_akun
    public function fetchAllPelangganByID($id)
    {
        $sql = "SELECT * FROM akun_user WHERE id_user = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // tampil data pelanggan berdasarkan id_akun
    public function fetchPelangganByID($id)
    {
        $sql = "SELECT * FROM akun_user WHERE id_user = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data tim
    public function fetchAllTim($val)
    {
        $sql = "SELECT * FROM akun WHERE id_role = $val AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // tampil data tim berdasarkan id
    public function fetchAllTimByID($val)
    {
        $sql = "SELECT * FROM akun WHERE id_akun = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$val]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data tim
    // public function fetchAllKaryawan($val)
    // {
    //     $sql = "SELECT no_karyawan FROM karyawan WHERE uid_akun = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([$val]);
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $result;
    // }
    
    // tampil data tim
    public function fetchAllKaryawanByNo($val)
    {
        $sql = "SELECT uid_akun FROM karyawan WHERE no_karyawan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$val]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchAllMetodePengambilan()
    {
        $sql = "SELECT * FROM metode_pengiriman";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchAllMetodePengambilanByID($idPengiriman)
    {
        $sql = "SELECT * FROM metode_pengiriman WHERE id_pengiriman = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPengiriman]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data produk berdasarkan nama layanan
    public function selectProduk($val)
    {
        $sql = "SELECT * FROM layanan WHERE nama_layanan = $val";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil semua data produk 
    public function fetchAllProduk()
    {
        $sql = "SELECT * FROM layanan ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data produk berdasarkan id layanan
    public function fetchAllProdukByID($namaProduk)
    {
        $sql = "SELECT * FROM layanan WHERE id_layanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$namaProduk]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data produk berdasarkan nama layanan
    public function fetchAllProdukByName($id)
    {
        $sql = "SELECT * FROM layanan WHERE nama_layanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // edit profile akun
    public function updateProfile($name, $email, $photo, $alamat, $no_telp, $id)
    {
        $sql = "UPDATE akun SET username = ?, email = ?, foto = ?, alamat = ?, no_telp = ? WHERE id_akun = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $email, $photo, $alamat, $no_telp, $id]);
        return true;
    }

    // edit data produk
    public function updateProduk($namaProduk, $hargaProduk, $fotoProduk, $cid, $idProduk)
    {
        $sql = "UPDATE layanan SET nama_layanan = ?, harga_layanan = ?, foto_layanan = ?, uid_akun = ? WHERE id_layanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$namaProduk, $hargaProduk, $fotoProduk, $cid, $idProduk]);
        return true;
    }

    // reset password pada halaman pengaturan
    public function changePass($pass, $id)
    {
        $sql = "UPDATE akun SET password = ? WHERE id_akun = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$pass, $id]);
        return true;
    }

    // verifikasi email
    public function verifyEmail($email)
    {
        $sql = "UPDATE akun SET verified = 1 WHERE email = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return true;
    }

    // tambah pesanan 
    public function addPesanan($idPesanan, $metodePengambilan, $cid)
    {
        $sql = "INSERT INTO pesanan (id_pesanan, uid_pengiriman, uid_akun, tanggal_selesai) VALUES (?, ?, ?, DATE_ADD(NOW(), 
        INTERVAL 5 DAY))";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan, $metodePengambilan, $cid]);
        return true;
    }

    // batal pesanan 
    public function batalPesanan($idPesanan)
    {
        $sql = "DELETE FROM pesanan WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan]);
        return true;
    }

    // tambah nama pelanggan buat pesanan 
    public function upPesananNamaPelanggan($idPelanggan, $idPesanan)
    {
        $sql = "UPDATE pesanan SET uid_user = ? WHERE id_pesanan = ? AND status_pesanan = 'Menunggu Konfirmasi'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPelanggan, $idPesanan]);
        return true;
    }
    
    // update status pesanan proses 
    public function upPesananProses($idPesanan)
    {
        $sql = "UPDATE pesanan SET status_pesanan = 'Proses', tanggal_selesai = DATE_ADD(NOW(), 
        INTERVAL 5 DAY) WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan]);
        return true;
    }

    // update status pesanan selesai 
    public function upPesananSelesai($idPesanan)
    {
        $sql = "UPDATE pesanan SET status_pesanan = 'Selesai' WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan]);
        return true;
    }
    
    // update status pesanan dibatalkan 
    public function upPesananBatal($idPesanan)
    {
        $sql = "UPDATE pesanan SET status_pesanan = 'Dibatalkan' WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan]);
        return true;
    }

    public function checkoutPesanan($catatan, $metode, $kurir, $grandTotal, $alamat, $idPesanan)
    {
        $sql = "UPDATE pesanan SET catatan = ?, uid_pengiriman = ?, uid_akun = ?, grand_total = ?, alamat = ?, status_pesanan = 'Proses', tanggal_selesai = DATE_ADD(NOW(), 
        INTERVAL 5 DAY) WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$catatan, $metode, $kurir, $grandTotal, $alamat, $idPesanan]);
        return true;
    }

    public function upQtyPilihanProduk($qty, $subtotal, $idPesanan, $idProduk)
    {
        $sql = "UPDATE detail_pesanan SET qty = ?, sub_total = ? WHERE uid_pesanan = ? AND uid_layanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$qty, $subtotal, $idPesanan, $idProduk]);
        return true;
    }

    public function upAlamat($keyword, $idPesanan)
    {
        $sql = "UPDATE pesanan SET alamat = ? WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$keyword, $idPesanan]);
        return true;
    }
    
    public function upKaryawan($idKaryawan, $idPesanan)
    {
        $sql = "UPDATE pesanan SET uid_akun = ? WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idKaryawan, $idPesanan]);
        return true;
    }
    
    public function upGrandTotal($grandtotal, $idPesanan)
    {
        $sql = "UPDATE pesanan SET grand_total = ? WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$grandtotal, $idPesanan]);
        return true;
    }

    public function upMetodePengiriman($idPengiriman, $idPesanan)
    {
        $sql = "UPDATE pesanan SET uid_pengiriman = ? WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPengiriman, $idPesanan]);
        return true;
    }

    // tambah detail pesanan atau keranjang
    public function addDetailPesanan($idPesanan, $idProduk, $qty, $hargaProduk, $subTotal)
    {
        $sql = "INSERT INTO detail_pesanan (uid_pesanan, uid_layanan, qty, harga_layanan, sub_total) VALUES (?, ?, ? ,?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan, $idProduk, $qty, $hargaProduk, $subTotal]);
        return true;
    }

    // tampil data pesanan berdasarkan id
    public function fetchAllPesanan()
    {
        $sql = "SELECT * FROM pesanan ORDER BY id_pesanan DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchAllPesananByID($id)
    {
        $sql = "SELECT * FROM pesanan WHERE id_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data pesanan berdasarkan uid
    public function fetchPesananByUID($id)
    {
        $sql = "SELECT * FROM pesanan WHERE uid_akun = ? AND status_pesanan = 'Menunggu Konfirmasi'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data pesanan berdasarkan uid_user
    public function fetchPesananByUID_USER($id)
    {
        $sql = "SELECT * FROM pesanan WHERE uid_user = ? AND status_pesanan = 'Menunggu Konfirmasi'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchPesananBystatus()
    {
        $sql = "SELECT * FROM pesanan WHERE status_pesanan = 'Menunggu Konfirmasi'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function fetchPesananBaru()
    {
        $sql = "SELECT * FROM pesanan WHERE status_pesanan = 'Menunggu Konfirmasi'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchPesananProses()
    {
        $sql = "SELECT * FROM pesanan WHERE status_pesanan = 'Proses'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function fetchPesananSelesai()
    {
        $sql = "SELECT * FROM pesanan WHERE status_pesanan = 'Selesai'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchPesananBatal()
    {
        $sql = "SELECT * FROM pesanan WHERE status_pesanan = 'Dibatalkan'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchPesananIdAndStatus($id)
    {
        $sql = "SELECT * FROM pesanan WHERE id_pesanan = ? AND status_pesanan = 'Menunggu Konfirmasi'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data pesanan berdasarkan id
    public function fetchAllDetailPesananByID($id)
    {
        $sql = "SELECT * FROM detail_pesanan WHERE uid_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    // tampil data pesanan berdasarkan id
    public function whileAllDetailPesananByID($id)
    {
        $sql = "SELECT * FROM detail_pesanan WHERE uid_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $text = '';
        $output = '';
        $path = '../asset/php/uploads/';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $idPesanan = $row['uid_pesanan'];
            $idLayanan = $row['uid_layanan'];
            $qty = $row['qty'];
            $price = $row['harga_layanan'];
            $subtotal = $row['sub_total'];

            $fotoProduk = $this->fetchAllProdukByID($idLayanan);
            $namaProduk = $fotoProduk['nama_layanan'];
            $foto = $fotoProduk['foto_layanan'];
            if ($foto != '') {
                $ufoto = $path . $foto;
            } else {
                $ufoto = '../asset/img/avatarr.png';
            }
            // $text .= $book;
            $output .= '<div class="box-pilihan-produk">
                            <div class="foto-produk-pilihan">
                                <img src="' . $ufoto . '">
                            </div>
                            <div class="data-produk-pilihan">
                                <p>' . $namaProduk . '</p>
                                <input type="hidden" name="nama-produk-pilihan">
                                <p>' . $price . '</p>
                                <input type="hidden" name="harga-produk-pilihan">
                            </div>
                        </div>
                        <div class="data-produk-pilihan-aksi">
                            <form action="" method="post">
                                <input type="hidden" name="qty_update_id" value="' . $idPesanan . '">
                                <input type="hidden" name="qty_update_id_layanan" value="' . $idLayanan . '">
                                <input type="number" name="qty_update_new" min="1" value="' . $qty . '">
                                <input type="submit" name="qty_update_btn" value="Perbarui Jumlah" id="' . $idLayanan . '" class="qty_update_btn">
                                <input type="text" name="subtotal-produk-pilihan" readonly value="' . $subtotal . '">
                                <a href="#" id="' . $idLayanan . '" title="Hapus produk" class="hapusProdukBtn">Hapus Produk</a>
                            </form>    
                        </div>';
            // $text .= "ID: ' {$d_id}'";
            // $text .= "P: ' {$l_id}'";
            // $text .= "J: ' {$qty}'";
        }
        echo $output;
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $text;
    }

    public function fetchAllDetailPesananByIDLayanan($id)
    {
        $sql = "SELECT * FROM detail_pesanan WHERE uid_layanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // tampil data user berdasarkan id
    public function fetchAllUserByID($id)
    {
        $sql = "SELECT * FROM akun WHERE id_akun = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // tambah data pengambilan
    public function addPengambilan($idPengambilan, $namaPengambilan)
    {
        $sql = "INSERT INTO metode_pengiriman (id_pengiriman, nama_pengiriman) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPengambilan, $namaPengambilan]);
        return true;
    }

    // tampil data role
    public function fetchAllRole()
    {
        $sql = "SELECT * FROM role WHERE id_role <= 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // hapus user
    public function delUser($id, $val)
    {
        $sql = "UPDATE akun SET deleted = $val WHERE id_akun = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return true;
    }

    // hapus produk
    public function delproduk($idProduk)
    {
        $sql = "DELETE FROM layanan WHERE id_layanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idProduk]);
        return true;
    }

    // hapus pilihan produk
    public function delProdukPilihan($idProduk, $idPesanan)
    {
        $sql = "DELETE FROM detail_pesanan WHERE uid_layanan = ? AND uid_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idProduk, $idPesanan]);
        return true;
    }

    // keyword
    public function searchPelanggan($keyword)
    {
        $sql = "SELECT * FROM akun_user WHERE
                username_user LIKE '%$keyword%' OR
                no_telp_user LIKE '%$keyword%' OR
                id_user LIKE '%$keyword%'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // keyword
    public function searchPelangganByName($keyword)
    {
        $sql = "SELECT * FROM akun_user WHERE username_user LIKE '%$keyword%'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // keyword
    public function searchPelangganByNoTelp($keyword)
    {
        $sql = "SELECT * FROM akun_user WHERE no_telp_user LIKE '%$keyword%'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // keyword produk
    public function searchProduk($keyword)
    {
        $sql = "SELECT * FROM layanan WHERE
                nama_layanan LIKE '%$keyword%' OR
                id_layanan LIKE '%$keyword%' OR
                harga_layanan LIKE '%$keyword%'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // keyword pesanan
    public function searchPesanan($keyword)
    {
        $sql = "SELECT * FROM pesanan WHERE
                id_pesanan LIKE '%$keyword%' OR
                uid_pengiriman LIKE '%$keyword%' OR
                uid_user LIKE '%$keyword%' OR
                catatan LIKE '%$keyword%' OR
                grand_total LIKE '%$keyword%' OR
                status_pesanan LIKE '%$keyword%'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // keyword produk
    public function searchKaryawan($keyword)
    {
        $sql = "SELECT * FROM akun WHERE 
                id_role = 2 AND username LIKE '%$keyword%' OR
                no_telp LIKE '%$keyword%' AND id_role = 2 OR 
                email LIKE '%$keyword%' AND id_role = 2 OR
                id_akun LIKE '%$keyword%' AND id_role = 2 OR
                alamat LIKE '%$keyword%' AND id_role = 2 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchDetailPesanan($idPesanan, $idProduk)
    {
        $sql = "SELECT COUNT(uid_layanan) AS pilihan_produk FROM detail_pesanan WHERE uid_pesanan = ? AND uid_layanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan, $idProduk]);
        $number_of_rows = $stmt->fetchColumn();
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $number_of_rows;
    }

    public function cekDetailPesanan($idPesanan)
    {
        $sql = "SELECT COUNT(uid_layanan) AS pilihan_produk FROM detail_pesanan WHERE uid_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan]);
        $number_of_rows = $stmt->fetchColumn();
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $number_of_rows;
    }

    public function fetchDetailPesananProduk($idPesanan)
    {
        $sql = "SELECT SUM(qty) AS TotalProduk FROM detail_pesanan WHERE uid_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan]);
        $number_of_rows = $stmt->fetchColumn();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $number_of_rows;
    }

    public function grand_total_pesanan($idPesanan)
    {
        $sql = "SELECT SUM(sub_total) AS grandTotal FROM detail_pesanan WHERE uid_pesanan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan]);
        $number_of_rows = $stmt->fetchColumn();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $number_of_rows;
    }
    
    public function total_pendapatan()
    {
        $sql = "SELECT SUM(grand_total) AS grandTotal FROM pesanan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $number_of_rows;
    }

    public function produk_terlaris()
    {
        $sql = "SELECT uid_layanan, SUM(qty) qty FROM detail_pesanan GROUP BY uid_layanan ORDER BY qty DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $number_of_rows;
    }

    public function pelanggan_utama()
    {
        $sql = "SELECT uid_user, SUM(grand_total) AS total_transaksi FROM pesanan GROUP BY uid_user ORDER BY grand_total DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $number_of_rows;
    }

    public function transaksi_pelanggan_utama($idPelanggan)
    {
        $sql = "SELECT uid_user, COUNT(uid_user) AS total_transaksi FROM pesanan WHERE uid_user = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPelanggan]);
        // $number_of_rows = $stmt->fetchColumn();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function total_transaksi_pelanggan_utama($idPelanggan)
    {
        $sql = "SELECT uid_user, SUM(grand_total) AS total_transaksi FROM pesanan WHERE uid_user = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPelanggan]);
        // $number_of_rows = $stmt->fetchColumn();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function grafik_total_pesanan() {
        $sql = "SELECT YEAR(tanggal_masuk) AS tahun, COUNT(*) AS jumlah_tahunan FROM pesanan GROUP BY YEAR(tanggal_masuk)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function grafik_total_pendapatan() {
        $sql = "SELECT SUM(grand_total) AS total_transaksi, YEAR(tanggal_masuk) AS tahun, COUNT(*) AS jumlah_tahunan FROM pesanan GROUP BY YEAR(tanggal_masuk)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function grafik_produk_terlaris() {
        $sql = "SELECT uid_layanan, SUM(qty) qty FROM detail_pesanan GROUP BY uid_layanan ORDER BY qty DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function grafik_nominal_produk_terlaris() {
        $sql = "SELECT uid_layanan, SUM(sub_total) nominal_produk FROM detail_pesanan GROUP BY uid_layanan ORDER BY sub_total DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
