<?php
include("includes/db.php");
if(isset($_GET['action']))
	if($_GET['action'] == 'add') {
		if(isset($_GET['id']) && ctype_digit($_GET['id']) && isset($_GET['sid'])) {
	    header("Content-type: text/txt; charset=UTF-8");
	    mysqli_query($connection,"CALL getorcreate5({$_GET['id']},'{$_GET['sid']}')");
	    echo "1";
		}
	}
	elseif ($_GET['action'] == 'dec')	{
		if(isset($_GET['id']) && ctype_digit($_GET['id']) && isset($_GET['sid'])) {
	    header("Content-type: text/txt; charset=UTF-8");
	    $res = mysqli_query($connection,"SELECT decB({$_GET['id']},'{$_GET['sid']}') AS res");
	    echo "1";
		}
	}
	elseif ($_GET['action'] == 'inc')	{
		if(isset($_GET['id']) && ctype_digit($_GET['id']) && isset($_GET['sid'])) {
	    header("Content-type: text/txt; charset=UTF-8");
	    mysqli_query($connection,"CALL incB({$_GET['id']},'{$_GET['sid']}')");
	    echo "1";
		}
	}
	elseif ($_GET['action'] == 'del')	{
		if(isset($_GET['id']) && ctype_digit($_GET['id']) && isset($_GET['sid'])) {
	    header("Content-type: text/txt; charset=UTF-8");
	    mysqli_query($connection,"CALL delB({$_GET['id']},'{$_GET['sid']}')");
	    echo "1";
		}
	}
	elseif ($_GET['action'] == 'count')	{
		if(isset($_GET['sid'])) {
	    header("Content-type: text/txt; charset=UTF-8");
	   	$res32=mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) FROM `Basket` WHERE `Basket`.`session_id` = (SELECT `id` FROM `Sessions` WHERE `sid` = '{$_GET['sid']}')"));
			echo $res32['COUNT(*)'];
		}
	}	
	elseif ($_GET['action'] == 'sum')	{
		if(isset($_GET['sid'])) {
	    header("Content-type: text/txt; charset=UTF-8");
	    $res=mysqli_query($connection,"SELECT SUM(V.value * Basket.value) as sum FROM (SELECT Prices.goods_id, Prices.value FROM (SELECT goods_id, MAX(date) as date FROM Prices GROUP BY goods_id) AS T JOIN Prices ON Prices.goods_id = T.goods_id AND Prices.date = T.date) AS V JOIN Basket ON V.goods_id = Basket.goods_id WHERE Basket.session_id = (SELECT id FROM Sessions WHERE Sessions.sid = '{$_GET['sid']}')");
			$res1=mysqli_fetch_assoc($res);
			if (isset($res1['sum']))
				$sum = $res1['sum'];
			else
				$sum = 0;
			echo $sum;
		}
	}
	else
		echo "0";
?>