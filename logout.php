<?php
	$base_url = "http://localhost/vote/";
	session_start();
	session_destroy();
	header('location:'.$base_url.'');
?>