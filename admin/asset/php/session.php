<?php
session_start();
require_once 'auth.php';
$cuser = new Auth();

if (!isset($_SESSION['userAdmin'])) {
    header('location: ../../../index.php');
    die;
} 
$cemail = $_SESSION['userAdmin'];

$data = $cuser->currentUser($cemail);

$cid = $data['id_akun'];
$cname = $data['username'];
$pass = $data['password'];
$calamat = $data['alamat'];
$ctelp = $data['no_telp'];
$cphoto = $data['foto'];
$ccreated = $data['created_at'];

$reg_on = date('d M Y', strtotime($ccreated));

$verified = $data['verified'];

$fname = strtok($cname, " ");

if ($verified == 0) {
    $verified = 'Belum Verifikasi!';
} else {
    $verified = 'Sudah Verifikasi!';
}
