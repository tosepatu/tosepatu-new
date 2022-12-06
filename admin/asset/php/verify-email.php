<?php
require_once 'session.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $cuser->verifyEmail($email);
    header('location: ../../page/pengaturan.php');
    exit();
} else {
    header('location: ../../../home/page/index.php');
}