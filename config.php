<?php  
	/***
	**
	** Ket noi database
	**
	***/
	//dia chi trang web
	$base_url = "http://localhost/vote/";
	//Tao ket noi toi DTB
	$host = "localhost"; 
	// tai khoan co so du lieu 
	$user = "root";  
	// mat khau
	$pass = "";  
	//ten database
	$dtb ="vote";
	$mysqli = new mysqli($host, $user, $pass, $dtb);
	$mysqli->set_charset("utf8");

	
?>