<?php 
	$connection = mysqli_connect('localhost','root','','Test_db');
		if ($connection == false)
		{
			echo "Не получилось чот;)))) <br>";
			echo mysqli_connect_error();
			exit();
		}
 ?>