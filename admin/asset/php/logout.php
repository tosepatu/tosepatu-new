<?php
session_start();
unset($_SESSION['userAdmin']);
unset($_SESSION['userKaryawan']);
header("Location: ../../../home/page/masuk.php");
