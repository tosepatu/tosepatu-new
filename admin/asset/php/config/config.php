<?php
// Aktifkan Semua Laporan
// mysqli_report(MYSQLI_REPORT_ALL);
// /* untuk menekan peringatan */
// $conn = @new mysqli('localhost', 'root', '', 'db_tosepatu');
// if ($conn->connect_error) {
//     /* metode kesalahan */
//     error_log('Connection error: ' . $conn->connect_error);
// }
class Database
{

  const USERNAME = 'tosepatu.kc@gmail.com';
  const PASSWORD = 'keycmwufauijzziv';

  private $db_servername = 'mysql:host=localhost;dbname=db_tosepatu';
  private $db_username = 'root';
  private $db_password = '';

  public $conn;

  public function __construct()
  {
    try {
      $this->conn = new PDO($this->db_servername, $this->db_username, $this->db_password);
      // $conn = new PDO("mysql:host=$servername;dbname=db_tosepatu", $username, $password);
      // set the PDO error mode to exception
      // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo 'Connected successfully';
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
    return $this->conn;
  }

  // Cek data input
  public function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // Erorr and Success Alert
  public function showMessage($type, $message)
  {
    if ($type == 'danger') {
      return '<div class="alert ' . $type . '">
                <p class="danger">' . $message . '</p>
                </div>';
    } else {
      return '<div class="alert ' . $type . '">
                <p class="success">' . $message . '</p>
              </div>';
    }
  }
}
$cek = new Database();
