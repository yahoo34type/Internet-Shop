<!DOCTYPE html>
<html>
<head>
	<title>ioShop</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/io.png">
	<link rel="stylesheet" href="style.css" media="all">
</head>
	<div class="header">
		
			<header>
				<div class="basket">
								Корзина
								<img src="images/korz49.jpg">
				</div>
				<div class="topmenu">
						<a href="/index.php"">Главная</a>
						<a href="/towns.php">Список городов</a>
						<a href="/contacts.php">Контакты</a>
				</div>
				<img src="images/FeelsBadMan.png" alt="Логотип сайта" title="Логотип сайта">
				<!--<div class="afisha">
					<img src="images/afisha.png" alt="Обложечка" title="Обложечка">
					<h3>Лол, 30к<br>денег. Почем</h3>
					<p><a href="#">Тут?</a></p>
				</div>-->
			</header>
		
	</div>
	<div class="menu">
		<div class="mid">
			<nav>
			 <ul>
			 	<li><a href="/viewgoods.php?type=1&page=1">Компьютеры</a></li>
			 	<li><a href="/components.php">Комплектующие</a></li>
			 	<li><a href="/appliances.php">Бытовая техника</a></li>			 	
			 </ul>
			</nav>
		</div>
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