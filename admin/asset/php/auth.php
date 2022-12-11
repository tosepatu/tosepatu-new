<?php

require_once 'config/config.php';

class Auth extends Database
{
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
        $sql = "SELECT max(id_akun) as maxKode FROM akun";
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

    public function idPesananIncrement()
    {
        $sql = "SELECT max(id_pesanan) as maxKode FROM pesanan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $inc = $stmt->fetch(PDO::FETCH_ASSOC);

        $idPesanan = $inc['maxKode'];

        $noUrut = (int) substr($idPesanan, 10, 4);
        $noUrut++;
           
        $now = date('dmy');
        $character = 'TP220921'.$now;
        $idPesanan = $character . sprintf("%04s", $noUrut);

        echo $idPesanan;
    }

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

    public function fetchAllPelanggan($val)
    {
        $sql = "SELECT * FROM akun WHERE id_role = $val";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function fetchAllTim()
    {
        $sql = "SELECT * FROM akun WHERE id_role <= 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function selectProduk($val)
    {
        $sql = "SELECT * FROM layanan WHERE nama_layanan = $val";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchAllProduk()
    {
        $sql = "SELECT * FROM layanan ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchFotoProduk()
    {
        $sql = "SELECT foto_layanan FROM layanan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateProfile($name, $email, $photo, $alamat, $no_telp, $id)
    {
        $sql = "UPDATE akun SET username = ?, email = ?, foto = ?, alamat = ?, no_telp = ? WHERE id_akun = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $email, $photo, $alamat, $no_telp, $id]);
        return true;
    }

    public function changePass($pass, $id) {
        $sql = "UPDATE akun SET password = ? WHERE id_akun = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$pass, $id]);
        return true;
    }

    public function verifyEmail($email) {
        $sql = "UPDATE akun SET verified = 1 WHERE email = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return true;
    }

    public function addPesanan($idPesanan, $cid) {
        $sql = "INSERT INTO pesanan (id_pesanan, uid_akun, tanggal_selesai) VALUES (?, ?, tanggal_selesai = DATE_ADD(NOW(), 
        INTERVAL 5 DAY))";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan, $cid]);
        return true;
    }

    public function addDetailPesanan($idPesanan, $idProduk, $qty, $hargaProduk, $subtotal) {
        $sql = "INSERT INTO detail_pesanan (uid_pesanan, uid_layanan, qty, harga_layanan, sub_total) VALUES (?, ?, ? ,?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPesanan, $idProduk, $qty, $hargaProduk, $subtotal]);
        return true;
    }

    public function fetchAllUserByID($id) {
        $sql = "SELECT * FROM akun WHERE id_akun = ? AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function addPengambilan($idPengambilan, $namaPengambilan, $cid) {
        $sql = "INSERT INTO metode_pengiriman (id_pengiriman, nama_pengiriman, uid_akun) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPengambilan, $namaPengambilan, $cid]);
        return true;
    }
    
    public function fetchAllRole() {
        $sql = "SELECT * FROM role WHERE id_role <= 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
