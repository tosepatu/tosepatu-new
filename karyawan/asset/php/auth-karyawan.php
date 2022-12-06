<?php

require_once 'config/config-karyawan.php';

class AuthKaryawan extends Database {
    // current user session
    public function currentUser($email)
    {
        $sql = "SELECT * FROM akun WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}