<?php 
  include('includes/db.php');
	session_start();
	if (!isset($_SESSION['id'])) {
		$t = mysqli_query($connection,"SELECT REPLACE(UUID(),'-','_') AS `id`") or die('Запрос 0.1 не удался: ' . mysqli_error($connection));
	  $_SESSION['id'] = mysqli_fetch_assoc($t)['id'];
	  mysqli_query($connection,"INSERT INTO `Sessions`(`sid`) VALUES ('{$_SESSION['id']}')") or die('Запрос 0.2 не удался: ' . mysqli_error($connection));
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ioShop</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/io.png">
	<link rel="stylesheet" href="style.css" media="all">
	<script src="/hide.js"></script>
</head>
<div class="cover" id="cover"></div>
<header>
	<div class="header">
			<a href="/basket.php">
				<div class="basket">
					<img src="images/basket.png"><span class="s totalvalue">
						<?php
							$res=mysqli_query($connection,"SELECT SUM(`Basket`.`value` * `Prices`.`value`) AS `sum` FROM `Basket` JOIN `Prices` on `Basket`.`goods_id`=`Prices`.`goods_id` WHERE `Basket`.`session_id` = (SELECT `id` FROM `Sessions` WHERE `sid` = '{$_SESSION['id']}')");
							$res1=mysqli_fetch_assoc($res);
							if (isset($res1['sum']))
								$sum=$res1['sum'];
							else
								$sum = 0;
							echo $sum;
						?> 
					</span>р
					<div class="basketnum">
					<?php
							$res32=mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) FROM `Basket` WHERE `Basket`.`session_id` = (SELECT `id` FROM `Sessions` WHERE `sid` = '{$_SESSION['id']}')"));
							$c=$res32['COUNT(*)'];
							echo "<span class='totalcount'>$c</span>";
					?>
					</div>
				</div>
				</a>
				<div class="topmenu">
						<a href="/index.php""><div class='headerbtn'><img src="images/home.png"></div></a>
						<a href="/towns.php"><div class='headerbtn'><img src="images/planet.png"></div></a>
						<a href="/contacts.php"><div class='headerbtn'><img src="images/phone.png"></div></a>
				</div>
				<a href="javascript:" onclick="Hide('navmenu');"><div class='menubtn'><img class="siteicon" src="images/FeelsBadMan.png" alt="Меню сайта" title="Меню сайта"><img src="images/chevron.png" id='chev' height="12px" style="margin-left: 10px; margin-bottom: 22px;"></div></a>
	</div>
</header>
	<div class="menu" id="navmenu">
			
			 	<a href="/viewgoods.php?page=1"><div class = "menubtn2"><img src="images/comp.png">Компьютеры</div></a>
			 	<a href="/components.php"><div class = "menubtn2"><img src="images/chip.png">Комплектующие</div></a>
			 	<a href="/appliances.php"><div class = "menubtn2"><img src="images/wm.png">Бытовая техника</div></a>	 	
			 
	</div>
	<div class="content">
		<div class="mid2">
			<div class="bg">
				<?php
				include('includes/db.php');
				include('includes/urlgetchange.php'); //getvalchange
			  $res1 = mysqli_query($connection, ("SELECT `id`,`displayname` FROM `Goodstypes` WHERE id_category = 2")) or die('Запрос не удался: ' . mysqli_error($connection));
				while($row=mysqli_fetch_assoc($res1)) {
					    echo "<div class=\"goodsblock2\"><a href=\"/viewgoods.php?type=" . $row['id'] . "\">";
					    echo "<div class=\"image3\"><img src=\"images/types/" . $row['id'] . ".jpg\"></div>";
					    echo "<h3>". $row['displayname'] . "</h3>";
					    echo "</div>";
				};
				echo '<div class="clear">
				</div>';
				?>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="mid">
			2018 &copy; П К
		</div>
	</div>
</html>