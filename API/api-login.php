<?php 
session_start();
require_once '../admin/asset/php/config/config.php';
// require_once '../admin/asset/php/session.php';
$obj = new Auth();

header('Access-Control-Allow-Origin: *');

$json = array(
	"response_status"=>"OK",
	"response_message"=>'',
	"data"=>array()
);

$email = isset($_GET['email'])?$_GET['email']:'';
$password = isset($_GET['password'])?$_GET['password']:'';

$log = $obj->loginP($email);

$jml = $log->num_rows;
if($jml>0){
	while($rs = $sql->fetch_object()){
		$arr_row = array();
		$arr_row['username'] = $rs->username;
		$arr_row['email'] = $rs->nama;
		$arr_row['alamat'] = $rs->alamat;
		$arr_row['no_telp'] = $rs->telp;
		$json['data'][] = $arr_row;
	}	
}else{
	$json['response_status']= "Error";		
	$json['response_message']= "Username atau Password Salah";		
}

header('Content-Type: application/json');
print json_encode($json, JSON_PRETTY_PRINT);
