<?php 
	include('includes/db.php');
	$login = $_POST['login'];
	$password = $_POST['password'];	
	echo $login . " " . $password;
	mysqli_query($connection, "INSERT INTO `Users`(`login`,`password`,`regdate`) VALUES ('$login', '$password', NULL)");
 ?>