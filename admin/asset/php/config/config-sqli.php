<?php
	$conn = new mysqli("localhost","wstifdi1_tosepatu","Polije1234","wstifdi1_tosepatu");
	if($conn->connect_error){
		die("Connection Failed!".$conn->connect_error);
	}
?>