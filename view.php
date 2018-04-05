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
			 	<li><a href="#">Комплектующие</a></li>
			 	<li><a href="#">Бытовая техника</a></li>			 	
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
					$result = mysqli_query($connection, ("SELECT `Marks`.`name`,`Goods`.`model`,`Goods`.`description` FROM `Goods` JOIN `Marks` WHERE `Goods`.`id` = {$_GET['id']} AND `Marks`.`id`=`Goods`.`id_mark`")) or die('Запрос не удался: ' . mysqli_error($connection));
					while($row=mysqli_fetch_assoc($result)) 
					{
						echo "<div class=\"view\">";
						echo "<h3>{$row['name']} {$row['model']}</h3>";
						echo "<div class=\"newsimg\"><img src=\"images/goods/" . $_GET["id"] . ".jpg\" width=\"300px%\"></div>";
						echo "<h4><p align=\"justify\">{$row['description']}</p></h4>";
						echo "<div class=\"clear\"></div>";
						echo "<table>";
						$result1 = mysqli_query($connection, ("SELECT `Characteristics`.`name`, `Charvalues`.`value`, `Chartypes`.`name` AS `cname` FROM `Charvalues` LEFT JOIN `Characteristics` ON `char_id` = `Characteristics`.`id` LEFT JOIN `Chartypes` ON `Characteristics`.`chartype_id` = `Chartypes`.`id` WHERE `Charvalues`.`goods_id` = ". $_GET["id"] ." ORDER BY `Chartypes`.`id`, `Characteristics`.`id`")) or die('Запрос не удался: ' . mysqli_error($connection));
							$cur = "";
							while($rows=mysqli_fetch_assoc($result1)) 
							{
								if ($rows['cname'] != $cur)
								{
									$cur = $rows['cname'];
									echo "<tr><td class='nt2'>" . $rows['cname'] . "</td></tr>";
								}
								echo "<tr><td class='nt'>". $rows['name'] . "</td><td class='nt'>".$rows['value']."</td></tr>";
							}
							

							/*echo "<tr>";
							$k = preg_split("/[\":\t]+/", $key);
							if (($k[1]) == " " || $k[1] == "")
								echo "<td class='nt2'>$k[0]</td>";
							else
							foreach ($k as $val) {
								echo "<td class='nt'>$val</td>";
							}
							echo "</tr>";*/
						echo "</table>";
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