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
			 	<li><a href="/viewgoods.php?page=1">Компьютеры</a></li>
			 	<li><a href="/components.php">Комплектующие</a></li>
			 	<li><a href="/appliances.php">Бытовая техника</a></li>		 	
			 </ul>
			</nav>
		</div>
	</div>
	<div class="content">
		<div class="mid">
			<div class="bg">
			<?php
			$month_rus = array("Января","Февраля","Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря");
			if (!empty($_GET["id"]) && ctype_digit($_GET["id"]))
			{
					include('includes/db.php');
					$result = mysqli_query($connection, ("SELECT `Name`,`text`,`date` FROM `News` WHERE `id` = {$_GET['id']}")) or die('Запрос не удался: ' . mysqli_error($connection));
					while($row=mysqli_fetch_assoc($result)) 
					{
						echo "<div class=\"news\">";
						echo "<h3>{$row['Name']}</h3>";
						echo "<div class=\"newsimg\"><img src=\"images/news" . $_GET["id"] . ".jpg\" width=\"400px%\"></div>";
						echo "<h4><p align=\"justify\">{$row['text']}</p></h4><br>";
						echo "<h5>". substr($row['date'],8,2) . " " . $month_rus[(int)substr($row['date'],5,2)] . " " . substr($row['date'],0,4) . " " .substr($row['date'],11,5) . "</h5></div>";
						echo "<div class=\"clear\"></div>";
					}
			}
			else
				{
				  echo "<script type=\"text/javascript\">
					window.location = \"index.php\"
					</script>";
				}
			?>			
		</div>
	</div>
	<div class="footer">
		<div class="mid">
			2018 &copy; П К
		</div> 
	</div>
</html>